<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Field_Submit extends Jquery_Field_Text {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_image		= NULL;
	protected $_attributes	= array('class' => 'submit');
	
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
		
		if($this->_name) {
			$attributes['name'] = $this->_name;
		}
		
		$attributes['type'] = 'submit';
		
		if($this->_image) {
			$attributes['type'] = 'image';
			$attributes['src'] = $this->_image;
		}
			
		if($this->_value) {
			$attributes['value'] = $this->_value;
		}
		
		return array('attributes' => $attributes);
	}
	
	/**
	 * Sets a background image
	 *
	 * @param string
	 * @return this
	 */
	public function setImage($image) {
		Jquery_Field_Error::i()->argument(1, 'string');
		$this->_image = $image;
		return $this;
	}
	
	
}