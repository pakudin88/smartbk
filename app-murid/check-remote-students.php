<?php
/**
 * Check Student Accounts in Remote Database
 */

echo "=== CHECKING STUDENT ACCOUNTS IN REMOTE DATABASE ===\n";

$remoteConfig = [
    'hostname' => 'srv1412.hstgr.io',
    'username' => 'u809035070_simaklah', 
    'password' => 'Simaklah88#',
    'database' => 'u809035070_simaklah',
    'port' => 3306
];

try {
    $mysqli = new mysqli(
        $remoteConfig['hostname'],
        $remoteConfig['username'], 
        $remoteConfig['password'],
        $remoteConfig['database'],
        $remoteConfig['port']
    );
    
    if ($mysqli->connect_error) {
        die("❌ Connection failed: " . $mysqli->connect_error . "\n");
    }
    
    echo "✅ Connected to remote database\n\n";
    
    // Check users table structure
    echo "=== USERS TABLE STRUCTURE ===\n";
    $result = $mysqli->query("DESCRIBE users");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo $row['Field'] . " | " . $row['Type'] . " | " . ($row['Null'] == 'YES' ? 'NULL' : 'NOT NULL') . "\n";
        }
    }
    
    echo "\n=== STUDENT ACCOUNTS (role = 'murid') ===\n";
    
    // Count total students
    $result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE role = 'murid'");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "Total students found: " . $row['count'] . "\n\n";
    }
    
    // Show active students
    $result = $mysqli->query("
        SELECT id, username, name, email, nisn, status, created_at 
        FROM users 
        WHERE role = 'murid' 
        ORDER BY created_at DESC 
        LIMIT 10
    ");
    
    if ($result && $result->num_rows > 0) {
        echo "Recent student accounts:\n";
        echo str_repeat("-", 100) . "\n";
        printf("%-5s %-15s %-25s %-25s %-15s %-10s\n", "ID", "Username", "Name", "Email", "NISN", "Status");
        echo str_repeat("-", 100) . "\n";
        
        while ($row = $result->fetch_assoc()) {
            printf("%-5s %-15s %-25s %-25s %-15s %-10s\n", 
                $row['id'], 
                $row['username'], 
                substr($row['name'], 0, 24), 
                substr($row['email'], 0, 24), 
                $row['nisn'], 
                $row['status']
            );
        }
    } else {
        echo "❌ No student accounts found with role = 'murid'\n";
        
        // Check what roles exist
        echo "\nChecking available roles:\n";
        $result = $mysqli->query("SELECT DISTINCT role, COUNT(*) as count FROM users GROUP BY role");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo "Role: " . $row['role'] . " | Count: " . $row['count'] . "\n";
            }
        }
    }
    
    // Check password column for testing
    echo "\n=== PASSWORD TESTING ===\n";
    $result = $mysqli->query("
        SELECT username, password 
        FROM users 
        WHERE role = 'murid' 
        LIMIT 3
    ");
    
    if ($result && $result->num_rows > 0) {
        echo "Sample password hashes (for testing):\n";
        while ($row = $result->fetch_assoc()) {
            echo "Username: " . $row['username'] . "\n";
            echo "Password hash: " . substr($row['password'], 0, 50) . "...\n";
            echo "Hash type: " . (strpos($row['password'], '$2y$') === 0 ? 'bcrypt' : 'other') . "\n\n";
        }
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== TESTING INSTRUCTIONS ===\n";
echo "1. Find student accounts from the list above\n";
echo "2. Use app-superadmin to create test student accounts if needed\n";
echo "3. Test login at: http://localhost:8080/login\n";
echo "4. If no students exist, ask admin to create test accounts\n";
?>
