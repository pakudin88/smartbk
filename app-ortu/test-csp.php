<?php
echo "=== Test ContentSecurityPolicy Service ===\n";

try {
    // Set up basic environment
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    }
    
    chdir(__DIR__ . '/public');
    
    // Load paths and bootstrap
    require_once FCPATH . '../app/Config/Paths.php';
    $paths = new Config\Paths();
    require_once $paths->systemDirectory . '/bootstrap.php';
    
    echo "✓ Bootstrap completed\n";
    
    // Load environment
    require_once SYSTEMPATH . 'Config/DotEnv.php';
    (new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
    if (! defined('ENVIRONMENT')) {
        define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
    }
    
    echo "✓ Environment loaded: " . ENVIRONMENT . "\n";
    
    // Test ContentSecurityPolicy config
    $cspConfig = config('ContentSecurityPolicy');
    echo "✓ ContentSecurityPolicy configuration loaded\n";
    echo "✓ reportOnly: " . ($cspConfig->reportOnly ? 'true' : 'false') . "\n";
    echo "✓ scriptSrc: " . $cspConfig->scriptSrc . "\n";
    echo "✓ styleSrc: " . $cspConfig->styleSrc . "\n";
    
    // Test CSP service creation (this was failing before)
    $csp = \Config\Services::csp();
    echo "✓ CSP service created successfully\n";
    
    // Test Response service creation (this depends on CSP)
    $response = \Config\Services::response();
    echo "✓ Response service created successfully\n";
    
    echo "\n🎉 SUCCESS: ContentSecurityPolicy error sudah teratasi!\n";
    echo "Aplikasi sekarang dapat menangani CSP dengan benar.\n";
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>
