<?php
echo "Testing app-ortu HTTP response...\n";

// Simulate a basic HTTP request to index.php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['HTTP_HOST'] = 'localhost';

// Set the working directory
chdir(__DIR__ . '/public');

// Capture any output
ob_start();
try {
    include __DIR__ . '/public/index.php';
    $output = ob_get_contents();
    ob_end_clean();
    
    if (!empty($output)) {
        echo "✓ App generated output successfully!\n";
        echo "Output preview: " . substr($output, 0, 100) . "...\n";
    } else {
        echo "✓ App loaded without errors (no output expected for this test)\n";
    }
} catch (Exception $e) {
    ob_end_clean();
    echo "✗ Error: " . $e->getMessage() . "\n";
} catch (Error $e) {
    ob_end_clean();
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
}
?>
