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

/**
 * Class toy
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 *
 */
class toy
{
	/**
	 *
	 * @var array Imported pathes collection
	 */
	private static $_imports = array(APPPATH, SYSPATH);
	
	/**
	 * Creates new module or return existing. Web application must be defined as module.
	 *
	 * @param string $name Module name
	 * @param array $args Default properties
	 * @return ToyModule
	*/
	public static function module($name = false, $args = array())
	{
		return ($name === false)? ToyModule::module('toy', $args) : ToyModule::module($name, $args);
	}
	
	/**
	 * Registered clases autoload function
	 *
	 * @param string $classname Classname with/without namespace
	 * @throws Exception Failed if php classfile not found
	 */
	public static function autoload($classname)
	{
		$_ns_to_dir = str_replace('\\', '/', $classname);
		foreach (self::$_imports as $dir)
		{
			$filename = $dir . $_ns_to_dir . '.php';
			if (!is_file($filename)) continue;
			require $filename;
			return;
		}
		throw new Exception("Failed to load ToyPHP requested class file {$classname}");
	}
	
	/**
	 * Imports directories separated with coma import(dir1[,dir2, dir3, ....])
	 */
	public static function import()
	{
		foreach (func_get_args() as $path)
		{
			$_path = rtrim($path, '/') . '/';
			self::$_imports[$_path] = $_path;
		}
	}
	
	/**
	 *
	 * @param unknown $name
	 * @throws Exception
	 * @return mixed
	 */
	public static function scope($name)
	{
		if (!isset($GLOBALS[$name]))
		{
			throw new Exception("Failed to get ToyPHP scope {$name}");
		}
		
		if (func_num_args() == 2)
		{
			// seter
			$GLOBALS[$name] = func_get_arg(1);
		}
		
		// geter
		return $GLOBALS[$name];
	}
	
	/**
	 * Return current version of ToyPPH framework
	 * @return string
	 */
	public static function version()
	{
		return '1.0';
	}

	
}

/**
 * Class ToyModule
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * 
 * @property \toy\services\Route $route
 * @property \toy\services\Request $request
 * @property \toy\services\Db $db
 * @property \toy\services\Config $config
 * @property \toy\services\Cache $cache
 * @property \toy\services\Cookie $cookie
 * @property \toy\services\Encoder $encoder
 * @property \toy\services\XsrfToken $xsrf
 * @property \toy\services\Agent $agent
 * @property \toy\services\Uri $uri
 * @property \toy\services\Event $events
 * @property \toy\services\Translator $i18n
 * @property \toy\services\Session $session
 * @method string ip() ip() return remote clietn IP address
 * @method bool log() log($message, $type = 'info', $prefix = 'log') return true if success false otherwise
 * @method bool logError()  logError($message, $type = 'info', $prefix = 'errors') return true if success false otherwise
 * @method array|bool auth() auth($fn = false) auth result $fn is valid callback
 * @method string baseUrl() baseUrl($https = 'http://') return web app base url
 * @method string siteUrl() siteUrl($path = '', $https = 'http://') return web app site url (typically HMVC hierarchical url path)
 * @method string currentUrl() currentUrl() return web app current url
 * @method string skinUrl() skinUrl($path = '', $https = 'http://') return web app skin url
 * @method void redirect() redirect($uri = '', $method = 'location', $status = 302) redirect webapp and halt current script
 */
class ToyModule
{
	/**
	 * 
	 * @var unknown
	 */
	private static $_modules = array();
	
	/**
	 * 
	 * @var unknown
	 */
	private static $_scope = array();
	
	/**
	 * 
	 * @var unknown
	 */
	private static $_config = array();
	
	/**
	 * 
	 * @var unknown
	 */
	public $about = array();
	
	/**
	 * 
	 * @param unknown $name
	 * @param unknown $args
	 * @throws Exception
	 */
	public function __construct($name, $args = array())
	{
		// about info of module
		$this->about = isset($args['about'])? $args['about'] : array();
		
		// register self in modules list 
		self::$_modules[$name] = $this;
		
		// services, filters, factories
		if (isset($args['scope']))
		{
			foreach ($args['scope'] as $arg) 
			{
				self::$_scope[$arg[0]] = $arg[1];
			}
		}
		
		// dependencies
		$dependencies = array();
		foreach ($args as $k => $v)
		{
			if (!is_int($k)) continue;
			$dependencies[] = $v;
		}
		
		foreach (array_diff($dependencies, array_keys(self::$_modules)) as $module)
		{
			$filename = SYSPATH . $module . '/' . $module.'.php';
			if (!is_file($filename))
			{
				throw new Exception("Failed to load ToyPHP module {$module} required for {$name}");
			}
			require $filename;
		}
	}
	
