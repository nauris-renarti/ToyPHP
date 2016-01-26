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
 * Class Cache
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 * @created 01-jun-2015 9:55:43
 * 
 */
class Cache
{
	/**
	 *
	 * @var string
	 */
	public $prefix = 'cache_';
	
	/**
	 * 
	 * @var bool
	 */
	public $enabled = true;
	
	/**
	 * 
	 * @var bool
	 */
	public $hashKey = true;
	
	/**
	 * 
	 * @param unknown $args
	 */
	public function __construct()
	{
		foreach (toy::module('toy')->config->valueOf(__CLASS__) as $k => $v) 
		{
			$this->$k = $v;
		}
	}
	

	/**
	 *
	 * @param string $key
	 * @param mixed $data
	 * @return boolean
	 */
	public function set($key, $data)
	{
		if ($this->enabled === false) return false;
		
		$filename = APPPATH . 'cache/'.$this->prefix . (($this->hashKey === true)? md5($key) : $key);

		if (!$fp = @fopen($filename, "w")) return false;

		$data = @serialize($data);
		$result = fwrite($fp, $data);
		fclose($fp);

		return true;
	}

	/**
	 *
	 * @param string $key
	 * @param number $timeout
	 * @param string $default
	 * @return mixed
	 */
	public function get($key, $timeout = 3600, $default = false)
	{
		if ($this->enabled === false) return $default;
		
		$filename = APPPATH . 'cache/'.$this->prefix . (($this->hashKey === true)? md5($key) : $key);

		if (!file_exists($filename)) return $default;

		if ( (filemtime($filename)+$timeout) < time() )
		{
			@unlink($filename);
			return $default;
		}

		$data = '';
		$file_handle = fopen($filename, "r");
		while (!feof($file_handle))
		{
			$data.= fgets($file_handle);
		}
		fclose($file_handle);

		return @unserialize( $data );
	}

	/**
	 *
	 * @param string $key
	 * @return boolean
	 */
	public function remove($key)
	{
		$filename = APPPATH . 'cache/'.$this->prefix . (($this->hashKey === true)? md5($key) : $key);
		if (!file_exists($filename)) return false;
		@unlink($filename);
		return true;
	}

}

/* End of file Cache.php */
/* Location: ./modules/toy/services/Cache.php */