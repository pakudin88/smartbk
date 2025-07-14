<?php
echo "Testing app-ortu configuration...\n";

try {
    // Set working directory first
    chdir(dirname(__FILE__) . '/public');
    
    // Test the Paths configuration
    require_once __DIR__ . '/app/Config/Paths.php';
    $paths = new Config\Paths();
    
    echo "System directory: " . $paths->systemDirectory . "\n";
    
    if (file_exists($paths->systemDirectory . '/bootstrap.php')) {
        echo "✓ Bootstrap file found!\n";
        echo "✓ app-ortu configuration is working!\n";
    } else {
        echo "✗ Bootstrap file not found at: " . $paths->systemDirectory . '/bootstrap.php' . "\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
}
?>
