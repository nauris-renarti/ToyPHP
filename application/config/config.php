<?php
// error reporting lefel
error_reporting(E_ALL);

// display errors
ini_set('display_errors', '1');

// log errors
ini_set("log_errors", 1);

// set server default time zone
date_default_timezone_set('UTC');

// return config as array
return array(
		
	// toy\services\Cache
	'toy\services\Cache' => array(
		'enabled' => true, 
		'prefix'  => 'cache_',
		'hashKey' => true,
	),	

	// toy\services\Encoder
	'toy\services\Encoder' => array(
		'key'    => 'My super secret pasword :)',
		'mode'   => MCRYPT_MODE_CFB,
		'chiper' => MCRYPT_GOST,
	),

	// toy\services\XsrfToken
	'toy\services\XsrfToken' => array(
		'tokenName' => 'XSRF-TOKEN',
	),
		
	// toy\filters\HttpAuthentication	
	'toy\filters\HttpAuthentication' => array(
		'toy'  => 'story',
	),
		
	// toy\services\Uri
	'toy\services\Uri' => array(
		'allowedUriChars' => 'a-я 0-9%@#_\-=+',
		'defaultUriLanguage' => 'en',
		'allowedUriLanguages' => array('en','lv','ru'),
	),
		
		
);
