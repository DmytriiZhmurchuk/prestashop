<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class AuthController extends AuthControllerCore
{
 
    public function init()
    {
        parent::init();
    }

    /**
     * Process submit on an account
     */
    protected function processSubmitAccount()
    {
        Hook::exec('actionBeforeSubmitAccount');
        $this->create_account = true;
        $isTransfromGuestToCustomer = false;
        
        if(Tools::isSubmit('transform_toaccount')  && Tools::getValue('transform_toaccount')){
            $isTransfromGuestToCustomer = true;
        }

        if (Tools::isSubmit('submitAccount')) {
            $this->context->smarty->assign('email_create', 1);
        }
        // New Guest customer
        if (!Tools::getValue('is_new_customer', 1) && !Configuration::get('PS_GUEST_CHECKOUT_ENABLED')) {
            $this->errors[] = Tools::displayError('You cannot create a guest account.');
        }
        if (!Tools::getValue('is_new_customer', 1) && !$isTransfromGuestToCustomer) {
            $_POST['passwd'] = md5(time()._COOKIE_KEY_);
        }
        if ($guest_email = Tools::getValue('guest_email')) {
            $_POST['email'] = $guest_email;
        }
        // Checked the user address in case he changed his email address
        if (Validate::isEmail($email = Tools::getValue('email')) && !empty($email)) {
            if (Customer::customerExists($email)) {
                $this->errors[] = Tools::displayError('An account using this email address has already been registered.', false);
            }
        }
        // Preparing customer
        $customer = new Customer();
        $lastnameAddress = Tools::getValue('lastname');
        $firstnameAddress = Tools::getValue('firstname');
        $_POST['lastname'] = Tools::getValue('customer_lastname', $lastnameAddress);
        $_POST['firstname'] = Tools::getValue('customer_firstname', $firstnameAddress);
        $addresses_types = array('address');
        if (!Configuration::get('PS_ORDER_PROCESS_TYPE') && Configuration::get('PS_GUEST_CHECKOUT_ENABLED') && Tools::getValue('invoice_address')) {
            $addresses_types[] = 'address_invoice';
        }

        $error_phone = false;
        if (Configuration::get('PS_ONE_PHONE_AT_LEAST')) {
            if (Tools::isSubmit('submitGuestAccount') || !Tools::getValue('is_new_customer')) {
                if (!Tools::getValue('phone') && !Tools::getValue('phone_mobile')) {
                    $error_phone = true;
                }
            } elseif (((Configuration::get('PS_REGISTRATION_PROCESS_TYPE') && Configuration::get('PS_ORDER_PROCESS_TYPE'))
                    || (Configuration::get('PS_ORDER_PROCESS_TYPE') && !Tools::getValue('email_create'))
                    || (Configuration::get('PS_REGISTRATION_PROCESS_TYPE') && Tools::getValue('email_create')))
                    && (!Tools::getValue('phone') && !Tools::getValue('phone_mobile'))) {
                $error_phone = true;
            }
        }

        if ($error_phone) {
            $this->errors[] = Tools::displayError('You must register at least one phone number.');
        }

        $this->errors = array_unique(array_merge($this->errors, $customer->validateController()));

        // Check the requires fields which are settings in the BO
        $this->errors = $this->errors + $customer->validateFieldsRequiredDatabase();

        if (!Configuration::get('PS_REGISTRATION_PROCESS_TYPE') && !$this->ajax && !Tools::isSubmit('submitGuestAccount')) {
            if (!count($this->errors)) {

                $this->processCustomerNewsletter($customer);

                $customer->firstname = Tools::ucwords($customer->firstname);
                $customer->birthday = (empty($_POST['years']) ? '' : (int)Tools::getValue('years').'-'.(int)Tools::getValue('months').'-'.(int)Tools::getValue('days'));
                if (!Validate::isBirthDate($customer->birthday)) {
                    $this->errors[] = Tools::displayError('Invalid date of birth.');
                }

                // New Guest customer
                $customer->is_guest = (Tools::isSubmit('is_new_customer') ? !Tools::getValue('is_new_customer', 1) : 0);
                $customer->active = 1;

                if (!count($this->errors)) {
                    if ($customer->add()) {
                        if (!$customer->is_guest) {
                            if (!$this->sendConfirmationMail($customer)) {
                                $this->errors[] = Tools::displayError('The email cannot be sent.');
                            }
                        }

                        $this->updateContext($customer);

                        $this->context->cart->update();
                        Hook::exec('actionCustomerAccountAdd', array(
                                '_POST' => $_POST,
                                'newCustomer' => $customer
                            ));
                        if ($this->ajax) {
                            $return = array(
                                'hasError' => !empty($this->errors),
                                'errors' => $this->errors,
                                'isSaved' => true,
                                'id_customer' => (int)$this->context->cookie->id_customer,
                                //'id_address_delivery' => $this->context->cart->id_address_delivery,
                                //'id_address_invoice' => $this->context->cart->id_address_invoice,
                                'token' => Tools::getToken(false)
                            );
                            $this->ajaxDie(Tools::jsonEncode($return));
                        }

                        if (($back = Tools::getValue('back')) && $back == Tools::secureReferrer($back)) {
                            Tools::redirect(html_entity_decode($back));
                        }

                        // redirection: if cart is not empty : redirection to the cart
                        if (count($this->context->cart->getProducts(true)) > 0) {
                            $multi = (int)Tools::getValue('multi-shipping');
                            Tools::redirect('index.php?controller=order'.($multi ? '&multi-shipping='.$multi : ''));
                        }
                        // else : redirection to the account
                        else {
                            Tools::redirect('index.php?controller='.(($this->authRedirection !== false) ? urlencode($this->authRedirection) : 'my-account'));
                        }
                    } else {
                        $this->errors[] = Tools::displayError('An error occurred while creating your account.');
                    }
                }
            }
        } else {
            // if registration type is in one step, we save the address

            $_POST['lastname'] = $lastnameAddress;
            $_POST['firstname'] = $firstnameAddress;
            $_POST['phone_mobile'] = Tools::getValue('phone_mobile');
            $post_back = $_POST;


            if (!count($this->errors)) {
                if (Customer::customerExists(Tools::getValue('email'))) {
                    $this->errors[] = Tools::displayError('An account using this email address has already been registered. Please enter a valid password or request a new one. ', false);
                }

                $this->processCustomerNewsletter($customer);

                if (!count($this->errors)) {
                    $customer->active = 1;
                    // New Guest customer
                    if (Tools::isSubmit('is_new_customer') && !$isTransfromGuestToCustomer) {
                        $customer->is_guest = !Tools::getValue('is_new_customer', 1);
                    } else {
                        $customer->is_guest = 0;
                    }
                    if (!$customer->add()) {
                        $this->errors[] = Tools::displayError('An error occurred while creating your account.');
                    } else {
                        if (!count($this->errors)) {
                            if (!$customer->is_guest) {
                                //$this->context->customer = $customer;
                                $this->updateContext($customer);

                                $customer->cleanGroups();
                                // we add the guest customer in the default customer group
                                $customer->addGroups(array((int)Configuration::get('PS_CUSTOMER_GROUP')));
                                if (!$this->sendConfirmationMail($customer)) {
                                    $this->errors[] = Tools::displayError('The email cannot be sent.');
                                }
                            } else {
                                $customer->cleanGroups();
                                // we add the guest customer in the guest customer group
                                $customer->addGroups(array((int)Configuration::get('PS_GUEST_GROUP')));
                            }
                            $this->updateContext($customer);

                            if ($this->ajax && Configuration::get('PS_ORDER_PROCESS_TYPE')) {
                                $delivery_option = array((int)$this->context->cart->id_address_delivery => (int)$this->context->cart->id_carrier.',');
                                $this->context->cart->setDeliveryOption($delivery_option);
                            }

                            // If a logged guest logs in as a customer, the cart secure key was already set and needs to be updated
                            $this->context->cart->update();

                            // Avoid articles without delivery address on the cart
                            $this->context->cart->autosetProductAddress();

                            Hook::exec('actionCustomerAccountAdd', array(
                                    '_POST' => $_POST,
                                    'newCustomer' => $customer
                                ));
                            if ($this->ajax) {
                                $return = array(
                                    'hasError' => !empty($this->errors),
                                    'errors' => $this->errors,
                                    'isSaved' => true,
                                    'id_customer' => (int)$this->context->cookie->id_customer,
                                    'id_address_delivery' => $this->context->cart->id_address_delivery,
                                    'id_address_invoice' => $this->context->cart->id_address_invoice,
                                    'token' => Tools::getToken(false)
                                );
                                $this->ajaxDie(Tools::jsonEncode($return));
                            }

                            if (($back = Tools::getValue('back')) && $back == Tools::secureReferrer($back)) {
                                Tools::redirect(html_entity_decode($back));
                            }

                            // redirection: if cart is not empty : redirection to the cart
                            if (count($this->context->cart->getProducts(true)) > 0) {
                                Tools::redirect('index.php?controller=order'.($multi = (int)Tools::getValue('multi-shipping') ? '&multi-shipping='.$multi : ''));
                            }
                            // else : redirection to the account
                            else {
                                Tools::redirect('index.php?controller='.(($this->authRedirection !== false) ? urlencode($this->authRedirection) : 'my-account'));
                            }
                        }
                    }
                }
            }

            if (count($this->errors)) {
                //for retro compatibility to display guest account creation form on authentication page
                if (Tools::getValue('submitGuestAccount')) {
                    $_GET['display_guest_checkout'] = 1;
                }

                if (!Tools::getValue('is_new_customer')) {
                    unset($_POST['passwd']);
                }
                if ($this->ajax) {
                    $return = array(
                        'hasError' => !empty($this->errors),
                        'errors' => $this->errors,
                        'isSaved' => false,
                        'id_customer' => 0
                    );
                    $this->ajaxDie(Tools::jsonEncode($return));
                }
                $this->context->smarty->assign('account_error', $this->errors);
            }
        }
    }
    
    /**
     * sendConfirmationMail
     * @param Customer $customer
     * @return bool
     */
    protected function sendConfirmationMail(Customer $customer)
    {
        if (!Configuration::get('PS_CUSTOMER_CREATION_EMAIL')) {
            return true;
        }

        return Mail::Send(
            $this->context->language->id,
            'account',
            Mail::l('Welcome!'),
            array(
                '{firstname}' => $customer->firstname,
                '{lastname}' => $customer->lastname,
                '{email}' => $customer->email,
                '{passwd}' => Tools::getValue('passwd')),
            $customer->email,
            $customer->firstname.' '.$customer->lastname
        );
    }
}
