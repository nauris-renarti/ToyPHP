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

/**
 * Class Session
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class Session
{
	/**
	 *
	 */
	function start()
	{
		session_start();
	}

	/**
	 *
	 * @return boolean
	 */
	function isStarted()
	{
		return (session_id() != '');
	}

	/**
	 *
	 */
	function regenerate()
	{
		if ($this->isStarted())
		{
			session_unset();
			session_destroy();
		}
		session_start();
		session_regenerate_id(true);
	}

	/**
	 *
	 * @param string $key
	 * @param mixed|bool $default
	 * @return string
	 */
	function get($key, $default = false)
	{
		return isset($_SESSION[$key])? @unserialize($_SESSION[$key]) : $default;
	}

	/**
	 *
	 * @param unknown $key
	 * @param unknown $value
	 */
	function set($key, $value)
	{
		$_SESSION[$key] = @serialize($value);
	}

	/**
	 *
	 * @param unknown $key
	 * @param string $default
	 * @return Ambigous <string, string>
	 */
	function getFlashData($key, $default = false)
	{
		$flashKey = __CLASS__."::flash::{$key}";
		$result = $this->get($flashKey, $default);
		$this->remove($flashKey);
		return $result;
	}

	/**
	 *
	 * @param unknown $key
	 * @param unknown $value
	 */
	function setFlashData($key, $value)
	{
		$flashKey = __CLASS__."::flash::{$key}";
		$this->set($flashKey, $value);
	}

	/**
	 *
	 * @param unknown $key
	 */
	function remove($key)
	{
		if (is_array($key))
		{
			foreach ($key as $k)
			{
				$this->remove($k);
			}
		}
		else if (isset($_SESSION[$key]))
		{
			unset($_SESSION[$key]);
		}
	}
}

/* End of file Session.php */
/* Location: ./modules/toy/services/Session.php */