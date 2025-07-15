<?php
/**
 * Test Script untuk Direct Loading System
 * Memverifikasi bahwa sistem dapat melakukan proxy dengan benar
 */

echo "=== SMART BOOKKEEPING - DIRECT LOADING TEST ===\n\n";

// Function to read .env file and get configuration
function getAppConfig($appPath) {
    $envFile = $appPath . '/.env';
    
    if (!file_exists($envFile)) {
        return null;
    }
    
    $config = [];
    $envContent = file_get_contents($envFile);
    $lines = explode("\n", $envContent);
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        // Skip comments and empty lines
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }
        
        // Parse key=value pairs
        if (strpos($line, '=') !== false) {
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                // Remove quotes and trim whitespace
                $value = trim($value, "'\" \t\n\r\0\x0B");
                $config[$key] = $value;
            }
        }
    }
    
    return $config;
}

// Function to test if server is running
function testServerConnection($url) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_NOBODY => true,
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    return [
        'success' => $result !== false && $httpCode > 0,
        'http_code' => $httpCode,
        'error' => $error
    ];
}

// Test each application configuration
$apps = [
    'app-guru' => ['name' => 'Portal Guru', 'path' => 'guru'],
    'app-ortu' => ['name' => 'Portal Orang Tua', 'path' => 'ortu'],
    'app-superadmin' => ['name' => 'Portal Super Admin', 'path' => 'admin']
];

foreach ($apps as $appFolder => $appInfo) {
    echo "Testing: {$appInfo['name']}\n";
    echo "Folder: $appFolder\n";
    echo "URL Path: /smartbk/{$appInfo['path']}\n";
    
    $appPath = __DIR__ . '/' . $appFolder;
    $config = getAppConfig($appPath);
    
    if ($config && isset($config['app.baseURL'])) {
        $baseUrl = $config['app.baseURL'];
        echo "✅ Configuration: FOUND\n";
        echo "   BaseURL: $baseUrl\n";
        
        // Test server connection
        $connectionTest = testServerConnection($baseUrl);
        
        if ($connectionTest['success']) {
            echo "✅ Server Status: RUNNING (HTTP {$connectionTest['http_code']})\n";
        } else {
            echo "❌ Server Status: NOT RUNNING\n";
            if ($connectionTest['error']) {
                echo "   Error: {$connectionTest['error']}\n";
            }
        }
        
    } else {
        echo "❌ Configuration: NOT FOUND\n";
        
        $envFile = $appPath . '/.env';
        if (!file_exists($envFile)) {
            echo "   Reason: .env file missing\n";
        } else {
            echo "   Reason: app.baseURL not configured\n";
        }
    }
    
    echo "-----------------------------------\n";
}

echo "\n=== DIRECT LOADING URL MAPPING ===\n\n";

// Test URL mappings
$urlMappings = [
    '/smartbk/guru' => 'app-guru',
    '/smartbk/teacher' => 'app-guru',
    '/smartbk/ortu' => 'app-ortu',
    '/smartbk/parent' => 'app-ortu',
    '/smartbk/admin' => 'app-superadmin',
    '/smartbk/superadmin' => 'app-superadmin'
];

foreach ($urlMappings as $publicUrl => $appFolder) {
    echo "Public URL: $publicUrl\n";
    echo "Maps to: $appFolder\n";
    
    $appPath = __DIR__ . '/' . $appFolder;
    $config = getAppConfig($appPath);
    
    if ($config && isset($config['app.baseURL'])) {
        $baseUrl = $config['app.baseURL'];
        echo "Proxy to: $baseUrl ✅\n";
        
        $connectionTest = testServerConnection($baseUrl);
        if ($connectionTest['success']) {
            echo "Status: READY FOR PROXY ✅\n";
        } else {
            echo "Status: SERVER NOT RUNNING ❌\n";
        }
    } else {
        echo "Proxy to: NOT CONFIGURED ❌\n";
    }
    
    echo "-----------------------------------\n";
}

echo "\n=== SYSTEM FILES CHECK ===\n\n";

// Check if required files exist
$requiredFiles = [
    'app-loader.php' => 'Dynamic proxy handler',
    '.htaccess' => 'URL routing configuration',
    'index.html' => 'Portal selection page',
    'error-config.html' => 'Configuration error page',
    'error-server.html' => 'Server error page'
];

foreach ($requiredFiles as $file => $description) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "✅ $file: EXISTS ($description)\n";
    } else {
        echo "❌ $file: NOT FOUND ($description)\n";
    }
}

echo "\n=== DIRECT LOADING BENEFITS ===\n\n";
echo "✅ URL Structure:\n";
echo "   User sees: /smartbk/guru (clean URL)\n";
echo "   System proxies to: localhost:8081 (hidden from user)\n\n";

echo "✅ No Browser Redirect:\n";
echo "   URL stays the same in browser address bar\n";
echo "   Content loaded directly via server-side proxy\n\n";

echo "✅ Professional Appearance:\n";
echo "   No port numbers visible to users\n";
echo "   Consistent domain structure\n\n";

echo "=== USAGE INSTRUCTIONS ===\n\n";
echo "1. Start Apache in XAMPP Control Panel\n";
echo "2. Start application servers:\n";

foreach ($apps as $appFolder => $appInfo) {
    $appPath = __DIR__ . '/' . $appFolder;
    $config = getAppConfig($appPath);
    if ($config && isset($config['app.baseURL'])) {
        $baseUrl = $config['app.baseURL'];
        $port = parse_url($baseUrl, PHP_URL_PORT);
        echo "   cd $appFolder && php spark serve --port=$port\n";
    }
}

echo "3. Access main portal: http://localhost/smartbk\n";
echo "4. Test direct loading URLs:\n";
foreach (array_keys($urlMappings) as $url) {
    echo "   http://localhost$url\n";
}

echo "\n=== TESTING COMPLETED ===\n";
echo "🎯 Direct Loading System: URL biasa tanpa redirect!\n";
?>
