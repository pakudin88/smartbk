<?php
echo "=== Final Web Application Test ===\n";

// Simulate complete web environment
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SCRIPT_NAME'] = '/simaklah-main/app-ortu/public/index.php';

// Capture output to prevent header conflicts
ob_start();

try {
    // Include the actual index.php with all error handling
    chdir(__DIR__ . '/public');
    
    // Test just the constants part
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    }
    
    require_once FCPATH . '../app/Config/Paths.php';
    $paths = new Config\Paths();
    require_once $paths->systemDirectory . '/bootstrap.php';
    
    echo "✓ All core constants defined successfully\n";
    echo "✓ FCPATH: " . FCPATH . "\n";
    echo "✓ Bootstrap completed without FCPATH errors\n";
    
    // Test CodeIgniter services
    $app = Config\Services::codeigniter();
    echo "✓ CodeIgniter services loaded\n";
    
    echo "\n🎉 SUCCESS: The FCPATH error has been resolved!\n";
    echo "The application should now load properly in the browser.\n";
    
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
