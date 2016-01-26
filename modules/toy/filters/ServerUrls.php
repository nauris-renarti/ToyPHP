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
 * Class ServerUrls
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class ServerUrls
{
	public static $urls = array();
	
	/**
	 * 
	 * @param string $https
	 * @return string
	 */
	public static function baseUrl($https = 'http://')
	{
		if (!isset(self::$urls['baseUrl']))
		{
			if (isset($_SERVER['HTTP_HOST']))
			{
				$_predefined_rootpath = strtolower(ROOTPATH);
				$_http_host = $_SERVER['HTTP_HOST'];
				$_http_document_root = strtolower($_SERVER['DOCUMENT_ROOT']);
				$_http_script_name = strtolower($_SERVER['SCRIPT_NAME']);
				
				$_protocol       = $https;
				$_host           = $_SERVER['HTTP_HOST'];
				$_subfolder      = trim(str_replace($_http_document_root, '', rtrim(str_replace('\\', '/', $_predefined_rootpath), '/')), '/');
				$_intersections  = array_intersect(explode('/', $_subfolder), explode('/', trim($_http_script_name, '/')));
				$_real_subfolder = trim(join('/', $_intersections), '/');
				// print('<pre>' . print_r(get_defined_vars(), true) . '</pre>');
				self::$urls['baseUrl'] = $_protocol . $_host . '/' . (($_real_subfolder == '')? '' : $_real_subfolder . '/');
			}
			else 
			{
				// for CLI ???
				self::$urls['baseUrl'] = ROOTPATH;
			}
		}
		return self::$urls['baseUrl'];
	}
	
	/**
	 * 
	 * @param string $path
	 * @param string $https
	 * @return string
	 */
	public static function siteUrl($path = '', $https = 'http://')
	{
		if (!isset(self::$urls[$https.$path]))
		{
			$_base = self::baseUrl($https);
			$_path = trim($path, '/');
			self::$urls[$https.$path] = $_base . (($_path == '')? '' : $_path . '/');
		}
		return self::$urls[$https.$path];
	}
	
	/**
	 * 
	 * @return string
	 */
	public static function currentUrl()
	{
		if (!isset(self::$urls['currentUrl']))
		{
			if (isset($_SERVER['HTTP_HOST']))
			{
				$_protocol_assoc = preg_split('/\\//', $_SERVER['SERVER_PROTOCOL'], -1);
				$_protocol = isset($_protocol_assoc[0])? strtolower($_protocol_assoc[0]) : 'http';
				$_host = $_SERVER['HTTP_HOST'];
				$_request = $_SERVER['REQUEST_URI'];
				self::$urls['currentUrl'] = $_protocol .'://'.$_host.$_request;
			}
			else
			{
				// for CLI ???
				self::$urls['currentUrl'] = ROOTPATH;
			}
		}
		return self::$urls['currentUrl'];
	}
	
	/**
	 *
	 * @param string $uri
	 * @param string $method
	 * @param number $status
	 */
	public static function redirect($uri = '', $method = 'location', $status = 302)
	{
		if (!preg_match('/^(https?|s?ftp|mailto)\:/i', $uri)) 
		{
			$uri = self::siteUrl($uri);
		}
	
		switch($method) 
		{			
			case 'refresh':
				header("Refresh:0; url=" . $uri);
				break;
				
			default:
				header("Location: " . $uri, true, $status);
				break;
		}
	
		exit();
	}	
	
	/**
	 * 
	 * @param string $path
	 * @param string $https
	 * @return string
	 */
	public static function skinUrl($path = '', $https = 'http://')
	{
		$base = self::baseUrl($https);
		$skinPath = trim(trim(str_replace(rtrim(ROOTPATH, '/'), '', rtrim(SKINPATH, '/')), '\\'), '/');
		return rtrim($base . str_replace('\\', '/', $skinPath) . '/' . $path, '/');
	}
	
	
}

/* End of file ServerUrls.php */
/* Location: ./modules/toy/filters/ServerUrls.php */