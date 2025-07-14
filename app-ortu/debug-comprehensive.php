<?php
echo "=== COMPREHENSIVE CODEIGNITER 4 DEBUG TEST ===\n\n";

// 1. PHP Version Check
echo "1. PHP VERSION CHECK:\n";
echo "   Current PHP Version: " . PHP_VERSION . "\n";
echo "   Minimum Required: 7.4.0\n";
echo "   Status: " . (version_compare(PHP_VERSION, '7.4.0', '>=') ? "✓ OK" : "✗ UPGRADE NEEDED") . "\n\n";

// 2. Extension Check
echo "2. REQUIRED EXTENSIONS:\n";
$extensions = ['intl', 'mbstring', 'json', 'mysqlnd', 'curl', 'fileinfo', 'gd', 'xml'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    echo "   $ext: " . ($loaded ? "✓ Loaded" : "✗ Missing") . "\n";
}
echo "\n";

// 3. File Structure Check
echo "3. CODEIGNITER FILE STRUCTURE:\n";
$required_files = [
    'app/Config/App.php',
    'app/Config/Database.php',
    'app/Config/Routes.php',
    'vendor/autoload.php',
    'public/index.php',
    '.env'
];

foreach ($required_files as $file) {
    $exists = file_exists(__DIR__ . '/' . $file);
    echo "   $file: " . ($exists ? "✓ Found" : "✗ Missing") . "\n";
}
echo "\n";

// 4. Directory Permissions
echo "4. WRITABLE DIRECTORIES:\n";
$dirs = ['writable', 'writable/cache', 'writable/logs', 'writable/session'];
foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    $writable = is_dir($path) && is_writable($path);
    echo "   $dir: " . ($writable ? "✓ Writable" : "✗ Not Writable") . "\n";
}
echo "\n";

// 5. Environment Configuration
echo "5. ENVIRONMENT CONFIGURATION:\n";
if (file_exists(__DIR__ . '/.env')) {
    $env_content = file_get_contents(__DIR__ . '/.env');
    preg_match('/CI_ENVIRONMENT\s*=\s*(.+)/', $env_content, $env_matches);
    preg_match('/CI_DEBUG\s*=\s*(.+)/', $env_content, $debug_matches);
    
    echo "   Environment: " . (isset($env_matches[1]) ? trim($env_matches[1]) : "Not Set") . "\n";
    echo "   Debug Mode: " . (isset($debug_matches[1]) ? trim($debug_matches[1]) : "Not Set") . "\n";
} else {
    echo "   .env file: ✗ Missing\n";
}
echo "\n";

// 6. Try Loading CodeIgniter
echo "6. CODEIGNITER LOADING TEST:\n";
try {
    // Load Composer autoloader
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
        echo "   Composer Autoloader: ✓ Loaded\n";
    } else {
        throw new Exception("Composer autoloader not found");
    }
    
    // Load Paths config
    if (file_exists(__DIR__ . '/app/Config/Paths.php')) {
        require_once __DIR__ . '/app/Config/Paths.php';
        echo "   Paths Config: ✓ Loaded\n";
    } else {
        throw new Exception("Paths config not found");
    }
    
    echo "   CodeIgniter Core: ✓ Ready to Load\n";
    
} catch (Exception $e) {
    echo "   Error: ✗ " . $e->getMessage() . "\n";
}
echo "\n";

// 7. Database Connection Test
echo "7. DATABASE CONNECTION TEST:\n";
try {
    if (file_exists(__DIR__ . '/.env')) {
        $env_content = file_get_contents(__DIR__ . '/.env');
        preg_match('/database\.default\.hostname\s*=\s*(.+)/', $env_content, $host_matches);
        preg_match('/database\.default\.database\s*=\s*(.+)/', $env_content, $db_matches);
        preg_match('/database\.default\.username\s*=\s*(.+)/', $env_content, $user_matches);
        
        $host = isset($host_matches[1]) ? trim($host_matches[1]) : 'localhost';
        $database = isset($db_matches[1]) ? trim($db_matches[1]) : '';
        $username = isset($user_matches[1]) ? trim($user_matches[1]) : 'root';
        
        echo "   Host: $host\n";
        echo "   Database: $database\n";
        echo "   Username: $username\n";
        
        // Try to connect (basic test)
        if (extension_loaded('mysqli') && $host && $database) {
            $connection = @mysqli_connect($host, $username, '', $database);
            if ($connection) {
                echo "   Connection: ✓ Successful\n";
                mysqli_close($connection);
            } else {
                echo "   Connection: ✗ Failed - " . mysqli_connect_error() . "\n";
            }
        } else {
            echo "   Connection: ⚠ Cannot test (missing mysqli or config)\n";
        }
    }
} catch (Exception $e) {
    echo "   Database Test Error: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "DEBUG TEST COMPLETED - " . date('Y-m-d H:i:s') . "\n";
echo str_repeat("=", 60) . "\n";
?>
