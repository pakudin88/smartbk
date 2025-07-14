<?php
// Quick diagnostic to check if app can load without errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== SIMAKLAH APP-MURID DIAGNOSTIC ===\n";

// Check if basic files exist
$requiredFiles = [
    'app/Config/App.php',
    'app/Config/Routes.php', 
    'app/Controllers/Auth.php',
    'app/Controllers/SafeSpaceController.php',
    'app/Controllers/BaseController.php',
    '.env'
];

foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "✅ $file exists\n";
    } else {
        echo "❌ $file missing\n";
    }
}

// Test basic autoloading
try {
    require_once 'vendor/autoload.php';
    echo "✅ Autoload works\n";
} catch (Exception $e) {
    echo "❌ Autoload failed: " . $e->getMessage() . "\n";
}

// Test env loading
if (file_exists('.env')) {
    echo "✅ .env file exists\n";
} else {
    echo "❌ .env file missing\n";
}

// Test basic config
try {
    $config = new \Config\App();
    echo "✅ App config loaded: " . $config->baseURL . "\n";
} catch (Exception $e) {
    echo "❌ App config failed: " . $e->getMessage() . "\n";
}

// Test syntax of controllers
$controllers = [
    'app/Controllers/Auth.php',
    'app/Controllers/SafeSpaceController.php',
    'app/Controllers/BaseController.php'
];

foreach ($controllers as $controller) {
    if (file_exists($controller)) {
        $output = [];
        $return_var = 0;
        exec("php -l \"$controller\"", $output, $return_var);
        if ($return_var === 0) {
            echo "✅ $controller syntax OK\n";
        } else {
            echo "❌ $controller syntax error:\n";
            echo implode("\n", $output) . "\n";
        }
    }
}

echo "\n=== DIAGNOSTIC COMPLETE ===\n";
?>
