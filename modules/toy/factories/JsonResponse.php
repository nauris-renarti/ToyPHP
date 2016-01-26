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

namespace toy\factories;

use \toy;

/**
 * Class JsonResponse
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class JsonResponse
{
	/**
	 *
	 * @var array
	 */
	private $_data = array();
	
	/**
	 *
	 * @var int
	 */
	private $_options = 0;
	
	/**
	 *
	 * @param mixed $data Array or Object
	 */
	public function __construct($data = array(), $options = 0)
	{
		header('Content-Type: application/json');
		$this->setOptions($options);
		$this->setData($data);
	}
	
	/**
	 *
	 * @param int $value
	 * @return \toy\factories\JsonResponse
	 */
	public function setOptions($value)
	{
		$this->_options = $value;
		return $this;
	}
	
	/**
	 * 
	 * @param mixed $value
	 * @return \toy\factories\JsonResponse
	 */
	public function setData($value)
	{
		$this->_data = $value;
		return $this;
	}
	
	/**
	 * 
	 */
	public function write()
	{
		print json_encode($this->_data, $this->_options);
	}
	
}

/* End of file JsonResponse.php */
/* Location: ./modules/toy/factories/JsonResponse.php */