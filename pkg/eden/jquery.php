<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
 
require_once dirname(__FILE__).'/eden.php';

/**
 * The starting point of every application call. If you are only
 * using the framework you can rename this function to whatever you
 * like.
 *
 */
function jquery() {
	return Jquery::i();
}

/**
 * Defines the starting point of every site call.
 * Starts laying out how classes and methods are handled.
 *
 * @package    Eden
 * @category   site
 */
class Jquery extends Eden {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_uid	= 1;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Bootstrap Methods
	-------------------------------*/
	/* Factory Methods
	-------------------------------*/
	/**
	 * Returns the block factory
	 *
	 * @return Jquery_Block
	 */
	public function block() {
		return $this->Jquery_Block();
	}
	
	/**
	 * Returns the field factory
	 *
	 * @return Jquery_Field
	 */
	public function field() {
		return $this->Jquery_Field();
	}
	
	/**
	 * Returns jquery block
	 *
	 * @return Jquery_Core
	 */
	public function core() {
		return $this->Jquery_Core();
	}
	
	/**
	 * Returns jqueryui block
	 *
	 * @return Jquery_Jqueryui
	 */
	public function jqueryui($theme = 'default') {
		return $this->Jquery_Jqueryui()->setTheme($theme);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the template loaded with specified data
	 *
	 * @param array
	 * @return Eden_Template
	 */
	public function template($file, array $data = array()) {
		Jquery_Error::i()->argument(1, 'string');
		return Eden_Template::i()->set($data)->parsePhp($file);
	}
	
	/**
	 * Generates an all pupose uid
	 *
	 * @return string
	 */
	public function uid() {
		return 'jquery'.time().'-'.self::$_uid++;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}