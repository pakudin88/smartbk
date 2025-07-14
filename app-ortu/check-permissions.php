<?php
echo "=== Directory Permissions Check ===\n\n";

$writable_dirs = [
    'writable',
    'writable/cache',
    'writable/logs',
    'writable/session',
    'writable/uploads',
    'writable/debugbar'
];

echo "Checking writable directories:\n";
echo str_repeat("-", 50) . "\n";

foreach ($writable_dirs as $dir) {
    $full_path = __DIR__ . '/' . $dir;
    $exists = is_dir($full_path);
    $writable = $exists ? is_writable($full_path) : false;
    
    $status = $exists ? ($writable ? "✓ WRITABLE" : "✗ NOT WRITABLE") : "✗ NOT FOUND";
    $color = ($exists && $writable) ? "" : " *** NEEDS FIX ***";
    
    printf("%-20s : %-15s%s\n", $dir, $status, $color);
}

echo "\n" . str_repeat("-", 50) . "\n";

// Test writing to cache directory
$test_file = __DIR__ . '/writable/cache/test_write.txt';
try {
    file_put_contents($test_file, 'Test write: ' . date('Y-m-d H:i:s'));
    if (file_exists($test_file)) {
        echo "✓ Successfully wrote test file to cache directory\n";
        unlink($test_file); // Clean up
    } else {
        echo "✗ Failed to write test file to cache directory\n";
    }
} catch (Exception $e) {
    echo "✗ Error writing to cache directory: " . $e->getMessage() . "\n";
}

echo "\nCurrent working directory: " . getcwd() . "\n";
echo "Script directory: " . __DIR__ . "\n";
?>
