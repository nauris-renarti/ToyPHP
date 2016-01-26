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
 * Class Event
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class Event
{
	/**
	 * 
	 * @var array
	 */
	private static $_events = array();
	
	/**
	 * 
	 * @param unknown $name
	 * @param unknown $fn
	 * @return \toy\factories\Event
	 */
	public function on($name, $fn)
	{
		self::$_events[$name][] = $fn;
		return $this; 
	}
	
	/**
	 * 
	 * @param unknown $name
	 * @param unknown $fn
	 * @return \toy\factories\Event
	 */
	public function off($name, $fn)
	{
		if (!isset(self::$_events[$name])) return $this;
		unset(self::$_events[$name]);
		return $this;
	}
	
	/**
	 * 
	 * @param unknown $name
	 * @return \toy\factories\Event
	 */
	public function fire($name)
	{
		if (!isset(self::$_events[$name]))
		{
			return $this;
		}
		
		$args = array_slice(func_get_args(), 1);
		
		foreach (self::$_events[$name] as $callback)
		{
			call_user_func($callback, $args);
		}
		
		return $this;
	}
}

/* End of file Event.php */
/* Location: ./modules/toy/services/Event.php */