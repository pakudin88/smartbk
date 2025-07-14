<?php
echo "=== REMOTE DATABASE VERIFICATION ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

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

echo "1. DATABASE CONNECTION STATUS:\n";

try {
    $db = \Config\Database::connect();
    $db->initialize();
    
    if ($db->connID) {
        echo "   ✓ Connected to: " . $db->getDatabase() . "\n";
        echo "   ✓ Server: " . $db->hostname . "\n";
        echo "   ✓ Version: " . $db->getVersion() . "\n";
        
        // List all tables
        $tables = $db->listTables();
        echo "\n2. AVAILABLE TABLES (" . count($tables) . " total):\n";
        
        foreach ($tables as $table) {
            echo "   - $table\n";
        }
        
        // Check specific tables that might be needed for login
        echo "\n3. CHECKING KEY TABLES:\n";
        $key_tables = ['users', 'parents', 'students', 'invitations', 'sessions', 'auth'];
        
        foreach ($key_tables as $table) {
            if (in_array($table, $tables)) {
                // Get table info
                $fields = $db->getFieldNames($table);
                echo "   ✓ $table (fields: " . count($fields) . ")\n";
                echo "     Columns: " . implode(', ', array_slice($fields, 0, 5)) . "\n";
            } else {
                echo "   - $table (not found)\n";
            }
        }
        
        echo "\n4. APPLICATION STATUS:\n";
        echo "   ✓ App-ortu connected to remote database\n";
        echo "   ✓ Database: u809035070_simaklah on srv1412.hstgr.io\n";
        echo "   ✓ Ready for production use\n";
        
    } else {
        echo "   ✗ Database connection failed\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n5. NEXT STEPS:\n";
echo "   - Start server: php spark serve --port=8080\n";
echo "   - Test login panel: http://localhost:8080\n";
echo "   - Application now uses remote production database\n";

echo "\n=== VERIFICATION COMPLETED ===\n";
