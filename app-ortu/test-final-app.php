<?php
echo "=== FINAL APP-ORTU TEST ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Test direct index.php execution
echo "1. TESTING DIRECT INDEX.PHP EXECUTION:\n";

// Capture output
ob_start();
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '8080';
$_SERVER['HTTP_HOST'] = 'localhost:8080';
$_SERVER['HTTPS'] = '';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PATH_INFO'] = '';
$_SERVER['QUERY_STRING'] = '';

// Force web context
putenv('CI_ENVIRONMENT=development');

try {
    // Change to public directory like a real web request
    chdir(__DIR__ . '/public');
    include 'index.php';
} catch (Throwable $e) {
    echo "Error during index.php execution: " . $e->getMessage() . "\n";
}

$output = ob_get_clean();
echo "Output captured: " . strlen($output) . " characters\n";
echo "Content:\n" . $output . "\n";

echo "\n=== TEST COMPLETED ===\n";
