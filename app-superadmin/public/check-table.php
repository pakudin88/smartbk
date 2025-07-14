<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=sekolah_multiapp', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Struktur Tabel Users</h2>";
    $stmt = $pdo->query('DESCRIBE users');
    
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['Field']}</td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Key']}</td>";
        echo "<td>{$row['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>Data Users (5 baris pertama)</h2>";
    $stmt = $pdo->query('SELECT * FROM users LIMIT 5');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($users as $user) {
        echo "<p>";
        foreach ($user as $key => $value) {
            echo "<strong>$key:</strong> $value | ";
        }
        echo "</p>";
    }
    
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
