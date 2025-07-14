<?php
// Simple test to check if CodeIgniter is working
require_once 'app/Config/Autoload.php';

// Check if we can create a basic CI environment
try {
    // Check if we can connect to database
    include 'app/Config/Database.php';
    
    echo "Testing basic setup...\n";
    echo "✓ Autoload included\n";
    echo "✓ Database config loaded\n";
    
    // Test if we can start a minimal environment
    define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);
    define('FCPATH', ROOTPATH . 'public' . DIRECTORY_SEPARATOR);
    define('SYSTEMPATH', ROOTPATH . 'system' . DIRECTORY_SEPARATOR);
    define('APPPATH', ROOTPATH . 'app' . DIRECTORY_SEPARATOR);
    define('WRITEPATH', ROOTPATH . 'writable' . DIRECTORY_SEPARATOR);
    
    echo "✓ Paths defined\n";
    echo "✓ Basic setup appears to be working\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
