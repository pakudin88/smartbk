<?php
echo "=== TESTING TOOLBAR CONFIGURATION ===\n";

try {
    // Set up environment
    putenv('CI_ENVIRONMENT=development');
    
    chdir(__DIR__ . '/public');
    
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    }
    
    // Load CodeIgniter
    require_once FCPATH . '../app/Config/Paths.php';
    $paths = new Config\Paths();
    require_once $paths->systemDirectory . '/bootstrap.php';
    
    // Load environment
    require_once SYSTEMPATH . 'Config/DotEnv.php';
    (new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
    if (! defined('ENVIRONMENT')) {
        define('ENVIRONMENT', env('CI_ENVIRONMENT', 'development'));
    }
    
    echo "1. Testing Toolbar Config...\n";
    try {
        $toolbarConfig = config('Toolbar');
        echo "   ✅ Toolbar config loaded successfully\n";
        echo "   Collectors count: " . count($toolbarConfig->collectors) . "\n";
        echo "   Max history: " . $toolbarConfig->maxHistory . "\n";
    } catch (Exception $e) {
        echo "   ✗ Toolbar config error: " . $e->getMessage() . "\n";
    }
    
    echo "\n2. Testing Toolbar Service...\n";
    try {
        $toolbar = \Config\Services::toolbar();
        echo "   ✅ Toolbar service created successfully\n";
    } catch (Exception $e) {
        echo "   ✗ Toolbar service error: " . $e->getMessage() . "\n";
    }
    
    echo "\n3. Testing Events System...\n";
    try {
        // This should not trigger the toolbar error anymore
        \CodeIgniter\Events\Events::trigger('pre_system');
        echo "   ✅ Events trigger successful\n";
    } catch (Exception $e) {
        echo "   ✗ Events error: " . $e->getMessage() . "\n";
    }
    
    echo "\n4. Testing Full Application Flow...\n";
    try {
        // Test if we can create the full CodeIgniter app without errors
        $app = \Config\Services::codeigniter();
        echo "   ✅ CodeIgniter app service created\n";
        
        // Test if app can initialize without the toolbar error
        ob_start();
        // Don't actually run the app, just test initialization components
        echo "   ✅ Application components ready\n";
        ob_end_clean();
        
    } catch (Exception $e) {
        echo "   ✗ Application error: " . $e->getMessage() . "\n";
        echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
    
    echo "\n🎉 TOOLBAR CONFIGURATION TEST COMPLETE!\n";
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>
