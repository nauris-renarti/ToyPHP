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
 * Class Agent
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 * @created 01-jun-2015 9:55:42
 * 
 */
class Agent
{
	/**
	 *
	 * @var unknown_type
	 */
	public $platforms = array();
	/**
	 *
	 * @var unknown_type
	*/
	public $robots = array();
	/**
	 *
	 * @var unknown_type
	*/
	public $browsers = array();
	/**
	 *
	 * @var unknown_type
	*/
	public $mobiles = array();
	
	/**
	 * 
	 * @param unknown $args
	 */
	public function __construct()
	{
		foreach (toy::module('toy')->config->valueOf(__CLASS__) as $k => $v)
		{
			$this->$k = $v;
		}
	}
	/**
	 *
	 * @return string
	*/
	public function useragent()
	{
		return (php_sapi_name() === 'cli'  || defined('STDIN'))? "Console/0.0 ({$_SERVER['OS']})" : trim($_SERVER['HTTP_USER_AGENT']);
	}
	
	/**
	 *
	 * @return unknown|boolean
	 */
	public function platform()
	{
		$user_agent = $this->useragent();
		foreach ($this->platforms as $key => $value)
		{
			if (preg_match("|".preg_quote($key)."|i", $user_agent))
			{
				return $value;
			}
		}
		return false;
	}
	
	/**
	 *
	 * @return unknown|boolean
	 */
	public function robot()
	{
		$user_agent = $this->useragent();
		foreach ($this->robots as $key => $value)
		{
			if (preg_match("|".preg_quote($key)."|i", $user_agent))
			{
				return $value;
			}
		}
		return false;
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function isRobot()
	{
		return ($this->robot() === false)? false : true;
	}
	
	/**
	 *
	 * @return unknown_type
	 */
	public function browsers()
	{
		return $this->browsers;
	}
	
	/**
	 *
	 * @return unknown|boolean
	 */
	public function browser()
	{
		$user_agent = $this->useragent();
		foreach ($this->browsers() as $key => $value)
		{
			if (preg_match("|".preg_quote($key).".*?([0-9\.]+)|i", $user_agent, $match))
			{
				return $value;
			}
		}
		return false;
	}
	
	/**
	 *
	 * @return string
	 */
	public function browserInfo()
	{
		return ($this->browser().' '. $this->browserVersion());
	}
	
	/**
	 *
	 * @return unknown|boolean
	 */
	public function browserVersion()
	{
		$user_agent = $this->useragent();
		foreach ($this->browsers() as $key => $value)
		{
			if (preg_match("|".preg_quote($key).".*?([0-9\.]+)|i", $user_agent, $match))
			{
				return $match[1];
			}
		}
		return false;
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function isBrowser()
	{
		return ($this->browser() === false)? false : true;
	}
	
	/**
	 *
	 * @return unknown|boolean
	 */
	public function mobile()
	{
		$user_agent = $this->useragent();
		foreach ($this->mobiles as $key => $value)
		{
			if (strpos(strtolower($user_agent), $key) !== false)
			{
				return $value;
			}
		}
		return false;
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function isMobile()
	{
		return ($this->mobile() === false)? false : true;
	}
	
	/**
	 *
	 * @return multitype:|boolean
	 */
	public function acceptLanguages()
	{
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE'] != '')
		{
			$_languages = preg_replace('#(;q=[0-9\.]+)#i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE'])));

			$languages = array();
			$_languages = explode(',', $_languages);
			foreach ($_languages as $language)
			{
				if (strlen($language) != 2) continue;
				$languages[] = $language;
			}

			return $languages;
		}
		return array();
	}
	
	/**
	 *
	 * @param unknown_type $language
	 * @return boolean
	 */
	public function acceptLanguage($language = 'en')
	{
		$languages = $this->acceptLanguages();
		return (in_array(strtolower($language), $languages, true));
	}
	
	/**
	 *
	 * @return multitype:|boolean
	 */
	public function acceptCharset()
	{
		if (isset($_SERVER['HTTP_ACCEPT_CHARSET']) && $_SERVER['HTTP_ACCEPT_CHARSET'] != '')
		{
			$charsets = preg_replace('/(;q=.+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_CHARSET'])));
			return explode(',', $charsets);
		}
		return array();
	}

	/**
	 * 
	 * @return Ambigous <multitype:, unknown>|multitype:
	 */
	public function acceptCharsets() 
	{
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE'] != '')
		{
			preg_match_all('/[a-z]{2}-[A-Z]{2}/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $_charsets);
			return (isset($_charsets[0])? $_charsets[0] : array());
		}
		return array();
	}
}

/* End of file Agent.php */
/* Location: ./modules/toy/services/Agent.php */