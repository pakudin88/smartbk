<?php
echo "=== SIMPLE APPLICATION TEST ===\n";

// Simulate browser request
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SCRIPT_NAME'] = '/simaklah-main/app-ortu/public/index.php';
$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';

// Change to public directory
chdir(__DIR__ . '/public');

echo "Testing if application can load without fatal errors...\n";

try {
    // Buffer output to catch any content
    ob_start();
    
    // Include index.php like a real browser request
    include 'index.php';
    
    $output = ob_get_clean();
    
    echo "✅ Application executed without fatal errors!\n";
    echo "Output length: " . strlen($output) . " bytes\n";
    
    // Check for specific error patterns
    if (strpos($output, 'Fatal error') !== false) {
        echo "❌ Fatal error found in output\n";
    } elseif (strpos($output, 'Whoops!') !== false) {
        echo "⚠️  Application error page displayed (but framework is working)\n";
    } elseif (strpos($output, '<html') !== false) {
        echo "✅ HTML output generated successfully\n";
    } else {
        echo "⚠️  Unexpected output format\n";
    }
    
    // Show first 200 characters for debugging
    echo "\nFirst 200 characters of output:\n";
    echo substr($output, 0, 200) . "...\n";
    
} catch (ParseError $e) {
    echo "❌ Parse Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== CONCLUSION ===\n";
echo "If you see HTML output and no fatal errors, the application is working!\n";
echo "Check browser at: http://localhost/simaklah-main/app-ortu/public/\n";
?>
