<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
class Jquery_Block_Pagination extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_start 	= 0;
	protected $_range 	= 25;
	protected $_total 	= 0;
	protected $_show	= 5;
	protected $_query 	= array();
	protected $_url 	= NULL;
	protected $_class	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($total) {
		$this->_total = $total;
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
		$pages 	= ceil($this->_total / $this->_range);
		$page 	= floor($this->_start / $this->_range) + 1;
		$min 	= $page - $this->_show;
		$max 	= $page + $this->_show;
		
		if($min < 1) {
			$min = 1;
		}
		
		if($max > $pages) {
			$max = $pages;
		}
		
		return array(
			'class'	=> $this->_class,
			'url'	=> $this->_url,
			'query' => $this->_query,
			'start' => $this->_start,
			'range' => $this->_range,
			'total' => $this->_total,
			'show'	=> $this->_show,
			'min'	=> $min,
			'max'	=> $max, 
			'pages' => $pages,
			'page'	=> $page);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).self::$_blockRoot.'/pagination.phtml');
	}
	
	/**
	 * Sets start
	 *
	 * @param int
	 * @return this 
	 */
	public function setStart($start) {
		Jquery_Block_Error::i()->argument(1, 'int');
		if($start < 0) {
			$start = 0;
		}
		
		$this->_start = $start;
		
		return $this;
	}
	
	/**
	 * Sets range
	 *
	 * @param int
	 * @return this 
	 */
	public function setRange($range) {
		Jquery_Block_Error::i()->argument(1, 'int');
		if($range < 0) {
			$range = 1;
		}
		
		$this->_range = $range;
		
		return $this;
	}
	
	/**
	 * Sets page
	 *
	 * @param int
	 * @return this 
	 */
	public function setPage($page) {
		Jquery_Block_Error::i()->argument(1, 'int');
		if($page < 1) {
			$page = 1;
		}
		
		$this->_start = ( $page - 1 ) * $this->_range;
		return $this;
	}
	
	/**
	 * Sets pages to show left and right of the current page
	 *
	 * @param int
	 * @return this 
	 */
	public function setShow($show) {
		Jquery_Block_Error::i()->argument(1, 'int');
		if($show < 1) {
			$show = 1;
		}
		
		$this->_show = $show;
		
		return $this;
	}
	
	/**
	 * This Block has pagination we need to pass in the GET query
	 *
	 * @param array
	 * @return this
	 */
	public function setQuery(array $query) {
		$this->_query = $query;
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
}