<?php
// Diagnostic script untuk app-ortu
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "DIAGNOSTIC APP-ORTU\n";
echo "==================\n\n";

// 1. Basic checks
echo "1. PHP Version: " . PHP_VERSION . "\n";
echo "2. Current Directory: " . getcwd() . "\n";
echo "3. Script Location: " . __DIR__ . "\n\n";

// 2. File structure check
echo "FILE STRUCTURE CHECK:\n";
$requiredFiles = [
    'app/Config/App.php',
    'app/Config/Database.php', 
    'app/Controllers/Partnership.php',
    'public/index.php',
    'vendor/autoload.php',
    '.env'
];

foreach ($requiredFiles as $file) {
    $fullPath = __DIR__ . '/' . $file;
    if (file_exists($fullPath)) {
        echo "✓ $file exists\n";
    } else {
        echo "✗ $file MISSING\n";
    }
}

echo "\n";

// 3. Database connection test
echo "DATABASE CONNECTION TEST:\n";
try {
    $host = 'srv1412.hstgr.io';
    $dbname = 'u809035070_simaklah';
    $username = 'u809035070_simaklah';
    $password = 'Simaklah88#';
    
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    
    echo "✓ Database connection successful\n";
    
    // Check required tables
    $requiredTables = [
        'parent_invitations',
        'parent_summaries', 
        'action_plans',
        'parent_feedback'
    ];
    
    foreach ($requiredTables as $table) {
        $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
        $stmt->execute([$table]);
        if ($stmt->rowCount() > 0) {
            echo "✓ Table $table exists\n";
        } else {
            echo "✗ Table $table MISSING\n";
        }
    }
    
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 4. CodeIgniter bootstrap test  
echo "CODEIGNITER BOOTSTRAP TEST:\n";
try {
    // Set up paths
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    }
    
    if (file_exists(__DIR__ . '/app/Config/Paths.php')) {
        require_once __DIR__ . '/app/Config/Paths.php';
        $paths = new Config\Paths();
        echo "✓ Paths configuration loaded\n";
        
        if (!defined('APPPATH')) {
            define('APPPATH', realpath($paths->appDirectory) . DIRECTORY_SEPARATOR);
        }
        if (!defined('SYSTEMPATH')) {
            define('SYSTEMPATH', realpath($paths->systemDirectory) . DIRECTORY_SEPARATOR);
        }
        if (!defined('ROOTPATH')) {
            define('ROOTPATH', realpath(APPPATH . '../') . DIRECTORY_SEPARATOR);
        }
        
        echo "✓ Directory constants defined\n";
        echo "  APPPATH: " . APPPATH . "\n";
        echo "  SYSTEMPATH: " . SYSTEMPATH . "\n";
        echo "  ROOTPATH: " . ROOTPATH . "\n";
        
    } else {
        echo "✗ Paths.php not found\n";
    }
    
    // Test autoloader
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
        echo "✓ Composer autoloader loaded\n";
    } else {
        echo "✗ Composer autoloader not found\n";
    }
    
} catch (Exception $e) {
    echo "✗ Bootstrap error: " . $e->getMessage() . "\n";
}

echo "\n";

// 5. Environment test
echo "ENVIRONMENT TEST:\n";
if (file_exists(__DIR__ . '/.env')) {
    $envContent = file_get_contents(__DIR__ . '/.env');
    if (strpos($envContent, 'CI_ENVIRONMENT') !== false) {
        echo "✓ CI_ENVIRONMENT found in .env\n";
    }
    if (strpos($envContent, 'app.baseURL') !== false) {
        echo "✓ app.baseURL found in .env\n";  
    }
    if (strpos($envContent, 'database.default.hostname') !== false) {
        echo "✓ Database config found in .env\n";
    }
} else {
    echo "✗ .env file not found\n";
}

echo "\nDIAGNOSTIC COMPLETE\n";
?>
