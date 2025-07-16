<?php
/**
 * Test Script untuk Dynamic Redirect System
 * Memverifikasi bahwa sistem dapat membaca konfigurasi .env dengan benar
 */

echo "=== SMART BOOKKEEPING - DYNAMIC REDIRECT TEST ===\n\n";

// Function to read .env file and get baseURL
function getBaseUrlFromEnv($appPath) {
    $envFile = $appPath . '/.env';
    
    if (!file_exists($envFile)) {
        return null;
    }
    
    $envContent = file_get_contents($envFile);
    $lines = explode("\n", $envContent);
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        // Skip comments and empty lines
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }
        
        // Look for app.baseURL
        if (strpos($line, 'app.baseURL') === 0) {
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $baseUrl = trim($parts[1]);
                // Remove quotes
                $baseUrl = trim($baseUrl, "'\"");
                return $baseUrl;
            }
        }
    }
    
    return null;
}

// Test each application
$apps = [
    'app-guru' => 'Portal Guru',
    'app-ortu' => 'Portal Orang Tua',
    'app-superadmin' => 'Portal Super Admin'
];

foreach ($apps as $appFolder => $appName) {
    echo "Testing: $appName\n";
    echo "Folder: $appFolder\n";
    
    $appPath = __DIR__ . '/' . $appFolder;
    $baseUrl = getBaseUrlFromEnv($appPath);
    
    if ($baseUrl) {
        echo "✅ SUCCESS: BaseURL found = $baseUrl\n";
        
        // Extract port from URL
        $port = parse_url($baseUrl, PHP_URL_PORT);
        if ($port) {
            echo "   Port: $port\n";
        }
        
        // Test if .env file exists
        $envFile = $appPath . '/.env';
        if (file_exists($envFile)) {
            echo "   .env file: EXISTS ✅\n";
        } else {
            echo "   .env file: NOT FOUND ❌\n";
        }
        
    } else {
        echo "❌ ERROR: Cannot read baseURL from .env\n";
        
        $envFile = $appPath . '/.env';
        if (!file_exists($envFile)) {
            echo "   Reason: .env file not found\n";
        } else {
            echo "   Reason: baseURL not found in .env\n";
        }
    }
    
    echo "-----------------------------------\n";
}

echo "\n=== REDIRECT URL TESTING ===\n\n";

// Test URL mappings
$redirectMappings = [
    'guru' => 'app-guru',
    'teacher' => 'app-guru',
    'ortu' => 'app-ortu',
    'parent' => 'app-ortu',
    'admin' => 'app-superadmin',
    'superadmin' => 'app-superadmin'
];

foreach ($redirectMappings as $urlPath => $appFolder) {
    echo "URL Path: /smartbk/$urlPath\n";
    echo "Maps to: $appFolder\n";
    
    $appPath = __DIR__ . '/' . $appFolder;
    $baseUrl = getBaseUrlFromEnv($appPath);
    
    if ($baseUrl) {
        echo "Target: $baseUrl ✅\n";
    } else {
        echo "Target: NOT CONFIGURED ❌\n";
    }
    
    echo "-----------------------------------\n";
}

echo "\n=== SYSTEM STATUS ===\n\n";

// Check if redirect.php exists
if (file_exists(__DIR__ . '/redirect.php')) {
    echo "✅ redirect.php: EXISTS\n";
} else {
    echo "❌ redirect.php: NOT FOUND\n";
}

// Check if .htaccess exists
if (file_exists(__DIR__ . '/.htaccess')) {
    echo "✅ .htaccess: EXISTS\n";
} else {
    echo "❌ .htaccess: NOT FOUND\n";
}

// Check if index.html exists
if (file_exists(__DIR__ . '/index.html')) {
    echo "✅ index.html: EXISTS\n";
} else {
    echo "❌ index.html: NOT FOUND\n";
}

echo "\n=== USAGE INSTRUCTIONS ===\n\n";
echo "1. Start Apache in XAMPP\n";
echo "2. Start application servers:\n";
foreach ($apps as $appFolder => $appName) {
    $appPath = __DIR__ . '/' . $appFolder;
    $baseUrl = getBaseUrlFromEnv($appPath);
    if ($baseUrl) {
        $port = parse_url($baseUrl, PHP_URL_PORT);
        echo "   cd $appFolder && php spark serve --port=$port\n";
    }
}
echo "3. Access: http://localhost/smartbk\n";
echo "4. Test dynamic redirects\n\n";

echo "=== TEST COMPLETED ===\n";
?>
