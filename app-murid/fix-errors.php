<?php
/**
 * Error Fix Script - Resolve common CodeIgniter baseURL and config issues
 */

echo "=== SIMAKLAH ERROR FIX SCRIPT ===\n";

// Fix 1: Ensure baseURL is never empty
echo "1. Fixing baseURL configuration...\n";

$appConfigPath = 'app/Config/App.php';
if (file_exists($appConfigPath)) {
    $content = file_get_contents($appConfigPath);
    
    // Ensure baseURL has a default value
    if (strpos($content, "public string \$baseURL = '';") !== false) {
        $content = str_replace(
            "public string \$baseURL = '';",
            "public string \$baseURL = 'http://localhost:8080/';",
            $content
        );
        file_put_contents($appConfigPath, $content);
        echo "   ✅ Fixed empty baseURL in App.php\n";
    } else {
        echo "   ✅ baseURL already set in App.php\n";
    }
} else {
    echo "   ❌ App.php not found!\n";
}

// Fix 2: Ensure .env has proper baseURL
echo "2. Fixing .env configuration...\n";
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    
    if (strpos($envContent, "app.baseURL = ''") !== false) {
        $envContent = str_replace(
            "app.baseURL = ''",
            "app.baseURL = 'http://localhost:8080/'",
            $envContent
        );
        file_put_contents('.env', $envContent);
        echo "   ✅ Fixed empty baseURL in .env\n";
    } else {
        echo "   ✅ .env baseURL is not empty\n";
    }
    
    // Ensure app_baseURL is not set to empty
    if (strpos($envContent, "app_baseURL = ''") !== false) {
        $envContent = str_replace(
            "app_baseURL = ''",
            "# app_baseURL = 'http://localhost:8080/'",
            $envContent
        );
        file_put_contents('.env', $envContent);
        echo "   ✅ Commented out empty app_baseURL\n";
    }
} else {
    echo "   ❌ .env file not found!\n";
}

// Fix 3: Check if BaseController has required methods
echo "3. Checking BaseController methods...\n";
$baseControllerPath = 'app/Controllers/BaseController.php';
if (file_exists($baseControllerPath)) {
    $content = file_get_contents($baseControllerPath);
    
    if (strpos($content, 'getUserData') === false) {
        echo "   ⚠️ getUserData method missing in BaseController\n";
    } else {
        echo "   ✅ getUserData method exists\n";
    }
    
    if (strpos($content, 'urlTo') === false) {
        echo "   ⚠️ urlTo method missing in BaseController\n";
    } else {
        echo "   ✅ urlTo method exists\n";
    }
} else {
    echo "   ❌ BaseController.php not found!\n";
}

// Fix 4: Verify critical directories exist
echo "4. Checking directory structure...\n";
$dirs = [
    'app/Controllers',
    'app/Views/auth',
    'app/Views/safe_space',
    'app/Views/dashboard',
    'public/js',
    'writable/cache',
    'writable/logs'
];

foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        echo "   ✅ $dir exists\n";
    } else {
        if (mkdir($dir, 0755, true)) {
            echo "   ✅ Created $dir\n";
        } else {
            echo "   ❌ Failed to create $dir\n";
        }
    }
}

// Fix 5: Set proper permissions on writable directories
echo "5. Setting permissions...\n";
$writableDirs = ['writable', 'writable/cache', 'writable/logs', 'writable/session'];
foreach ($writableDirs as $dir) {
    if (is_dir($dir)) {
        chmod($dir, 0755);
        echo "   ✅ Set permissions on $dir\n";
    }
}

echo "\n=== FIX COMPLETE ===\n";
echo "You can now try starting the server with:\n";
echo "php spark serve --port=8080\n";
echo "or run start-server.bat\n";
?>
