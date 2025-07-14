<?php
/**
 * Analyze Remote Database Structure for Student Authentication
 */

echo "=== ANALYZING REMOTE DATABASE STRUCTURE ===\n";

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
    
    // Check all tables
    echo "=== AVAILABLE TABLES ===\n";
    $result = $mysqli->query("SHOW TABLES");
    $tables = [];
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
        echo "- " . $row[0] . "\n";
    }
    
    // Check if there's a roles table
    if (in_array('roles', $tables)) {
        echo "\n=== ROLES TABLE ===\n";
        $result = $mysqli->query("SELECT * FROM roles");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row['id'] . " | Name: " . $row['name'] . "\n";
            }
        }
    }
    
    // Check users with different role_ids
    echo "\n=== USERS BY ROLE_ID ===\n";
    $result = $mysqli->query("SELECT role_id, COUNT(*) as count FROM users GROUP BY role_id");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo "Role ID: " . $row['role_id'] . " | Count: " . $row['count'] . "\n";
        }
    }
    
    // Show sample users
    echo "\n=== SAMPLE USERS ===\n";
    $result = $mysqli->query("
        SELECT id, role_id, username, full_name, email, is_active 
        FROM users 
        LIMIT 10
    ");
    
    if ($result) {
        printf("%-5s %-8s %-15s %-25s %-25s %-8s\n", "ID", "Role ID", "Username", "Full Name", "Email", "Active");
        echo str_repeat("-", 90) . "\n";
        while ($row = $result->fetch_assoc()) {
            printf("%-5s %-8s %-15s %-25s %-25s %-8s\n", 
                $row['id'], 
                $row['role_id'], 
                $row['username'], 
                substr($row['full_name'], 0, 24), 
                substr($row['email'], 0, 24), 
                $row['is_active'] ? 'Yes' : 'No'
            );
        }
    }
    
    // Check if there are any users that might be students
    echo "\n=== ANALYZING POTENTIAL STUDENT ACCOUNTS ===\n";
    
    // Try to find the student role ID
    if (in_array('roles', $tables)) {
        $result = $mysqli->query("SELECT id FROM roles WHERE name LIKE '%murid%' OR name LIKE '%student%' OR name LIKE '%siswa%'");
        if ($result && $result->num_rows > 0) {
            $studentRoleId = $result->fetch_assoc()['id'];
            echo "Found student role ID: " . $studentRoleId . "\n";
            
            // Count students with this role
            $result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE role_id = $studentRoleId AND is_active = 1");
            if ($result) {
                $count = $result->fetch_assoc()['count'];
                echo "Active students with this role: " . $count . "\n";
                
                if ($count > 0) {
                    // Show sample student accounts
                    $result = $mysqli->query("
                        SELECT username, full_name, email 
                        FROM users 
                        WHERE role_id = $studentRoleId AND is_active = 1 
                        LIMIT 5
                    ");
                    
                    echo "\nSample student accounts:\n";
                    while ($row = $result->fetch_assoc()) {
                        echo "- Username: " . $row['username'] . " | Name: " . $row['full_name'] . "\n";
                    }
                }
            }
        } else {
            echo "❌ No student role found in roles table\n";
            echo "Available roles:\n";
            $result = $mysqli->query("SELECT id, name FROM roles");
            while ($row = $result->fetch_assoc()) {
                echo "- ID: " . $row['id'] . " | Name: " . $row['name'] . "\n";
            }
        }
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== NEXT STEPS ===\n";
echo "1. Update Auth controller to use correct field names\n";
echo "2. Use role_id instead of role field\n";
echo "3. Use full_name instead of name field\n";
echo "4. Create sample student accounts if needed\n";
?>
