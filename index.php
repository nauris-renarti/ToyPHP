<?php
// Benchmarking
$benchmark = microtime(true);

// Path defines
define('ROOTPATH', realpath(__DIR__) . '/');
define('APPPATH',  realpath(__DIR__  . '/application').'/');
define('SYSPATH',  realpath(__DIR__  . '/modules').'/');
define('SKINPATH', realpath(__DIR__  . '/skins/default').'/');

// Require ToyPHP framework
require SYSPATH . 'toy/toy.php';

// Define application
$app = toy::module('app');

// Anonymous function as WelcomeController
$app->controller('WelcomeController', function(){
	// include HTML file
	require APPPATH . 'views/welcome.html.php';
});

// Run WelcomeController
$app->WelcomeController->run();

// Debug
print '<script>$(function(){$("body").append("<p style=\"text-align: center; margin: 15px 0;\">Page rendered in ' . number_format(microtime(true) - $benchmark, 4) . '(sec.)</p>")});</script>';

/* End of file index.php */
/* Location: ./index.php */
