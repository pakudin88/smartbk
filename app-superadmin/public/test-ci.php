<?php
// Test CodeIgniter Controller Access
echo "<h2>Test CodeIgniter Controller Access</h2>";

// Define path
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Change to this directory
chdir(FCPATH);

// Load CodeIgniter paths
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();

// Try to load the framework
try {
    require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
    echo "<p style='color:green'>CodeIgniter framework loaded successfully!</p>";
    
    // Load DotEnv
    require_once SYSTEMPATH . 'Config/DotEnv.php';
    (new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
    
    // Define ENVIRONMENT
    if (! defined('ENVIRONMENT')) {
        define('ENVIRONMENT', $_ENV['CI_ENVIRONMENT'] ?? 'development');
    }
    
    echo "<p>Environment: " . ENVIRONMENT . "</p>";
    
    // Start the application
    $app = CodeIgniter\Config\Services::codeigniter();
    echo "<p style='color:green'>Application service loaded!</p>";
    
    // Test controller directly
    echo "<p>Testing Users controller...</p>";
    $controller = new \App\Controllers\Users();
    echo "<p style='color:green'>Users controller instantiated successfully!</p>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
} catch (Error $e) {
    echo "<p style='color:red'>Fatal Error: " . $e->getMessage() . "</p>";
}

echo "<p><a href='index.php/users'>Try accessing Users via index.php</a></p>";
?>
