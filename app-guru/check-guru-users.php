<?php
// Check guru users in users table
$host = 'srv1412.hstgr.io';
$dbname = 'u809035070_simaklah';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Checking guru users in database...\n";
    
    // Check existing guru users (role_id = 2)
    $stmt = $pdo->query("SELECT * FROM users WHERE role_id = 2 AND is_active = 1 LIMIT 5");
    $gurus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($gurus) {
        echo "Found existing guru users:\n";
        foreach ($gurus as $guru) {
            echo "- ID: {$guru['id']}, Username: {$guru['username']}, Name: {$guru['full_name']}, Email: {$guru['email']}\n";
        }
    } else {
        echo "No guru users found. Creating demo guru user...\n";
        
        // Create demo guru user
        $hashedPassword = password_hash('guru123', PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (role_id, tahun_ajaran_id, username, password, full_name, email, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        
        $stmt->execute([
            2,  // role_id for guru
            15, // same tahun_ajaran_id as other users
            'demo_guru',
            $hashedPassword,
            'Demo Guru Smart BK',
            'demo@guru.com',
            1
        ]);
        
        echo "Demo guru user created successfully!\n";
        echo "Username: demo_guru\n";
        echo "Password: guru123\n";
    }
    
    // Show login credentials for existing users
    if ($gurus) {
        echo "\nTesting password verification for existing guru users:\n";
        foreach ($gurus as $guru) {
            echo "\nTesting user: {$guru['username']}\n";
            // Try common passwords
            $testPasswords = ['guru123', 'password', '123456', 'admin'];
            foreach ($testPasswords as $testPass) {
                if (password_verify($testPass, $guru['password'])) {
                    echo "✓ Password found: {$testPass}\n";
                    break;
                }
            }
        }
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
