<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Field_Button extends Jquery_Field_Text {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_attributes	= array('class' => 'text');
	protected $_theme 		= 'default';
	protected $_options 	= array();
	protected $_submit		= false;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($name, $submit) {
		$this->_name 	= $name;
		$this->_submit 	= $submit;
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
		$attributes['type'] = 'button';
		
		if($this->_submit) {
			$attributes['type'] = 'submit';
		}
		
		if(isset($attributes['class'])) {
			$attributes['class'] = trim($attributes['class'].' eve-field-button');
		} else {
			$attributes['class'] = 'eve-field-button';
		}
		
		return array(
			'theme'			=> $this->_theme,
			'attributes' 	=> $attributes,
			'options'		=> $this->_options,
			'value'			=> $this->_value);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return dirname(__FILE__).'/button.phtml';
	}
	
	/**
	 * Set Options
	 *
	 * @param string|array
	 * @param scalar
	 * @return this
	 */
	public function setOptions($option, $value = NULL) {
		Jquery_Field_Error::i()
			->argument(1, 'array', 'string')
			->argument(2, 'scalar', 'null');
			
		if(is_array($option)) {
			$this->_options = $option;
			return $this;
		}
		
		$this->_options[$option] = $value;
		return $this;
	}
	
	/**
	 * Set JqueryUI Theme
	 *
	 * @param string
	 * @return this
	 */
	public function setTheme($theme) {
		Jquery_Field_Error::i()->argument(1, 'string');
		$this->_theme = $theme;
		return $this;
	}
}