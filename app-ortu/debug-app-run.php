<?php
// Advanced debugging untuk mengetahui kenapa $app->run() return null
echo "=== ADVANCED APP-ORTU DEBUG ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Simulate the exact same environment as web request
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '8080';
$_SERVER['HTTP_HOST'] = 'localhost:8080';

echo "1. TESTING CORE COMPONENTS:\n";

try {
    // Change to public directory like the real scenario
    chdir(__DIR__ . '/public');
    
    // Use the exact same constants and setup as index.php
    define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    define('COMPOSER_PATH', FCPATH . '../vendor/autoload.php');
    define('APP_START_TIME', microtime(true));
    define('APP_START_MEMORY', memory_get_usage(true));
    
    // Test autoloader
    require_once COMPOSER_PATH;
    echo "✓ Composer autoloader loaded\n";
    
    // Test paths
    require_once FCPATH . '../app/Config/Paths.php';
    $paths = new Config\Paths();
    echo "✓ Paths configuration loaded\n";
    
    // Test bootstrap
    require_once $paths->systemDirectory . '/bootstrap.php';
    echo "✓ CodeIgniter bootstrap loaded\n";
    
    // Test environment (same as index.php)
    require_once SYSTEMPATH . 'Config/DotEnv.php';
    (new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
    echo "✓ Environment DotEnv loaded\n";
    
    // Define ENVIRONMENT the same way as index.php
    if (! defined('ENVIRONMENT')) {
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
    echo "✓ ENVIRONMENT defined as: " . ENVIRONMENT . "\n";
    
    // Define CI_DEBUG
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
    echo "✓ CI_DEBUG defined as: " . (CI_DEBUG ? 'true' : 'false') . "\n";
    
    // Test services
    $app = Config\Services::codeigniter();
    echo "✓ CodeIgniter service created\n";
    
    $app->initialize();
    echo "✓ Application initialized\n";
    
    $app->setContext('web');
    echo "✓ Context set to web\n";
    
    echo "\n2. TESTING APP RUN:\n";
    
    // The critical test
    $response = $app->run();
    
    if ($response === null) {
        echo "✗ app->run() returned NULL\n";
        echo "This is the source of the problem!\n";
        
        // Let's try to get more info
        echo "\n3. DEBUGGING NULL RESPONSE:\n";
        
        // Check if router is working
        $router = service('router');
        echo "Router service: " . (is_object($router) ? "✓ OK" : "✗ FAILED") . "\n";
        
        // Check if request is valid
        $request = service('request');
        echo "Request service: " . (is_object($request) ? "✓ OK" : "✗ FAILED") . "\n";
        echo "Request URI: " . ($request ? $request->getUri() : 'N/A') . "\n";
        
        // Try to see what route is matched
        try {
            $routes = service('routes');
            echo "Routes service: " . (is_object($routes) ? "✓ OK" : "✗ FAILED") . "\n";
        } catch (Exception $e) {
            echo "Routes error: " . $e->getMessage() . "\n";
        }
        
    } else {
        echo "✓ app->run() returned valid response\n";
        echo "Response type: " . get_class($response) . "\n";
        
        if (method_exists($response, 'getBody')) {
            $body = $response->getBody();
            echo "Response body length: " . strlen($body) . "\n";
            echo "Response preview: " . substr($body, 0, 100) . "...\n";
        }
    }
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== DEBUG COMPLETED ===\n";
?>
