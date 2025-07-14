<?php
echo "=== ENVIRONMENT LOADING DEBUG ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Test environment loading step by step
echo "1. TESTING ENVIRONMENT VARIABLES:\n";

// Direct .env file check
$env_file = __DIR__ . '/.env';
if (file_exists($env_file)) {
    echo "   ✓ .env file exists\n";
    
    $content = file_get_contents($env_file);
    $lines = explode("\n", $content);
    
    echo "   Database config in .env:\n";
    foreach ($lines as $line) {
        if (strpos($line, 'database.default.') === 0 && strpos($line, '#') !== 0) {
            echo "     $line\n";
        }
    }
} else {
    echo "   ✗ .env file not found\n";
}

echo "\n2. TESTING CODEIGNITER ENV LOADING:\n";

// Bootstrap CodeIgniter
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

// Test DotEnv loading
require_once SYSTEMPATH . 'Config/DotEnv.php';
$dotenv = new CodeIgniter\Config\DotEnv(ROOTPATH);
$dotenv->load();

echo "   ✓ DotEnv loaded\n";

// Check specific variables
$db_vars = [
    'database.default.hostname',
    'database.default.database', 
    'database.default.username',
    'database.default.password'
];

foreach ($db_vars as $var) {
    $value = getenv($var);
    if ($value !== false) {
        $display_value = ($var === 'database.default.password') ? '***hidden***' : $value;
        echo "   ✓ $var = $display_value\n";
    } else {
        echo "   ✗ $var not found in environment\n";
    }
}

echo "\n3. TESTING DATABASE CONFIG CLASS:\n";

if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'development');
}

try {
    $config = new \Config\Database();
    echo "   ✓ Database config class instantiated\n";
    
    echo "   Config values:\n";
    echo "     hostname: " . $config->default['hostname'] . "\n";
    echo "     database: " . $config->default['database'] . "\n";
    echo "     username: " . $config->default['username'] . "\n";
    echo "     password: " . (empty($config->default['password']) ? 'empty' : '***set***') . "\n";
    echo "     driver: " . $config->default['DBDriver'] . "\n";
    echo "     port: " . $config->default['port'] . "\n";
    
} catch (Exception $e) {
    echo "   ✗ Database config error: " . $e->getMessage() . "\n";
}

echo "\n=== DEBUG COMPLETED ===\n";
