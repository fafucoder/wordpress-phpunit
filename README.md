Wordpress phpunit 
-----------------

in wordpress use phpunit test you code.

## Install
```
$ composer require dawn/wordpress-phpunit
```

## Useage

edit you bootstrap files
```php

<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Dawn\Phpunit\Bootstrap;

$bootstrap = new Bootstrap(array(
	'wordpress_test_dir' => '/var/www/html/demo/',
	'wordpress_dir' => '/var/www/html/wordpress', //wordpress dir
	'theme' => 'demo', 
	'plugins' => array(
		'wordpress-dir/index.php', //need load wordpress plugins
	),
	'debug' => true,
	'database' => array(
		'db_name' => '',   //wordprss-test database name
		'db_user' => 'root', 
		'db_password' => '',
		'db_host' => 'localhost',
		'db_charset' => 'utf8',
	),
	'info' => array(
		'domain' => 'www.example.com',
		'email' => 'example@example.com',
		'title' => 'test blog',
	),
));

$bootstrap->run();
```

