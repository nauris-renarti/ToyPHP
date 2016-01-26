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
 * Class StringFunctions
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class StringFunctions
{
	/**
	 *
	 * @param string $str
	 * @param array $noStrip
	 * @return string
	 */
	public static function strtocamelcase($str, $noStrip = array())
	{
		return lcfirst(self::strtocapitalize($str, $noStrip));
	}
	
	/**
	 *
	 * @param string $str
	 * @param array $noStrip
	 * @return mixed
	 */
	public static function strtocapitalize($str, $noStrip = array())
	{
		$str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', trim($str));
		$str = ucwords($str);
		return str_replace(" ", "", $str);
	}
	
	/**
	 *
	 * @param number $length
	 * @param string $chars
	 * @return string
	 */
	public static function strrandom($length = 255, $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		while ($length > mb_strlen($chars, 'UTF-8')) 
		{
			$chars .= $chars;
		}
		return substr(str_shuffle($chars), 0, $length);
	}
	
	/**
	 * 
	 * @param string $key
	 * @return string
	 */
	public static function translate($key)
	{
		return toy::module()->i18n->get($key);
	}
	

}

/* End of file StringFunctions.php */
/* Location: ./modules/toy/filters/StringFunctions.php */