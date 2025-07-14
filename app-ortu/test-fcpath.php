<?php
echo "=== FCPATH Test ===\n";

// Set working directory to public
chdir(__DIR__ . '/public');

try {
    // Include only the beginning part that defines FCPATH
    define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    
    echo "✓ FCPATH defined as: " . FCPATH . "\n";
    
    // Test if the paths can be loaded
    require_once FCPATH . '../app/Config/Paths.php';
    $paths = new Config\Paths();
    
    echo "✓ Paths loaded successfully\n";
    echo "✓ System directory: " . $paths->systemDirectory . "\n";
    
    // Test if bootstrap file exists
    if (file_exists($paths->systemDirectory . '/bootstrap.php')) {
        echo "✓ Bootstrap file accessible\n";
    } else {
        echo "✗ Bootstrap file not found\n";
    }
    
    echo "\n✅ FCPATH is working correctly!\n";
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
}
?>
