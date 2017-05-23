<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Block_Dialog extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_theme 	= 'default';
	protected $_title 	= NULL;
	protected $_content = NULL;
	protected $_options = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($title, $content) {
		$this->_title 	= $title;
		$this->_content = $content;
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
		$this->_options['title'] = $this->_title;
		
		return array(
			'content'	=> $this->_content,
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
		return dirname(__FILE__).'/dialog.phtml';
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