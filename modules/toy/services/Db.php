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
use \PDO;
use \PDOStatement;
use \toy\factories\DbStatement;

/**
 * Class Db
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 * @created 01-jun-2015 9:55:43
 * 
 */
class Db extends PDO
{
	/**
	 * 
	 * @var number
	 */
	public static $callID = 0;
	
	/**
	 * 
	 * @var string
	 */
	public $connectionID = '';
	
	/**
	 * 
	 * @var boolean
	 */
	public $traceSingleConnection = false;
	
	/**
	 * 
	 * @var boolean
	 */
	public $traceSql = false;
	
	/**
	 * 
	 * @param unknown $dsn
	 * @param unknown $username
	 * @param unknown $password
	 */
 	public function __construct ()
 	{
 		$config = toy::module('toy')->config;
 		
 		foreach ($config->valueOf('db') as $k => $v) 
 		{
 			$this->$k = $v; 		
 		}
 		
 		if ($this->traceSingleConnection) 
 		{
 			$this->connectionID = '_'. md5(uniqid());
 		} 		
 		
 		$conn = $config->valueOf('database');
 		
 		parent::__construct($conn['dsn'], $conn['username'], $conn['password'], (isset($conn['options'])? $conn['options'] : array()));
 	}
 	
	/**
	 * 
	 * @return number
	 */
	public function getCallID() 
	{
		return self::$callID;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see PDO::prepare()
	 * @return \toy\factories\DbStatement
	 */
	public function prepare($statement, $driver_options = array())
	{
		self::$callID++;
		
		$log = false;
		
		if ($this->traceSql) 
		{
			$log = toy::module('toy')->log;		
			$log->message('==============================================', self::$callID, 'sql' . $this->connectionID);
			$log->message($statement, self::$callID, 'sql' . $this->connectionID);
		}
		
		$start = microtime(true);
		$stm = parent::prepare($statement, $driver_options);
		$finish = microtime(true);
		
		if ($this->traceSql) 
		{
			$log->message('Prepare time = ' . floatval($finish - $start) . ' (sec.)', self::$callID, 'sql' . $this->connectionID);
		}
				
		if (($stm instanceof PDOStatement) === false) 
		{
			return $stm;
		}
		
		return new DbStatement($this, $stm);
	}
}

/* End of file Db.php */
/* Location: ./modules/toy/services/Db.php */
