<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Field_Tags extends Jquery_Field_Text {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_loaded = false;
	
	protected $_attributes	= array('class' => 'text tags');
	protected $_theme 		= 'default';
	protected $_options 	= array();
	protected $_items		= array();
	
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
		
		$attributes = $this->_attributes;
		$attributes['name'] = $this->_name;
		$attributes['type'] = 'text';
		$attributes['size'] = 1; 
		
		if(isset($attributes['class'])) {
			$attributes['class'] = trim($attributes['class'].' eve-field-tags-field');
		} else {
			$attributes['class'] = 'eve-field-tags-field';
		}
		
		return array(
			'value'			=> $this->_value,
			'loaded'		=> $loaded,
			'theme'			=> $this->_theme,
			'attributes' 	=> $attributes,
			'items'			=> $this->_items,
			'options'		=> $this->_options);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return dirname(__FILE__).'/tags.phtml';
	}
	
	/**
	 * Adds item to the accordion
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return this
	 */
	public function setItems($item) {
		Jquery_Field_Error::i()->argument(1, 'array', 'scalar');
		
		if(is_array($item)) {
			$this->_items = array_values($item);
			return $this;
		}
		
		$this->_items[] = $item;
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
	
	/**
	 * Sets the field value
	 *
	 * @param scalar
	 * @return this
	 */
	public function setValue($value) {
		Jquery_Field_Error::i()->argument(1, 'scalar', 'array');
		$this->_value = $value;
		return $this;
	}
}