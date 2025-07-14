<?php
// Check roles table structure
try {
    $db = new PDO('mysql:host=localhost;dbname=sekolah_multiapp', 'root', '');
    
    echo "=== ROLES TABLE STRUCTURE ===\n";
    $result = $db->query('DESCRIBE roles');
    foreach($result as $row) {
        echo $row['Field'] . ' - ' . $row['Type'] . "\n";
    }
    
    echo "\n=== ROLES TABLE DATA ===\n";
    $result = $db->query('SELECT * FROM roles');
    foreach($result as $row) {
        print_r($row);
    }
    
    echo "\n=== USERS TABLE STRUCTURE ===\n";
    $result = $db->query('DESCRIBE users');
    foreach($result as $row) {
        echo $row['Field'] . ' - ' . $row['Type'] . "\n";
    }
    
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
