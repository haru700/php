<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Field_Datetime extends Jquery_Field_Date {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_attributes	= array('class' => 'text datetime');
	protected static $_loaded = false;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the template variables in key value format
	 *
	 * @param array data
	 * @return array
	 */
	public function getVariables() {
		$attributes = $this->_attributes;
		$attributes['name'] = $this->_name;
		$attributes['type'] = 'text';
		
		if($this->_value) {
			$attributes['value'] = $this->_value;
		}
		
		if(isset($attributes['class'])) {
			$attributes['class'] = trim($attributes['class'].' eve-field-datetime');
		} else {
			$attributes['class'] = 'eve-field-datetime';
		}
		
		$loaded = self::$_loaded;
		self::$_loaded = true;
		
		return array(
			'loaded'		=> $loaded,
			'theme'			=> $this->_theme,
			'attributes' 	=> $attributes,
			'options'		=> $this->_options);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return dirname(__FILE__).'/datetime.phtml';
	}
	
	/**
	 * Sets loaded to previously loaded
	 *
	 * @return this
	 */
	public function loaded($loaded = true) {
		self::$_loaded = $loaded;
		return $this;
	}
}