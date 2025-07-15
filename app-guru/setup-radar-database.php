<?php
/**
 * Script untuk membuat tabel-tabel fitur Radar Kelas dan Pusat Kendali Konseling
 * Jalankan sekali untuk membuat struktur database
 */

// Database configuration - Remote Server
$host = 'srv1412.hstgr.io';
$dbname = 'u809035070_simaklah';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';
$port = 3306;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to remote database: $dbname\n";
    
    // Tabel untuk laporan radar kelas
    $createRadarLaporan = "
    CREATE TABLE IF NOT EXISTS radar_laporan (
        id INT AUTO_INCREMENT PRIMARY KEY,
        guru_id INT NOT NULL,
        siswa_id INT NOT NULL,
        wali_id INT NULL,
        bk_id INT NULL,
        kategori ENUM('Akademik', 'Sosial', 'Perilaku') NOT NULL,
        tingkat_prioritas ENUM('Rendah', 'Sedang', 'Tinggi') NOT NULL,
        prioritas_bk ENUM('Rendah', 'Sedang', 'Tinggi', 'Urgent') NULL,
        deskripsi TEXT NOT NULL,
        status ENUM('Baru', 'Dalam Proses', 'Eskalasi BK', 'Dalam Konseling', 'Selesai', 'Butuh Tindak Lanjut') DEFAULT 'Baru',
        tindakan_wali ENUM('Pantau', 'Tindak Lanjut Pribadi', 'Eskalasi ke BK') NULL,
        catatan_wali TEXT NULL,
        label_bk VARCHAR(50) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_guru_id (guru_id),
        INDEX idx_siswa_id (siswa_id),
        INDEX idx_status (status),
        INDEX idx_kategori (kategori),
        INDEX idx_prioritas (tingkat_prioritas)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    // Tabel untuk log konseling terenkripsi
    $createKonselingLog = "
    CREATE TABLE IF NOT EXISTS konseling_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        kasus_id INT NOT NULL,
        bk_id INT NOT NULL,
        jenis_sesi ENUM('Konseling Individual', 'Konseling Kelompok', 'Observasi', 'Home Visit') NOT NULL,
        ringkasan_sesi TEXT NOT NULL COMMENT 'Data terenkripsi base64',
        analisis TEXT NOT NULL COMMENT 'Data terenkripsi base64',
        rencana_intervensi TEXT NOT NULL COMMENT 'Data terenkripsi base64',
        evaluasi_kemajuan TEXT NULL COMMENT 'Data terenkripsi base64',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_kasus_id (kasus_id),
        INDEX idx_bk_id (bk_id),
        FOREIGN KEY (kasus_id) REFERENCES radar_laporan(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    // Tabel untuk notifikasi sistem
    $createNotifikasi = "
    CREATE TABLE IF NOT EXISTS radar_notifikasi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        laporan_id INT NOT NULL,
        jenis ENUM('Laporan Baru', 'Eskalasi', 'Update Status', 'Tindak Lanjut') NOT NULL,
        pesan TEXT NOT NULL,
        is_read BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user_id (user_id),
        INDEX idx_is_read (is_read),
        FOREIGN KEY (laporan_id) REFERENCES radar_laporan(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    // Tabel untuk tracking aktivitas
    $createAktivitasLog = "
    CREATE TABLE IF NOT EXISTS radar_aktivitas_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        laporan_id INT NOT NULL,
        aktivitas ENUM('Buat Laporan', 'Update Status', 'Tambah Catatan', 'Eskalasi', 'Selesai') NOT NULL,
        deskripsi TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user_id (user_id),
        INDEX idx_laporan_id (laporan_id),
        INDEX idx_aktivitas (aktivitas),
        FOREIGN KEY (laporan_id) REFERENCES radar_laporan(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    // Execute table creation
    echo "\n📝 Creating tables...\n";
    
    $pdo->exec($createRadarLaporan);
    echo "  ✅ Table 'radar_laporan' created/verified\n";
    
    $pdo->exec($createKonselingLog);
    echo "  ✅ Table 'konseling_log' created/verified\n";
    
    $pdo->exec($createNotifikasi);
    echo "  ✅ Table 'radar_notifikasi' created/verified\n";
    
    $pdo->exec($createAktivitasLog);
    echo "  ✅ Table 'radar_aktivitas_log' created/verified\n";
    
    // Insert sample data
    echo "\n📊 Inserting sample data...\n";
    
    // Sample laporan data
    $sampleLaporan = [
        [
            'guru_id' => 1,
            'siswa_id' => 2,
            'kategori' => 'Akademik',
            'tingkat_prioritas' => 'Sedang',
            'deskripsi' => 'Siswa sering tidak mengerjakan tugas matematika dan terlihat kesulitan memahami materi aljabar.'
        ],
        [
            'guru_id' => 1,
            'siswa_id' => 3,
            'kategori' => 'Sosial',
            'tingkat_prioritas' => 'Tinggi',
            'deskripsi' => 'Siswa terlihat menarik diri dari teman-teman dan sering menyendiri saat istirahat.'
        ],
        [
            'guru_id' => 1,
            'siswa_id' => 4,
            'kategori' => 'Perilaku',
            'tingkat_prioritas' => 'Rendah',
            'deskripsi' => 'Siswa kadang terlambat masuk kelas setelah jam istirahat, namun tidak mengganggu proses belajar.'
        ]
    ];
    
    $insertLaporan = $pdo->prepare("
        INSERT INTO radar_laporan (guru_id, siswa_id, kategori, tingkat_prioritas, deskripsi, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, NOW(), NOW())
    ");
    
    foreach ($sampleLaporan as $laporan) {
        try {
            $insertLaporan->execute([
                $laporan['guru_id'],
                $laporan['siswa_id'],
                $laporan['kategori'],
                $laporan['tingkat_prioritas'],
                $laporan['deskripsi']
            ]);
            echo "  ✅ Sample laporan inserted for siswa_id: {$laporan['siswa_id']}\n";
        } catch (PDOException $e) {
            if ($e->getCode() != 23000) { // Skip duplicate entry errors
                echo "  ⚠️  Error inserting sample data: " . $e->getMessage() . "\n";
            }
        }
    }
    
    // Check final table status
    echo "\n📋 Database status:\n";
    
    $tables = ['radar_laporan', 'konseling_log', 'radar_notifikasi', 'radar_aktivitas_log'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
        $count = $stmt->fetch()['count'];
        echo "  - $table: $count records\n";
    }
    
    echo "\n🎉 Database setup complete!\n";
    echo "Struktur database untuk fitur Radar Kelas dan Pusat Kendali Konseling siap digunakan.\n";
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
