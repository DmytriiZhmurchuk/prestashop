{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{capture name=path}
	{if !isset($email_create)}{l s='Authentication'}{else}
		<a href="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Authentication'}">{l s='Authentication'}</a>
		<span class="navigation-pipe">{$navigationPipe}</span>{l s='Create your account'}
	{/if}
{/capture}
<h1 class="page-heading">{if !isset($email_create)}{l s='Authentication'}{else}{l s='Create an account'}{/if}</h1>
{if isset($back) && preg_match("/^http/", $back)}{assign var='current_step' value='login'}{include file="$tpl_dir./order-steps.tpl"}{/if}
{include file="$tpl_dir./errors.tpl"}
{assign var='stateExist' value=false}
{assign var="postCodeExist" value=false}
{assign var="dniExist" value=false}
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			{if !isset($inOrderProcess)}
				<form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post" id="account-creation_form" class="std box">
					{$HOOK_CREATE_ACCOUNT_TOP}
					<div class="account_creation">
						<h3 class="page-subheading">{l s='Your personal information'}</h3>
						<p class="required"><sup>*</sup>{l s='Required field'}</p>

						<div class="required form-group">
							<label for="customer_firstname">{l s='First name'} <sup>*</sup></label>
							<input onkeyup="$('#firstname').val(this.value);" type="text" class="is_required validate form-control" data-validate="isName" id="customer_firstname" name="customer_firstname" value="{if isset($smarty.post.customer_firstname)}{$smarty.post.customer_firstname}{/if}" />
						</div>
						<div class="required form-group">
							<label for="customer_lastname">{l s='Last name'} <sup>*</sup></label>
							<input onkeyup="$('#lastname').val(this.value);" type="text" class="is_required validate form-control" data-validate="isName" id="customer_lastname" name="customer_lastname" value="{if isset($smarty.post.customer_lastname)}{$smarty.post.customer_lastname}{/if}" />
						</div>
						<div class="required form-group">
							<label for="phone_mobile">{l s='Mobile phone'}<sup>*</sup></label>
							<input type="tel" class="is_required validate form-control" data-validate="isPhoneNumber" name="phone_mobile" id="phone_mobile" value="{if isset($smarty.post.phone_mobile)}{$smarty.post.phone_mobile}{/if}" />
						</div>
						<div class="required form-group">
							<label for="email">{l s='Email'} <sup>*</sup></label>
							<input type="email" class="is_required validate form-control" data-validate="isEmail" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}" />
						</div>
						<div class="required password form-group">
							<label for="passwd">{l s='Password'} <sup>*</sup></label>
							<input type="password" class="is_required validate form-control" data-validate="isPasswd" name="passwd" id="passwd" />
							<span class="form_info">{l s='(Five characters minimum)'}</span>
						</div>
						{if isset($newsletter) && $newsletter}
							<div class="checkbox">
								<input type="checkbox" name="newsletter" id="newsletter" value="1" {if isset($smarty.post.newsletter) AND $smarty.post.newsletter == 1} checked="checked"{/if} />
								<label for="newsletter">{l s='Sign up for our newsletter!'}</label>
								{if array_key_exists('newsletter', $field_required)}
									<sup> *</sup>
								{/if}
							</div>
						{/if}
						{$HOOK_CREATE_ACCOUNT_FORM}
						<div class="submit clearfix">
							<input type="hidden" name="email_create" value="1" />
							<input type="hidden" name="is_new_customer" value="1" />
							{if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'html':'UTF-8'}" />{/if}
							<button type="submit" name="submitAccount" id="submitAccount" class="btn btn-default button button-medium">
								<span>{l s='Register'}<i class="icon-chevron-right right"></i></span>
							</button>
						</div>
					</div>	
				</form>	
			{elseif isset($inOrderProcess) && $inOrderProcess}
				<form action="{$link->getPageLink('authentication', true, NULL, "back=$back")|escape:'html':'UTF-8'}" method="post" id="new_account_form" class="std clearfix">
					<div class="box">
						<div id="opc_account_form" style="display: block; ">
							<h3 class="page-heading bottom-indent">{l s='Instant checkout'}</h3>
							<p class="required"><sup>*</sup>{l s='Required field'}</p>
							<!-- Account -->
							<div class="required form-group">
								<label for="firstname">{l s='First name'} <sup>*</sup></label>
								<input type="text" class="is_required validate form-control" data-validate="isName" id="firstname" name="firstname" value="{if isset($smarty.post.firstname)}{$smarty.post.firstname}{/if}" />
							</div>
							<div class="required form-group">
								<label for="lastname">{l s='Last name'} <sup>*</sup></label>
								<input type="text" class="is_required validate form-control" data-validate="isName" id="lastname" name="lastname" value="{if isset($smarty.post.lastname)}{$smarty.post.lastname}{/if}" />
							</div>
							<div class="required form-group">
								<label for="phone_mobile">{l s='Mobile phone'}<sup>*</sup></label>
								<input type="tel" class="is_required validate form-control" data-validate="isPhoneNumber" name="phone_mobile" id="phone_mobile" value="{if isset($smarty.post.phone_mobile)}{$smarty.post.phone_mobile}{/if}" />
							</div>
							<div class="required form-group">
								<label for="guest_email">{l s='Email address'} <sup>*</sup></label>
								<input type="text" class="is_required validate form-control" data-validate="isEmail" id="guest_email" name="guest_email" value="{if isset($smarty.post.guest_email)}{$smarty.post.guest_email}{/if}" />
							</div>
							<div class="required password form-group account hidden">
								<label for="passwd">{l s='Password'} <sup>*</sup></label>
								<input type="password" class="is_required validate form-control" data-validate="isPasswd" name="passwd" id="passwd" />
								<span class="form_info">{l s='(Five characters minimum)'}</span>
							</div>
							<input type="hidden" name="alias" id="alias" value="{l s='My address'}" />
							<input type="hidden" name="is_new_customer" id="is_new_customer" value="0" />
							<div class="checkbox">
								<label for="transform_toaccount">
								<input type="checkbox" name="transform_toaccount" id="transform_toaccount"{if (isset($smarty.post.transform_toaccount) && $smarty.post.transform_toaccount)} checked="checked"{/if} autocomplete="off"/>
								{l s='Создать профиль'}</label>
							</div>
							<!-- END Account -->
						</div>
						{$HOOK_CREATE_ACCOUNT_FORM}
					</div>
					<p class="cart_navigation required submit clearfix">
						<span><sup>*</sup>{l s='Required field'}</span>
						<input type="hidden" name="display_guest_checkout" value="1" />
						<button type="submit" class="button btn btn-default button-medium" name="submitGuestAccount" id="submitGuestAccount">
							<span>
								{l s='Proceed to checkout'}
								<i class="icon-chevron-right right"></i>
							</span>
						</button>
					</p>
				</form>
			{/if}
		</div>
		<div class="col-xs-12 col-sm-6">
			<form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post" id="login_form" class="box">
				<h3 class="page-subheading">{l s='Already registered?'}</h3>
				<div class="form_content clearfix">
					<div class="form-group">
						<label for="email">{l s='Email address'}</label>
						<input class="is_required validate account_input form-control" data-validate="isEmail" type="email" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|stripslashes}{/if}" />
					</div>
					<div class="form-group">
						<label for="passwd">{l s='Password'}</label>
						<input class="is_required validate account_input form-control" type="password" data-validate="isPasswd" id="passwd" name="passwd" value="" />
					</div>
					<p class="lost_password form-group"><a href="{$link->getPageLink('password')|escape:'html':'UTF-8'}" title="{l s='Recover your forgotten password'}" rel="nofollow">{l s='Forgot your password?'}</a></p>
					<p class="submit">
						{if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'html':'UTF-8'}" />{/if}
						<button type="submit" id="SubmitLogin" name="SubmitLogin" class="button btn btn-default button-medium">
							<span>
								<i class="icon-lock left"></i>
								{l s='Sign in'}
							</span>
						</button>
					</p>
				</div>
			</form>
		</div>
	</div>
{strip}
{if isset($smarty.post.id_state) && $smarty.post.id_state}
	{addJsDef idSelectedState=$smarty.post.id_state|intval}
{elseif isset($address->id_state) && $address->id_state}
	{addJsDef idSelectedState=$address->id_state|intval}
{else}
	{addJsDef idSelectedState=false}
{/if}
{if isset($smarty.post.id_state_invoice) && isset($smarty.post.id_state_invoice) && $smarty.post.id_state_invoice}
	{addJsDef idSelectedStateInvoice=$smarty.post.id_state_invoice|intval}
{else}
	{addJsDef idSelectedStateInvoice=false}
{/if}
{if isset($smarty.post.id_country) && $smarty.post.id_country}
	{addJsDef idSelectedCountry=$smarty.post.id_country|intval}
{elseif isset($address->id_country) && $address->id_country}
	{addJsDef idSelectedCountry=$address->id_country|intval}
{else}
	{addJsDef idSelectedCountry=false}
{/if}
{if isset($smarty.post.id_country_invoice) && isset($smarty.post.id_country_invoice) && $smarty.post.id_country_invoice}
	{addJsDef idSelectedCountryInvoice=$smarty.post.id_country_invoice|intval}
{else}
	{addJsDef idSelectedCountryInvoice=false}
{/if}
{if isset($countries)}
	{addJsDef countries=$countries}
{/if}
{if isset($vatnumber_ajax_call) && $vatnumber_ajax_call}
	{addJsDef vatnumber_ajax_call=$vatnumber_ajax_call}
{/if}
{if isset($email_create) && $email_create}
	{addJsDef email_create=$email_create|boolval}
{else}
	{addJsDef email_create=false}
{/if}
{/strip}
