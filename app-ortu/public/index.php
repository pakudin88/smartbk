<?php

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 |--------------------------------------------------------------------------
 | ERROR DISPLAY
 |--------------------------------------------------------------------------
 | Don't show ANY in production environments. Instead, let the system catch
 | it and display a generic error message.
 */
ini_set('display_errors', '1');
error_reporting(E_ALL);

/*
 |--------------------------------------------------------------------------
 | DEBUG MODE
 |--------------------------------------------------------------------------
 | Debug mode is an experimental flag that can allow for displaying
 | additional error details.
 */
define('CI_DEBUG', 1);

/*
 |--------------------------------------------------------------------------
 | COMPOSER PATH
 |--------------------------------------------------------------------------
 | The path that Composer's autoload file is expected to live.
 */
define('COMPOSER_PATH', __DIR__ . '/../vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | TIMING CONSTANTS
 |--------------------------------------------------------------------------
 | Provide some of the base performance values into the system.
 */
define('APP_START_TIME', microtime(true));
define('APP_START_MEMORY', memory_get_usage(true));

/*
 |--------------------------------------------------------------------------
 | LOAD OUR PATHS CONFIG FILE
 |--------------------------------------------------------------------------
 | This will set the various paths for our application. Those have been
 | customized for this application structure.
 */
require_once FCPATH . '../app/Config/Paths.php';

$paths = new Config\Paths();

/*
 |--------------------------------------------------------------------------
 | BOOTSTRAP THE FRAMEWORK
 |--------------------------------------------------------------------------
 | This bootstraps the framework and gets it ready for use.
 */
require_once $paths->systemDirectory . '/bootstrap.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

// Define ENVIRONMENT
if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
}

// Define CI_DEBUG early to prevent issues
if (! defined('CI_DEBUG')) {
    define('CI_DEBUG', ENVIRONMENT !== 'production');
}

/*
 |--------------------------------------------------------------------------
 | LAUNCH THE APPLICATION
 |--------------------------------------------------------------------------
 | Now that everything is setup, it's time to actually fire up the engines
 | and make this app do its thing.
 */

$app = Config\Services::codeigniter();
$app->initialize();

$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);

$response = $app->run();
$response->send();

if (CI_DEBUG && $context === 'web') {
    $app->showDebugger();
}
