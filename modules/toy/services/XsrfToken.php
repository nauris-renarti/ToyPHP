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

/**
 * Class XsrfToken
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class XsrfToken
{
	/**
	 * 
	 * @var unknown
	 */
	private $_token = false;
	
	/**
	 * 
	 * @var string
	 */
	public $tokenName = 'XSRF-TOKEN';
	
	
	/**
	 * 
	 */
	public function __construct()
	{
		foreach (toy::module()->config->valueOf(__CLASS__) as $k => $v) 
		{
			$this->$k = $v;
		}
		
		// $this->_token =  isset($_SESSION[$this->tokenName])? $_SESSION[$this->tokenName] : false;
	}
	
	/**
	 *
	 */
	public function get()
	{
		if ($this->_token === false)
		{
			$this->_token = md5(uniqid(microtime(), true));
			if (session_id() == '') 
			{
				session_start();
			}
			$_SESSION[$this->tokenName] = $this->_token;
			setcookie($this->tokenName, $this->_token, null, '/');
		}
		return $this->_token;
	}
	
	/**
	 *
	 * @param unknown $token
	 * @return boolean
	 */
	public function isValid($token) 
	{
		return (isset($_SESSION[$this->tokenName]) && $_SESSION[$this->tokenName] == $token)? true : false;
	}
	
	
}

/* End of file XsrfToken.php */
/* Location: ./modules/toy/services/XsrfToken.php */