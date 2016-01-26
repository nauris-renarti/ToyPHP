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
 * Class Config 
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class Config
{
	/**
	 * 
	 * @var unknown
	 */
	private $_data = array();
	
	/**
	 * 
	 * @return \toy\factories\Config
	 */
	public function load()
	{
		foreach (func_get_args() as $_file)
		{
			$_a = is_string($_file)? require $_file : $_file;
			$this->_data = array_merge($this->_data, $_a);
		}		
		return $this;
	}
	
	/**
	 * 
	 * @return mixed
	 */
	public function valueOf() 
	{
		return $this->_map_config($this->_data, func_get_args());
	}
	
	/**
	 * 
	 * @param array $data
	 * @param array $keys
	 * @return mixed
	 */
	private function _map_config($data, $keys)
	{
		if (isset($data[$keys[0]]) && count($keys) > 1) 
		{
			return $this->_map_config($data[$keys[0]], array_slice($keys, 1));
		}
		else if (isset($data[$keys[0]]) && count($keys) == 1) 
		{
			return $data[$keys[0]];
		}
		return false;
	}
}

/* End of file Config.php */
/* Location: ./modules/toy/services/Config.php */