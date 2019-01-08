<?php

/* Path to the WordPress codebase you'd like to test. Add a forward slash in the end. */
defined('ABSPATH') || define( 'ABSPATH', '/tmp/wordpress/' );


defined('WP_DEFAULT_THEME') || define( 'WP_DEFAULT_THEME', 'default' );

// Test with WordPress debug mode (default).
defined('WP_DEBUG') || define( 'WP_DEBUG', true );

defined('DB_NAME') || define( 'DB_NAME', '' );
defined('DB_USER') || define( 'DB_USER', '' );
defined('DB_PASSWORD') || define( 'DB_PASSWORD', '' );
defined('DB_HOST') || define( 'DB_HOST', 'localhost' );
defined('DB_CHARSET') || define( 'DB_CHARSET', 'utf8' );
defined('DB_COLLATE') || define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 */
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

$table_prefix  = 'wptests_';   // Only numbers, letters, and underscores please!

defined('WP_TESTS_DOMAIN') || define( 'WP_TESTS_DOMAIN', 'example.org' );
defined('WP_TESTS_EMAIL') || define( 'WP_TESTS_EMAIL', 'admin@example.org' );
defined('WP_TESTS_TITLE') || define( 'WP_TESTS_TITLE', 'Test Blog' );

define( 'WP_PHP_BINARY', 'php' );

define( 'WPLANG', '' );