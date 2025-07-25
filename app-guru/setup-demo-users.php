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
            'tahun_ajaran_id' => 1
        ],
        [
            'username' => 'guru_demo',
            'email' => 'guru.demo@sekolah.id', 
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role_id' => 2, // guru
            'full_name' => 'Siti Demo Guru, S.Pd',
            'is_active' => 1,
            'tahun_ajaran_id' => 1
        ],
        [
            'username' => 'admin_guru',
            'email' => 'admin.guru@sekolah.id',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role_id' => 2, // guru
            'full_name' => 'Admin Demo Guru',
            'is_active' => 1,
            'tahun_ajaran_id' => 1
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
            ],
            [
                'username' => 'guru1',
                'email' => 'guru1@sekolah.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'guru_mapel',
                'full_name' => 'Siti Rahayu, S.Pd',
                'nip' => '19800515 200604 2 002'
            ],
            [
                'username' => 'wali1',
                'email' => 'wali1@sekolah.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'wali_kelas',
                'full_name' => 'Budi Santoso, S.Pd',
                'nip' => '19750820 199803 1 003'
            ],
            [
                'username' => 'bk1',
                'email' => 'bk1@sekolah.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'guru_bk',
                'full_name' => 'Rina Wijaya, S.Psi',
                'nip' => '19850310 200912 2 004'
            ],
            [
                'username' => 'mapel1',
                'email' => 'mapel1@sekolah.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'guru_mapel',
                'full_name' => 'Joko Wahyudi, S.Pd',
                'nip' => '19780625 200103 1 005'
            ]
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password, role, full_name, nip, is_active, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, 1, NOW(), NOW())
        ");
        
        foreach ($demoUsers as $user) {
            try {
                $stmt->execute([
                    $user['username'],
                    $user['email'],
                    $user['password'],
                    $user['role'],
                    $user['full_name'],
                    $user['nip']
                ]);
                echo "  ✅ Created user: {$user['username']} ({$user['role']}) - {$user['full_name']}\n";
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Duplicate entry
                    echo "  ⚠️  User {$user['username']} already exists\n";
                } else {
                    echo "  ❌ Error creating user {$user['username']}: " . $e->getMessage() . "\n";
                }
            }
        }
    }
    
    echo "\n🎉 Demo setup complete!\n";
    echo "You can now test login with:\n";
    echo "  Username: admin / Password: password123 (Kepala Sekolah)\n";
    echo "  Username: guru1 / Password: password123 (Guru Mapel)\n";
    echo "  Username: wali1 / Password: password123 (Wali Kelas)\n";
    echo "  Username: bk1 / Password: password123 (Guru BK)\n";
    echo "  Username: mapel1 / Password: password123 (Guru Mapel)\n";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    echo "Please make sure MySQL is running and database '$dbname' exists.\n";
    exit(1);
}
?>
