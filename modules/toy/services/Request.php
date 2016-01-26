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

use \Exception;
use \toy\factories\Param;

/**
 * Class Request
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class Request
{
	/**
	 * 
	 * @var unknown
	 */
	private $_PHP_INPUT = array();
	
	/**
	 * 
	 * @var string
	 */
	public $method = false;
	
	/**
	 * 
	 * @param unknown $module
	 * @param unknown $args
	 */
	public function __construct()
	{
		if (isset($_SERVER['X-XSRF-TOKEN'])) 
		{
			if (toy::module('toy')->xsrf->isValid($_SERVER['X-XSRF-TOKEN']) === false)
			{
				throw new Exception('Invalid request credentials');
			}
		}

		$_php_input = @file_get_contents('php://input');
				
		if ( !empty($_php_input) ) 
		{
			$this->_PHP_INPUT = json_decode($_php_input, true);
		}
		
		$this->method = isset($_SERVER['REQUEST_METHOD'])? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
	}
	
	/**
	 * 
	 * @param array $value
	 */
	public function setStream($value)
	{
		$this->_PHP_INPUT = $value;
	}
	
	
	/**
	 *
	 * @param unknown $name
	 * @return \toy\factories\Param
	 */
	public function __get($name)
	{
		if (isset($_GET[$name]))
		{
			return (new Param($name, stGET, $_GET));
		}
		else if (isset($_POST[$name]))
		{
			return (new Param($name, stPOST, $_POST));
		}
		else if (isset($_REQUEST[$name]))
		{
			return (new Param($name, stREQUEST, $_REQUEST));
		}
		else if (isset($_COOKIE[$name]))
		{
			return (new Param($name, stCOOKIE, $_COOKIE));
		}
		else if (isset($_SERVER[$name]))
		{
			return (new Param($name, stSERVER, $_SERVER));
		}
		else if (isset($_SESSION[$name]))
		{
			return (new Param($name, stSESSION, $_SESSION));
		}
		else if (isset($_FILES[$name]))
		{
			return (new Param($name, stFILES, $_FILES));
		}
		else if (isset($GLOBALS[$name]))
		{
			return (new Param($name, stGLOBALS, $GLOBALS));
		}
		else if (isset($_ENV[$name]))
		{
			return (new Param($name, stENV, $_ENV));
		}
		else if (isset($this->_PHP_INPUT[$name]))
		{
			return (new Param($name, stPHPINPUT, $this->_PHP_INPUT));
		}
		else
		{
			return new Param($name, stARRAY,array());
		}
	}
	
	/**
	 *
	 * @param string $name
	 * @return \toy\factories\Param
	 */
	public function valueOf($name)
	{
		return $this->$name;
	}
	
	/**
	 * @return boolean
	 */
	public static function isAjax()
	{
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHttpRequest');
	}
	
	/**
	 *
	 * @return boolean
	 */
	public static function isHttps()
	{
		if (! isset($_SERVER['HTTPS']))
		{
			return false;
		}
		else if ($_SERVER['HTTPS'] == 1) // Apache
		{
			return true;
		}
		else if ($_SERVER['HTTPS'] == 'on') // IIS
		{
			return true;
		}
		else if ($_SERVER['SERVER_PORT'] == 443)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	/**
	 *
	 * @return boolean
	 */
	public static function isCli()
	{
		return (php_sapi_name() === 'cli' || defined('STDIN'));
	}
	
	/**
	 *
	 * @return number
	 */
	public static function isDeveloper()
	{
		return preg_match('/(::1|127.0.0.1|localhost)/i', $_SERVER['HTTP_HOST']);
	}
	
	/**
	 * 
	 * @return string
	 */
	public static function ip()
	{
		if (isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['HTTP_CLIENT_IP']))
		{
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		else if (isset($_SERVER['REMOTE_ADDR']))
		{
			return $_SERVER['REMOTE_ADDR'];
		}
		else if (isset($_SERVER['HTTP_CLIENT_IP']))
		{
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		return'0.0.0.0';
	}
}

/* End of file Request.php */
/* Location: ./modules/toy/services/Request.php */