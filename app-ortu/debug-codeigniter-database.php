<?php
echo "=== CODEIGNITER DATABASE DEBUG ===\n";

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
    
    echo "1. Testing CodeIgniter Database Config...\n";
    $dbConfig = config('Database');
    echo "   Default group: " . $dbConfig->defaultGroup . "\n";
    echo "   Hostname: " . $dbConfig->default['hostname'] . "\n";
    echo "   Database: " . $dbConfig->default['database'] . "\n";
    echo "   Username: " . $dbConfig->default['username'] . "\n";
    echo "   Driver: " . $dbConfig->default['DBDriver'] . "\n";
    
    echo "\n2. Testing Database Connection through CodeIgniter...\n";
    
    try {
        $db = \Config\Database::connect();
        echo "   Database object created\n";
        
        // Check connection
        if (method_exists($db, 'initialize')) {
            $db->initialize();
            echo "   Database initialized\n";
        }
        
        // Test simple query
        $result = $db->query("SELECT 1 as test");
        if ($result) {
            echo "   ✅ Simple query successful\n";
            $row = $result->getRowArray();
            echo "   Query result: " . $row['test'] . "\n";
        } else {
            echo "   ✗ Simple query failed\n";
        }
        
        // Check if connected
        if (isset($db->connID) && $db->connID) {
            echo "   ✅ Connection ID exists\n";
        } else {
            echo "   ✗ No connection ID\n";
        }
        
    } catch (Exception $e) {
        echo "   ✗ CodeIgniter DB Exception: " . $e->getMessage() . "\n";
        echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
    
    echo "\n3. Testing Direct MySQLi with same config...\n";
    
    $mysqli = new mysqli(
        $dbConfig->default['hostname'],
        $dbConfig->default['username'],
        $dbConfig->default['password'],
        $dbConfig->default['database'],
        $dbConfig->default['port']
    );
    
    if ($mysqli->connect_error) {
        echo "   ✗ Direct MySQLi failed: " . $mysqli->connect_error . "\n";
    } else {
        echo "   ✅ Direct MySQLi successful\n";
        $result = $mysqli->query("SELECT 1 as test");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "   MySQLi query result: " . $row['test'] . "\n";
        }
        $mysqli->close();
    }
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>
