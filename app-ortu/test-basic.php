<?php
// Test sangat basic untuk melihat apa yang terjadi
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== BASIC PHP TEST ===\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Current Time: " . date('Y-m-d H:i:s') . "\n";
echo "Script Path: " . __FILE__ . "\n";
echo "Working Directory: " . getcwd() . "\n";

// Test ekstensi penting
echo "\n=== EXTENSION TEST ===\n";
$extensions = ['intl', 'mbstring', 'json', 'mysqli', 'curl'];
foreach ($extensions as $ext) {
    echo "$ext: " . (extension_loaded($ext) ? "✓" : "✗") . "\n";
}

// Test file penting
echo "\n=== FILE TEST ===\n";
$files = [
    '.env' => file_exists('.env'),
    'vendor/autoload.php' => file_exists('vendor/autoload.php'),
    'app/Config/App.php' => file_exists('app/Config/App.php'),
    'public/index.php' => file_exists('public/index.php')
];

foreach ($files as $file => $exists) {
    echo "$file: " . ($exists ? "✓" : "✗") . "\n";
}

// Test write permission
echo "\n=== WRITE TEST ===\n";
try {
    $test_file = 'writable/test_write.txt';
    file_put_contents($test_file, 'test');
    if (file_exists($test_file)) {
        echo "Writable directory: ✓\n";
        unlink($test_file);
    } else {
        echo "Writable directory: ✗\n";
    }
} catch (Exception $e) {
    echo "Writable directory: ✗ - " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETED ===\n";
?>
