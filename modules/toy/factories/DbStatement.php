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
use \PDOStatement;
use \toy\services\Db;

/**
 * Class DbStatement
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class DbStatement
{
	/**
	 *
	 * @var \PDOStatement
	 */
	private $_statement = null;
	
	/**
	 * 
	 * @var \toy\factories\Db
	 */
	private $_db;

	/**
	 *
	 * @param \PDOStatement $stm
	 */
	public function __construct(Db $db, PDOStatement $stm)
	{
		$this->_db = $db;
		$this->_statement = &$stm;
	}

	/**
	 *
	 * @param string $name
	 */
	public function __get($name)
	{
		return $this->_statement->$name;
	}

	/**
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return unknown
	 */
	public function __set($name, $value)
	{
		return $this->_statement->$name = $value;
	}

	/**
	 *
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($name, $arguments = null )
	{
		return call_user_func_array(array($this->_statement, $name), $arguments);
	}

	/**
	 *
	 * @param string $name
	 */
	public function __isset($name)
	{
		return isset($this->_statement->$name);
	}

	/**
	 *
	 * @param string $name
	 */
	public function __unset($name)
	{
		unset($this->_statement->$name);
	}

	/**
	 * (non-PHPdoc)
	 * @see \PDOStatement::execute()
	 */
	public function execute($input_parameters = null)
	{
		$callID = $this->_db->getCallID();
		$connectionID = $this->_db->connectionID;

		$log = false;
		
		if ($this->_db->traceSql)
		{
			toy::module('toy')->log($input_parameters, $callID, 'sql' . $connectionID);
		}

		$start  = microtime(true);
		$result = $this->_statement->execute($input_parameters);
		$finish = microtime(true);

		if ($this->_db->traceSql)
		{
			toy::module('toy')->log('Execute time = ' . floatval($finish - $start) . ' (sec.)', $callID, 'sql' . $connectionID);
			toy::module('toy')->log('Result row count = ' . $this->_statement->rowCount(), $callID, 'sql' . $connectionID);
		}

		// return $result;
		return $this;
	}
}

/* End of file DbStatement.php */
/* Location: ./modules/toy/factories/DbStatement.php */
