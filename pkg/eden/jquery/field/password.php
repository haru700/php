<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Field_Password extends Jquery_Field_Text {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_attributes	= array('class' => 'password');
	
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
		$loaded = self::$_loaded;
		
		$attributes = $this->_attributes;
		$attributes['name'] = $this->_name;
		$attributes['type'] = 'password';
		
		if($this->_hint) {
			self::$_loaded = true;
			if(isset($attributes['class'])) {
				$attributes['class'] = trim($attributes['class'].' eve-field-hint');
			} else {
				$attributes['class'] = 'eve-field-hint';
			}
		}
		
		if($this->_value) {
			$attributes['value'] = $this->_value;
		}
		
		return array(
			'loaded'		=> $loaded,
			'attributes' 	=> $attributes,
			'hint'			=> $this->_hint);
	}
}