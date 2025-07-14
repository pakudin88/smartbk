<?php
// Create demo parent user in orang_tua table
$host = 'srv1412.hstgr.io';
$dbname = 'u809035070_simaklah';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if demo user already exists
    $stmt = $pdo->prepare("SELECT * FROM orang_tua WHERE username = ?");
    $stmt->execute(['demo_parent']);
    
    if ($stmt->rowCount() > 0) {
        echo "Demo user already exists. Updating password...\n";
        
        $hashedPassword = password_hash('demo123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE orang_tua SET password = ?, updated_at = NOW() WHERE username = ?");
        $stmt->execute([$hashedPassword, 'demo_parent']);
        
        echo "Demo user password updated successfully!\n";
    } else {
        echo "Creating new demo parent user...\n";
        
        $hashedPassword = password_hash('demo123', PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO orang_tua (username, email, password, nama_lengkap, hubungan_keluarga, is_active, tahun_ajaran_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        
        $stmt->execute([
            'demo_parent',
            'demo@parent.com',
            $hashedPassword,
            'Demo Parent User',
            'Wali',
            1,
            15  // Using the same tahun_ajaran_id as existing users
        ]);
        
        echo "Demo parent user created successfully!\n";
    }
    
    // Verify the user was created/updated
    $stmt = $pdo->prepare("SELECT username, email, nama_lengkap, hubungan_keluarga, is_active FROM orang_tua WHERE username = ?");
    $stmt->execute(['demo_parent']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "\nDemo user details:\n";
        echo "- Username: {$user['username']}\n";
        echo "- Email: {$user['email']}\n";
        echo "- Nama Lengkap: {$user['nama_lengkap']}\n";
        echo "- Hubungan Keluarga: {$user['hubungan_keluarga']}\n";
        echo "- Status: " . ($user['is_active'] ? 'Active' : 'Inactive') . "\n";
        echo "\nLogin credentials:\n";
        echo "Username: demo_parent\n";
        echo "Password: demo123\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
