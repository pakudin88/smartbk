<?php
// Fix app-ortu setup and permissions

echo "=== FIXING APP-ORTU SETUP ===\n";

// 1. Check and fix writable directory permissions
$writableDirs = [
    'writable/cache',
    'writable/logs', 
    'writable/session',
    'writable/uploads'
];

foreach ($writableDirs as $dir) {
    $fullPath = __DIR__ . '/' . $dir;
    if (!is_dir($fullPath)) {
        if (mkdir($fullPath, 0755, true)) {
            echo "✓ Created directory: $dir\n";
        } else {
            echo "✗ Failed to create: $dir\n";
        }
    } else {
        echo "✓ Directory exists: $dir\n";
    }
    
    // Try to make writable (Windows compatible)
    if (is_dir($fullPath)) {
        chmod($fullPath, 0755);
    }
}

// 2. Create .htaccess for public directory if needed
$htaccessContent = <<<EOT
# Disable directory browsing
Options -Indexes

# Disable server signature start
ServerSignature Off

# Limit file uploads to 20MB
LimitRequestBody 20971520

# Rewrite rules
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?/\$1 [L]
</IfModule>

<IfModule !mod_rewrite.c>
    ErrorDocument 404 index.php
</IfModule>
EOT;

$htaccessFile = __DIR__ . '/public/.htaccess';
if (!file_exists($htaccessFile)) {
    file_put_contents($htaccessFile, $htaccessContent);
    echo "✓ Created .htaccess file\n";
}

// 3. Fix session configuration in Session.php if needed
$sessionConfig = __DIR__ . '/app/Config/Session.php';
if (file_exists($sessionConfig)) {
    echo "✓ Session config exists\n";
} else {
    $sessionConfigContent = <<<'EOT'
<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Session extends BaseConfig
{
    public string $driver = 'CodeIgniter\Session\Handlers\FileHandler';
    public string $cookieName = 'ci_session';
    public int $expiration = 7200;
    public string $savePath = WRITEPATH . 'session';
    public bool $matchIP = false;
    public int $timeToUpdate = 300;
    public bool $regenerateDestroy = false;
}
EOT;
    
    file_put_contents($sessionConfig, $sessionConfigContent);
    echo "✓ Created Session config\n";
}

// 4. Test database connectivity and show sample URL
try {
    $host = 'srv1412.hstgr.io';
    $dbname = 'u809035070_simaklah';
    $username = 'u809035070_simaklah';
    $password = 'Simaklah88#';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    echo "✓ Database connection successful\n";
    
    // Get test token
    $stmt = $pdo->prepare("SELECT invitation_token FROM parent_invitations WHERE invitation_token LIKE 'test_%' ORDER BY created_at DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $token = $result['invitation_token'];
        echo "\n=== TEST URLS ===\n";
        echo "1. Main Page: http://localhost/smartbk/app-ortu/public/\n";
        echo "2. Test Page: http://localhost/smartbk/app-ortu/public/test\n";
        echo "3. Demo Login: http://localhost/smartbk/app-ortu/public/?token=$token\n";
    }
    
} catch (Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
}

echo "\n=== SETUP COMPLETE ===\n";
echo "App-Ortu should now be ready to use!\n";
?>