	/**
	 * 
	 * @return string
	 */
	public function moduleName()
	{
		return array_search($this, self::$_modules);
	}
	
	/**
	 * 
	 *
	public function __destruct()
 	{
 		//return;
 		static $_printed = false;
 		if ($_printed) return;
 		print '<pre>';	
 		print '<h3>Modules</h3>';	
 		print_r( self::$_modules );
 		print '<h3>Config</h3>';
 		print_r( self::$_config );
 		print '<h3>Scope</h3>';
 		print_r( self::$_scope );
 		print '</pre>';
 		$_printed = true;
 	}
 	*/
	
	/**
	 * 
	 * @param unknown $name
	 * @return unknown|boolean
	 */
	public function __get($name)
	{
		if (isset(self::$_scope[$name]))
		{
			if (is_string(self::$_scope[$name]) && !strpos(self::$_scope[$name], '::')  && !function_exists(self::$_scope[$name]))
			{
				$classname = self::$_scope[$name];
				self::$_scope[$name] = new $classname;
			}				
			return self::$_scope[$name];
		}
		else
		{
			return false;
		}		
	}
	
	/**
	 * 
	 * @param unknown $name
	 * @param unknown $args
	 * @return Ambigous <boolean, mixed>
	 */
	public function __call($name, $args)
	{
		return (isset(self::$_scope[$name]) && is_callable(self::$_scope[$name], true))? call_user_func_array(self::$_scope[$name], $args) : false;
	}
	
	/**
	 * 
	 * @param unknown $name
	 * @param unknown $args
	 * @return Ambigous <ToyModule, unknown>
	 */
	public static function module($name, $args = array())
	{
		return (isset(self::$_modules[$name]))? self::$_modules[$name] : new ToyModule($name, $args);
	}
	
	/**
	 * 
	 * @param string $fn
	 * @return ToyModule
	 */
	public function config($fn = false)
	{
		if ($fn !== false)
		{
			self::$_config[] = $fn;
		}
		return $this;
	}
	
	/**
	 * 
	 * @param string $fn
	 * @throws Exception
	 * @return ToyModule
	 */
	public function run($fn = false)
	{
		$this->config($fn);		
		foreach (self::$_config as $fn)
		{
			if (is_callable($fn, true))
			{
				call_user_func($fn, $this);
			}
			else 
			{
				throw new Exception('Invalid ToyPHP config script callback type!');
			}
		}		
		return $this;
	}
	
	/**
	 * 
	 * @param unknown $name
	 * @param string $fn
	 * @return ToyModule
	 */
	public function bind($name, $fn = false)
	{
		if ($fn !== false)
		{
			self::$_scope[$name] = $fn;
			return $this;
		}
		return $this->$name;
	}
	
	/**
	 * 
	 * @param unknown $name
	 * @param string $fn
	 * @return ToyModule
	 */
	public function factory($name, $fn = false)
	{
		return $this->bind($name, $fn);
	}
	
	/**
	 * 
	 * @param unknown $name
	 * @param string $fn
	 * @return ToyModule
	 */
	public function service($name, $fn = false)
	{
		return $this->bind($name, $fn);
	}
	
	/**
	 * 
	 * @param unknown $name
	 * @param string $fn
	 * @return ToyModule
	 */
	public function filter($name, $fn = false)
	{
		return $this->bind($name, $fn);
	}

	/**
	 * 
	 * @param unknown $name
	 * @param string $fn
	 * @return ToyModule
	 */
	public function controller($name, $fn = false)
	{
		if ($fn !== false)
		{
			$fn = (is_string($fn) && !strpos($fn, '::')  && !function_exists($fn))? new $fn($name) : new ToyController($name, $fn);
		}
		return $this->bind($name, $fn);
	}
	
}

/**
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 *
 */
class ToyController
{
	/**
	 * 
	 * @var unknown
	 */
	private $_fn;
	
	/**
	 * 
	 * @var unknown
	 */
	protected $_name;
	
	/**
	 * 
	 * @param unknown $name
	 * @param string $fn
	 */
	public function __construct($name, $fn = false)
	{
		$this->_name = $name;
		$this->_fn = $fn;
	}
	
