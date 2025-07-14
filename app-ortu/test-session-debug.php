<?php
echo "=== SESSION CONFIGURATION DEBUG ===\n";

// Set up environment like real application
putenv('CI_ENVIRONMENT=development');

chdir(__DIR__ . '/public');

if (!defined('FCPATH')) {
    define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
}

if (!defined('CI_DEBUG')) {
    define('CI_DEBUG', true);
}

// Load bootstrap
require_once FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

// Load environment
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'development'));
}

echo "Testing Session Configuration...\n";

try {
    $sessionConfig = config('Session');
    echo "✅ Session config loaded\n";
    echo "- Driver: " . $sessionConfig->driver . "\n";
    echo "- Cookie name: " . $sessionConfig->cookieName . "\n";
    echo "- Save path: " . $sessionConfig->savePath . "\n";
    echo "- Expiration: " . $sessionConfig->expiration . "\n";
    echo "- Match IP: " . ($sessionConfig->matchIP ? 'true' : 'false') . "\n";
    
    // Check if save path resolves correctly
    $resolvedPath = realpath($sessionConfig->savePath);
    echo "- Resolved save path: " . ($resolvedPath ? $resolvedPath : 'FAILED TO RESOLVE') . "\n";
    
    // Test creating session service
    echo "\nTesting Session Service...\n";
    
    // This is where the error might occur
    $session = \Config\Services::session();
    echo "✅ Session service created successfully\n";
    
    // Test session start
    echo "\nTesting Session Start...\n";
    $session->start();
    echo "✅ Session started successfully\n";
    
    // Test setting and getting value
    $session->set('test_key', 'test_value');
    $value = $session->get('test_key');
    echo "✅ Session set/get test: " . $value . "\n";
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
} catch (Error $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
?>
