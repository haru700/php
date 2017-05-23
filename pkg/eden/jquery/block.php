<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Block extends Eden_Class {
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
	 * Returns accordion block
	 *
	 * @param array
	 * @param string|null
	 * @return Jquery_Block_Accordion
	 */
	public function accordion(array $options = array(), $theme = 'default') {
		Jquery_Block_Error::i()->argument(2, 'string', 'null');
		return $this->Jquery_Block_Accordion()->setOptions($options)->setTheme($theme);
	}
	
	/**
	 * Returns accordion block
	 *
	 * @param array
	 * @param string|null
	 * @return Jquery_Block_Tabs
	 */
	public function tabs(array $options = array(), $theme = 'default') {
		Jquery_Block_Error::i()->argument(2, 'string', 'null');
		return $this->Jquery_Block_Tabs()->setOptions($options)->setTheme($theme);
	}
	
	/**
	 * Returns accordion block
	 *
	 * @param array
	 * @param string|null
	 * @return Jquery_Block_Dialog
	 */
	public function dialog($title, $content, array $options = array(), $theme = 'default') {
		Jquery_Block_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(4, 'string', 'null');
			
		return $this->Jquery_Block_Dialog($title, $content)->setOptions($options)->setTheme($theme);
	}
	
	/**
	 * Returns table sort block
	 *
	 * @param array
	 * @param string
	 * @param string
	 * @param string|null
	 * @return Jquery_Block_Sort
	 */
	public function sort(array $query, $key, $label, $url = NULL) {
		Jquery_Block_Error::i()
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string', 'null');
			
		$block = $this->Jquery_Block_Sort($query, $key, $label);
		
		if($url) {
			$block->setUrl($url);
		}
		
		return $block;
	}
	
	/**
	 * Returns pagination block
	 *
	 * @param int
	 * @return Jquery_Block_Pagination
	 */
	public function pagination($total) {
		Jquery_Block_Error::i()->argument(1, 'int');
		return $this->Jquery_Block_Pagination($total);
	}
	
	/**
	 * Returns grid block
	 *
	 * @param int
	 * @param string
	 * @param string
	 * @return Jquery_Block_Grid
	 */
	public function grid($total, $url, $theme = 'default') {
		Jquery_Block_Error::i()
			->argument(1, 'int')
			->argument(2, 'string')
			->argument(3, 'string');
			
		return $this->Jquery_Block_Grid($total, $url)->setTheme($theme);
	}
	
	/**
	 * Returns tree block
	 *
	 * @param string|null
	 * @param string
	 * @return Jquery_Block_Tree
	 */
	public function tree($url = NULL, $theme = 'default') {
		Jquery_Block_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string');
			
		return $this->Jquery_Block_Tree($url)->setTheme($theme);
	}
	
	/**
	 * Returns navigation block
	 *
	 * @param string|null
	 * @param string
	 * @return Jquery_Block_Navigation
	 */
	public function navigation($url = NULL, $theme = 'default') {
		Jquery_Block_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string');
			
		return $this->Jquery_Block_Navigation($url)->setTheme($theme);
	}
	
	/**
	 * Returns panel block
	 *
	 * @param string
	 * @param string|bool
	 * @param string|bool
	 * @param string|bool
	 * @param string|bool
	 * @param string
	 * @return Jquery_Block_Panel
	 */
	public function panel($center, $north = false, $south = false, $east = false, $west = false, $theme = 'default') {
		Jquery_Block_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'bool')
			->argument(3, 'string', 'bool')
			->argument(4, 'string', 'bool')
			->argument(5, 'string', 'bool')
			->argument(6, 'string');
			
		return $this->Jquery_Block_Panel($center, $north, $south, $east, $west)->setTheme($theme);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/*
 * Block Error
 */ 
class Jquery_Block_Error extends Eden_Error {
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