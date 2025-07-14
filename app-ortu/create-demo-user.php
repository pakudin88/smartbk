<?php
echo "=== CREATING DEMO LOGIN USER ===\n";
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

try {
    $db = \Config\Database::connect();
    $db->initialize();
    
    if ($db->connID) {
        echo "   ✓ Database connected\n\n";
        
        echo "1. CREATING DEMO USER:\n";
        
        // Delete existing demo user if exists
        $db->query("DELETE FROM users WHERE username = 'demo_parent'");
        
        // Create new demo user with known password
        $demo_password = 'demo123';
        $demo_hash = password_hash($demo_password, PASSWORD_DEFAULT);
        
        $insert_sql = "INSERT INTO users (username, password, role_id, is_active, created_at, updated_at) 
                       VALUES (?, ?, ?, ?, ?, ?)";
        
        $db->query($insert_sql, [
            'demo_parent',
            $demo_hash,
            5, // Parent role
            1, // Active
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);
        
        echo "   ✅ Demo user created successfully!\n\n";
        
        echo "2. DEMO LOGIN CREDENTIALS:\n";
        echo "   Username: demo_parent\n";
        echo "   Password: demo123\n";
        echo "   Role: Parent (ID: 5)\n";
        echo "   Status: Active\n\n";
        
        echo "3. VERIFICATION:\n";
        // Verify the user was created
        $verify = $db->query("SELECT username, role_id, is_active FROM users WHERE username = 'demo_parent'")->getRow();
        if ($verify) {
            echo "   ✅ User verified in database\n";
            echo "   ✅ Username: " . $verify->username . "\n";
            echo "   ✅ Role ID: " . $verify->role_id . "\n";
            echo "   ✅ Active: " . ($verify->is_active ? 'Yes' : 'No') . "\n";
            
            // Test password verification
            $user_data = $db->query("SELECT password FROM users WHERE username = 'demo_parent'")->getRow();
            if (password_verify('demo123', $user_data->password)) {
                echo "   ✅ Password verification: SUCCESS\n";
            } else {
                echo "   ❌ Password verification: FAILED\n";
            }
        } else {
            echo "   ❌ User verification failed\n";
        }
        
        echo "\n4. HOW TO LOGIN:\n";
        echo "   1. Start server: php spark serve --port=8080\n";
        echo "   2. Open browser: http://localhost:8080\n";
        echo "   3. Login with:\n";
        echo "      Username: demo_parent\n";
        echo "      Password: demo123\n";
        echo "   4. Should redirect to dashboard after successful login\n";
        
    } else {
        echo "   ✗ Database connection failed\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== DEMO USER CREATED ===\n";
