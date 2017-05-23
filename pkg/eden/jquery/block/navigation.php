<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Block_Navigation extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_loaded = false;
	
	protected $_theme 		= 'default';
	protected $_start 		= false;
	protected $_node 		= NULL;
	protected $_root 		= NULL;
	protected $_options 	= array();
	protected $_attributes	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($root = NULL, $node = NULL) {
		if(!$node) {
			$this->_start = true;
			$node = $this->_createNode('', '', $root, NULL);
		}
		
		$this->_root = $root;
		$this->_node = $node;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Adds node to the tree
	 *
	 * @param string
	 * @param string|null
	 * @param string|null
	 * @param string
	 * @param bool
	 * @return this
	 */
	public function addNode($key, $label, $href, $type = NULL, $path = NULL) {
		Jquery_Block_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string', 'null')
			->argument(5, 'string', 'null');
		
		$paths = explode('/', $path);

		$parent = $this->_node;
		foreach($paths as $path) {
			if(!isset($parent->children[$path])) {
				break;
			}
			
			$parent = $parent->children[$path];
		}
		
		$parent->children[$key] = $this->_createNode($key, $label, $href, $type, $parent);
		
		return $this;
	}
	
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
			'start'			=> $this->_start,
			'loaded'		=> $loaded,
			'node'			=> $this->_node,
			'root'			=> $this->_root,
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
		return dirname(__FILE__).'/navigation.phtml';
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
	protected function _createNode($key, $label, $href, $type, $parent = NULL) {
		$node = new stdClass();
		$node->key = $key;
		$node->type = $type;
		$node->label = $label;
		$node->href = $href;
		$node->children = array();
		
		return $node;
	}
	
	/* Private Methods
	-------------------------------*/
}