<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Block_Accordion extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_theme 	= 'default';
	protected $_items 	= array();
	protected $_options = array();
	
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
	 * Adds item to the accordion
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return this
	 */
	public function addItem($title, $content, $href = '#') {
		Jquery_Block_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string');
			
		$this->_items[] = array($href, $title, $content);
		return $this;
	}
	
	/**
	 * Returns the template variables in key value format
	 *
	 * @param array data
	 * @return array
	 */
	public function getVariables() {
		return array(
			'items'		=> $this->_items,
			'options'	=> $this->_options,
			'theme' 	=> $this->_theme);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return dirname(__FILE__).'/accordion.phtml';
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
}