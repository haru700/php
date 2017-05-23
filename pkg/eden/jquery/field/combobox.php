<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Field_Combobox extends Jquery_Field_Select {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_loaded = false;
	
	protected $_theme 		= NULL;
	protected $_options 	= array();
	
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
		self::$_loaded = true;
		
		if(isset($attributes['class'])) {
			$attributes['class'] = trim($attributes['class'].' eve-field-combobox');
		} else {
			$attributes['class'] = 'eve-field-combobox';
		}
		
		return array(
			'loaded'		=> $loaded,
			'theme'			=> $this->_theme,
			'attributes' 	=> $this->_attributes,
			'options'		=> $this->_options,
			'items'			=> $this->_items,
			'name'			=> $this->_name,
			'value'			=> $this->_value);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return dirname(__FILE__).'/combobox.phtml';
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