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

namespace toy\filters;

use \toy;

/**
 * Class Loger
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class Loger
{
	/**
	 * 
	 * @param unknown $message
	 * @param system $type
	 * @param string $file
	 * @return boolean
	 */
	public static function log($message, $type = 'info', $prefix = 'log')
	{
		$filename = APPPATH.'logs/'.$prefix.'_'.date('Ymd').'.log';
		if (!$hFile = @fopen($filename, "a")) return false;
		$line = join("\t", array(date('Y-m-d H:i:s e'), toy::module('toy')->ip(), $type, print_r( $message, true ))) . "\n";
	
		flock($hFile, LOCK_EX);
		fwrite($hFile, $line);
		flock($hFile, LOCK_UN);
		fclose($hFile);
	
		return true;
	}
	
	/**
	 * 
	 * @param unknown $message
	 * @param string $type
	 * @param string $prefix
	 */
	public static function logError($message, $type = 'info', $prefix = 'errors')
	{
		return self::log($message, $type, $prefix);
	}
	
}

/* End of file Loger.php */
/* Location: ./modules/toy/filters/Loger.php */