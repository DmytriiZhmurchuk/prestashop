<?php

if (!defined('_PS_VERSION_'))
	exit;

class modalcookie extends Module
{
	public function __construct()
	{
		$this->name = 'modalcookie';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'Dulco';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Popup окно');
		$this->description = $this->l('всплывающее окно с информацией или рекламой на CSS');
		$path = dirname(__FILE__);
		if (strpos(__FILE__, 'Module.php') !== false)
			$path .= '/../modules/'.$this->name;
		include_once $path.'/modalcookieClass.php';
	}

	public function install()
	{
		if (!parent::install() || !$this->registerHook('displayHeader'))
			return false;

		$res = Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'modalcookie` (
			`id_modalcookie` int(10) unsigned NOT NULL auto_increment,
			`id_shop` int(10) unsigned NOT NULL ,
			PRIMARY KEY (`id_modalcookie`))
			ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8');

		if ($res)
			$res &= Db::getInstance()->execute('
				CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'modalcookie_lang` (
				`id_modalcookie` int(10) unsigned NOT NULL,
				`id_lang` int(10) unsigned NOT NULL,
				`message` text NOT NULL,
				PRIMARY KEY (`id_modalcookie`, `id_lang`))
				ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8');


		if ($res)
			foreach
			(Shop::getShops(false) as $shop)
				$res &= $this->createExamplemodalcookie($shop['id_shop']);

			if (!$res)
				$res &= $this->uninstall();

			return $res;
	}

	private function createExamplemodalcookie($id_shop)
	{
		$modalcookie = new modalcookieClass();
		$modalcookie->id_shop = (int)$id_shop;
		foreach (Language::getLanguages(false) as $lang)
		{
			$modalcookie->message[$lang['id_lang']] = '<p><span style="text-align: center; font: 28px Monotype Corsiva, Arial; font-weight: bold; color: #0251c7; text-shadow: 0 1px 3px rgba(0,0,0,.3);">«Модули и шаблоны на <span style="color: #000000;">webnewbie.ru</span> для начинающих с PrestaShop»</span><br /> <br /> <a href="http://webnewbie.ru/" rel="nofollow"><img style="float: left; margin: 5px 10px 5px 0; border: 0;" src="http://webnewbie.ru/upload/wn.png" alt="" /></a> <span style="font: 24px Monotype Corsiva, Arial; color: #008000; text-align: left; text-shadow: 0 1px 3px rgba(0,0,0,.3);">Уважаемые, друзья!</span><br /> <br /> Вам не стоит раскошеливаться на начальном этапе открытия интернет-магазина<br /> <br />Этот ресурс для Вас:</p>
<p><a style="font-weight: bold;" href="http://webnewbie.ru/" rel="nofollow">«Бесплатные модули и шаблоны»</a></p>
<p><br /> Перейдите по ссылке и <span style="color: #0251c7;">почитайте полезные статьи</span> - вы найдете полезные для себя модули, описание того, как их можно сделать самостоятельно, я расскажу вам как интегрировать блог ВордПресса в ПрестаШоп. И много интересного и полезного!</p>
<p align="center"><img src="http://webnewbie.ru/upload/strelohkaa.png" alt="" width="50" /><br /> Вы не пожалеете!</p>
<p style="text-align: center; font-size: 18px;"><a class="button" href="http://webnewbie.ru/modules/blogwp/wordpress/">Делюсь опытом</a></p>';
		}
		return $modalcookie->add();
	}

	public function uninstall()
	{
		$res = Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'modalcookie`');
		$res &= Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'modalcookie_lang`');

		if (!$res || !parent::uninstall())
			return false;

		return true;
	}

	private function initForm()
	{
		$languages = Language::getLanguages(false);
		foreach ($languages as $k => $language)
			$languages[$k]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));

		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = 'modalcookie';
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->languages = $languages;
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
		$helper->allow_employee_form_lang = true;
		$helper->toolbar_scroll = true;
		$helper->tpl_vars['version'] = $this->version;
		$helper->tpl_vars['author'] = $this->author;
		$helper->tpl_vars['this_path'] = $this->_path;
		$helper->toolbar_btn = $this->initToolbar();
		$helper->title = $this->displayName;
		$helper->submit_action = 'submitUpdatemodalcookie';
		
		$this->fields_form[0]['form'] = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->displayName,
				'image' => $this->_path.'logo.gif'
			),
			'submit' => array(
				'name' => 'submitUpdatemodalcookie',
				'title' => $this->l('Сохранить'),
				'class' => 'button'
			),
			'input' => array(
				
				array(
					'type' => 'textarea',
					'label' => $this->l('Сообщение'),
					'name' => 'message',
					'lang' => true,
					'autoload_rte' => true,
					'cols' => 60,
					'rows' => 30
				),
				
			)
		);		
		return $helper;
	}

	private function initToolbar()
	{
		$this->toolbar_btn['save'] = array(
			'href' => '#',
			'desc' => $this->l('Save')
		);
		
		return $this->toolbar_btn;
	}

	public function getContent()
	{
		$this->_html = '';
		$this->postProcess();
		
		$helper = $this->initForm();
		
		$id_shop = (int)$this->context->shop->id;
		$modalcookie = modalcookieClass::getByIdShop($id_shop);

		if (!$modalcookie) 
			$this->createExamplemodalcookie($id_shop);
		
		foreach ($this->fields_form[0]['form']['input'] as $input) 
			if ($input['name'])
				$helper->fields_value[$input['name']] = $modalcookie->{$input['name']};
		
				
		$this->_html .= $helper->generateForm($this->fields_form);
		return $this->_html;
	}

	public function postProcess()
	{
		$errors = '';
		$id_shop = (int)$this->context->shop->id;
		
		

		if (Tools::isSubmit('submitUpdatemodalcookie'))
		{
			$id_shop = (int)$this->context->shop->id;
			$modalcookie = modalcookieClass::getByIdShop($id_shop);
			$modalcookie->copyFromPost();
			$modalcookie->update();

			
			$this->_clearCache('modalcookie.tpl');
		}
	}

	public function hookDisplayHeader($params)
	{
		if (!$this->isCached('modalcookie.tpl', $this->getCacheId()))
		{
			$id_shop = (int)$this->context->shop->id;
			$modalcookie = modalcookieClass::getByIdShop($id_shop);
			if (!$modalcookie)
				return;			
			$modalcookie = new modalcookieClass((int)$modalcookie->id, $this->context->language->id);
			if (!$modalcookie)
				return;
			$this->smarty->assign(array(
					'modalcookie' => $modalcookie,
					'default_lang' => (int)$this->context->language->id,
					
					'id_lang' => $this->context->language->id,
					
				));
		}
		return $this->display(__FILE__, 'modalcookie.tpl', $this->getCacheId());
	}

	
}
