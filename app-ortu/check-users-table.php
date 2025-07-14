<?php
// Check users table structure
$host = 'srv1412.hstgr.io';
$dbname = 'u809035070_simaklah';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Checking users table...\n";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        echo "Table 'users' does not exist.\n";
        echo "It looks like 'orang_tua' is the main users table for parents.\n";
    } else {
        echo "Users table structure:\n";
        $stmt = $pdo->query("DESCRIBE users");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- {$row['Field']} ({$row['Type']})\n";
        }
        
        echo "\nSample users data:\n";
        $stmt = $pdo->query("SELECT * FROM users LIMIT 2");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Row:\n";
            foreach ($row as $col => $val) {
                echo "  $col: $val\n";
            }
            echo "\n";
        }
    }
    
    // Let's also check our demo user
    echo "\nChecking for demo_parent user in orang_tua table:\n";
    $stmt = $pdo->prepare("SELECT * FROM orang_tua WHERE username = ?");
    $stmt->execute(['demo_parent']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "Demo user found:\n";
        echo "- Username: {$user['username']}\n";
        echo "- Email: {$user['email']}\n";
        echo "- Nama Lengkap: {$user['nama_lengkap']}\n";
        echo "- Password hash exists: " . (empty($user['password']) ? 'NO' : 'YES') . "\n";
    } else {
        echo "Demo user not found in orang_tua table.\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
