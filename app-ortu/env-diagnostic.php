<?php
echo "=== Environment Diagnostic ===\n";

// Check if .env file exists
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    echo "✓ .env file exists\n";
} else {
    echo "✗ .env file missing\n";
}

// Check environment variables
echo "CI_ENVIRONMENT from \$_ENV: " . ($_ENV['CI_ENVIRONMENT'] ?? 'not set') . "\n";
echo "CI_ENVIRONMENT from \$_SERVER: " . ($_SERVER['CI_ENVIRONMENT'] ?? 'not set') . "\n";
echo "CI_ENVIRONMENT from getenv(): " . (getenv('CI_ENVIRONMENT') ?: 'not set') . "\n";

// Check if ENVIRONMENT constant is defined
if (defined('ENVIRONMENT')) {
    echo "ENVIRONMENT constant: " . ENVIRONMENT . "\n";
} else {
    echo "ENVIRONMENT constant: not defined\n";
}

// Load the .env manually to test
if (file_exists($envFile)) {
    $envContent = file_get_contents($envFile);
    if (preg_match('/CI_ENVIRONMENT\s*=\s*(.+)/', $envContent, $matches)) {
        echo "CI_ENVIRONMENT in .env file: '" . trim($matches[1]) . "'\n";
    }
}

// Test DotEnv loading
try {
    require_once __DIR__ . '/vendor/codeigniter4/framework/system/Config/DotEnv.php';
    $dotenv = new CodeIgniter\Config\DotEnv(__DIR__);
    $dotenv->load();
    echo "✓ DotEnv loaded successfully\n";
    echo "CI_ENVIRONMENT after DotEnv: " . ($_ENV['CI_ENVIRONMENT'] ?? 'still not set') . "\n";
} catch (Exception $e) {
    echo "✗ DotEnv loading failed: " . $e->getMessage() . "\n";
}
?>
