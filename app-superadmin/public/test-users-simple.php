<?php
// Simple test file
echo "<h1>Testing Users Page</h1>";

// Test database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=sekolah_multiapp', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green'>✓ Database connection OK</p>";
    
    // Test query
    $stmt = $pdo->query('SELECT u.*, r.role_name FROM users u LEFT JOIN roles r ON r.id = u.role_id');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<p style='color: green'>✓ Found " . count($users) . " users</p>";
    
    echo "<h2>Users List:</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";
    foreach($users as $user) {
        echo "<tr>";
        echo "<td>" . $user['id'] . "</td>";
        echo "<td>" . $user['full_name'] . "</td>";
        echo "<td>" . $user['email'] . "</td>";
        echo "<td>" . $user['role_name'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch (Exception $e) {
    echo "<p style='color: red'>✗ Database error: " . $e->getMessage() . "</p>";
}
?>
