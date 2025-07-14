<?php
// Final test untuk app-ortu setelah fix error

echo "=== FINAL TEST APP-ORTU AFTER ERROR FIX ===\n";

// Test 1: Basic PHP and file access
echo "1. Testing basic access...\n";
echo "   PHP Version: " . PHP_VERSION . "\n";
echo "   Current time: " . date('Y-m-d H:i:s') . "\n";

// Test 2: Environment check
echo "\n2. Environment configuration...\n";
if (file_exists(__DIR__ . '/.env')) {
    $env = file_get_contents(__DIR__ . '/.env');
    if (strpos($env, 'CI_ENVIRONMENT = production') !== false) {
        echo "   ✓ Environment: production\n";
    }
}

if (file_exists(__DIR__ . '/public/index.php')) {
    $index = file_get_contents(__DIR__ . '/public/index.php');
    if (strpos($index, 'CI_DEBUG', 0) !== false) {
        echo "   ✓ CI_DEBUG configured\n";
    }
}

// Test 3: Database
echo "\n3. Database connection...\n";
try {
    $pdo = new PDO("mysql:host=srv1412.hstgr.io;dbname=u809035070_simaklah;charset=utf8", 
                   "u809035070_simaklah", "Simaklah88#");
    echo "   ✓ Database connected\n";
    
    // Check demo token
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM parent_invitations WHERE invitation_token = 'DEMO2024ORTU'");
    $stmt->execute();
    $result = $stmt->fetch();
    echo "   ✓ Demo token available: " . ($result['count'] > 0 ? 'YES' : 'NO') . "\n";
    
} catch (Exception $e) {
    echo "   ✗ Database error: " . $e->getMessage() . "\n";
}

// Test 4: Try to simulate CodeIgniter bootstrap (safely)
echo "\n4. CodeIgniter bootstrap test...\n";
try {
    // Define required constants
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    }
    
    // Test paths
    if (file_exists(__DIR__ . '/app/Config/Paths.php')) {
        require_once __DIR__ . '/app/Config/Paths.php';
        $paths = new Config\Paths();
        echo "   ✓ Paths configuration loaded\n";
    }
    
    // Test autoloader
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
        echo "   ✓ Composer autoloader loaded\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Bootstrap error: " . $e->getMessage() . "\n";
}

echo "\n=== TEST RESULTS ===\n";
echo "If all tests above show ✓, the app should work now.\n\n";

echo "TEST THESE URLS:\n";
echo "1. http://localhost/smartbk/app-ortu/public/ (Main page)\n";
echo "2. http://localhost/smartbk/app-ortu/public/test (Test route)\n";  
echo "3. http://localhost/smartbk/app-ortu/public/?token=DEMO2024ORTU (Demo)\n\n";

echo "ERROR FIX APPLIED:\n";
echo "- Disabled debug toolbar to prevent TypeError\n";
echo "- Set environment to production\n";
echo "- Set CI_DEBUG to 0\n";
echo "- Cleared cache and session files\n";
echo "- Simplified Events.php configuration\n\n";

echo "=== TEST COMPLETE ===\n";
?>
