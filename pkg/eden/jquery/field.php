<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Field extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns a text field
	 *
	 * @param string
	 * @param scalar|null
	 * @return Jquery_Field_Text
	 */
	public function text($name, $value = NULL, $hint = NULL) {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null');
			
		$field = $this->Jquery_Field_Text($name);
		
		if(!is_null($value)) {
			$field->setValue($value);
		}
		
		if(!is_null($hint)) {
			$field->setHint($hint);
		}
		
		return $field;
	}
	
	/**
	 * Returns a password field
	 *
	 * @param string
	 * @param scalar|null
	 * @return Jquery_Field_Password
	 */
	public function password($name, $value = NULL, $hint = NULL) {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null');
			
		$field = $this->Jquery_Field_Password($name);
		
		if(!is_null($value)) {
			$field->setValue($value);
		}
		
		if(!is_null($hint)) {
			$field->setHint($hint);
		}
		
		return $field;
	}
	
	/**
	 * Returns a file field
	 *
	 * @param string
	 * @param bool
	 * @param array
	 * @return Jquery_Field_File
	 */
	public function file($name, $multiple = false, array $accept = array()) {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'bool');
			
		$field = $this->Jquery_Field_File($name, $multiple);
		
		if($multiple) {
			$field->setAttributes('multiple', 'multiple');
		}
		
		if(!empty($accept)) {
			$field->setAttributes('accept', implode(',', $accept));
		}
		
		return $field;
	}
	
	/**
	 * Returns an image upload field
	 *
	 * @param string
	 * @param bool
	 * @return Jquery_Field_File
	 */
	public function image($name, $multiple = false) {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'bool');
		
		$accept = array('image/gif','image/jpg','image/jpeg','image/png');
		return $this->file($name, $multiple, $accept);
	}
	
	/**
	 * Returns a submit field
	 *
	 * @param string
	 * @param scalar|null
	 * @param string|null
	 * @return Jquery_Field_Submit
	 */
	public function submit($value, $name = NULL, $image = NULL) {
		Jquery_Field_Error::i()->argument(1, 'string');
		$field = $this->Jquery_Field_Submit($name)->setValue($value);
		if($image) {
			$field->setImage($image);
		}
		
		return $field;
	}
	
	
	/**
	 * Returns a color field
	 *
	 * @param string
	 * @param scalar|null
	 * @return Jquery_Field_Color
	 */
	public function color($name, $value = NULL) {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'null');
			
		$field = $this->Jquery_Field_Color($name);
		
		if(!is_null($value)) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns a textarea field
	 *
	 * @param string
	 * @param scalar|null
	 * @return Jquery_Field_Textarea
	 */
	public function textarea($name, $value = NULL) {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null');
			
		$field = $this->Jquery_Field_Textarea($name);
		
		if(!is_null($value)) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns a WYSIWYG field
	 *
	 * @param string
	 * @param scalar|null
	 * @return Jquery_Field_Textarea
	 */
	public function wysiwyg($name, $value = NULL) {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null');
			
		$field = $this->Jquery_Field_Wysiwyg($name);
		
		if(!is_null($value)) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns a select field
	 *
	 * @param string
	 * @param array
	 * @param scalar|null
	 * @return Jquery_Field_Select
	 */
	public function select($name, $value = NULL, array $items = array()) {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null');
			
		$field = $this->Jquery_Field_Select($name)->setItems($items);
		
		if(!is_null($value)) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns a radio fieldset
	 *
	 * @param string
	 * @param array
	 * @param scalar|null
	 * @return Jquery_Field_Radio
	 */
	public function radio($name, $value = NULL, array $items = array()) {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null');
			
		$field = $this->Jquery_Field_Radio($name)->setItems($items);
		
		if(!is_null($value)) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns a checkbox field or fieldset
	 *
	 * @param string
	 * @param array
	 * @param scalar|null
	 * @return Jquery_Field_Checkbox
	 */
	public function checkbox($name, $value = NULL, $items = array()) {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'array', 'null')
			->argument(3, 'string', 'array');
		
		if(is_string($options)) {
			$options = array(1 => $options);
		}
		
		$field = $this->Jquery_Field_Checkbox($name)->setItems($items);
		
		if(!is_null($value)) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns a date field
	 *
	 * @param string
	 * @param scalar|null
	 * @param string
	 * @return Jquery_Field_Date
	 */
	public function date($name, $value = NULL, $theme = 'default') {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null')
			->argument(3, 'string');
			
		$field = $this->Jquery_Field_Date($name)->setTheme($theme);
		
		if($value) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns a datetime field
	 *
	 * @param string
	 * @param scalar|null
	 * @param string|null
	 * @return Jquery_Field_Datetime
	 */
	public function datetime($name, $value = NULL, $theme = 'default') {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null')
			->argument(3, 'string', 'null');
			
		$field = $this->Jquery_Field_Datetime($name)->setTheme($theme);
		
		if($value) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns a time field
	 *
	 * @param string
	 * @param scalar|null
	 * @param string
	 * @return Jquery_Field_Time
	 */
	public function time($name, $value = NULL, $theme = 'default') {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null')
			->argument(3, 'string');
			
		$field = $this->Jquery_Field_Time($name)->setTheme($theme);
		
		if($value) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns a slider field
	 *
	 * @param string
	 * @param scalar|null
	 * @param string
	 * @return Jquery_Field_Slider
	 */
	public function slider($name, $value = 0, $theme = 'default') {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null')
			->argument(3, 'string');
			
		return $this->Jquery_Field_Slider($name)->setTheme($theme)->setValue($value);
	}
	
	/**
	 * Returns an autocomplete field
	 *
	 * @param string
	 * @param array
	 * @param string
	 * @return Jquery_Field_Autocomplete
	 */
	public function autocomplete($name, array $items, $value = NULL, $theme = 'default') {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(3, 'scalar', 'null')
			->argument(4, 'string');
			
		$field = $this
			->Jquery_Field_Autocomplete($name)
			->setItems($items)->setTheme($theme);
		
		if($value) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns a tags field
	 *
	 * @param string
	 * @param array
	 * @param string
	 * @return Jquery_Field_Tags
	 */
	public function tags($name, $value = NULL, array $items = array(), $theme = 'default') {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null', 'array')
			->argument(4, 'string');
			
		$field = $this
			->Jquery_Field_Tags($name)
			->setItems($items)->setTheme($theme);
		
		if($value) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns an combobox field
	 *
	 * @param string
	 * @param scalar|null
	 * @param array
	 * @param array
	 * @param string
	 * @return Jquery_Field_Combobox
	 */
	public function combobox($name, $value = NULL, array $items = array(), array $options = array(), $theme = 'default') {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'scalar', 'null')
			->argument(5, 'string');
			
		$field = $this
			->Jquery_Field_Combobox($name)
			->setOptions($options)
			->setItems($items)
			->setTheme($theme);
		
		if($value) {
			$field->setValue($value);
		}
		
		return $field;
	}
	
	/**
	 * Returns a ui button field
	 *
	 * @param string
	 * @param string|null
	 * @param bool
	 * @return Jquery_Field_Button
	 */
	public function button($value, $name = NULL, $submit = false, $theme = 'default') {
		Jquery_Field_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'null')
			->argument(3, 'bool')
			->argument(4, 'string');
		
		return $this
			->Jquery_Field_Button($name, $submit)
			->setTheme($theme)->setValue($value);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/*
 * Field Error
 */ 
class Jquery_Field_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}