<?php
// Simple test to verify app-ortu is working
echo "Testing App-Ortu Configuration...\n\n";

// Test 1: Check if basic PHP is working
echo "✓ PHP is working (version: " . PHP_VERSION . ")\n";

// Test 2: Check if paths are correct
$appPath = __DIR__ . '/app';
echo "✓ App path exists: " . ($appPath && is_dir($appPath) ? 'YES' : 'NO') . "\n";

// Test 3: Check if vendor autoload exists
$vendorPath = __DIR__ . '/vendor/autoload.php';
echo "✓ Composer autoload exists: " . (file_exists($vendorPath) ? 'YES' : 'NO') . "\n";

// Test 4: Check environment file
$envPath = __DIR__ . '/.env';
echo "✓ .env file exists: " . (file_exists($envPath) ? 'YES' : 'NO') . "\n";

// Test 5: Try to load CodeIgniter
try {
    require_once $vendorPath;
    
    // Load paths config
    require_once __DIR__ . '/app/Config/Paths.php';
    $paths = new Config\Paths();
    
    // Bootstrap framework
    require_once $paths->systemDirectory . '/bootstrap.php';
    
    // Load environment
    require_once SYSTEMPATH . 'Config/DotEnv.php';
    (new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
    
    echo "✓ CodeIgniter 4 loaded successfully\n";
    echo "✓ Environment: " . ($_ENV['CI_ENVIRONMENT'] ?? 'not set') . "\n";
    echo "✓ Debug: " . ($_ENV['CI_DEBUG'] ?? 'not set') . "\n";
    
} catch (Exception $e) {
    echo "✗ Error loading CodeIgniter: " . $e->getMessage() . "\n";
}

echo "\nTest completed!\n";
?>
