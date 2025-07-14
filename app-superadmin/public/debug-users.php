<?php
// Debug script untuk cek halaman users
echo "<h2>Debug Users Page</h2>";

// Cek apakah CodeIgniter bekerja
echo "<p>1. Testing basic PHP...</p>";
phpinfo();

// Cek koneksi database
echo "<p>2. Testing database connection...</p>";
try {
    $pdo = new PDO('mysql:host=localhost;dbname=sekolah_multiapp', 'root', '');
    echo "<p style='color:green'>Database connected successfully!</p>";
    
    // Cek users
    $stmt = $pdo->query("SELECT * FROM users LIMIT 5");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<p>Users found: " . count($users) . "</p>";
    
    foreach ($users as $user) {
        echo "<p>User: " . $user['name'] . " - " . $user['email'] . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>Database error: " . $e->getMessage() . "</p>";
}

// Cek path CodeIgniter
echo "<p>3. Testing CodeIgniter path...</p>";
echo "<p>Current directory: " . __DIR__ . "</p>";
echo "<p>PHP version: " . phpversion() . "</p>";
?>
