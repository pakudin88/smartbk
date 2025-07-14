<?php
echo "=== SIMPLE TEST APP-ORTU ===\n";

// Test basic PHP
echo "1. PHP Version: " . PHP_VERSION . "\n";

// Test file access
echo "2. Testing file access...\n";
if (file_exists(__DIR__ . '/app/Config/App.php')) {
    echo "   ✓ App config exists\n";
} else {
    echo "   ✗ App config missing\n";
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "   ✓ Composer autoload exists\n";
} else {
    echo "   ✗ Composer autoload missing\n";
}

// Test database connection
echo "3. Testing database connection...\n";
try {
    $host = 'srv1412.hstgr.io';
    $dbname = 'u809035070_simaklah';
    $username = 'u809035070_simaklah';
    $password = 'Simaklah88#';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "   ✓ Database connection successful\n";
    
    // Test table exists
    $stmt = $pdo->prepare("SHOW TABLES LIKE 'parent_invitations'");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo "   ✓ Table parent_invitations exists\n";
    } else {
        echo "   ✗ Table parent_invitations missing\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Database error: " . $e->getMessage() . "\n";
}

// Test CodeIgniter loading
echo "4. Testing CodeIgniter loading...\n";
try {
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    }
    
    // Load paths
    require_once __DIR__ . '/app/Config/Paths.php';
    $paths = new Config\Paths();
    
    // Define important paths
    if (!defined('APPPATH')) {
        define('APPPATH', realpath($paths->appDirectory) . DIRECTORY_SEPARATOR);
    }
    if (!defined('SYSTEMPATH')) {
        define('SYSTEMPATH', realpath($paths->systemDirectory) . DIRECTORY_SEPARATOR);
    }
    if (!defined('ROOTPATH')) {
        define('ROOTPATH', realpath(APPPATH . '../') . DIRECTORY_SEPARATOR);
    }
    
    echo "   ✓ Paths configured\n";
    
    // Test autoloader
    if (file_exists(ROOTPATH . 'vendor/autoload.php')) {
        require_once ROOTPATH . 'vendor/autoload.php';
        echo "   ✓ Composer autoloader loaded\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ CodeIgniter loading error: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";
?>
