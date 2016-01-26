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
 * Class HttpAuthentication
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class HttpAuthentication
{
	/**
	 *
	 * @return array|boolean
	*/
	public static function ask($fn = false)
	{
		// predefined [user=>password]
		$credentials = toy::module('toy')->config->valueOf(__CLASS__);
		
		// if empty credentials - its always return true
		if (empty($credentials)) return true;

		// Authentication over HTTP always ignores for CLI
		if (php_sapi_name() === 'cli' || defined('STDIN')) return true;
			
		// check auth
		$user = isset($_SERVER['PHP_AUTH_USER'])? $_SERVER['PHP_AUTH_USER'] : false;
		$pass = isset($_SERVER['PHP_AUTH_PW'])? $_SERVER['PHP_AUTH_PW'] : false;
		
		// check auth
		if (isset($credentials[$user]) && ($pass == $credentials[$user])) 
		{
			$result = array(
					    'success' => array(
						'user'    => $user, 
						'login'   => time(),
					)
			);
			
			if ($fn !== false)
			{
				call_user_func_array($fn, $result);
			}
			
			return $result;
		}
		
		// response
		header('WWW-Authenticate: Basic realm="Authorization required"');
		header('HTTP/1.0 401 Unauthorized', true, 401);
		
		if ($fn !== false) 
		{
			call_user_func_array($fn, array(false));
		}
		
		return false;
	}
}

/* End of file HttpAuthentication.php */
/* Location: ./modules/toy/filters/HttpAuthentication.php */
