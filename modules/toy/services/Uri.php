<?php
/**
 * ToyPHP
 *
 * An open source application development framework for PHP 4 or newer
 *
 * @package		ToyPHP
 * @author		Nauris Dambis <nauris.renarti@gmail.com>
 * @copyright	Copyright (c) 20015 - 2016, Nauris Dambis
 * @license		https://github.com/nauris-renarti/ToyPHP/blob/master/LICENSE
 * @link		https://github.com/nauris-renarti/ToyPHP
 * @since		Version 1.0
 */

namespace toy\services;

use \toy;
use \Exception;
use \toy\factories\Param;

/**
 * Class Uri
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class Uri
{
	/**
	 * 
	 * @var string
	 */
	private $_path = '';
	
	/**
	 *
	 * @var string
	 */
	private $_method = '';
	
	/**
	 * 
	 * @var array
	 */
	private $_segments = array();
	
	/**
	 * 
	 * @var string
	 */
	public $allowedUriChars = 'a-z 0-9%#_\-=+';
	
	/**
	 * 
	 * @var bool|string
	 */
	private $_language = false;
	
	/**
	 * 
	 * @var string
	 */
	public $defaultUriLanguage = 'en';
	
	/**
	 * 
	 * @var array
	 */
	public $allowedUriLanguages = array('en');
	
	/**
	 * 
	 */
	public function __construct()
	{
		foreach (toy::module('toy')->config->valueOf(__CLASS__) as $k => $v) 
		{
			$this->$k = $v;
		}
		
		//$this->_path = isset($_SERVER['PATH_INFO'])? trim(filter_var($_SERVER['PATH_INFO'], FILTER_SANITIZE_URL), '/') : '';	
		$this->_path = isset($_SERVER['PATH_INFO'])? trim($_SERVER['PATH_INFO'], '/') : '';	
		$this->_method = isset($_SERVER['REQUEST_METHOD'])? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
		
		$allowedUriChars = str_replace( array('\-', '\\-', '#'), array('-', '/\-', '/\#'), preg_quote( $this->allowedUriChars ) );
		if (($this->_path != '') && ($allowedUriChars != ''))
		{
			if ( !preg_match("#^[".$allowedUriChars."]+$#i", $this->_path) ) 
			{
				throw new Exception("URI contain disallowed chars >> {$this->_path}");
			}
		}
		
		//$this->_path = rawurldecode( $this->_path );		
		$this->_segments = explode('/', $this->_path);
		foreach ($this->_segments as $k => $v)
		{
			$this->_segments[$k] = rawurldecode($v);
		}
	}
	
	/**
	 * 
	 * @return string
	 */
	public function language()
	{
		if ($this->_language === false)
		{
			if (!empty($this->_segments))
			{
				if (preg_match('/^[a-z]{2}$/i', $this->_segments[0]) && in_array(strtolower($this->_segments[0]), $this->allowedUriLanguages))
				{
					$this->_language = strtolower($this->_segments[0]);
				}
				else
				{
					$this->_language = $this->defaultUriLanguage;
				}
			}
			else 
			{
				$this->_language = $this->defaultUriLanguage;
			}
		}
		return $this->_language;
	}
	
	/**
	 * 
	 * @return array
	 */
	public function languages()
	{
		return $this->allowedUriLanguages;
	}
	
	/**
	 * 
	 * @param number $index
	 * @return \toy\services\Param
	 */
	public function segment($index = 2)
	{
		return isset($this->_segments[$index])? new Param($index, stARRAY, $this->_segments) : new Param($index, stARRAY, array());
	}
	
	/**
	 * 
	 * @return string
	 */
	public function path()
	{
		return $this->_path;
	}
	
	
}

/* End of file Uri.php */
/* Location: ./modules/toy/services/Uri.php */