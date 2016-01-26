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

/**
 * Class IpFunctions
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class IpFunctions
{
	/**
	 * 
	 * @return string
	 */
	public static function ip()
	{
		if (isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['HTTP_CLIENT_IP']))
		{
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		else if (isset($_SERVER['REMOTE_ADDR']))
		{
			return $_SERVER['REMOTE_ADDR'];
		}
		else if (isset($_SERVER['HTTP_CLIENT_IP']))
		{
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		return'0.0.0.0';
	}
	
	/**
	 *
	 * @return boolean
	 */
	public static function isTrustedReferer($whitelist = array())
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{
			return false;
		}
	
		if (empty($whitelist))
		{
			return true;
		}
	
		$url = parse_url($_SERVER['HTTP_REFERER']);
	
		return in_array($url['host'], $whitelist);
	}
	
	/**
	 *
	 * @param string $ip
	 * @return boolean
	 */
	public static function isTrustedIp($ip, $whitelist = array())
	{
		if (empty($whitelist))
		{
			return true;
		}
	
		foreach($whitelist as $range)
		{
			if (self::ipInRange($ip, $range) || $ip == $range)
			{
				return true;
			}
		}
	
		return false;
	}
	
	/**
	 *
	 * @param string $ip
	 * @return boolean
	 */
	public static function ipInBlacklist($ip, $blacklist = array())
	{
		foreach($blacklist as $range)
		{
			if (self::ipInRange($ip, $range) || $ip == $range)
			{
				return true;
			}
		}
		return false;
	}
		
	/**
	 *
	 * Function to determine if an IP is located in a specific range as specified via several alternative formats.
	 *
	 * Network ranges can be specified as:
	 * 1. Wildcard format:     1.2.3.*
	 * 2. CIDR format:         1.2.3/24  OR  1.2.3.4/255.255.255.0
	 * 3. Start-End IP format: 1.2.3.0-1.2.3.255
	 *
	 * Copyright 2008: Paul Gregg <pgregg@pgregg.com>
	 * 10 January 2008
	 * Version: 1.2
	 *
	 * Source website: http://www.pgregg.com/projects/php/ipInRange/
	 * Version 1.2
	 *
	 * @param string $ip
	 * @param string $range
	 * @return boolean
	 */
	public static function ipInRange($ip, $range)
	{
		if (strpos($range, '/') !== false)
		{
			// $range is in IP/NETMASK format
			list($range, $netmask) = explode('/', $range, 2);
	
			if (strpos($netmask, '.') !== false)
			{
				// $netmask is a 255.255.0.0 format
				$netmask = str_replace('*', '0', $netmask);
				$netmask_dec = ip2long($netmask);
	
				return ( (ip2long($ip) & $netmask_dec) == (ip2long($range) & $netmask_dec) );
			}
			else
			{
				// $netmask is a CIDR size block
				// fix the range argument
				$x = explode('.', $range);
				while(count($x)<4) $x[] = '0';
				list($a,$b,$c,$d) = $x;
				$range = sprintf("%u.%u.%u.%u", empty($a)?'0':$a, empty($b)?'0':$b,empty($c)?'0':$c,empty($d)?'0':$d);
				$range_dec = ip2long($range);
				$ip_dec = ip2long($ip);
				$wildcard_dec = pow(2, (32-$netmask)) - 1;
				$netmask_dec = ~ $wildcard_dec;
	
				return (($ip_dec & $netmask_dec) == ($range_dec & $netmask_dec));
			}
		}
		else
		{
			// range might be 255.255.*.* or 1.2.3.0-1.2.3.255
			if (strpos($range, '*') !== false) // a.b.*.* format
			{
				// Just convert to A-B format by setting * to 0 for A and 255 for B
				$lower = str_replace('*', '0', $range);
				$upper = str_replace('*', '255', $range);
				$range = "$lower-$upper";
			}
	
			if (strpos($range, '-')!==false) // A-B format
			{
				list($lower, $upper) = explode('-', $range, 2);
				$lower_dec = (float)sprintf("%u",ip2long($lower));
				$upper_dec = (float)sprintf("%u",ip2long($upper));
				$ip_dec = (float)sprintf("%u",ip2long($ip));
	
				return (($ip_dec >= $lower_dec) && ($ip_dec <= $upper_dec));
			}
	
			return false;
		}
	}
	
}

/* End of file IpFunctions.php */
/* Location: ./modules/toy/filters/IpFunctions.php */