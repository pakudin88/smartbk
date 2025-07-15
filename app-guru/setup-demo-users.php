<?php
/**
 * Script untuk setup demo users di database
 * Jalankan sekali untuk membuat data demo
 */

// Database configuration
$host = 'localhost';
$dbname = 'sekolah_multiapp';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to database: $dbname\n";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        echo "❌ Table 'users' not found. Please run migrations first.\n";
        echo "Run: php spark migrate\n";
        exit(1);
    }
    
    // Check existing users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $count = $stmt->fetch()['total'];
    
    if ($count > 0) {
        echo "✅ Found $count existing users in database\n";
        echo "Demo users might already exist. Checking...\n";
        
        $stmt = $pdo->query("SELECT username, role, full_name FROM users LIMIT 10");
        while ($row = $stmt->fetch()) {
            echo "  - {$row['username']} ({$row['role']}) - {$row['full_name']}\n";
        }
    } else {
        echo "📝 Creating demo users...\n";
        
        // Demo users data
        $demoUsers = [
            [
                'username' => 'admin',
                'email' => 'admin@sekolah.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'kepala_sekolah',
                'full_name' => 'Dr. Ahmad Kepala Sekolah',
                'nip' => '19701010 199203 1 001'
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
