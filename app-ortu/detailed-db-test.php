<?php
echo "=== DETAILED DATABASE CONNECTION TEST ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

$hostname = 'srv1412.hstgr.io';
$database = 'u809035070_simaklah';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';
$port = 3306;

echo "1. TESTING WITH MYSQLI DIRECTLY:\n";
echo "   Host: $hostname\n";
echo "   Database: $database\n";
echo "   Username: $username\n";
echo "   Port: $port\n\n";

// Test 1: Basic MySQLi connection
try {
    echo "   Attempting MySQLi connection...\n";
    $mysqli = new mysqli($hostname, $username, $password, $database, $port);
    
    if ($mysqli->connect_error) {
        echo "   ✗ MySQLi Error: " . $mysqli->connect_error . "\n";
        echo "   ✗ Error Code: " . $mysqli->connect_errno . "\n";
    } else {
        echo "   ✓ MySQLi connection successful!\n";
        echo "   ✓ Server version: " . $mysqli->server_info . "\n";
        
        // Test query
        $result = $mysqli->query("SELECT DATABASE() as current_db, NOW() as current_time");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "   ✓ Current database: " . $row['current_db'] . "\n";
            echo "   ✓ Server time: " . $row['current_time'] . "\n";
        }
        
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "   ✗ MySQLi Exception: " . $e->getMessage() . "\n";
}

echo "\n2. TESTING DNS RESOLUTION:\n";
$ip = gethostbyname($hostname);
if ($ip != $hostname) {
    echo "   ✓ DNS resolved: $hostname -> $ip\n";
} else {
    echo "   ✗ DNS resolution failed for $hostname\n";
}

echo "\n3. TESTING PORT CONNECTIVITY:\n";
$connection = @fsockopen($hostname, $port, $errno, $errstr, 10);
if ($connection) {
    echo "   ✓ Port $port is accessible on $hostname\n";
    fclose($connection);
} else {
    echo "   ✗ Cannot connect to port $port on $hostname\n";
    echo "   ✗ Error: $errstr ($errno)\n";
}

echo "\n4. TESTING WITH PDO:\n";
try {
    $dsn = "mysql:host=$hostname;port=$port;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 10
    ]);
    
    echo "   ✓ PDO connection successful!\n";
    
    $stmt = $pdo->query("SELECT VERSION() as version");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "   ✓ MySQL version: " . $result['version'] . "\n";
    
} catch (PDOException $e) {
    echo "   ✗ PDO Error: " . $e->getMessage() . "\n";
    echo "   ✗ Error Code: " . $e->getCode() . "\n";
}

echo "\n5. NETWORK TROUBLESHOOTING:\n";
echo "   If connection fails, possible causes:\n";
echo "   - Firewall blocking outgoing connections\n";
echo "   - Database server whitelist (IP restrictions)\n";
echo "   - Incorrect credentials\n";
echo "   - Server maintenance\n";

echo "\n=== TEST COMPLETED ===\n";
