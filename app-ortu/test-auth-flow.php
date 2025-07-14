<?php
// Test authentication and dashboard access
$host = 'srv1412.hstgr.io';
$dbname = 'u809035070_simaklah';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Testing authentication flow...\n";
    
    // Test login credentials
    $stmt = $pdo->prepare("SELECT * FROM orang_tua WHERE username = ? AND is_active = 1");
    $stmt->execute(['demo_parent']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "✓ User found: {$user['username']} - {$user['nama_lengkap']}\n";
        
        // Test password verification
        $testPassword = 'demo123';
        if (password_verify($testPassword, $user['password'])) {
            echo "✓ Password verification successful\n";
            
            echo "\nSession data that would be set:\n";
            echo "- parent_logged_in: true\n";
            echo "- user_id: {$user['id']}\n";
            echo "- username: {$user['username']}\n";
            echo "- parent_name: {$user['nama_lengkap']}\n";
            echo "- email: {$user['email']}\n";
            echo "- hubungan_keluarga: {$user['hubungan_keluarga']}\n";
            
        } else {
            echo "✗ Password verification failed\n";
        }
    } else {
        echo "✗ User not found\n";
    }
    
    // Check for tables that dashboard might need
    echo "\nChecking required tables:\n";
    
    $tables = ['parent_summaries', 'action_plans', 'action_progress'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "✓ Table '$table' exists\n";
        } else {
            echo "✗ Table '$table' does not exist (will return empty array)\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
