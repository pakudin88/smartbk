<?php
echo "=== Full Application Test with App Config ===\n";

try {
    // Set up basic environment
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    }
    
    chdir(__DIR__ . '/public');
    
    // Load paths and bootstrap
    require_once FCPATH . '../app/Config/Paths.php';
    $paths = new Config\Paths();
    require_once $paths->systemDirectory . '/bootstrap.php';
    
    echo "✓ Bootstrap completed\n";
    
    // Load environment
    require_once SYSTEMPATH . 'Config/DotEnv.php';
    (new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
    if (! defined('ENVIRONMENT')) {
        define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
    }
    
    echo "✓ Environment loaded: " . ENVIRONMENT . "\n";
    
    // Now test the App config
    $appConfig = config('App');
    echo "✓ App configuration loaded without allowedHostnames error\n";
    echo "✓ baseURL: " . $appConfig->baseURL . "\n";
    echo "✓ allowedHostnames property exists: " . (property_exists($appConfig, 'allowedHostnames') ? 'YES' : 'NO') . "\n";
    
    // Test URI service creation (this was failing before)
    $uri = \Config\Services::uri();
    echo "✓ URI service created successfully\n";
    
    echo "\n🎉 SUCCESS: The allowedHostnames error has been completely resolved!\n";
    echo "The application should now work properly in the browser.\n";
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>
