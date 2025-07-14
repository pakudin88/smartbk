<?php
echo "=== PHP Extension Check for CodeIgniter 4 ===\n\n";

$required_extensions = [
    'intl' => 'Internationalization support',
    'mbstring' => 'Multibyte string support',
    'json' => 'JSON support',
    'mysqlnd' => 'MySQL Native Driver',
    'mysqli' => 'MySQL Improved Extension',
    'curl' => 'Client URL Library',
    'fileinfo' => 'File Information',
    'gd' => 'Graphics Draw',
    'xml' => 'XML support'
];

echo "Checking required PHP extensions:\n";
echo str_repeat("-", 50) . "\n";

$missing_extensions = [];

foreach ($required_extensions as $ext => $description) {
    $status = extension_loaded($ext) ? "✓ LOADED" : "✗ MISSING";
    $color = extension_loaded($ext) ? "" : " *** CRITICAL ***";
    
    printf("%-15s : %-10s - %s%s\n", $ext, $status, $description, $color);
    
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
    }
}

echo "\n" . str_repeat("-", 50) . "\n";

if (empty($missing_extensions)) {
    echo "✓ All required extensions are loaded!\n";
} else {
    echo "✗ Missing extensions: " . implode(', ', $missing_extensions) . "\n";
    echo "\nTo fix this:\n";
    echo "1. Open php.ini file (location: " . php_ini_loaded_file() . ")\n";
    echo "2. Uncomment these lines by removing ';' at the beginning:\n";
    foreach ($missing_extensions as $ext) {
        echo "   extension=$ext\n";
    }
    echo "3. Restart your web server (Apache/Nginx)\n";
}

echo "\nPHP Version: " . PHP_VERSION . "\n";
echo "PHP INI File: " . php_ini_loaded_file() . "\n";
echo "Current Date: " . date('Y-m-d H:i:s') . "\n";
?>
