<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Jqueryui extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_loaded = false;
	
	protected $_themes = array(
		'default' 			=> '/assets/jquery/jqueryui/default.css', 
		'ui-lightness'		=> '/assets/jquery/jqueryui/ui-lightness.css', 
		'ui-darkness'		=> '/assets/jquery/jqueryui/ui-darkness.css', 
		'smoothness'		=> '/assets/jquery/jqueryui/smoothness.css', 
		'start'				=> '/assets/jquery/jqueryui/start.css', 
		'redmond'			=> '/assets/jquery/jqueryui/redmond.css', 
		'sunny'				=> '/assets/jquery/jqueryui/sunny.css', 
		'overcast'			=> '/assets/jquery/jqueryui/overcast.css', 
		'le-frog'			=> '/assets/jquery/jqueryui/le-frog.css', 
		'flick'				=> '/assets/jquery/jqueryui/flick.css', 
		'pepper-grinder'	=> '/assets/jquery/jqueryui/pepper-grinder.css', 
		'eggplant'			=> '/assets/jquery/jqueryui/eggplant.css', 
		'dark-hive'			=> '/assets/jquery/jqueryui/dark-hive.css', 
		'cupertino'			=> '/assets/jquery/jqueryui/cupertino.css', 
		'south-street'		=> '/assets/jquery/jqueryui/south-street.css', 
		'blitzer'			=> '/assets/jquery/jqueryui/blitzer.css', 
		'humanity'			=> '/assets/jquery/jqueryui/humanity.css', 
		'hot-sneaks'		=> '/assets/jquery/jqueryui/hot-sneaks.css', 
		'excite-bike'		=> '/assets/jquery/jqueryui/excite-bike.css', 
		'vader'				=> '/assets/jquery/jqueryui/vader.css', 
		'dot-luv'			=> '/assets/jquery/jqueryui/dot-luv.css', 
		'mint-choc'			=> '/assets/jquery/jqueryui/mint-choc.css', 
		'black-tie'			=> '/assets/jquery/jqueryui/black-tie.css', 
		'trontastic'		=> '/assets/jquery/jqueryui/trontastic.css', 
		'swank-purse'		=> '/assets/jquery/jqueryui/swank-purse.css'); 
		
	protected $_theme = 'default';
	
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
		$loaded = self::$_loaded;
		self::$_loaded = true;
		return array(
			'loaded' 	=> $loaded,
			'theme'		=> $this->_theme);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return dirname(__FILE__).'/jqueryui.phtml';
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
	 * Sets the theme
	 *
	 * @param string
	 * @return this
	 */
	public function setTheme($theme) {
		Jquery_Jqueryui_Error::i()->argument(1, 'string');
		
		if($theme === 'random') {
			$theme = array_rand($this->_themes);
		}
		
		if(isset($this->_themes[$theme])) {
			$theme = $this->_themes[$theme];
		}
		
		$this->_theme = $theme;
		return $this;
	}
}


/*
 * jQuery UI Error
 */
class Jquery_Jqueryui_Error extends Eden_Error {
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