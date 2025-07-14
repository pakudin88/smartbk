<?php

// Check database connection and users table structure
require_once __DIR__ . '/vendor/autoload.php';

$config = new \Config\Database();
$db = \Config\Database::connect();

echo "<h2>Database Connection Test</h2>\n";

try {
    // Test connection
    $db->connect();
    echo "✅ Database connection successful!<br>\n";
    echo "Database: " . $config->default['database'] . "<br>\n";
    echo "Host: " . $config->default['hostname'] . "<br>\n";
    
    // Check if users table exists
    echo "<h3>Checking Tables</h3>\n";
    $tables = $db->listTables();
    
    if (in_array('users', $tables)) {
        echo "✅ Table 'users' exists!<br>\n";
        
        // Check users table structure
        $fields = $db->getFieldData('users');
        echo "<h4>Users Table Structure:</h4>\n";
        echo "<table border='1' style='border-collapse: collapse;'>\n";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>\n";
        
        foreach ($fields as $field) {
            echo "<tr>";
            echo "<td>" . $field->name . "</td>";
            echo "<td>" . $field->type . "</td>";
            echo "<td>" . ($field->nullable ? 'YES' : 'NO') . "</td>";
            echo "<td>" . ($field->primary_key ? 'PRI' : '') . "</td>";
            echo "<td>" . $field->default . "</td>";
            echo "</tr>\n";
        }
        echo "</table><br>\n";
        
        // Check if there are any users with role_id 4 (students)
        $studentCount = $db->table('users')->where('role_id', 4)->countAllResults();
        echo "Students in users table (role_id=4): " . $studentCount . "<br>\n";
        
        // Show sample user data for role_id 4
        if ($studentCount > 0) {
            $sampleUsers = $db->table('users')
                             ->select('id, username, full_name, email, role_id, is_active, created_at')
                             ->where('role_id', 4)
                             ->limit(5)
                             ->get()
                             ->getResultArray();
            
            echo "<h4>Sample Student Users:</h4>\n";
            echo "<table border='1' style='border-collapse: collapse;'>\n";
            echo "<tr><th>ID</th><th>Username</th><th>Full Name</th><th>Email</th><th>Role ID</th><th>Active</th><th>Created</th></tr>\n";
            
            foreach ($sampleUsers as $user) {
                echo "<tr>";
                echo "<td>" . $user['id'] . "</td>";
                echo "<td>" . $user['username'] . "</td>";
                echo "<td>" . $user['full_name'] . "</td>";
                echo "<td>" . $user['email'] . "</td>";
                echo "<td>" . $user['role_id'] . "</td>";
                echo "<td>" . ($user['is_active'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . $user['created_at'] . "</td>";
                echo "</tr>\n";
            }
            echo "</table><br>\n";
        }
        
    } else {
        echo "❌ Table 'users' does not exist!<br>\n";
        echo "Available tables: " . implode(', ', $tables) . "<br>\n";
    }
    
    // Check app_murid table
    if (in_array('app_murid', $tables)) {
        echo "✅ Table 'app_murid' exists!<br>\n";
        $muridCount = $db->table('app_murid')->countAllResults();
        echo "Records in app_murid table: " . $muridCount . "<br>\n";
    } else {
        echo "❌ Table 'app_murid' does not exist!<br>\n";
    }
    
    // Check other related tables
    $relatedTables = ['kelas', 'tahun_ajaran', 'roles'];
    foreach ($relatedTables as $table) {
        if (in_array($table, $tables)) {
            echo "✅ Table '$table' exists!<br>\n";
        } else {
            echo "❌ Table '$table' does not exist!<br>\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>\n";
}

echo "<h3>All Available Tables:</h3>\n";
echo implode(', ', $tables ?? []) . "<br>\n";

?>
