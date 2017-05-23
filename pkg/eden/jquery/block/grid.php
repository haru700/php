<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
 
//TODO
//Images
//Links
//resizing
class Jquery_Block_Grid extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_loaded = false;
	
	protected $_ajax	= false;
	protected $_url		= NULL;
	protected $_theme 	= 'default';
	protected $_total	= 1;
	
	protected $_options = array('pin' => 1);
	
	protected $_columns = array();
	protected $_rows	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($total, $url) {
		$this->_total 	= $total;
		$this->_url		= $url;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Defines a column and meta
	 *
	 * @param string
	 * @param string|array
	 * @param int
	 * @param string|bool
	 * @return this
	 */
	public function addColumn($key, $label, $width = 300, $field = 'text') {
		Jquery_Block_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'array')
			->argument(3, 'int')
			->argument(4, 'string', 'bool');
			
		if(is_array($label)) {
			$label['key'] = $key;
			if(!isset($label['field'])) {
				$label['field'] = false;
			}
			
			if(!isset($label['width'])) {
				$label['width'] = 300;
			}
			
			if(!isset($label['prefix'])) {
				$label['prefix'] = NULL;
			}
			
			if(!isset($label['decimal'])) {
				$label['decimal'] = '.';
			}
			
			if(!isset($label['places'])) {
				$label['places'] = 0;
			}
			
			if(!isset($label['separator'])) {
				$label['separator'] = ',';
			}
			
			if(!isset($label['options'])) {
				$label['options'] = array();
			}
			
			$this->_columns[] = $label;	
			return $this;
		}
		
		$this->_columns[] = array(
			'key'		=> $key,
			'label'		=> $label,
			'width'		=> $width,
			'field'		=> $field,
			'prefix'	=> NULL,
			'decimal'	=> '.',
			'places'	=> 0,
			'separator'	=> ',',
			'options'	=> array());
		
		return $this;
	}
	
	/**
	 * Adds a row
	 *
	 * @param array
	 * @return this
	 */
	public function addRow(array $row) {
		$this->_rows[] = $row;
		return $this;
	}
	
	/**
	 * Sets output to just body and pin
	 *
	 * @return this
	 */
	public function ajaxMode($mode = true) {
		$this->_ajax = $mode;
		return $this;
	}
	
	/**
	 * Returns the template variables in key value format
	 *
	 * @param array data
	 * @return array
	 */
	public function getVariables() {
		$width = 0;
		$pinWidth = 0;
		foreach($this->_columns as $i => $column) {
			$width += $column['width'];
			if($i < $this->_options['pin']) {
				$pinWidth += $column['width'];
			}
			
		}
		
		$loaded = self::$_loaded;
		self::$_loaded = true;
		
		$wysiwyg = array(
			'width' => '99%', 
			'height' => '100px', 
			'language' => 'en', 
			'customConfig' => '', 
			'toolbar' => array(
			array('Maximize', 'Source',
			'-', 'Bold', 'Italic', 'Underline', 'Strike', 
			'-', 'NumberedList', 'BulletedList',
			'-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'), 
			array('Link', 'Unlink', 
			'-', 'Image', 'Table', 'TextColor',
			'-', 'Font', 'FontSize')));
		
		return array(
			'total'			=> $this->_total,
			'loaded'		=> $loaded,
			'url'			=> $this->_url,
			'columns'		=> $this->_columns,
			'rows'			=> $this->_rows,
			'options'		=> $this->_options,
			'width'			=> $width,
			'pin_width'		=> $pinWidth,
			'theme' 		=> $this->_theme,
			'wysiwyg'		=> $wysiwyg);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		if($this->_ajax) {
			return dirname(__FILE__).'/grid/ajax.phtml';
		}
		
		return dirname(__FILE__).'/grid.phtml';
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
	 * Set rows
	 *
	 * @param array
	 * @return this
	 */
	public function setRows(array $rows) {
		foreach($rows as $row) {
			$this->addRow($row);
		}
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