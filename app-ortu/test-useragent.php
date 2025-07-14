<?php
echo "=== Test UserAgent Service ===\n";

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
    
    // Test UserAgents config
    $userAgentsConfig = config('UserAgents');
    echo "✓ UserAgents configuration loaded\n";
    echo "✓ Platforms array exists: " . (isset($userAgentsConfig->platforms) ? 'YES' : 'NO') . "\n";
    echo "✓ Browsers array exists: " . (isset($userAgentsConfig->browsers) ? 'YES' : 'NO') . "\n";
    echo "✓ Mobiles array exists: " . (isset($userAgentsConfig->mobiles) ? 'YES' : 'NO') . "\n";
    echo "✓ Robots array exists: " . (isset($userAgentsConfig->robots) ? 'YES' : 'NO') . "\n";
    
    // Test Request service creation (this includes UserAgent)
    $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';
    $request = \Config\Services::request();
    echo "✓ Request service created successfully\n";
    
    // Test UserAgent directly
    $userAgent = $request->getUserAgent();
    echo "✓ UserAgent service created without platforms error\n";
    
    echo "\n🎉 SUCCESS: UserAgent error sudah teratasi!\n";
    echo "Aplikasi sekarang dapat menangani User Agent dengan benar.\n";
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>
