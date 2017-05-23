<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Block_Panel extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_loaded = false;
	
	protected $_theme 		= 'default';
	protected $_options 	= array();
	protected $_attributes	= array();
	
	protected $_panels		= array();
	protected $_position	= array(0, 0, 0, 0);
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($center, $north = false, $south = false, $east = false, $west = false) {
		$this->_panels = array($center, $north, $south, $east, $west);
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
		
		return array(
			'panels'		=> $this->_panels,
			'position'		=> $this->_position,
			'loaded'		=> $loaded,
			'options'		=> $this->_options,
			'attributes' 	=> $this->_attributes,
			'theme' 		=> $this->_theme);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return dirname(__FILE__).'/panel.phtml';
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
	 * Returns the template variables in key value format
	 *
	 * @param string|array
	 * @param scalar|null
	 * @return this
	 */
	public function setAttributes($name, $value = NULL) {
		Jquery_Block_Error::i()
			->argument(1, 'string', 'array')
			->argument(2, 'scalar', 'null');
		
		if(is_array($name)) {
			$this->_attributes = $name;
			return $this;
		}
		
		$this->_attributes[$name] = $value;
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
		Jquery_Block_Error::i()
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
	 * Sets Panel Position
	 *
	 * @param string
	 * @return this
	 */
	public function setPosition($top = 0, $bottom = 0, $left = 0, $right = 0) {
		Jquery_Block_Error::i()->argument(1, 'string');
		$this->_position = array($top, $bottom, $left, $right);
		return $this;
	}
	
	/**
	 * Set JqueryUI Theme
	 *
	 * @param string
	 * @return this
	 */
	public function setTheme($theme) {
		Jquery_Block_Error::i()->argument(1, 'string');
		$this->_theme = $theme;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}