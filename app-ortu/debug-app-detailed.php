<?php
echo "=== DEBUGGING APP ACCESS ===\n";

try {
    // Test direct access to index.php
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/';
    $_SERVER['SERVER_NAME'] = 'localhost';
    $_SERVER['HTTP_HOST'] = 'localhost';
    $_SERVER['SCRIPT_NAME'] = '/simaklah-main/app-ortu/public/index.php';
    $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';
    
    chdir(__DIR__ . '/public');
    
    echo "1. Testing environment loading...\n";
    putenv('CI_ENVIRONMENT=development');
    
    // Set FCPATH
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    }
    
    echo "2. Testing configuration loading...\n";
    require_once FCPATH . '../app/Config/Paths.php';
    $paths = new Config\Paths();
    require_once $paths->systemDirectory . '/bootstrap.php';
    
    echo "3. Testing environment file...\n";
    require_once SYSTEMPATH . 'Config/DotEnv.php';
    (new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
    if (! defined('ENVIRONMENT')) {
        define('ENVIRONMENT', env('CI_ENVIRONMENT', 'development'));
    }
    echo "   Environment: " . ENVIRONMENT . "\n";
    
    echo "4. Testing services...\n";
    $request = \Config\Services::request();
    $response = \Config\Services::response();
    $router = \Config\Services::router();
    
    echo "5. Testing database connection...\n";
    $db = \Config\Database::connect();
    echo "   Database driver: " . $db->DBDriver . "\n";
    
    echo "6. Testing controller...\n";
    $partnership = new \App\Controllers\Partnership();
    echo "   Partnership controller created\n";
    
    // Test method
    ob_start();
    $result = $partnership->index();
    $output = ob_get_clean();
    
    if ($result instanceof \CodeIgniter\HTTP\Response) {
        echo "   Response object returned\n";
    } elseif (is_string($result)) {
        echo "   String result: " . strlen($result) . " characters\n";
    } else {
        echo "   Result type: " . gettype($result) . "\n";
    }
    
    echo "\n✅ APPLICATION APPEARS TO BE WORKING!\n";
    echo "Try accessing: http://localhost/simaklah-main/app-ortu/public/\n";
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
?>
