<?php
require_once 'app/Config/Autoload.php';
require_once 'app/Config/Database.php';

$autoload = new \Config\Autoload();
$autoload->initialize();

$db = \Config\Database::connect();

echo "Checking orang_tua table structure...\n";

try {
    $result = $db->query('DESCRIBE orang_tua');
    $fields = $result->getResult();
    echo "orang_tua table columns:\n";
    foreach ($fields as $field) {
        echo "- {$field->Field} ({$field->Type})\n";
    }
    
    // Also check some sample data
    echo "\nSample data from orang_tua:\n";
    $sample = $db->query('SELECT * FROM orang_tua LIMIT 3')->getResult();
    foreach ($sample as $row) {
        echo "ID: {$row->id}\n";
        foreach ((array)$row as $col => $val) {
            if ($col !== 'id') {
                echo "  {$col}: {$val}\n";
            }
        }
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    
    // Check if table exists
    $tables = $db->query('SHOW TABLES LIKE "orang_tua"')->getResult();
    if (empty($tables)) {
        echo "Table orang_tua does not exist.\n";
        
        // List all tables to find parent-related tables
        $allTables = $db->query('SHOW TABLES')->getResult();
        echo "Looking for parent-related tables:\n";
        foreach ($allTables as $table) {
            $tableName = array_values((array)$table)[0];
            if (strpos($tableName, 'orang') !== false || 
                strpos($tableName, 'parent') !== false || 
                strpos($tableName, 'user') !== false) {
                echo "- {$tableName}\n";
            }
        }
    }
}
