<?php
// Direct test of the fixed index.php
echo "Testing CodeIgniter Application...\n\n";

// Simulate web request
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '8080';

// Change to public directory and include index.php
chdir(__DIR__ . '/public');

// Capture output
ob_start();
try {
    include 'index.php';
    $output = ob_get_contents();
    echo "✓ Application loaded successfully!\n";
    echo "Output length: " . strlen($output) . " characters\n";
    if (strlen($output) > 0) {
        echo "Preview: " . substr($output, 0, 100) . "...\n";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
} finally {
    ob_end_clean();
}

echo "\nTest completed!\n";
?>
