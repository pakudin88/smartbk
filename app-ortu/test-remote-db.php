<?php
echo "=== DATABASE CONNECTION TEST ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Load environment variables
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

// Load environment
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'development');
}

if (! defined('CI_DEBUG')) {
    define('CI_DEBUG', true);
}

echo "1. CHECKING DATABASE CONFIGURATION:\n";
echo "   Hostname: " . getenv('database.default.hostname') . "\n";
echo "   Database: " . getenv('database.default.database') . "\n";
echo "   Username: " . getenv('database.default.username') . "\n";
echo "   Password: " . (getenv('database.default.password') ? '***hidden***' : 'empty') . "\n";

echo "\n2. TESTING DATABASE CONNECTION:\n";

try {
    // Get database configuration
    $config = new \Config\Database();
    $db_config = $config->default;
    
    echo "   Config hostname: " . $db_config['hostname'] . "\n";
    echo "   Config database: " . $db_config['database'] . "\n";
    echo "   Config username: " . $db_config['username'] . "\n";
    
    // Test connection
    $db = \Config\Database::connect();
    
    if ($db->connID) {
        echo "✓ Database connection successful!\n";
        
        // Test simple query
        $query = $db->query("SELECT 1 as test");
        $result = $query->getRow();
        if ($result && $result->test == 1) {
            echo "✓ Database query test successful!\n";
        }
        
        // Get database info
        $db_name = $db->getDatabase();
        echo "   Connected to database: " . $db_name . "\n";
        
        // Check tables (limit to first 5)
        $tables = $db->listTables();
        echo "   Found " . count($tables) . " tables\n";
        if (count($tables) > 0) {
            echo "   Sample tables: " . implode(', ', array_slice($tables, 0, 5)) . "\n";
        }
        
    } else {
        echo "✗ Database connection failed!\n";
    }
    
} catch (Exception $e) {
    echo "✗ Database connection error: " . $e->getMessage() . "\n";
    echo "   Error code: " . $e->getCode() . "\n";
}

echo "\n3. TESTING APPLICATION WITH REMOTE DB:\n";
echo "   Application is now configured to use remote database\n";
echo "   Server: srv1412.hstgr.io\n";
echo "   Database: u809035070_simaklah\n";

echo "\n=== TEST COMPLETED ===\n";
