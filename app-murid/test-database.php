<?php
/**
 * Database Connection Test for App-Murid
 * Test if database configuration matches app-superadmin
 */

require_once 'vendor/autoload.php';

echo "=== DATABASE CONNECTION TEST - APP MURID ===\n";

// Load environment
if (file_exists('.env')) {
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
}

// Test database configuration
try {
    // Initialize CodeIgniter config
    defined('APPPATH') || define('APPPATH', realpath(__DIR__ . '/app') . DIRECTORY_SEPARATOR);
    defined('ROOTPATH') || define('ROOTPATH', realpath(__DIR__) . DIRECTORY_SEPARATOR);
    defined('FCPATH') || define('FCPATH', realpath(__DIR__ . '/public') . DIRECTORY_SEPARATOR);
    defined('WRITEPATH') || define('WRITEPATH', realpath(__DIR__ . '/writable') . DIRECTORY_SEPARATOR);
    
    // Set environment
    if (!defined('ENVIRONMENT')) {
        define('ENVIRONMENT', $_ENV['CI_ENVIRONMENT'] ?? 'development');
    }
    
    echo "Environment: " . ENVIRONMENT . "\n";
    
    // Test database config loading
    $config = new \Config\Database();
    
    echo "\n=== DATABASE CONFIGURATIONS ===\n";
    echo "Default Group: " . $config->defaultGroup . "\n";
    
    echo "\nProduction Database (default):\n";
    echo "  Host: " . $config->default['hostname'] . "\n";
    echo "  Database: " . $config->default['database'] . "\n";
    echo "  Username: " . $config->default['username'] . "\n";
    echo "  Port: " . $config->default['port'] . "\n";
    
    echo "\nLocal Database:\n";
    echo "  Host: " . $config->local['hostname'] . "\n";
    echo "  Database: " . $config->local['database'] . "\n";
    echo "  Username: " . $config->local['username'] . "\n";
    echo "  Port: " . $config->local['port'] . "\n";
    
    // Test actual connection
    echo "\n=== TESTING DATABASE CONNECTION ===\n";
    
    $db = \Config\Database::connect();
    
    if ($db->connID) {
        echo "✅ Database connection successful!\n";
        
        // Test basic query
        $query = $db->query("SELECT 1 as test");
        $result = $query->getRow();
        
        if ($result && $result->test == 1) {
            echo "✅ Database query test successful!\n";
        }
        
        // Get current database name
        $currentDb = $db->query("SELECT DATABASE() as current_db")->getRow();
        echo "Connected to database: " . ($currentDb->current_db ?? 'Unknown') . "\n";
        
        // Test if user table exists
        $tableExists = $db->query("SHOW TABLES LIKE 'users'")->getRow();
        if ($tableExists) {
            echo "✅ Users table exists\n";
            
            // Count users with role murid
            $muridCount = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'murid'")->getRow();
            echo "Found " . ($muridCount->count ?? 0) . " student users (murid)\n";
        } else {
            echo "⚠️ Users table not found\n";
        }
        
    } else {
        echo "❌ Database connection failed!\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "Database configuration has been copied from app-superadmin\n";
echo "- Production: srv1412.hstgr.io/u809035070_simaklah\n";
echo "- Local: localhost/sekolah_multiapp\n";
echo "- Auto-detection based on environment\n";
?>
