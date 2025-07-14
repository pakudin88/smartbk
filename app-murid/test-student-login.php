<?php
/**
 * Test Student Login with Remote Database
 */

echo "=== TESTING STUDENT LOGIN CREDENTIALS ===\n";

$remoteConfig = [
    'hostname' => 'srv1412.hstgr.io',
    'username' => 'u809035070_simaklah', 
    'password' => 'Simaklah88#',
    'database' => 'u809035070_simaklah',
    'port' => 3306
];

try {
    $mysqli = new mysqli(
        $remoteConfig['hostname'],
        $remoteConfig['username'], 
        $remoteConfig['password'],
        $remoteConfig['database'],
        $remoteConfig['port']
    );
    
    if ($mysqli->connect_error) {
        die("❌ Connection failed: " . $mysqli->connect_error . "\n");
    }
    
    echo "✅ Connected to remote database\n\n";
    
    // Get student accounts for testing
    $result = $mysqli->query("
        SELECT id, username, full_name, email, password 
        FROM users 
        WHERE role_id = 4 AND is_active = 1 
        ORDER BY id 
        LIMIT 5
    ");
    
    if ($result && $result->num_rows > 0) {
        echo "=== AVAILABLE STUDENT ACCOUNTS ===\n";
        printf("%-5s %-15s %-25s %-30s %-15s\n", "ID", "Username", "Full Name", "Email", "Password Type");
        echo str_repeat("-", 100) . "\n";
        
        $testAccounts = [];
        while ($row = $result->fetch_assoc()) {
            $passwordType = 'Unknown';
            if (strpos($row['password'], '$2y$') === 0) {
                $passwordType = 'bcrypt';
            } elseif (strlen($row['password']) == 32) {
                $passwordType = 'MD5';
            }
            
            printf("%-5s %-15s %-25s %-30s %-15s\n", 
                $row['id'], 
                $row['username'], 
                substr($row['full_name'], 0, 24), 
                substr($row['email'], 0, 29), 
                $passwordType
            );
            
            $testAccounts[] = $row;
        }
        
        echo "\n=== PASSWORD TESTING ===\n";
        
        // Test common passwords
        $commonPasswords = ['123456', 'password', 'admin', 'siswa123', '12345', 'student'];
        
        foreach ($testAccounts as $account) {
            echo "\nTesting account: " . $account['username'] . "\n";
            $found = false;
            
            foreach ($commonPasswords as $testPassword) {
                if (password_verify($testPassword, $account['password'])) {
                    echo "✅ FOUND! Username: " . $account['username'] . " | Password: " . $testPassword . "\n";
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                echo "⚠️ No common password found for " . $account['username'] . "\n";
                echo "   Password hash: " . substr($account['password'], 0, 50) . "...\n";
            }
        }
        
    } else {
        echo "❌ No student accounts found\n";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== LOGIN TESTING INSTRUCTIONS ===\n";
echo "1. Start the server: php spark serve --port=8080\n";
echo "2. Visit: http://localhost:8080/login\n";
echo "3. Try the credentials found above\n";
echo "4. If no passwords work, check with app-superadmin admin\n";

echo "\n=== ALTERNATIVE: CREATE TEST ACCOUNT ===\n";
echo "If needed, you can create a test account via app-superadmin:\n";
echo "- Role: Student/Siswa (role_id = 4)\n";
echo "- Username: test.student\n";
echo "- Password: 123456\n";
echo "- Full Name: Test Student\n";
?>
