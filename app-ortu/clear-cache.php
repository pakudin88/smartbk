<?php
// Clear cache and test app-ortu

echo "=== CLEARING CACHE & FIXING APP-ORTU ===\n";

// 1. Clear writable cache
$cacheDir = __DIR__ . '/writable/cache';
if (is_dir($cacheDir)) {
    $files = glob($cacheDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✓ Cache files cleared\n";
}

// 2. Clear session files
$sessionDir = __DIR__ . '/writable/session';
if (is_dir($sessionDir)) {
    $files = glob($sessionDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✓ Session files cleared\n";
}

// 3. Test basic configuration
echo "\n=== TESTING CONFIGURATION ===\n";

try {
    // Test environment loading
    if (file_exists(__DIR__ . '/.env')) {
        $env = file_get_contents(__DIR__ . '/.env');
        if (strpos($env, 'CI_ENVIRONMENT = production') !== false) {
            echo "✓ Environment set to production\n";
        }
    }
    
    // Test database connection
    $pdo = new PDO("mysql:host=srv1412.hstgr.io;dbname=u809035070_simaklah;charset=utf8", 
                   "u809035070_simaklah", "Simaklah88#");
    echo "✓ Database connection working\n";
    
    // Test critical files
    $files = [
        'app/Config/App.php',
        'app/Config/Events.php', 
        'app/Config/Toolbar.php',
        'app/Controllers/Partnership.php',
        'public/index.php'
    ];
    
    foreach ($files as $file) {
        if (file_exists(__DIR__ . '/' . $file)) {
            echo "✓ $file exists\n";
        } else {
            echo "✗ $file missing\n";
        }
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== TESTING URLs ===\n";
echo "Try these URLs:\n";
echo "1. Main: http://localhost/smartbk/app-ortu/public/\n";
echo "2. Test: http://localhost/smartbk/app-ortu/public/test\n";
echo "3. Demo: http://localhost/smartbk/app-ortu/public/?token=DEMO2024ORTU\n";

echo "\n=== CACHE CLEAR COMPLETE ===\n";
?>
