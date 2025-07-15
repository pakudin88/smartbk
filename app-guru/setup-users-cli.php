<?php

// Bootstrap CodeIgniter
require_once __DIR__ . '/vendor/codeigniter4/framework/system/bootstrap.php';

// Load the environment
$app = \Config\Services::codeigniter();
$app->initialize();
$app->setContext('php-cli');

use CodeIgniter\CLI\CLI;

CLI::write('Setting up demo users for app-guru...', 'green');

try {
    $db = \Config\Database::connect();
    
    // Check if users table exists
    if (!$db->tableExists('users')) {
        CLI::error('Table "users" not found. Please run migrations first:');
        CLI::write('php spark migrate');
        exit(1);
    }
    
    // Check existing users
    $count = $db->table('users')->countAll();
    
    if ($count > 0) {
        CLI::write("Found $count existing users in database");
        CLI::write('Demo users might already exist. Checking...');
        
        $users = $db->table('users')->limit(10)->get()->getResultArray();
        foreach ($users as $user) {
            CLI::write("  - {$user['username']} ({$user['role']}) - {$user['full_name']}");
        }
    } else {
        CLI::write('Creating demo users...');
        
        // Demo users data
        $demoUsers = [
            [
                'username' => 'admin',
                'email' => 'admin@sekolah.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'kepala_sekolah',
                'full_name' => 'Dr. Ahmad Kepala Sekolah',
                'nip' => '19701010 199203 1 001',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'guru1',
                'email' => 'guru1@sekolah.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'guru_mapel',
                'full_name' => 'Siti Rahayu, S.Pd',
                'nip' => '19800515 200604 2 002',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'wali1',
                'email' => 'wali1@sekolah.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'wali_kelas',
                'full_name' => 'Budi Santoso, S.Pd',
                'nip' => '19750820 199803 1 003',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'bk1',
                'email' => 'bk1@sekolah.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'guru_bk',
                'full_name' => 'Rina Wijaya, S.Psi',
                'nip' => '19850310 200912 2 004',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'mapel1',
                'email' => 'mapel1@sekolah.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'guru_mapel',
                'full_name' => 'Joko Wahyudi, S.Pd',
                'nip' => '19780625 200103 1 005',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        foreach ($demoUsers as $user) {
            try {
                $db->table('users')->insert($user);
                CLI::write("  ✅ Created user: {$user['username']} ({$user['role']}) - {$user['full_name']}", 'green');
            } catch (\Exception $e) {
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    CLI::write("  ⚠️  User {$user['username']} already exists", 'yellow');
                } else {
                    CLI::error("  ❌ Error creating user {$user['username']}: " . $e->getMessage());
                }
            }
        }
    }
    
    CLI::write('', 'white');
    CLI::write('🎉 Demo setup complete!', 'green');
    CLI::write('You can now test login with:');
    CLI::write('  Username: admin / Password: password123 (Kepala Sekolah)');
    CLI::write('  Username: guru1 / Password: password123 (Guru Mapel)');
    CLI::write('  Username: wali1 / Password: password123 (Wali Kelas)');
    CLI::write('  Username: bk1 / Password: password123 (Guru BK)');
    CLI::write('  Username: mapel1 / Password: password123 (Guru Mapel)');
    
} catch (\Exception $e) {
    CLI::error('❌ Database error: ' . $e->getMessage());
    CLI::write('Please make sure database is properly configured and accessible.');
    exit(1);
}
