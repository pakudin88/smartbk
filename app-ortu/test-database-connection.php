<?php
echo "=== DATABASE CONNECTION TEST ===\n";

// Test various database configurations
$configs = [
    'localhost' => [
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'simaklah'
    ],
    '127.0.0.1' => [
        'hostname' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'database' => 'simaklah'
    ],
    'test_connection' => [
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'test'
    ]
];

foreach ($configs as $name => $config) {
    echo "\nTesting $name...\n";
    
    try {
        $mysqli = new mysqli(
            $config['hostname'],
            $config['username'],
            $config['password'],
            $config['database']
        );
        
        if ($mysqli->connect_error) {
            echo "   ✗ Connection failed: " . $mysqli->connect_error . "\n";
        } else {
            echo "   ✓ Connection successful!\n";
            echo "   Server info: " . $mysqli->server_info . "\n";
            $mysqli->close();
            break; // Stop on first successful connection
        }
        
    } catch (Exception $e) {
        echo "   ✗ Exception: " . $e->getMessage() . "\n";
    }
}

// Test if we can connect without specifying database
echo "\nTesting connection without database...\n";
try {
    $mysqli = new mysqli('localhost', 'root', '');
    if ($mysqli->connect_error) {
        echo "   ✗ Connection failed: " . $mysqli->connect_error . "\n";
    } else {
        echo "   ✓ Basic MySQL connection successful!\n";
        echo "   Server info: " . $mysqli->server_info . "\n";
        
        // List available databases
        $result = $mysqli->query("SHOW DATABASES");
        echo "   Available databases:\n";
        while ($row = $result->fetch_assoc()) {
            echo "      - " . $row['Database'] . "\n";
        }
        
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "   ✗ Exception: " . $e->getMessage() . "\n";
}

echo "\n=== RECOMMENDATION ===\n";
echo "If no connections work:\n";
echo "1. Start XAMPP MySQL service\n";
echo "2. Check if MySQL is running on port 3306\n";
echo "3. Verify MySQL credentials\n";
echo "4. Create 'simaklah' database if it doesn't exist\n";
?>
