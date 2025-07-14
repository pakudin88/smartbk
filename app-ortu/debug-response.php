<?php
// Test untuk melihat detail response yang dihasilkan
echo "=== RESPONSE DEBUG TEST ===\n";

// Set environment
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '8080';
$_SERVER['HTTP_HOST'] = 'localhost:8080';

// Change to public directory
$original_dir = getcwd();
chdir(__DIR__ . '/public');

echo "Testing response generation...\n";

// Start output buffering to capture everything
ob_start();

try {
    // Include the index.php to see what happens
    include 'index.php';
    
} catch (Exception $e) {
    echo "Exception caught: " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "Error caught: " . $e->getMessage() . "\n";
}

$captured_output = ob_get_clean();

// Restore directory
chdir($original_dir);

echo "=== CAPTURED OUTPUT ANALYSIS ===\n";
echo "Total output length: " . strlen($captured_output) . " bytes\n";
echo "Output content:\n";
echo "---START---\n";
echo $captured_output;
echo "\n---END---\n";

// Analyze the output
if (strpos($captured_output, 'App-Ortu is working!') !== false) {
    echo "\n✓ Application response found\n";
} else {
    echo "\n✗ Application response NOT found\n";
}

if (strpos($captured_output, 'Application Error:') !== false) {
    echo "✗ Error message found in output\n";
} else {
    echo "✓ No error messages found\n";
}

echo "\nTest completed!\n";
?>
