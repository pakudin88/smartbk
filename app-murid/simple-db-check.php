<?php

// Simple database check without CodeIgniter framework
$host = 'srv1412.hstgr.io';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';
$database = 'u809035070_simaklah';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database connection successful!\n";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Table 'users' exists!\n";
        
        // Check users table structure
        $stmt = $pdo->query("DESCRIBE users");
        echo "\nUsers table structure:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- {$row['Field']} ({$row['Type']}) - {$row['Key']}\n";
        }
        
        // Check students count
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role_id = 4");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "\nStudents with role_id=4: {$result['count']}\n";
        
        // Sample student data
        $stmt = $pdo->query("SELECT id, username, full_name, role_id, is_active FROM users WHERE role_id = 4 LIMIT 3");
        echo "\nSample student users:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- ID: {$row['id']}, Username: {$row['username']}, Name: {$row['full_name']}, Active: {$row['is_active']}\n";
        }
        
    } else {
        echo "❌ Table 'users' does not exist!\n";
    }
    
    // Check other tables
    $tables = ['app_murid', 'kelas', 'tahun_ajaran', 'roles'];
    echo "\nOther tables:\n";
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "✅ $table exists\n";
        } else {
            echo "❌ $table missing\n";
        }
    }
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}

?>
