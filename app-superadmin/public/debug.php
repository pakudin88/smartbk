<?php
// Debug file untuk melihat error yang terjadi
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Super Admin App</h1>";
echo "<hr>";

// Test 1: Cek akses ke file
echo "<h2>1. File Structure Check</h2>";
echo "Current directory: " . getcwd() . "<br>";
echo "FCPATH: " . __DIR__ . "<br>";
echo "Config path: " . __DIR__ . '/../app/Config/Paths.php' . "<br>";
echo "Config exists: " . (file_exists(__DIR__ . '/../app/Config/Paths.php') ? 'YES' : 'NO') . "<br>";

// Test 2: Cek bootstrap
echo "<h2>2. Bootstrap Test</h2>";
try {
    require __DIR__ . '/../app/Config/Paths.php';
    echo "Paths.php loaded successfully<br>";
    
    $paths = new Config\Paths();
    echo "Paths object created<br>";
    echo "System directory: " . $paths->systemDirectory . "<br>";
    echo "System directory exists: " . (is_dir($paths->systemDirectory) ? 'YES' : 'NO') . "<br>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

// Test 3: Cek database connection
echo "<h2>3. Database Connection Test</h2>";
try {
    $connection = new mysqli('localhost', 'root', '', 'sekolah_multiapp');
    if ($connection->connect_error) {
        echo "Database connection failed: " . $connection->connect_error . "<br>";
    } else {
        echo "Database connected successfully<br>";
        $connection->close();
    }
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "<br>";
}

// Test 4: Cek CodeIgniter bootstrap
echo "<h2>4. CodeIgniter Bootstrap Test</h2>";
try {
    define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
    
    // Load paths config
    require FCPATH . '../app/Config/Paths.php';
    $paths = new Config\Paths();
    
    // Check if bootstrap exists
    $bootstrapPath = rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
    echo "Bootstrap path: " . $bootstrapPath . "<br>";
    echo "Bootstrap exists: " . (file_exists($bootstrapPath) ? 'YES' : 'NO') . "<br>";
    
    if (file_exists($bootstrapPath)) {
        echo "Attempting to load bootstrap...<br>";
        require $bootstrapPath;
        echo "Bootstrap loaded successfully<br>";
    }
    
} catch (Exception $e) {
    echo "Bootstrap error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>Actions</h2>";
echo '<a href="index.php">Try Main App</a> | ';
echo '<a href="setup-db.php">Setup Database</a> | ';
echo '<a href="test-db.php">Test Database</a>';
?>
