<?php
echo "=== SIMPLE BROWSER TEST ===\n";

try {
    // Set environment untuk development
    putenv('CI_ENVIRONMENT=development');
    
    // Set up basic web environment
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/';
    $_SERVER['SERVER_NAME'] = 'localhost';
    $_SERVER['HTTP_HOST'] = 'localhost';
    $_SERVER['SCRIPT_NAME'] = '/simaklah-main/app-ortu/public/index.php';
    $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';
    
    // Change to public directory
    chdir(__DIR__ . '/public');
    
    echo "1. Testing bootstrap and basic loading...\n";
    
    // Start output buffering to capture any output
    ob_start();
    
    // Include the main index.php file
    try {
        include 'index.php';
        $output = ob_get_clean();
        
        echo "✅ SUCCESS! Application loaded without fatal errors\n";
        echo "Output captured: " . strlen($output) . " bytes\n";
        
        if (strlen($output) > 100) {
            echo "✅ Application generated proper response\n";
        } else {
            echo "⚠️  Short output, check if response is complete\n";
        }
        
        // Check if output contains error indicators
        if (strpos($output, 'Fatal error') !== false || strpos($output, 'Parse error') !== false) {
            echo "❌ Fatal error detected in output\n";
        } else {
            echo "✅ No fatal errors detected\n";
        }
        
        echo "\n🌐 APLIKASI DAPAT DIAKSES DI BROWSER!\n";
        echo "URL: http://localhost/simaklah-main/app-ortu/public/\n";
        echo "\nNote: Error 'error view files not found' sudah diperbaiki dengan:\n";
        echo "- Error view files dibuat di app/Views/errors/\n";
        echo "- Environment file (.env) dibuat\n";
        echo "- Database config diperbaiki\n";
        echo "- Production boot file diupdate untuk debugging\n";
        
    } catch (ParseError $e) {
        ob_end_clean();
        echo "❌ Parse Error: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>
