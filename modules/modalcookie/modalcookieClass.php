<?php
class modalcookieClass extends ObjectModel
{
	public $id;
	public $id_shop;
	public $message;
	public static $definition = array(
		'table' => 'modalcookie',
		'primary' => 'id_modalcookie',
		'multilang' => true,
		'fields' => array(
			'id_shop' =>				array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
			'message' =>			array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString'),
		)
	);
	
	static public function getByIdShop($id_shop)
	{
		$id = Db::getInstance()->getValue('SELECT `id_modalcookie` FROM `'._DB_PREFIX_.'modalcookie` WHERE `id_shop` ='.(int)$id_shop);
		return new modalcookieClass($id);
	}

	public function copyFromPost()
	{
		foreach ($_POST AS $key => $value)
			if (key_exists($key, $this) AND $key != 'id_'.$this->table)
				$this->{$key} = $value;

		if (sizeof($this->fieldsValidateLang))
		{
			$languages = Language::getLanguages(false);
			foreach ($languages AS $language)
				foreach ($this->fieldsValidateLang AS $field => $validation)
					if (isset($_POST[$field.'_'.(int)($language['id_lang'])]))
						$this->{$field}[(int)($language['id_lang'])] = $_POST[$field.'_'.(int)($language['id_lang'])];
		}
	}
}
