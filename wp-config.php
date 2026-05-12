<?php
if (!function_exists('getenv_docker'))
{
	function getenv_docker($env, $default)
	{
		if ($fileEnv = getenv($env . '_FILE'))
		{
			return rtrim(file_get_contents($fileEnv), "\r\n");
		}
		return (($val = getenv($env)) !== false) ? $val : $default;
	}
}

// Database
define('DB_NAME',     getenv_docker('WORDPRESS_DB_NAME', 'wordpress'));
define('DB_USER',     getenv_docker('WORDPRESS_DB_USER', 'wordpress'));
define('DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'root'));
define('DB_HOST',     getenv_docker('WORDPRESS_DB_HOST', 'db'));
define('DB_CHARSET',  'utf8mb4');
define('DB_COLLATE',  '');

// Redis
define('WP_REDIS_HOST', getenv_docker('WORDPRESS_REDIS_HOST', 'redis'));
define('WP_REDIS_PORT', 6379);
define('WP_REDIS_TIMEOUT', 1);
define('WP_REDIS_READ_TIMEOUT', 1);

define('WP_CACHE_KEY_SALT', getenv_docker('PROJECT_NAME', 'wordpress'));
define('AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',  'put-your-unique-phrase-here'));
define('SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  'put-your-unique-phrase-here'));
define('LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',  'put-your-unique-phrase-here'));
define('NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',  'put-your-unique-phrase-here'));
define('AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',  'put-your-unique-phrase-here'));
define('SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', 'put-your-unique-phrase-here'));
define('LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',  'put-your-unique-phrase-here'));
define('NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',  'put-your-unique-phrase-here'));

$table_prefix = getenv_docker('WORDPRESS_TABLE_PREFIX', 'wp_');

// Dynamic URL Handling
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
$base_url = $protocol . $_SERVER['HTTP_HOST'];

define('WP_HOME',    $base_url);
define('WP_SITEURL', $base_url);

// Debugging
define('WP_DEBUG',         true);
define('WP_DEBUG_LOG',     true);
define('WP_DEBUG_DISPLAY', true); // Local dev: show errors instead of a white screen
@ini_set('display_errors', 1);

// Optimization & Constraints
define('WP_HTTP_BLOCK_EXTERNAL', false); // Allow updates/plugin installs
define('DISABLE_WP_CRON',        true);  // Run via system crontab instead of web requests

// Proxy Handling
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false)
{
	$_SERVER['HTTPS'] = 'on';
}

if (!defined('ABSPATH'))
{
	define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';
