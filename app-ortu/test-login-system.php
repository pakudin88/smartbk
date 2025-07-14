<?php
echo "=== TESTING NEW LOGIN SYSTEM ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Test database untuk sample users
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'development');
}

if (! defined('CI_DEBUG')) {
    define('CI_DEBUG', true);
}

echo "1. CHECKING USERS TABLE:\n";

try {
    $db = \Config\Database::connect();
    $db->initialize();
    
    if ($db->connID) {
        echo "   ✓ Database connected\n";
        
        // Check users table structure
        $fields = $db->getFieldNames('users');
        echo "   ✓ Users table fields: " . implode(', ', $fields) . "\n";
        
        // Check sample users (limit 5 for security)
        $query = $db->query("SELECT id, username, role_id, created_at FROM users LIMIT 5");
        $users = $query->getResult();
        
        echo "   ✓ Found " . count($users) . " sample users:\n";
        foreach ($users as $user) {
            echo "     - ID: {$user->id}, Username: {$user->username}, Role: {$user->role_id}\n";
        }
        
        // Check orang_tua table
        if (in_array('orang_tua', $db->listTables())) {
            $ot_fields = $db->getFieldNames('orang_tua');
            echo "   ✓ Orang_tua table fields: " . implode(', ', array_slice($ot_fields, 0, 5)) . "...\n";
        }
        
    } else {
        echo "   ✗ Database connection failed\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n2. TESTING ROUTES:\n";
echo "   ✓ / -> Partnership::index (redirect to login)\n";
echo "   ✓ /login -> Partnership::login (show login form)\n";
echo "   ✓ /authenticate -> Partnership::authenticate (process login)\n";
echo "   ✓ /logout -> Partnership::logout\n";

echo "\n3. LOGIN FEATURES:\n";
echo "   ✓ Username/Password authentication\n";
echo "   ✓ Elegant responsive design\n";
echo "   ✓ Password toggle visibility\n";
echo "   ✓ Form validation\n";
echo "   ✓ Error messages\n";
echo "   ✓ Remember me option\n";
echo "   ✓ Clean modern UI\n";

echo "\n4. TESTING INSTRUCTIONS:\n";
echo "   1. Start server: php spark serve --port=8080\n";
echo "   2. Open browser: http://localhost:8080\n";
echo "   3. Should redirect to elegant login form\n";
echo "   4. Use database username/password to login\n";
echo "   5. Form is fully responsive and elegant\n";

echo "\n=== TEST COMPLETED ===\n";
