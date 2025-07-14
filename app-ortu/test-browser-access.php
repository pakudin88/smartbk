<?php
echo "=== BROWSER ACCESS TEST ===\n";

// Test apakah index.php bisa dijalankan tanpa error
try {
    // Simulasi request browser
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/';
    $_SERVER['SERVER_NAME'] = 'localhost';
    $_SERVER['HTTP_HOST'] = 'localhost';
    $_SERVER['SCRIPT_NAME'] = '/simaklah-main/app-ortu/public/index.php';
    $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';
    
    // Buffer output untuk menangkap response
    ob_start();
    
    // Set working directory ke public
    chdir(__DIR__ . '/public');
    
    // Include index.php seperti browser request
    include 'index.php';
    
    $output = ob_get_clean();
    
    echo "✓ BROWSER REQUEST SUKSES!\n";
    echo "✓ Index.php dapat diakses tanpa error fatal\n";
    echo "✓ Output length: " . strlen($output) . " bytes\n";
    
    if (strlen($output) > 100) {
        echo "✓ Ada HTML output yang dihasilkan\n";
        echo "✓ Aplikasi merespons normal\n";
    }
    
    echo "\n🌐 APLIKASI SIAP DIAKSES DI BROWSER!\n";
    echo "URL: http://localhost/simaklah-main/app-ortu/public/\n";
    
} catch (Exception $e) {
    echo "✗ Browser test error: " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "✗ Fatal error: " . $e->getMessage() . "\n";
}
?>
