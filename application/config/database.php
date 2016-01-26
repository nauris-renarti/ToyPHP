<?php
// -----------------------------------------------------------------------------
// Database connection params
// -----------------------------------------------------------------------------
return array(

	// -----------------------------------------------------------------------------
	// toy\factories\Db
	// -----------------------------------------------------------------------------
	'db' => array(
		'traceSql' => false,	
		'traceSingleConnection' => false,
	),
		
	// -----------------------------------------------------------------------------
	// Db/PDO connection params
	// -----------------------------------------------------------------------------
	'database' => array(		
		'dsn'      => 'mysql:host=localhost;dbname=test',
		'username' => 'user',
		'password' => 'password',
		'options'  => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8', time_zone = '+00:00'",
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		),
	),
		
	// -----------------------------------------------------------------------------
	// toy\factories\Model 
	// classmap [classmap][tables] = [[table]=>[modelclass]]
	// -----------------------------------------------------------------------------
	'classmap' => array(
		'tables' => array(
			// tickets
			'db_table_name' => 'namespace\PhpClassModel',
		),
	),
);
