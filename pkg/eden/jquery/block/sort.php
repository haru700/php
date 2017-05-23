<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Block_Sort extends Eden_Block {
	/* Constants
	-------------------------------*/
	const ASC 	= 'ASC';
	const DESC 	= 'DESC';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query 	= array();
	protected $_url 	= NULL;
	protected $_key		= NULL;
	protected $_label	= NULL;
	protected $_class	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($query, $key, $label) {
		$this->_query 	= $query;
		$this->_key 	= $key;
		$this->_label 	= $label;
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
		$order = NULL;
		if(!isset($this->_query['sort']) || $this->_query['sort'] != $this->_key) {
			$this->_query['sort'] = $this->_key;
			$this->_query['order'] = self::ASC;
		} else if($this->_query['order'] == self::ASC) {
			$order = self::ASC;
			$this->_query['order'] = self::DESC;
		} else {
			$order = self::DESC;
			$this->_query['order'] = self::ASC;
		}
		
		return array(
			'url'	=> $this->_url,
			'query' => $this->_query,
			'label' => $this->_label,
			'order'	=> strtolower($order),
			'class'	=> $this->_class);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).self::$_blockRoot.'/sort.phtml');
	}
	
	/**
	 * Sets class for each page link
	 *
	 * @param array
	 * @return this
	 */
	public function setClass($class) {
		Jquery_Block_Error::i()->argument(1, 'string');
		$this->_class = $class;
		return $this;
	}
	
	/**
	 * This Block has pagination we need to pass in the url
	 *
	 * @param array
	 * @return this
	 */
	public function setUrl($url) {
		Jquery_Block_Error::i()->argument(1, 'string');
		$this->_url = $url;
		return $this;
	}
}