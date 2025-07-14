<?php
echo "=== TESTING WRITEPATH CONSTANT ===\n";

// Set up environment
chdir(__DIR__ . '/public');

if (!defined('FCPATH')) {
    define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
}

// Load paths config
require_once FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();

echo "Paths configuration:\n";
echo "- systemDirectory: " . $paths->systemDirectory . "\n";
echo "- appDirectory: " . $paths->appDirectory . "\n";
echo "- writableDirectory: " . $paths->writableDirectory . "\n";
echo "- testsDirectory: " . $paths->testsDirectory . "\n";

// Load bootstrap
require_once $paths->systemDirectory . '/bootstrap.php';

echo "\nConstants after bootstrap:\n";
echo "- SYSTEMPATH: " . (defined('SYSTEMPATH') ? SYSTEMPATH : 'NOT DEFINED') . "\n";
echo "- APPPATH: " . (defined('APPPATH') ? APPPATH : 'NOT DEFINED') . "\n";
echo "- WRITEPATH: " . (defined('WRITEPATH') ? WRITEPATH : 'NOT DEFINED') . "\n";
echo "- ROOTPATH: " . (defined('ROOTPATH') ? ROOTPATH : 'NOT DEFINED') . "\n";

// Test if directories exist
echo "\nDirectory existence check:\n";
if (defined('WRITEPATH')) {
    echo "- WRITEPATH exists: " . (is_dir(WRITEPATH) ? 'YES' : 'NO') . "\n";
    echo "- WRITEPATH writable: " . (is_writable(WRITEPATH) ? 'YES' : 'NO') . "\n";
    
    $sessionPath = WRITEPATH . 'session';
    echo "- Session path: " . $sessionPath . "\n";
    echo "- Session dir exists: " . (is_dir($sessionPath) ? 'YES' : 'NO') . "\n";
    echo "- Session dir writable: " . (is_writable($sessionPath) ? 'YES' : 'NO') . "\n";
} else {
    echo "- WRITEPATH not defined!\n";
}

// Check actual resolved paths
echo "\nResolved paths:\n";
if (defined('WRITEPATH')) {
    echo "- Absolute WRITEPATH: " . realpath(WRITEPATH) . "\n";
}
echo "- Current working directory: " . getcwd() . "\n";
echo "- Script directory: " . __DIR__ . "\n";
?>
