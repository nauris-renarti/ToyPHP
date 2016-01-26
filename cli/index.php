<?php
// Path defines
define('ROOTPATH', realpath(__DIR__  . '/../') . '/');
define('APPPATH',  realpath(__DIR__) . '/');
define('SYSPATH',  realpath(__DIR__  . '/../modules') . '/');

// require ToyPHP framework
require SYSPATH . 'toy/toy.php';

// print message in console
print "CLI script was called successful.\n";
// print incuded files
print_r(get_included_files());

/* End of file index.php */
/* Location: ./cli/index.php */
