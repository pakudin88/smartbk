<?php

// Start output buffering early to prevent header issues
ob_start();

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
// CI_DEBUG will be defined later based on environment

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

// Define ENVIRONMENT first, before any CodeIgniter classes are used
if (! defined('ENVIRONMENT')) {
    // Load .env early
    if (file_exists(FCPATH . '../.env')) {
        $env_content = file_get_contents(FCPATH . '../.env');
        if (preg_match('/CI_ENVIRONMENT\s*=\s*(.+)/', $env_content, $matches)) {
            define('ENVIRONMENT', trim($matches[1]));
        } else {
            define('ENVIRONMENT', 'production');
        }
    } else {
        define('ENVIRONMENT', 'production');
    }
}

// Define CI_DEBUG early
if (! defined('CI_DEBUG')) {
    if (file_exists(FCPATH . '../.env')) {
        $env_content = file_get_contents(FCPATH . '../.env');
        if (preg_match('/CI_DEBUG\s*=\s*(.+)/', $env_content, $matches)) {
            define('CI_DEBUG', strtolower(trim($matches[1])) === 'true');
        } else {
            define('CI_DEBUG', ENVIRONMENT !== 'production');
        }
    } else {
        define('CI_DEBUG', ENVIRONMENT !== 'production');
    }
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

// Force web context when we have HTTP variables
$context = 'web';
if (php_sapi_name() === 'cli' && !isset($_SERVER['HTTP_HOST'])) {
    $context = 'php-cli';
}
$app->setContext($context);

try {
    // Get any captured output from early buffer
    $early_output = ob_get_clean();
    
    // Start fresh output buffering for response handling
    ob_start();
    
    $response = $app->run();
    
    // Get any captured output during app run
    $app_output = ob_get_clean();
    
    // Send the response properly
    if ($response && is_object($response) && method_exists($response, 'send')) {
        // Clean response - just send it
        $response->send();
    } else if (!empty($app_output)) {
        // If we have captured output but no response object, send it
        echo $app_output;
    } else if (!empty($early_output)) {
        // Send any early output as fallback
        echo $early_output;
    } else {
        // Last resort fallback
        echo 'App-Ortu is ready';
    }
    
} catch (Throwable $e) {
    // Clean any output buffers
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    // Send error response
    http_response_code(500);
    echo 'Application Error: ' . $e->getMessage();
}
