<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Field_Textarea extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_attributes	= array();
	protected $_name 		= NULL;
	protected $_value 		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($name) {
		$this->_name = $name;
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
		
		return array(
			'attributes' 	=> $attributes,
			'value'			=> $this->_value);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return dirname(__FILE__).'/textarea.phtml';
	}
	
	/**
	 * Returns the template variables in key value format
	 *
	 * @param string|array
	 * @param scalar|null
	 * @return this
	 */
	public function setAttributes($name, $value = NULL) {
		Jquery_Field_Error::i()
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
	 * Sets the field value
	 *
	 * @param scalar
	 * @return this
	 */
	public function setValue($value) {
		Jquery_Field_Error::i()->argument(1, 'scalar');
		$this->_value = $value;
		return $this;
	}
}