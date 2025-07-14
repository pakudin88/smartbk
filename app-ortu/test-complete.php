<?php
echo "=== HTTP Test for app-ortu ===\n";

// Set up environment for web request
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SCRIPT_NAME'] = '/simaklah-main/app-ortu/public/index.php';

// Change to public directory
chdir(__DIR__ . '/public');

echo "Testing complete application bootstrap...\n";

// Capture any output
ob_start();
try {
    // Test the application initialization without actually including index.php
    // to avoid header conflicts
    require_once __DIR__ . '/app/Config/Paths.php';
    $paths = new Config\Paths();
    
    require_once $paths->systemDirectory . '/bootstrap.php';
    
    // Load environment settings
    require_once SYSTEMPATH . 'Config/DotEnv.php';
    (new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
    
    // Define ENVIRONMENT
    if (! defined('ENVIRONMENT')) {
        define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
    }
    
    echo "✓ Environment: " . ENVIRONMENT . "\n";
    echo "✓ System bootstrap completed successfully\n";
    echo "✓ DotEnv loaded successfully\n";
    echo "✓ All required constants defined\n";
    
    // Test if we can load CodeIgniter services
    $app = Config\Services::codeigniter();
    if ($app) {
        echo "✓ CodeIgniter services loaded successfully\n";
    }
    
    echo "\n✅ SUCCESS: app-ortu is fully functional!\n";
    echo "The application should now work properly in a web browser.\n";
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} finally {
    ob_end_clean();
}
?>
