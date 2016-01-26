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
 * Class Route
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class Route
{
	/**
	 * 
	 * @var string
	 */
	public $path = '';
	
	/**
	 * 
	 * @var string
	 */
	private $_method = 'get';
	
	/**
	 * 
	 * @var bool
	 */
	private $_call_was_fired = false;
	
	/**
	 * 
	 * @param \toy\factories\Module $module
	 * @param string $method
	 * @param string $path
	 * @param array $args
	 */
	public function __construct()
	{
		$this->path = isset($_SERVER['PATH_INFO'])? trim(filter_var($_SERVER['PATH_INFO'], FILTER_SANITIZE_URL), '/') : '';	
		$this->_method = isset($_SERVER['REQUEST_METHOD'])? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
		$this->_segments = explode('/', $this->path);
	}
	
	/**
	 * 
	 * @param string $method Can by one from [get|post|put|delete]
	 * @param string $selector Any valid reg.exp. for URI routing
	 * @param mixed $handler
	 * @return \toy\factories\Route
	 */
	public function when($method, $selector, $handler) 
	{
		if ($this->_method != $method || $this->_call_was_fired) return $this;

		$args = array();		
		$pattern = str_replace(array('/','_',' '), array('\/','\_', '\ '), $selector);		
		if (preg_match("/^$pattern$/i", $this->path, $args))
		{
			$argsD = array();
			$argsW = array();
				
			foreach ($args as $k => $v)
			{
				if (is_numeric($k)) 
				{
					$argsD[$k] = $v;
				}
				else 
				{
					$argsW[$k] = $v;
				}
			}			
			$args = empty($argsW)? $argsD : $argsW;
		}
		
		if (empty($args) && ($selector != $this->path)) return $this;	
		
		$this->_checkRedirect($handler, $args);	
		
		$this->_call_was_fired = true;		
		call_user_func_array($handler, $args);						
		return $this;
	}
	
	/**
	 * 
	 * @param mixed $handler
	 * @return \toy\factories\Route
	 */
	public function otherwise($handler, $args = array())
	{
		if ($this->_call_was_fired) return $this;	
				
		$this->_checkRedirect($handler, $args);	
			
		$this->_call_was_fired = true;		
		call_user_func_array($handler, $args);		
		return $this;
	}
	
	/**
	 * 
	 * @param unknown $handler
	 */
	private function _checkRedirect($handler, $args = array())
	{
		if (is_array($handler) && is_string($handler[0]) && strtolower($handler[0]) == 'redirect')
		{
			$paterns = array();
			$replacements = array();
			foreach ($args as $key => $value)
			{
				$aptterns[] = "/<{$key}>/";
				$replacements[]= $value;
			}
			$_to_url = preg_replace($aptterns, $replacements, (isset($handler[1])? $handler[1] : ''));
			
			toy::module('toy')->redirect($_to_url);
		}
	}
	
}

/* End of file Route.php */
/* Location: ./modules/toy/services/Route.php */