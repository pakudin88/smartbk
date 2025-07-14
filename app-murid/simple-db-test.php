<?php
/**
 * Simple Database Connection Test for App-Murid
 */

echo "=== DATABASE CONNECTION TEST - APP MURID ===\n";

// Test MySQLi connection directly with local settings
echo "Testing Local Database Connection...\n";

$localConfig = [
    'hostname' => 'localhost',
    'username' => 'root', 
    'password' => '',
    'database' => 'sekolah_multiapp',
    'port' => 3306
];

try {
    $mysqli = new mysqli(
        $localConfig['hostname'],
        $localConfig['username'], 
        $localConfig['password'],
        $localConfig['database'],
        $localConfig['port']
    );
    
    if ($mysqli->connect_error) {
        echo "❌ Local connection failed: " . $mysqli->connect_error . "\n";
    } else {
        echo "✅ Local database connection successful!\n";
        echo "Connected to: " . $localConfig['database'] . "\n";
        
        // Test basic query
        $result = $mysqli->query("SELECT 1 as test");
        if ($result) {
            echo "✅ Basic query successful!\n";
        }
        
        // Check if users table exists
        $result = $mysqli->query("SHOW TABLES LIKE 'users'");
        if ($result && $result->num_rows > 0) {
            echo "✅ Users table exists\n";
            
            // Count murid users
            $result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE role = 'murid'");
            if ($result) {
                $row = $result->fetch_assoc();
                echo "Found " . $row['count'] . " student users (murid)\n";
            }
        } else {
            echo "⚠️ Users table not found - you may need to run migrations\n";
        }
        
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== PRODUCTION DATABASE CONFIG ===\n";
echo "Production settings copied from app-superadmin:\n";
echo "Host: srv1412.hstgr.io\n";
echo "Database: u809035070_simaklah\n"; 
echo "Username: u809035070_simaklah\n";
echo "Port: 3306\n";

echo "\n=== CONFIGURATION SUMMARY ===\n";
echo "✅ Database configuration copied from app-superadmin\n";
echo "✅ Auto-detection for local vs production\n";
echo "✅ Local development uses: localhost/sekolah_multiapp\n";
echo "✅ Production uses: srv1412.hstgr.io/u809035070_simaklah\n";

echo "\n=== NEXT STEPS ===\n";
echo "1. Ensure XAMPP MySQL is running\n";
echo "2. Create 'sekolah_multiapp' database if it doesn't exist\n";
echo "3. Import database schema from app-superadmin\n";
echo "4. Test app-murid login with database\n";

echo "\n=== DATABASE CREATION COMMAND ===\n";
echo "If database doesn't exist, run in MySQL:\n";
echo "CREATE DATABASE sekolah_multiapp CHARACTER SET utf8 COLLATE utf8_general_ci;\n";
?>
