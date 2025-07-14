<?php
echo "Testing app-ortu bootstrap...\n";

try {
    // Test if we can load the bootstrap
    require_once __DIR__ . '/public/index.php';
    echo "✓ Bootstrap loaded successfully!\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
}
?>
