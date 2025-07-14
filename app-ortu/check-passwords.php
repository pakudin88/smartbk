<?php
echo "=== CHECKING USER PASSWORDS ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Bootstrap CodeIgniter
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

echo "1. CHECKING DATABASE CONNECTION:\n";

try {
    $db = \Config\Database::connect();
    $db->initialize();
    
    if ($db->connID) {
        echo "   ✓ Connected to: " . $db->getDatabase() . "\n";
        
        echo "\n2. SAMPLE USERS WITH CREDENTIALS:\n";
        
        // Get sample users (limit for security)
        $query = $db->query("SELECT id, username, password, role_id, created_at 
                           FROM users 
                           WHERE username IN ('superadmin', 'orangtua_001', 'guru_mtk', 'admin', 'orang_tua', 'parent') 
                           OR role_id = 5 
                           LIMIT 10");
        $users = $query->getResult();
        
        if (count($users) > 0) {
            echo "   Found " . count($users) . " users:\n\n";
            
            foreach ($users as $user) {
                echo "   📋 Username: " . $user->username . "\n";
                echo "      Password Hash: " . $user->password . "\n";
                echo "      Role ID: " . $user->role_id . "\n";
                
                // Common password attempts for testing
                $common_passwords = ['123456', 'password', 'admin', $user->username, '12345', 'test123'];
                
                echo "      Test passwords to try:\n";
                foreach ($common_passwords as $pwd) {
                    $hash = md5($pwd);
                    if ($hash === $user->password) {
                        echo "      ✅ FOUND: '$pwd' (matches!)\n";
                        break;
                    } else {
                        echo "      - Try: '$pwd'\n";
                    }
                }
                echo "   " . str_repeat("-", 50) . "\n\n";
            }
        } else {
            echo "   No users found with common usernames\n";
            
            // Check any users with role_id 5 (parents)
            $query = $db->query("SELECT id, username, password, role_id FROM users WHERE role_id = 5 LIMIT 5");
            $parents = $query->getResult();
            
            if (count($parents) > 0) {
                echo "\n   PARENT USERS (Role ID 5):\n";
                foreach ($parents as $parent) {
                    echo "   - Username: " . $parent->username . " | Password Hash: " . $parent->password . "\n";
                }
            }
        }
        
        echo "\n3. PASSWORD TESTING GUIDE:\n";
        echo "   Most common passwords to try:\n";
        echo "   - 123456\n";
        echo "   - password\n";
        echo "   - admin\n";
        echo "   - Same as username\n";
        echo "   - 12345\n";
        echo "   - test123\n";
        
        echo "\n4. HOW TO LOGIN:\n";
        echo "   1. Start server: php spark serve --port=8080\n";
        echo "   2. Go to: http://localhost:8080\n";
        echo "   3. Use username from list above\n";
        echo "   4. Try passwords listed\n";
        
    } else {
        echo "   ✗ Database connection failed\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== PASSWORD CHECK COMPLETED ===\n";
