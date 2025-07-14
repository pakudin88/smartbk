<?php
echo "=== TESTING LOGIN PANEL ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Test route changes
echo "1. TESTING ROOT ROUTE (/):\n";

// Setup environment
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '8080';
$_SERVER['HTTP_HOST'] = 'localhost:8080';
$_SERVER['HTTPS'] = '';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PATH_INFO'] = '';
$_SERVER['QUERY_STRING'] = '';

putenv('CI_ENVIRONMENT=development');

// Capture output
ob_start();

try {
    chdir(__DIR__ . '/public');
    
    // Manual bootstrap like index.php
    define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    define('COMPOSER_PATH', FCPATH . '../vendor/autoload.php');
    
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
    
    $response = $app->run();
    
    if ($response && is_object($response) && method_exists($response, 'send')) {
        $response->send();
    }
    
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

$output = ob_get_clean();

echo "Output length: " . strlen($output) . " characters\n";
echo "First 200 characters:\n" . substr($output, 0, 200) . "\n";

if (strpos($output, 'Jendela Kemitraan') !== false) {
    echo "✓ Login panel detected!\n";
} else if (strpos($output, 'App-Ortu is working') !== false) {
    echo "✗ Still showing basic message\n";
} else {
    echo "? Unknown output\n";
}

echo "\n=== TEST COMPLETED ===\n";
