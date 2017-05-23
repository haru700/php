<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Field_Slider extends Jquery_Field_Text {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_loaded = false;
	
	protected $_attributes	= array('class' => 'slider text');
	protected $_theme 		= NULL;
	protected $_options 	= array();
	protected $_size		= '100px';
	
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
		$attributes['value'] = $this->_value;
		
		return array(
			'loaded'		=> $loaded,
			'theme'			=> $this->_theme,
			'attributes' 	=> $attributes,
			'size'			=> $this->_size,
			'options'		=> $this->_options);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return dirname(__FILE__).'/slider.phtml';
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
	 * Set Size
	 *
	 * @param string|array
	 * @param scalar
	 * @return this
	 */
	public function setSize($size, $scale = 'px') {
		Jquery_Field_Error::i()
			->argument(1, 'int', 'float')
			->argument(2, 'string');
		
		$this->_size = $size.$scale;
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