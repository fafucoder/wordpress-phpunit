<?php
namespace Dawn\Phpunit\Bootstrap;

class Bootstrap {
    public static $instance;

    /**
     * The plugins should be loaded.
     * 
     * @var array
     */
    protected $plugins = array();

    /**
     * The theme to switched.
     * 
     * @var string
     */
    protected $theme = '';

    /**
     * Files to load after `muplugins_loaded` filter.
     *
     * @var array
     */
    protected $bootstraps = array();

    /**
     * Wordpress test dir.
     * 
     * @var string
     */
    protected $wordpress_test_dir;

    /**
     * Wordpress dir.
     * 
     * @var string
     */
    protected $wordpress_dir;

    /**
     * If debug to turn on.
     * 
     * @var boolean
     */
    protected $debug = true;

    /**
     * Wordpress test database configs.
     * 
     * @var array
     */
    protected $database = array();

    /**
     * Test site config setting.
     * 
     * @var array
     */
    protected $info = array();

    /**
     * Single instance.
     * 
     * @param  array  $config [description]
     * @return object         
     */
    public function getInstance($config = array()) {
        if (!self::$instance || self::$instance instanceof self) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    /**
     * Construct,
     * 
     * @param array $config 
     */
    public function __construct($config = array()) {
        $keys = array_keys(get_object_vars($this));

        foreach ($config as $key => $value) {
            if (in_array($key, $keys)) {
                $this->$key = $value;
            }
        }
        $this->wordpress_test_dir = $this->get_test_dir();
    }

    /**
     * Set test dir.
     * 
     * @param string $test_dir 
     */
    public function set_test_dir($test_dir) {
        $this->wordpress_test_dir = $test_dir;
    }

    /**
     * Get test dir.
     * 
     * @return string 
     */
    public function get_test_dir() {
        if (isset($this->wordpress_test_dir) && file_exists($this->wordpress_test_dir)) {
            return $this->wordpress_test_dir;
        } else {
            return dirname(__DIR__) . '/wordpress-test-lib';
        }
    }

    /**
     * Set plugins.
     * 
     * @param mixed $plugins 
     */
    public function set_plugins($plugins) {
        if (is_string($plugins)) {
            if (!file_exists($plugins)) {
                return;
            }
            $this->plugins[] = $plugins;
        } elseif (is_array($plugins)) {
            $plugins = array_filter($plugins, function ($plugin) {
                return file_exists($plugin);
            });
            $plugins = array_unique($plugins);
            $this->plugins = array_merge($this->plugins, $plugins);
        }
    }

    /**
     * Set debug mode.
     * 
     * @param boolean $debug 
     */
    public function set_debug($debug = true) {
        $this->debug = $debug;
    }

    /**
     * Set wordpress dir.
     * 
     * @param string $wordpress_dir 
     */
    public function set_wordpress_dir($wordpress_dir) {
        $this->wordpress_dir = $wordpress_dir;
    }

    /**
     * Set theme.
     * 
     * @param string $theme 
     */
    public function set_theme($theme) {
        if (is_string($theme)) {
            $this->theme = $theme;
        } 
    }

    /**
     * Run bootstrap.
     * 
     * @param  mixed $closure 
     * @return void          
     */
    public function run($closure = null) {
        $test_root = $this->get_test_dir();
        $test_root = rtrim($test_root, '/');

        if (empty($test_root) || !file_exists($test_root)) {
            throw new \Exception('Empty test root');
        }

        if (!file_exists($test_root . '/includes/functions.php') || !file_exists($test_root . '/functions.php')) {
            throw new \Exception("functions.php in missing!");
        }

        if (!function_exists('tests_add_filter')) {
            if (file_exists($test_root . '/includes/functions.php')) {
                require_once $test_root . '/includes/functions.php';
            } elseif (file_exists($test_root . '/functions.php')) {
                require_once $test_root . '/functions.php';
            }
        }

        if (!empty($this->plugins)) {
            foreach ($this->plugins as $plugin) {
                if (!file_exists($plugin)) {
                    continue;
                }
                tests_add_filter('muplugins_loaded', function () use ($plugin) {
                    require_once $plugin;
                });
            }
        }

        if (!empty($this->theme)) {
            tests_add_filter('muplugins_loaded', function () {
                switch_theme($this->theme);
            });
        }

        //init config file
        $this->init_config();

        if (!file_exists($test_root . '/includes/bootstrap.php') || !file_exists($test_root . '/bootstrap.php')) {
            throw new \Exception("bootstrap.php is missing!");
        }

        if (!class_exists('WP_UnitTestCase')) {
            if (file_exists($test_root . '/includes/bootstrap.php')) {
                require_once $test_root . '/includes/bootstrap.php';
            } elseif (file_exists($test_root . '/bootstrap.php')) {
                require_once $test_root . '/bootstrap.php';
            }
        }

        if (is_callable($closure)) {
            call_user_func($closure);
        }

        foreach ($this->bootstraps as $file) {
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }

    /**
     * Init config.
     * 
     * @return void 
     */
    protected function init_config() {
        if (!empty($this->wordpress_dir)) {
            define('ABSPATH', $this->wordpress_dir);
        }

        if (!empty($this->debug)) {
            define('WP_DEBUG', $this->debug);
        }

        if (!empty($this->database)) {
            foreach ($this->database as $key => $value) {
                define(strtoupper($key), $value);
            }
        }

        if (!empty($this->info)) {
            foreach ($this->info as $key => $value) {
                $key = "WP_TESTS_" . strtoupper($key);
                define($key, $value);
            }
        }
    }
}