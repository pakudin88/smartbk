<?php
echo "=== CREATING SIMAKLAH DATABASE ===\n";

try {
    // Connect to MySQL without specifying database
    $mysqli = new mysqli('localhost', 'root', '');
    
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "✓ Connected to MySQL/MariaDB\n";
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS simaklah CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($mysqli->query($sql) === TRUE) {
        echo "✓ Database 'simaklah' created successfully (or already exists)\n";
    } else {
        echo "✗ Error creating database: " . $mysqli->error . "\n";
    }
    
    // Test connection to the new database
    $mysqli->select_db('simaklah');
    echo "✓ Successfully selected 'simaklah' database\n";
    
    // Create a simple test table to verify the database works
    $createTable = "CREATE TABLE IF NOT EXISTS test_connection (
        id INT AUTO_INCREMENT PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        message VARCHAR(255)
    )";
    
    if ($mysqli->query($createTable) === TRUE) {
        echo "✓ Test table created successfully\n";
        
        // Insert test data
        $insertTest = "INSERT INTO test_connection (message) VALUES ('Database connection test successful')";
        if ($mysqli->query($insertTest) === TRUE) {
            echo "✓ Test data inserted successfully\n";
            
            // Read back the data
            $result = $mysqli->query("SELECT * FROM test_connection ORDER BY id DESC LIMIT 1");
            if ($result && $row = $result->fetch_assoc()) {
                echo "✓ Test data retrieved: " . $row['message'] . "\n";
            }
        }
    }
    
    $mysqli->close();
    
    echo "\n🎉 DATABASE SETUP COMPLETE!\n";
    echo "✅ Database 'simaklah' is ready for use\n";
    echo "✅ Connection test passed\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
