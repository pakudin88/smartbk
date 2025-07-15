<?php
try {
    // Direct database connection using the same config as the app
    $host = 'srv1412.hstgr.io';
    $username = 'u809035070_simaklah';
    $password = 'Simaklah88#';
    $database = 'u809035070_simaklah';
    $port = 3306;
    
    $dsn = "mysql:host=$host;dbname=$database;port=$port;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
    
    // Connect using PDO
    $db = $pdo;
    echo "✓ Database connection successful\n";
    
    // Check guru_profiles table structure
    $stmt = $db->prepare("DESCRIBE guru_profiles");
    if ($stmt->execute()) {
        echo "\nChecking guru_profiles table structure:\n";
        $fields = $stmt->fetchAll();
        echo "Columns in guru_profiles:\n";
        foreach ($fields as $field) {
            echo "  - " . $field->Field . " (" . $field->Type . ")\n";
        }
    } else {
        echo "❌ guru_profiles table does not exist or cannot be accessed\n";
    }
    
    // Check if there are alternative tables for teacher profiles
    $stmt = $db->prepare("SHOW TABLES LIKE '%guru%'");
    $stmt->execute();
    $tables = $stmt->fetchAll();
    echo "\nLooking for teacher/guru related tables:\n";
    foreach ($tables as $table) {
        $tableName = current((array)$table);
        echo "  - " . $tableName . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
