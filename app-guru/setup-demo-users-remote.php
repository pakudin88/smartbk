<?php
/**
 * Script untuk setup demo users di database remote
 * Jalankan sekali untuk membuat data demo
 */

// Database configuration - Remote Server (sama seperti .env)
$host = 'srv1412.hstgr.io';
$dbname = 'u809035070_simaklah';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';
$port = 3306;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to remote database: $dbname\n";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        echo "❌ Table 'users' not found. Please run migrations first.\n";
        echo "Run: php spark migrate\n";
        exit(1);
    }
    
    // Check table structure
    echo "📋 Checking table structure...\n";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Available columns: " . implode(', ', $columns) . "\n";
    
    // Check existing users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $count = $stmt->fetch()['total'];
    
    echo "✅ Found $count existing users in database\n";
    
    if ($count > 0) {
        echo "Checking existing demo users...\n";
        
        $stmt = $pdo->query("SELECT username, role_id, full_name FROM users WHERE role_id = 2 LIMIT 10");
        $existingGurus = $stmt->fetchAll();
        
        if (count($existingGurus) > 0) {
            echo "Found existing guru accounts:\n";
            foreach ($existingGurus as $guru) {
                echo "  - {$guru['username']} (role_id: {$guru['role_id']}) - {$guru['full_name']}\n";
            }
        }
    }
    
    // Demo users data - menggunakan role_id = 2 untuk guru
    $demoUsers = [
        [
            'username' => 'demo_guru',
            'email' => 'demo.guru@sekolah.id',
            'password' => password_hash('demo123', PASSWORD_DEFAULT),
            'role_id' => 2, // guru
            'full_name' => 'Demo Guru',
            'is_active' => 1,
            'tahun_ajaran_id' => null // Set null untuk menghindari constraint issue
        ],
        [
            'username' => 'guru_demo',
            'email' => 'guru.demo@sekolah.id', 
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role_id' => 2, // guru
            'full_name' => 'Siti Demo Guru, S.Pd',
            'is_active' => 1,
            'tahun_ajaran_id' => null
        ],
        [
            'username' => 'admin_guru',
            'email' => 'admin.guru@sekolah.id',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role_id' => 2, // guru
            'full_name' => 'Admin Demo Guru',
            'is_active' => 1,
            'tahun_ajaran_id' => null
        ]
    ];
    
    echo "\n📝 Creating/Updating demo users...\n";
    
    foreach ($demoUsers as $user) {
        try {
            // Check if user exists
            $checkStmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $checkStmt->execute([$user['username']]);
            
            if ($checkStmt->rowCount() > 0) {
                // Update existing user
                $updateStmt = $pdo->prepare("
                    UPDATE users SET 
                    email = ?, 
                    password = ?, 
                    role_id = ?, 
                    full_name = ?, 
                    is_active = ?,
                    tahun_ajaran_id = ?,
                    updated_at = NOW() 
                    WHERE username = ?
                ");
                
                $updateStmt->execute([
                    $user['email'],
                    $user['password'],
                    $user['role_id'],
                    $user['full_name'],
                    $user['is_active'],
                    $user['tahun_ajaran_id'],
                    $user['username']
                ]);
                echo "  ✅ Updated user: {$user['username']} - {$user['full_name']}\n";
            } else {
                // Insert new user
                $insertStmt = $pdo->prepare("
                    INSERT INTO users (username, email, password, role_id, full_name, is_active, tahun_ajaran_id, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                ");
                
                $insertStmt->execute([
                    $user['username'],
                    $user['email'],
                    $user['password'],
                    $user['role_id'],
                    $user['full_name'],
                    $user['is_active'],
                    $user['tahun_ajaran_id']
                ]);
                echo "  ✅ Created user: {$user['username']} - {$user['full_name']}\n";
            }
        } catch (PDOException $e) {
            echo "  ❌ Error processing user {$user['username']}: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n🎉 Demo setup complete!\n";
    echo "=== AKUN DEMO GURU ===\n";
    echo "Username: demo_guru / Password: demo123\n";
    echo "Username: guru_demo / Password: password123\n";
    echo "Username: admin_guru / Password: admin123\n\n";
    echo "Login di: http://localhost/smartbk/app-guru/public/login\n";
    echo "Atau: http://[your-domain]/smartbk/app-guru/public/login\n";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    echo "Please check database configuration in .env file.\n";
    exit(1);
}
?>
