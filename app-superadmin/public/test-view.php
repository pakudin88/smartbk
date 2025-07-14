<?php
// Test view sederhana
echo "<h2>Test View Users</h2>";

// Test akses langsung ke view
$viewPath = '../app/Views/users/index.php';
$layoutPath = '../app/Views/layouts/main.php';

if (file_exists($viewPath)) {
    echo "<p style='color:green'>View users/index.php exists</p>";
} else {
    echo "<p style='color:red'>View users/index.php NOT found</p>";
}

if (file_exists($layoutPath)) {
    echo "<p style='color:green'>Layout main.php exists</p>";
} else {
    echo "<p style='color:red'>Layout main.php NOT found</p>";
}

// Test data dummy
$users = [
    ['id' => 1, 'name' => 'Admin', 'email' => 'admin@test.com', 'role_name' => 'Super Admin'],
    ['id' => 2, 'name' => 'User', 'email' => 'user@test.com', 'role_name' => 'User']
];

echo "<h3>Dummy Data:</h3>";
foreach ($users as $user) {
    echo "<p>ID: {$user['id']}, Name: {$user['name']}, Email: {$user['email']}, Role: {$user['role_name']}</p>";
}

// Test CodeIgniter view helper
echo "<h3>Test CodeIgniter View Helper</h3>";
try {
    // Define path constants
    define('APPPATH', realpath('../app/') . '/');
    define('ROOTPATH', realpath('../') . '/');
    define('FCPATH', __DIR__ . '/');
    
    echo "<p>APPPATH: " . APPPATH . "</p>";
    echo "<p>ROOTPATH: " . ROOTPATH . "</p>";
    echo "<p>FCPATH: " . FCPATH . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>
