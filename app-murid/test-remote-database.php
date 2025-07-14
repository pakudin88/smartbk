<?php
/**
 * Remote Database Connection Test for App-Murid
 */

echo "=== REMOTE DATABASE CONNECTION TEST - APP MURID ===\n";

// Remote database configuration (from app-superadmin)
$remoteConfig = [
    'hostname' => 'srv1412.hstgr.io',
    'username' => 'u809035070_simaklah', 
    'password' => 'Simaklah88#',
    'database' => 'u809035070_simaklah',
    'port' => 3306
];

echo "Testing Remote Database Connection...\n";
echo "Host: " . $remoteConfig['hostname'] . "\n";
echo "Database: " . $remoteConfig['database'] . "\n";
echo "Username: " . $remoteConfig['username'] . "\n";

try {
    $mysqli = new mysqli(
        $remoteConfig['hostname'],
        $remoteConfig['username'], 
        $remoteConfig['password'],
        $remoteConfig['database'],
        $remoteConfig['port']
    );
    
    if ($mysqli->connect_error) {
        echo "❌ Remote connection failed: " . $mysqli->connect_error . "\n";
        echo "Error code: " . $mysqli->connect_errno . "\n";
    } else {
        echo "✅ Remote database connection successful!\n";
        echo "Connected to: " . $remoteConfig['database'] . "\n";
        
        // Test basic query
        $result = $mysqli->query("SELECT 1 as test");
        if ($result) {
            echo "✅ Basic query successful!\n";
        }
        
        // Get database info
        $result = $mysqli->query("SELECT DATABASE() as current_db, VERSION() as version");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "Database: " . $row['current_db'] . "\n";
            echo "MySQL Version: " . $row['version'] . "\n";
        }
        
        // Check if users table exists
        $result = $mysqli->query("SHOW TABLES LIKE 'users'");
        if ($result && $result->num_rows > 0) {
            echo "✅ Users table exists\n";
            
            // Count murid users
            $result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE role = 'murid'");
            if ($result) {
                $row = $result->fetch_assoc();
                echo "Found " . $row['count'] . " student users (murid) in remote database\n";
            }
            
            // Show sample murid users
            $result = $mysqli->query("SELECT username, name, nisn FROM users WHERE role = 'murid' LIMIT 5");
            if ($result && $result->num_rows > 0) {
                echo "\nSample student accounts in remote database:\n";
                while ($row = $result->fetch_assoc()) {
                    echo "- Username: " . $row['username'] . " | Name: " . $row['name'] . " | NISN: " . $row['nisn'] . "\n";
                }
            }
        } else {
            echo "⚠️ Users table not found in remote database\n";
            
            // Check what tables exist
            $result = $mysqli->query("SHOW TABLES");
            if ($result) {
                echo "Available tables:\n";
                while ($row = $result->fetch_array()) {
                    echo "- " . $row[0] . "\n";
                }
            }
        }
        
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== CONFIGURATION SUMMARY ===\n";
echo "✅ Database configuration set to REMOTE\n";
echo "✅ Host: srv1412.hstgr.io\n";
echo "✅ Database: u809035070_simaklah\n";
echo "✅ Same database as app-superadmin\n";

echo "\n=== NEXT STEPS ===\n";
echo "1. Ensure internet connection is stable\n";
echo "2. Check if student accounts exist in remote database\n";
echo "3. Test app-murid login with remote database\n";
echo "4. Update Auth controller if needed for remote data structure\n";

echo "\n=== TESTING LOGIN ===\n";
echo "Start server: php spark serve --port=8080\n";
echo "Visit: http://localhost:8080/login\n";
echo "Use existing student credentials from remote database\n";
?>
