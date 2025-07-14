<?php
echo "=== TESTING REMOTE DATABASE CONNECTION ===\n";

$config = [
    'hostname' => 'srv1412.hstgr.io',
    'username' => 'u809035070_simaklah',
    'password' => 'Simaklah88#',
    'database' => 'u809035070_simaklah',
    'port' => 3306
];

echo "Testing connection to: {$config['hostname']}\n";
echo "Database: {$config['database']}\n";
echo "Username: {$config['username']}\n";

try {
    $mysqli = new mysqli(
        $config['hostname'],
        $config['username'],
        $config['password'],
        $config['database'],
        $config['port']
    );
    
    if ($mysqli->connect_error) {
        echo "✗ Connection failed: " . $mysqli->connect_error . "\n";
        echo "Error code: " . $mysqli->connect_errno . "\n";
    } else {
        echo "✅ Connection successful!\n";
        echo "Server info: " . $mysqli->server_info . "\n";
        
        // Test basic query
        $result = $mysqli->query("SELECT DATABASE() as current_db");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "Current database: " . $row['current_db'] . "\n";
        }
        
        // List tables
        echo "\nTables in database:\n";
        $result = $mysqli->query("SHOW TABLES");
        $tableCount = 0;
        while ($row = $result->fetch_array()) {
            echo "  - " . $row[0] . "\n";
            $tableCount++;
            if ($tableCount > 10) {
                echo "  ... and more (showing first 10)\n";
                break;
            }
        }
        
        $mysqli->close();
    }
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
}

echo "\n=== CodeIgniter Database Test ===\n";

// Test if internet connection is available
echo "Testing internet connectivity...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_NOBODY, true);
$result = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode == 200) {
    echo "✅ Internet connection available\n";
} else {
    echo "✗ Internet connection issue (HTTP code: $httpcode)\n";
}
?>
