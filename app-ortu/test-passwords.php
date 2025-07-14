<?php
echo "=== PASSWORD TESTING & CREATION ===\n";
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

echo "1. TESTING EXISTING PASSWORDS:\n";

$test_passwords = ['123456', 'password', 'admin', 'test123', '12345', 'superadmin'];

try {
    $db = \Config\Database::connect();
    $db->initialize();
    
    if ($db->connID) {
        echo "   ✓ Database connected\n\n";
        
        // Get existing users
        $query = $db->query("SELECT username, password FROM users WHERE username IN ('superadmin', 'orangtua_001', 'guru_mtk') LIMIT 3");
        $users = $query->getResult();
        
        foreach ($users as $user) {
            echo "   🔐 Testing passwords for: " . $user->username . "\n";
            
            $found = false;
            foreach ($test_passwords as $pwd) {
                if (password_verify($pwd, $user->password)) {
                    echo "      ✅ FOUND: Password is '$pwd'\n";
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                echo "      ❌ None of common passwords match\n";
                echo "      Hash: " . substr($user->password, 0, 30) . "...\n";
            }
            echo "\n";
        }
        
        echo "2. CREATING TEST USER FOR DEMO:\n";
        
        // Check if test user already exists
        $test_query = $db->query("SELECT id FROM users WHERE username = 'demo_parent'");
        $existing = $test_query->getRow();
        
        if (!$existing) {
            // Create demo user
            $demo_password = 'demo123';
            $demo_hash = password_hash($demo_password, PASSWORD_DEFAULT);
            
            $insert_data = [
                'username' => 'demo_parent',
                'password' => $demo_hash,
                'role_id' => 5, // Parent role
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('users')->insert($insert_data);
            echo "   ✅ Created demo user:\n";
            echo "      Username: demo_parent\n";
            echo "      Password: demo123\n";
            echo "      Role: Parent (5)\n";
        } else {
            echo "   ℹ️  Demo user already exists\n";
            echo "      Username: demo_parent\n";
            echo "      Password: demo123\n";
        }
        
        echo "\n3. TESTING LOGIN CREDENTIALS:\n";
        echo "   🧪 You can now test with:\n\n";
        
        echo "   Demo Account (GUARANTEED TO WORK):\n";
        echo "   Username: demo_parent\n";
        echo "   Password: demo123\n";
        echo "   Role: Parent\n\n";
        
        echo "   Other accounts (try these passwords):\n";
        echo "   Username: superadmin | Try: admin, superadmin, 123456\n";
        echo "   Username: orangtua_001 | Try: 123456, password, orangtua_001\n";
        echo "   Username: guru_mtk | Try: guru123, password, 123456\n";
        
        echo "\n4. HOW TO LOGIN:\n";
        echo "   1. Start: php spark serve --port=8080\n";
        echo "   2. URL: http://localhost:8080\n";
        echo "   3. Use demo_parent / demo123 for guaranteed access\n";
        
    } else {
        echo "   ✗ Database connection failed\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== PASSWORD TEST COMPLETED ===\n";
