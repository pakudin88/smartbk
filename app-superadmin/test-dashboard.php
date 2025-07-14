<?php
// Test Dashboard Access
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include CodeIgniter bootstrap
require_once __DIR__ . '/vendor/autoload.php';

// Start CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

// Test session
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['full_name'] = 'Test User';
$_SESSION['username'] = 'testuser';
$_SESSION['role_name'] = 'Super Admin';

// Test Dashboard Controller
try {
    $dashboard = new \App\Controllers\Dashboard();
    echo "Dashboard controller loaded successfully\n";
    
    // Test the index method
    $result = $dashboard->index();
    echo "Dashboard index method executed successfully\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
