<?php
require_once dirname(__FILE__) . '/vendor/autoload.php';

use Dawn\Tests\Bootstrap;

Bootstrap::run(array(	
	'wordpress_test_dir' => '/var/www/html/demo/',
	'wordpress_dir' => '/var/www/html/wordpress',
	'theme' => 'demo',
	'plugins' => array(
		'wordpress-dir/index.php',
	),
	'debug' => true,
	'database' => array(
		'db_name' => 'wordpress-tests',
		'db_user' => 'root',
		'db_password' => 'toor',
		'db_host' => 'localhost',
		'db_charset' => 'utf8',
	),
	'info' => array(
		'domain' => 'www.example.com',
		'email' => 'example@example.com',
		'title' => 'test blog',
	),
));