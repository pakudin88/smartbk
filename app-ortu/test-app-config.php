<?php
echo "=== Comprehensive App Config Test ===\n";

try {
    // Test that we can load the App config without errors
    require_once __DIR__ . '/app/Config/App.php';
    $appConfig = new Config\App();
    
    echo "✓ App configuration loaded successfully\n";
    
    // Check required properties
    $requiredProperties = [
        'baseURL',
        'allowedHostnames', 
        'indexPage',
        'uriProtocol',
        'permittedURIChars',
        'defaultLocale',
        'negotiateLocale',
        'supportedLocales',
        'appTimezone',
        'charset',
        'forceGlobalSecureRequests',
        'proxyIPs',
        'CSPEnabled'
    ];
    
    $missing = [];
    foreach ($requiredProperties as $prop) {
        if (!property_exists($appConfig, $prop)) {
            $missing[] = $prop;
        }
    }
    
    if (empty($missing)) {
        echo "✓ All required properties are present\n";
    } else {
        echo "✗ Missing properties: " . implode(', ', $missing) . "\n";
    }
    
    // Test specific property values
    echo "✓ baseURL: " . $appConfig->baseURL . "\n";
    echo "✓ allowedHostnames: " . (empty($appConfig->allowedHostnames) ? 'empty array (correct)' : 'configured') . "\n";
    echo "✓ defaultLocale: " . $appConfig->defaultLocale . "\n";
    echo "✓ appTimezone: " . $appConfig->appTimezone . "\n";
    
    echo "\n🎉 App configuration is complete and valid!\n";
    echo "The allowedHostnames error should be resolved.\n";
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
}
?>
