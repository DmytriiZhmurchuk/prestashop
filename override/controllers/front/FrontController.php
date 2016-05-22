<?php

class FrontController extends FrontControllerCore
{
    protected $manufacturer;
    
    public function initContent(){
        parent::initContent();
        $this->assignAll();
    }

    public function setMedia(){
        /**
         * If website is accessed by mobile device
         * @see FrontControllerCore::setMobileMedia()
         */
        if ($this->useMobileTheme()) {
            $this->setMobileMedia();
            return true;
        }
        $this->addCSS(_THEME_CSS_DIR_.'theme6_overwrite.css', 'all');
        $this->addCSS(_THEME_CSS_DIR_.'grid_prestashop.css', 'all');  // retro compat themes 1.5.0.1
        $this->addCSS(_THEME_CSS_DIR_.'global.css', 'all');
        $this->addJquery();
        $this->addJqueryPlugin('easing');
        $this->addJS(_PS_JS_DIR_.'tools.js');
        $this->addJS(_THEME_JS_DIR_.'global.js');
       

        // Automatically add js files from js/autoload directory in the template
        if (@filemtime($this->getThemeDir().'js/autoload/')) {
            foreach (scandir($this->getThemeDir().'js/autoload/', 0) as $file) {
                if (preg_match('/^[^.].*\.js$/', $file)) {
                    $this->addJS($this->getThemeDir().'js/autoload/'.$file);
                }
            }
        }
        // Automatically add css files from css/autoload directory in the template
        if (@filemtime($this->getThemeDir().'css/autoload/')) {
            foreach (scandir($this->getThemeDir().'css/autoload', 0) as $file) {
                if (preg_match('/^[^.].*\.css$/', $file)) {
                    $this->addCSS($this->getThemeDir().'css/autoload/'.$file);
                }
            }
        }

        if (Tools::isSubmit('live_edit') && Tools::getValue('ad') && Tools::getAdminToken('AdminModulesPositions'.(int)Tab::getIdFromClassName('AdminModulesPositions').(int)Tools::getValue('id_employee'))) {
            $this->addJqueryUI('ui.sortable');
            $this->addjqueryPlugin('fancybox');
            $this->addJS(_PS_JS_DIR_.'hookLiveEdit.js');
        }

        if (Configuration::get('PS_QUICK_VIEW')) {
            $this->addjqueryPlugin('fancybox');
        }

        if (Configuration::get('PS_COMPARATOR_MAX_ITEM') > 0) {
            $this->addJS(_THEME_JS_DIR_.'products-comparison.js');
        }

        // Execute Hook FrontController SetMedia
        Hook::exec('actionFrontControllerSetMedia', array());

        return true;
    }
    ////-------------------------

    /**
     * Assign template vars if displaying the manufacturer list
     */
    protected function assignAll()
    {
        if (Configuration::get('PS_DISPLAY_SUPPLIERS')) {
            $data = Manufacturer::getManufacturers(false, $this->context->language->id, true, false, false, false);
            $nbProducts = count($data);
            $this->n = abs((int)Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE')));
            $this->p = abs((int)Tools::getValue('p', 1));
            $data = Manufacturer::getManufacturers(true, $this->context->language->id, true, $this->p, $this->n, false);
            $this->pagination($nbProducts);

            foreach ($data as &$item) {
                $item['image'] = (!file_exists(_PS_MANU_IMG_DIR_.$item['id_manufacturer'].'-'.ImageType::getFormatedName('medium').'.jpg')) ? $this->context->language->iso_code.'-default' : $item['id_manufacturer'];
            }

            $this->context->smarty->assign(array(
                'pages_nb' => ceil($nbProducts / (int)$this->n),
                'nbManufacturers' => $nbProducts,
                'mediumSize' => Image::getSize(ImageType::getFormatedName('medium')),
                'manufacturers' => $data,
                'add_prod_display' => Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY')
            ));
        } else {
            $this->context->smarty->assign('nbManufacturers', 0);
        }
    }

    /**
     * Get instance of current manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

   
    //-----------------------------
    
}
