<?php
echo "=== Complete Bootstrap Test ===\n";

// Simulate the exact process from index.php
try {
    // 1. Define FCPATH
    define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    echo "✓ FCPATH defined: " . FCPATH . "\n";
    
    // 2. Change directory
    if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
        chdir(dirname(__FILE__) . '/public');
        echo "✓ Changed to public directory\n";
    }
    
    // 3. Define other basic constants
    define('APP_START_TIME', microtime(true));
    define('APP_START_MEMORY', memory_get_usage(true));
    echo "✓ Timing constants defined\n";
    
    // 4. Load paths
    require_once FCPATH . '../app/Config/Paths.php';
    $paths = new Config\Paths();
    echo "✓ Paths loaded\n";
    
    // 5. Load bootstrap
    require_once $paths->systemDirectory . '/bootstrap.php';
    echo "✓ Bootstrap loaded\n";
    
    // 6. Load environment (this is where the error might occur)
    require_once SYSTEMPATH . 'Config/DotEnv.php';
    (new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
    echo "✓ DotEnv loaded\n";
    
    // 7. Define ENVIRONMENT
    if (! defined('ENVIRONMENT')) {
        define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
    }
    echo "✓ Environment defined: " . ENVIRONMENT . "\n";
    
    echo "\n🎉 All constants and bootstrap completed successfully!\n";
    echo "FCPATH: " . FCPATH . "\n";
    echo "ROOTPATH: " . (defined('ROOTPATH') ? ROOTPATH : 'not defined') . "\n";
    echo "APPPATH: " . (defined('APPPATH') ? APPPATH : 'not defined') . "\n";
    echo "SYSTEMPATH: " . (defined('SYSTEMPATH') ? SYSTEMPATH : 'not defined') . "\n";
    echo "WRITEPATH: " . (defined('WRITEPATH') ? WRITEPATH : 'not defined') . "\n";
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>
