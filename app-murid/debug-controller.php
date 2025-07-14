<?php
// Debug script to test controller loading
try {
    // Try to create an instance of the SafeSpaceController
    require_once __DIR__ . '/app/Controllers/SafeSpaceController.php';
    
    echo "✅ SafeSpaceController.php file exists and is readable\n";
    
    $controller = new \App\Controllers\SafeSpaceController();
    echo "✅ SafeSpaceController class can be instantiated\n";
    
    if (method_exists($controller, 'konsulCepat')) {
        echo "✅ konsulCepat method exists\n";
        
        // Try to call the method
        ob_start();
        $controller->konsulCepat();
        $output = ob_get_clean();
        echo "✅ konsulCepat method executed successfully\n";
        echo "Output: " . htmlspecialchars($output) . "\n";
    } else {
        echo "❌ konsulCepat method does NOT exist\n";
        echo "Available methods: " . implode(', ', get_class_methods($controller)) . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
}
?>