	/**
	 * 
	 * @return mixed
	 */
	public function __invoke()
	{
		return $this->run(func_get_args());
	}
	
	/**
	 * 
	 * @return mixed
	 */
	public function run()
	{
		return call_user_func_array($this->_fn, func_get_args());
	}
	
	/**
	 * 
	 * @param unknown $name
	 * @param unknown $args
	 * @return mixed
	 */
	public function __call($name, $args = array())
	{
		return call_user_func_array(array($this->_fn, $name), $args);
	}
}

// -----------------------------------------------------------------------------
// autoload
// -----------------------------------------------------------------------------
spl_autoload_register('toy::autoload');

// -----------------------------------------------------------------------------
// Data stream type enum
// -----------------------------------------------------------------------------
define('stGLOBALS',   1);
define('stSERVER',    2);
define('stGET',       3);
define('stPOST',      4);
define('stFILES',     5);
define('stREQUEST',   6);
define('stSESSION',   7);
define('stENV',       8);
define('stCOOKIE',    9);
define('stPHPINPUT',  10);
define('stARRAY',     11);
define('stUNDEFINED', 0);

// -----------------------------------------------------------------------------
// toy module options
// -----------------------------------------------------------------------------
$options = array(

	'about' => array(
		'title'      => 'ToyPHP framework',
		'descriptor' => 'Built-in ToyPHP services, factories and filters',
		'author'     => 'Nauris Dambis, nauris.renarti@gmail.com',
		'link'       => 'https://github.com/nauris-renarti/ToyPHP',
		'copyright'  => 'Copyright (c) 20015 - 2016, Nauris Dambis',
		'package'    => 'ToyPHP',
		'version'    => '1.0',
		'license'    => 'https://github.com/nauris-renarti/ToyPHP/blob/master/LICENSE',
	),
		
	'scope' => array(
		// services
		array('route',   'toy\services\Route'),
		array('request', 'toy\services\Request'),
		array('db',      'toy\services\Db'),
		array('config',  'toy\services\Config'),
		array('cache',   'toy\services\Cache'),
		array('cookie',  'toy\services\Cookie'),
		array('encoder', 'toy\services\Encoder'),
		array('xsrf',    'toy\services\XsrfToken'),
		array('agent',   'toy\services\Agent'),
		array('uri',     'toy\services\Uri'),
		array('events',  'toy\services\Event'),		
		array('i18n',    'toy\services\Translator'),
		array('session', 'toy\services\Session'),
		// filters
		array('ip',         'toy\services\Request::ip'),
		array('log',        'toy\filters\Loger::log'),
		array('logError',   'toy\filters\Loger::logError'),
		array('auth',       'toy\filters\HttpAuthentication::ask'),
		array('baseUrl',    'toy\filters\ServerUrls::baseUrl'),
		array('siteUrl',    'toy\filters\ServerUrls::siteUrl'),
		array('currentUrl', 'toy\filters\ServerUrls::currentUrl'),
		array('redirect',   'toy\filters\ServerUrls::redirect'),		
		array('skinUrl',    'toy\filters\ServerUrls::skinUrl'),
		array('translate',  'toy\filters\StringFunctions::translate'),
		// string functions
		array('strtocamelcase',  'toy\filters\StringFunctions::strtocamelcase'),
		array('strtocapitalize', 'toy\filters\StringFunctions::strtocapitalize'),
		array('strrandom',       'toy\filters\StringFunctions::strrandom'),
		// ip functions
		//array('isTrustedIp',      'toy\filters\IpFunctions::isTrustedIp'),
		//array('isTrustedReferer', 'toy\filters\IpFunctions::isTrustedReferer'),
		//array('ipInBlacklist',    'toy\filters\IpFunctions::ipInBlacklist'),		
	),
	
);

// -----------------------------------------------------------------------------
// toy module definition
// -----------------------------------------------------------------------------
toy::module('toy', $options);


// -----------------------------------------------------------------------------
// Functions - shortcuts
// -----------------------------------------------------------------------------

/**
 * Translation
 * 
 * @param string $key
 * @return string
 */
function __t($key) 
{
	return toy::module('toy')->i18n->get($key);
}

/**
 * Uri language
 */
function language()
{
	toy::module('toy')->uri->language();
}


/* End of file toy.php */
/* Location: ./modules/toy/toy.php */
	