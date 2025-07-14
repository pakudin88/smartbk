<?php
// Simple debug untuk cek controller Users
echo "<h2>Debug Controller Users</h2>";

// Cek apakah file controller ada
$controllerPath = '../app/Controllers/Users.php';
if (file_exists($controllerPath)) {
    echo "<p style='color:green'>Controller Users.php found!</p>";
} else {
    echo "<p style='color:red'>Controller Users.php NOT found!</p>";
}

// Cek apakah model ada
$modelPath = '../app/Models/UserModel.php';
if (file_exists($modelPath)) {
    echo "<p style='color:green'>Model UserModel.php found!</p>";
} else {
    echo "<p style='color:red'>Model UserModel.php NOT found!</p>";
}

// Cek apakah view ada
$viewPath = '../app/Views/users/index.php';
if (file_exists($viewPath)) {
    echo "<p style='color:green'>View users/index.php found!</p>";
} else {
    echo "<p style='color:red'>View users/index.php NOT found!</p>";
}

// Cek apakah layout ada
$layoutPath = '../app/Views/layouts/main.php';
if (file_exists($layoutPath)) {
    echo "<p style='color:green'>Layout main.php found!</p>";
} else {
    echo "<p style='color:red'>Layout main.php NOT found!</p>";
}

// Test direct access ke controller
echo "<p>Testing direct controller access...</p>";
echo "<p><a href='../index.php/users' target='_blank'>Test Users Controller</a></p>";
echo "<p><a href='../index.php/dashboard' target='_blank'>Test Dashboard Controller</a></p>";

// Test database connection
echo "<p>Testing database connection...</p>";
try {
    $pdo = new PDO('mysql:host=localhost;dbname=sekolah_multiapp', 'root', '');
    echo "<p style='color:green'>Database connected successfully!</p>";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Total users in database: " . $result['count'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>Database error: " . $e->getMessage() . "</p>";
}
?>
