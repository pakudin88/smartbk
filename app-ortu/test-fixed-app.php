<?php
echo "=== TESTING FIXED APPLICATION ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Setup proper web environment
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/login';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '8080';
$_SERVER['HTTP_HOST'] = 'localhost:8080';
$_SERVER['HTTPS'] = '';
$_SERVER['SCRIPT_NAME'] = '/index.php';

putenv('CI_ENVIRONMENT=development');

echo "1. TESTING LOGIN ROUTE:\n";

ob_start();
$original_dir = getcwd();

try {
    chdir(__DIR__ . '/public');
    
    // Bootstrap like index.php
    define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    define('COMPOSER_PATH', FCPATH . '../vendor/autoload.php');
    define('APP_START_TIME', microtime(true));
    define('APP_START_MEMORY', memory_get_usage(true));
    
    require_once COMPOSER_PATH;
    require_once FCPATH . '../app/Config/Paths.php';
    $paths = new Config\Paths();
    require_once $paths->systemDirectory . '/bootstrap.php';
    
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
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

chdir($original_dir);
$output = ob_get_clean();

echo "   Output length: " . strlen($output) . " characters\n";

if (strpos($output, 'Jendela Kemitraan') !== false) {
    echo "   ✓ Login form detected!\n";
} else if (strpos($output, 'Error') !== false) {
    echo "   ✗ Error in output\n";
    echo "   First 300 chars: " . substr($output, 0, 300) . "\n";
} else {
    echo "   ? Unexpected output\n";
    echo "   First 200 chars: " . substr($output, 0, 200) . "\n";
}

echo "\n2. MANUAL TEST INSTRUCTIONS:\n";
echo "   1. Run: php spark serve --port=8080\n";
echo "   2. Open: http://localhost:8080/login\n";
echo "   3. Should see elegant login form\n";
echo "   4. Try login with database users\n";

echo "\n=== TEST COMPLETED ===\n";
