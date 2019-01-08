<?php
require_once dirname(__FILE__) . '/vendor/autoload.php';

use Dawn\Tests\Bootstrap;

Bootstrap::run(array(
	'dbname' => 'demo',
	'host' => '127.0.0.1',
	'username' => 'root',
	'password' => 'root',
	'debug' => true,
	'wordpress_dir' => '/var/www/html/wordpress',
	'plugins' => array(
		'wordpress-dir/index.php',
	),
	'themes' => array(
		'demo',
	),
	'wordpress_test_dir' => '/var/www/html/demo/',
));