<?php

// Create missing tables for app-murid
$host = 'srv1412.hstgr.io';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';
$database = 'u809035070_simaklah';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Creating missing tables...\n";
    
    // Create tahun_ajaran table if not exists
    $createTahunAjaran = "
    CREATE TABLE IF NOT EXISTS `tahun_ajaran` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `nama_tahun_ajaran` varchar(100) NOT NULL,
        `tahun_mulai` year(4) NOT NULL,
        `tahun_selesai` year(4) NOT NULL,
        `is_active` tinyint(1) DEFAULT 0,
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    
    $pdo->exec($createTahunAjaran);
    echo "✅ tahun_ajaran table created/verified\n";
    
    // Create app_murid table
    $createAppMurid = "
    CREATE TABLE IF NOT EXISTS `app_murid` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `user_id` int(11) unsigned NOT NULL,
        `nisn` varchar(20) DEFAULT NULL,
        `nis` varchar(20) DEFAULT NULL,
        `nama_lengkap` varchar(255) NOT NULL,
        `jenis_kelamin` enum('L','P') NOT NULL,
        `tempat_lahir` varchar(100) DEFAULT NULL,
        `tanggal_lahir` date DEFAULT NULL,
        `alamat` text DEFAULT NULL,
        `no_telepon` varchar(20) DEFAULT NULL,
        `email` varchar(255) DEFAULT NULL,
        `nama_ayah` varchar(255) DEFAULT NULL,
        `nama_ibu` varchar(255) DEFAULT NULL,
        `kelas_id` int(11) DEFAULT NULL,
        `tahun_ajaran_id` int(11) unsigned DEFAULT NULL,
        `status` enum('aktif','tidak_aktif','lulus','pindah') DEFAULT 'aktif',
        `foto` varchar(255) DEFAULT NULL,
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `user_id` (`user_id`),
        KEY `kelas_id` (`kelas_id`),
        KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
        CONSTRAINT `fk_app_murid_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        CONSTRAINT `fk_app_murid_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL,
        CONSTRAINT `fk_app_murid_tahun_ajaran` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    
    $pdo->exec($createAppMurid);
    echo "✅ app_murid table created/verified\n";
    
    // Insert sample tahun ajaran if empty
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM tahun_ajaran");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        $insertTahunAjaran = "
        INSERT INTO `tahun_ajaran` (`nama_tahun_ajaran`, `tahun_mulai`, `tahun_selesai`, `is_active`) VALUES
        ('2024/2025', 2024, 2025, 1),
        ('2023/2024', 2023, 2024, 0),
        ('2025/2026', 2025, 2026, 0);
        ";
        
        $pdo->exec($insertTahunAjaran);
        echo "✅ Sample tahun_ajaran data inserted\n";
    } else {
        echo "✅ tahun_ajaran already has data ({$result['count']} records)\n";
    }
    
    // Insert sample murid data for existing users with role_id=4
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM app_murid");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        // Get students from users table
        $stmt = $pdo->query("SELECT id, username, full_name, email FROM users WHERE role_id = 4 AND is_active = 1 LIMIT 5");
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get active tahun ajaran
        $stmt = $pdo->query("SELECT id FROM tahun_ajaran WHERE is_active = 1 LIMIT 1");
        $tahunAjaran = $stmt->fetch(PDO::FETCH_ASSOC);
        $tahunAjaranId = $tahunAjaran['id'] ?? 1;
        
        // Get some kelas
        $stmt = $pdo->query("SELECT id FROM kelas ORDER BY id LIMIT 3");
        $kelasIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        foreach ($students as $index => $student) {
            $kelasId = $kelasIds[$index % count($kelasIds)] ?? null;
            $nisn = '000' . str_pad($student['id'], 7, '0', STR_PAD_LEFT);
            $nis = str_pad($student['id'], 5, '0', STR_PAD_LEFT);
            
            $insertMurid = "
            INSERT INTO `app_murid` (
                `user_id`, `nisn`, `nis`, `nama_lengkap`, `jenis_kelamin`, 
                `email`, `kelas_id`, `tahun_ajaran_id`, `status`
            ) VALUES (
                {$student['id']}, '$nisn', '$nis', '{$student['full_name']}', 'L', 
                '{$student['email']}', $kelasId, $tahunAjaranId, 'aktif'
            )";
            
            try {
                $pdo->exec($insertMurid);
                echo "✅ Created murid profile for user ID {$student['id']}\n";
            } catch (PDOException $e) {
                echo "⚠️ Skipped user ID {$student['id']}: {$e->getMessage()}\n";
            }
        }
    } else {
        echo "✅ app_murid already has data ({$result['count']} records)\n";
    }
    
    echo "\n=== FINAL CHECK ===\n";
    
    // Final verification
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role_id = 4");
    $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM app_murid");
    $muridCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    echo "Users with role_id=4: $userCount\n";
    echo "app_murid records: $muridCount\n";
    
    // Test join query
    $testQuery = "
    SELECT u.id, u.username, u.full_name, m.nisn, m.nis, k.nama_kelas, ta.nama_tahun_ajaran
    FROM users u
    LEFT JOIN app_murid m ON u.id = m.user_id
    LEFT JOIN kelas k ON m.kelas_id = k.id
    LEFT JOIN tahun_ajaran ta ON m.tahun_ajaran_id = ta.id
    WHERE u.role_id = 4 AND u.is_active = 1
    LIMIT 3
    ";
    
    $stmt = $pdo->query($testQuery);
    echo "\nSample joined data:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['username']}: {$row['full_name']} (NISN: {$row['nisn']}, Kelas: {$row['nama_kelas']})\n";
    }
    
    echo "\n✅ Database setup complete!\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

?>
