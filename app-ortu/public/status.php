<?php
// Simple standalone test server
echo "Content-Type: text/html\n\n";

echo "<!DOCTYPE html>
<html>
<head>
    <title>App-Ortu Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
    </style>
</head>
<body>
    <h1>App-Ortu Status Test</h1>";

// Test basic functionality
echo "<h2>Basic Tests:</h2>";
echo "<p class='success'>✓ PHP is working (Version: " . PHP_VERSION . ")</p>";
echo "<p class='success'>✓ Server is responding</p>";
echo "<p class='info'>Current time: " . date('Y-m-d H:i:s') . "</p>";

// Test file paths
$paths = [
    'App directory' => __DIR__ . '/app',
    'Public directory' => __DIR__ . '/public',
    'Vendor directory' => __DIR__ . '/vendor',
    '.env file' => __DIR__ . '/.env'
];

echo "<h2>File Structure:</h2>";
foreach ($paths as $name => $path) {
    $exists = file_exists($path);
    $class = $exists ? 'success' : 'error';
    $symbol = $exists ? '✓' : '✗';
    echo "<p class='$class'>$symbol $name: " . ($exists ? 'EXISTS' : 'MISSING') . "</p>";
}

// Test CodeIgniter loading
echo "<h2>CodeIgniter Test:</h2>";
try {
    require_once __DIR__ . '/vendor/autoload.php';
    echo "<p class='success'>✓ Composer autoload working</p>";
    
    require_once __DIR__ . '/app/Config/Paths.php';
    echo "<p class='success'>✓ Paths config loaded</p>";
    
    echo "<p class='info'>✓ Ready for CodeIgniter initialization</p>";
    
} catch (Exception $e) {
    echo "<p class='error'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Next Steps:</h2>";
echo "<p>1. Start development server: <code>php spark serve --port=8080</code></p>";
echo "<p>2. Visit: <a href='http://localhost:8080/status'>http://localhost:8080/status</a></p>";
echo "<p>3. Visit: <a href='http://localhost:8080/test'>http://localhost:8080/test</a></p>";

echo "</body></html>";
?>
