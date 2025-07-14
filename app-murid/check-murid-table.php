<?php
/**
 * Check Murid Table in Remote Database
 */

echo "=== CHECKING MURID TABLE IN REMOTE DATABASE ===\n";

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
    
    // Check murid table structure
    echo "=== MURID TABLE STRUCTURE ===\n";
    $result = $mysqli->query("DESCRIBE murid");
    if ($result) {
        printf("%-20s %-20s %-10s %-10s\n", "Field", "Type", "Null", "Key");
        echo str_repeat("-", 70) . "\n";
        while ($row = $result->fetch_assoc()) {
            printf("%-20s %-20s %-10s %-10s\n", 
                $row['Field'], 
                $row['Type'], 
                $row['Null'], 
                $row['Key'] ?? ''
            );
        }
    }
    
    // Count records in murid table
    echo "\n=== MURID TABLE DATA ===\n";
    $result = $mysqli->query("SELECT COUNT(*) as count FROM murid");
    if ($result) {
        $count = $result->fetch_assoc()['count'];
        echo "Total records in murid table: " . $count . "\n";
    }
    
    // Show sample murid records
    if ($count > 0) {
        echo "\nSample murid records:\n";
        $result = $mysqli->query("SELECT * FROM murid LIMIT 5");
        if ($result && $result->num_rows > 0) {
            $first = true;
            while ($row = $result->fetch_assoc()) {
                if ($first) {
                    // Print headers
                    echo str_repeat("-", 120) . "\n";
                    foreach (array_keys($row) as $key) {
                        printf("%-15s ", $key);
                    }
                    echo "\n" . str_repeat("-", 120) . "\n";
                    $first = false;
                }
                
                foreach ($row as $value) {
                    printf("%-15s ", substr($value ?? 'NULL', 0, 14));
                }
                echo "\n";
            }
        }
    }
    
    // Check users table with role_id = 4 (seems to be students)
    echo "\n=== USERS TABLE (STUDENTS - ROLE_ID 4) ===\n";
    $result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE role_id = 4");
    if ($result) {
        $count = $result->fetch_assoc()['count'];
        echo "Total students in users table (role_id=4): " . $count . "\n";
    }
    
    if ($count > 0) {
        echo "\nSample student users:\n";
        $result = $mysqli->query("
            SELECT id, username, full_name, email, is_active 
            FROM users 
            WHERE role_id = 4 
            LIMIT 5
        ");
        
        if ($result) {
            printf("%-5s %-15s %-25s %-25s %-8s\n", "ID", "Username", "Full Name", "Email", "Active");
            echo str_repeat("-", 85) . "\n";
            while ($row = $result->fetch_assoc()) {
                printf("%-5s %-15s %-25s %-25s %-8s\n", 
                    $row['id'], 
                    $row['username'], 
                    substr($row['full_name'], 0, 24), 
                    substr($row['email'], 0, 24), 
                    $row['is_active'] ? 'Yes' : 'No'
                );
            }
        }
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== RECOMMENDATION ===\n";
echo "Based on the analysis:\n";
echo "1. Use 'users' table with role_id = 4 for students\n";
echo "2. Use 'full_name' field instead of 'name'\n";
echo "3. Update Auth controller accordingly\n";
echo "4. Test with existing student accounts\n";
?>
