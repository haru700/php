<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Field_Wysiwyg extends Jquery_Field_Textarea {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_loaded = false;
	
	protected $_theme = 'default';
	
	protected $_options = array(
		'width' => '750px', 
		'language' => 'en', 
		'customConfig' => '', 
		'toolbar' => array(
			array('Maximize', 'ShowBlocks', 'Source',
			'-', 'Bold', 'Italic', 'Underline', 'Strike', 
			'-', 'Subscript', 'Superscript', 
			'-', 'NumberedList', 'BulletedList', 
			'-', 'Outdent', 'Indent', 'Blockquote', 
			'-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 
			'-', 'Link', 'Unlink', 
			'-', 'Image', 'Table', 'HorizontalRule', 'SpecialChar', 'TextColor'),
			array('Styles', 'Format', 'Font', 'FontSize')));
	
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
		
		if(isset($attributes['class'])) {
			$attributes['class'] = trim($attributes['class'].' eve-field-wysiwyg');
		} else {
			$attributes['class'] = 'eve-field-wysiwyg';
		}
		
		$loaded = self::$_loaded;
		self::$_loaded = true;
		
		return array(
			'loaded'		=> $loaded,
			'theme'			=> $this->_theme,
			'options'		=> $this->_options,
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
		return dirname(__FILE__).'/wysiwyg.phtml';
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
	 * @param scalar|null|array
	 * @return this
	 */
	public function setOptions($option, $value = NULL) {
		Jquery_Field_Error::i()
			->argument(1, 'array', 'string')
			->argument(2, 'scalar', 'null', 'array');
		
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