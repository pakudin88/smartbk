<?php
echo "=== RESPONSE DEBUG TEST ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Setup proper environment
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '8080';
$_SERVER['HTTP_HOST'] = 'localhost:8080';
$_SERVER['HTTPS'] = '';
$_SERVER['SCRIPT_NAME'] = '/index.php';

putenv('CI_ENVIRONMENT=development');
chdir(__DIR__ . '/public');

// Manual bootstrap like index.php
define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
define('COMPOSER_PATH', FCPATH . '../vendor/autoload.php');
define('APP_START_TIME', microtime(true));
define('APP_START_MEMORY', memory_get_usage(true));

require_once COMPOSER_PATH;
require_once FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

// Setup environment
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'development');
}

if (! defined('CI_DEBUG')) {
    define('CI_DEBUG', true);
}

$app = Config\Services::codeigniter();
$app->initialize();
$app->setContext('web');

echo "1. Running application...\n";
$response = $app->run();

echo "2. Response object details:\n";
echo "   Type: " . gettype($response) . "\n";
if (is_object($response)) {
    echo "   Class: " . get_class($response) . "\n";
    echo "   Has send method: " . (method_exists($response, 'send') ? 'YES' : 'NO') . "\n";
    echo "   Response body: " . $response->getBody() . "\n";
    echo "   Status code: " . $response->getStatusCode() . "\n";
} else {
    echo "   Value: " . var_export($response, true) . "\n";
}

echo "\n=== DEBUG COMPLETED ===\n";
