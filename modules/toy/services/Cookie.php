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
 * Class Cookie
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 * @created 01-jun-2015 9:55:43
 * 
 */
class Cookie
{
	/**
	 *
	 * @param unknown $key
	 * @param unknown $value
	 * @param string $expire
	 * @param string $path
	 * @param string $domain
	 * @param string $secure
	 * @param string $httponly
	 * @return boolean
	 */
	public function set($key, $value, $expire = null, $path = '/', $domain = null, $secure = false, $httponly = false) 
	{
		return setcookie($key, $value, $expire, $path, $domain, $secure, $httponly);
	}
	
	/**
	 * 
	 * @param unknown $key
	 * @param unknown $value
	 * @param string $expire
	 * @param string $path
	 * @param string $domain
	 * @param string $secure
	 * @param string $httponly
	 * @return boolean
	 */
	public function setObject($key, $value, $expire = null, $path = '/', $domain = null, $secure = false, $httponly = false) 
	{
		$_value = @serialize($value);
		return setcookie($key, $_value, $expire, $path, $domain, $secure, $httponly);
	}
	
	/**
	 * 
	 * @param unknown $key
	 * @param unknown $value
	 * @param string $expire
	 * @param string $path
	 * @param string $domain
	 * @param string $secure
	 * @param string $httponly
	 * @return boolean
	 */
	public function setSafe($key, $value, $expire = null, $path = '/', $domain = null, $secure = false, $httponly = false)
	{
		$_value = toy::module('toy')->encoder->encrypt($value);
		return $this->set($key, $_value, $expire, $path, $domain, $secure, $httponly);
	}
	
	/**
	 *
	 * @param unknown $key
	 * @param string $default
	 * @return Ambigous <unknown, string>
	 */
	public function get($key, $default = false)
	{
		return isset($_COOKIE[$key])? $_COOKIE[$key] : $default;
	}

	/**
	 * 
	 * @param unknown $key
	 * @param string $default
	 * @return string
	 */
	public function getObject($key, $default = false)
	{
		return isset($_COOKIE[$key])? @unserialize($_COOKIE[$key]) : $default;
	}
	
	/**
	 * 
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function getSafe($key, $default = false)
	{
		if (!isset($_COOKIE[$key])) return $default;
		return toy::module('toy')->encoder->decrypt($this->get($key, $default));
	}
	
	/**
	 *
	 * @param unknown $key
	 */
	public function remove($key)
	{
		if (!isset($_COOKIE[$key])) return;
		$this->set($key, null, strtotime('-1 min'));
	}
}

/* End of file Cookie.php */
/* Location: ./modules/toy/services/Cookie.php */