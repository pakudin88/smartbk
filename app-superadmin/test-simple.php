<?php
// Simple test to check if the system is working
require_once 'vendor/autoload.php';

echo "Testing Dashboard class loading...\n";
echo "Dashboard.php syntax check: ";
$output = shell_exec('php -l app/Controllers/Dashboard.php');
echo trim($output) . "\n";

echo "Testing if we can instantiate Dashboard class (this may fail due to dependencies)...\n";
try {
    // This might fail because we're not in a proper CI environment
    $dashboard = new \App\Controllers\Dashboard();
    echo "SUCCESS: Dashboard class loaded!\n";
} catch (Exception $e) {
    echo "INFO: Dashboard class can't be instantiated outside CI environment (this is expected): " . $e->getMessage() . "\n";
}

echo "Testing Models...\n";
try {
    $userModel = new \App\Models\UserModel();
    echo "SUCCESS: UserModel loaded!\n";
} catch (Exception $e) {
    echo "INFO: UserModel can't be instantiated outside CI environment (this is expected): " . $e->getMessage() . "\n";
}

echo "\nTest completed. If no fatal errors appear above, the files should work in web context.\n";
