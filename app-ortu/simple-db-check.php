<?php
// Simple database check without CodeIgniter
$host = 'srv1412.hstgr.io';
$dbname = 'u809035070_simaklah';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Checking orang_tua table structure...\n";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'orang_tua'");
    if ($stmt->rowCount() == 0) {
        echo "Table 'orang_tua' does not exist.\n";
        
        // List related tables
        echo "Looking for related tables:\n";
        $stmt = $pdo->query("SHOW TABLES");
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $tableName = $row[0];
            if (strpos($tableName, 'orang') !== false || 
                strpos($tableName, 'parent') !== false || 
                strpos($tableName, 'user') !== false) {
                echo "- $tableName\n";
            }
        }
    } else {
        // Show table structure
        echo "Table structure:\n";
        $stmt = $pdo->query("DESCRIBE orang_tua");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- {$row['Field']} ({$row['Type']})\n";
        }
        
        // Show sample data
        echo "\nSample data (first 2 rows):\n";
        $stmt = $pdo->query("SELECT * FROM orang_tua LIMIT 2");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Row:\n";
            foreach ($row as $col => $val) {
                echo "  $col: $val\n";
            }
            echo "\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
