<?php
// Final troubleshooting script for app-ortu

echo "=== FINAL APP-ORTU TROUBLESHOOTING ===\n";

// 1. Check PHP version and extensions
echo "1. PHP Environment:\n";
echo "   PHP Version: " . PHP_VERSION . "\n";
echo "   PDO MySQL: " . (extension_loaded('pdo_mysql') ? "✓" : "✗") . "\n";
echo "   Session: " . (extension_loaded('session') ? "✓" : "✗") . "\n";
echo "   JSON: " . (extension_loaded('json') ? "✓" : "✗") . "\n\n";

// 2. Check file permissions and structure
echo "2. File Structure:\n";
$criticalFiles = [
    'public/index.php',
    'app/Config/App.php',
    'app/Config/Database.php',
    'app/Controllers/Partnership.php',
    'app/Views/layouts/partnership_layout.php',
    '.env',
    'vendor/autoload.php'
];

foreach ($criticalFiles as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "   ✓ $file\n";
    } else {
        echo "   ✗ $file MISSING\n";
    }
}

// 3. Test database and get working demo URL
echo "\n3. Database & Demo Data:\n";
try {
    $pdo = new PDO("mysql:host=srv1412.hstgr.io;dbname=u809035070_simaklah;charset=utf8", 
                   "u809035070_simaklah", "Simaklah88#");
    echo "   ✓ Database connected\n";
    
    // Get all active invitations
    $stmt = $pdo->prepare("SELECT invitation_token, parent_name, expires_at FROM parent_invitations WHERE is_active = 1 AND expires_at > NOW() ORDER BY created_at DESC");
    $stmt->execute();
    $invitations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "   ✓ Active invitations: " . count($invitations) . "\n";
    
    if (!empty($invitations)) {
        echo "\n   Available test tokens:\n";
        foreach ($invitations as $inv) {
            echo "   - Token: {$inv['invitation_token']}\n";
            echo "     Parent: {$inv['parent_name']}\n";
            echo "     Expires: {$inv['expires_at']}\n";
            echo "     URL: http://localhost/smartbk/app-ortu/public/?token={$inv['invitation_token']}\n\n";
        }
    }
    
} catch (Exception $e) {
    echo "   ✗ Database error: " . $e->getMessage() . "\n";
}

// 4. Test CodeIgniter bootstrap
echo "4. CodeIgniter Test:\n";
try {
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    }
    
    require_once __DIR__ . '/app/Config/Paths.php';
    $paths = new Config\Paths();
    echo "   ✓ Paths loaded\n";
    
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
        echo "   ✓ Autoloader available\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Bootstrap error: " . $e->getMessage() . "\n";
}

// 5. Generate quick access URLs
echo "\n5. Quick Access URLs:\n";
echo "   Main App: http://localhost/smartbk/app-ortu/public/\n";
echo "   Test Page: http://localhost/smartbk/app-ortu/public/test\n";
echo "   HTML Test: http://localhost/smartbk/app-ortu/test.html\n";

// 6. Create a simple HTML test page for direct browser access
$htmlTest = <<<'HTML'
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App-Ortu Quick Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin: 5px; }
        .btn:hover { background: #0056b3; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 App-Ortu - Quick Test Portal</h1>
        <p>Klik tombol di bawah untuk mengtest berbagai fitur aplikasi:</p>
        
        <h3>Test Applications</h3>
        <a href="public/" class="btn">Main Application</a>
        <a href="public/test" class="btn">Test Route</a>
        <a href="public/?token=DEMO2024ORTU" class="btn">Demo Login</a>
        
        <h3>Development Tools</h3>
        <a href="diagnostic.php" class="btn">Run Diagnostic</a>
        <a href="quick-test.php" class="btn">Quick Test</a>
        <a href="fix-setup.php" class="btn">Fix Setup</a>
        
        <h3>Database Tools</h3>
        <a href="create-database-tables.php" class="btn">Create Tables</a>
        <a href="create-demo-data.php" class="btn">Create Demo Data</a>
        
        <hr>
        <h3>Demo Login Information</h3>
        <p><strong>Token:</strong> DEMO2024ORTU</p>
        <p><strong>Parent:</strong> Bapak/Ibu Ahmad Demo</p>
        <p><strong>Student:</strong> Ahmad Demo Siswa</p>
        <p><strong>Features:</strong> Academic reports, Action plans, Progress tracking, Feedback system</p>
        
        <hr>
        <p><em>Last updated: <?= date('Y-m-d H:i:s') ?></em></p>
    </div>
</body>
</html>
HTML;

file_put_contents(__DIR__ . '/test-portal.html', $htmlTest);
echo "   ✓ Created test-portal.html\n";

echo "\n=== TROUBLESHOOTING COMPLETE ===\n";
echo "App-Ortu setup should be working now!\n";
echo "Access test portal: http://localhost/smartbk/app-ortu/test-portal.html\n";
?>
