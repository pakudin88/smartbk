<?php
echo "=== DETAILED CI DATABASE CONNECTION ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Complete bootstrap
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'development');
}

if (! defined('CI_DEBUG')) {
    define('CI_DEBUG', true);
}

echo "1. TESTING DATABASE CONNECTION WITH DETAILED ERRORS:\n";

try {
    // Get database config
    $config = new \Config\Database();
    $dbConfig = $config->default;
    
    echo "   Using config:\n";
    echo "     Host: " . $dbConfig['hostname'] . "\n";
    echo "     Database: " . $dbConfig['database'] . "\n";
    echo "     Username: " . $dbConfig['username'] . "\n";
    echo "     Driver: " . $dbConfig['DBDriver'] . "\n";
    echo "     Port: " . $dbConfig['port'] . "\n";
    echo "     Debug: " . ($dbConfig['DBDebug'] ? 'enabled' : 'disabled') . "\n";
    
    // Create database connection manually
    echo "\n   Creating database connection...\n";
    
    $database = \Config\Database::connect('default', false);
    echo "   ✓ Database object created\n";
    
    // Check connection ID
    echo "   Connection ID: " . ($database->connID ? 'exists' : 'null') . "\n";
    
    // Force connection
    if (!$database->connID) {
        echo "   Attempting to initialize connection...\n";
        $database->initialize();
        echo "   After initialize - Connection ID: " . ($database->connID ? 'exists' : 'null') . "\n";
    }
    
    // Test with simple query
    if ($database->connID) {
        echo "   ✓ Connection established!\n";
        
        $query = $database->query("SELECT 1 as test");
        if ($query) {
            $result = $query->getRow();
            echo "   ✓ Query successful: " . $result->test . "\n";
        } else {
            echo "   ✗ Query failed\n";
        }
        
        // Get database version
        $version = $database->getVersion();
        echo "   ✓ Database version: $version\n";
        
    } else {
        echo "   ✗ Could not establish connection\n";
        
        // Get last error
        $error = $database->error();
        if ($error) {
            echo "   ✗ Database error: " . print_r($error, true) . "\n";
        }
    }
    
} catch (Throwable $e) {
    echo "   ✗ Exception: " . $e->getMessage() . "\n";
    echo "   ✗ File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "   ✗ Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n2. CLEARING CACHE AND TESTING:\n";

try {
    // Clear any potential cache
    if (function_exists('opcache_reset')) {
        opcache_reset();
        echo "   ✓ OPcache cleared\n";
    }
    
} catch (Exception $e) {
    echo "   - OPcache not available\n";
}

echo "\n=== TEST COMPLETED ===\n";
