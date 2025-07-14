<?php
/**
 * Simple Server Test - Test if basic CodeIgniter can start
 */

echo "=== TESTING CODEIGNITER BOOTSTRAP ===\n";

// Check critical paths
$paths = [
    'spark' => 'CodeIgniter CLI',
    'public/index.php' => 'Web entry point',
    'app/Config/Paths.php' => 'Paths config'
];

foreach ($paths as $path => $desc) {
    if (file_exists($path)) {
        echo "✅ $desc ($path)\n";
    } else {
        echo "❌ $desc missing ($path)\n";
    }
}

// Test basic PHP server
echo "\n=== TESTING PHP BUILT-IN SERVER ===\n";
echo "You can manually test with:\n";
echo "php -S localhost:8080 -t public\n";
echo "Or use CodeIgniter:\n";
echo "php spark serve --port=8080\n";

// Check if we can at least parse the index
echo "\n=== TESTING INDEX.PHP SYNTAX ===\n";
if (file_exists('public/index.php')) {
    $output = [];
    $return_var = 0;
    exec('php -l public/index.php', $output, $return_var);
    if ($return_var === 0) {
        echo "✅ public/index.php syntax OK\n";
    } else {
        echo "❌ public/index.php syntax error:\n";
        echo implode("\n", $output) . "\n";
    }
}

echo "\n=== CHECKING ENVIRONMENT VARIABLES ===\n";
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    if (strpos($envContent, "app.baseURL = 'http://localhost:8080/'") !== false) {
        echo "✅ baseURL correctly set in .env\n";
    } else {
        echo "⚠️ baseURL may not be set correctly in .env\n";
    }
}

echo "\n=== TEST COMPLETE ===\n";
echo "If all checks pass, try running:\n";
echo "php spark serve --port=8080\n";
echo "Then visit: http://localhost:8080\n";
?>
