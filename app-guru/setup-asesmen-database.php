<?php
/**
 * Setup Database untuk Fitur Asesmen Bakat Minat
 * Menambahkan tabel-tabel yang diperlukan untuk sistem asesmen
 */

// Database connection
$hostname = 'srv1412.hstgr.io';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';
$database = 'u809035070_simaklah';

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== SETUP DATABASE ASESMEN BAKAT MINAT ===\n\n";

    // 1. Tabel jenis_asesmen - Master data jenis tes
    $sql_jenis_asesmen = "
    CREATE TABLE IF NOT EXISTS jenis_asesmen (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_asesmen VARCHAR(100) NOT NULL,
        kode_asesmen VARCHAR(20) UNIQUE NOT NULL,
        kategori ENUM('bakat', 'minat', 'kepribadian', 'gaya_belajar') NOT NULL,
        deskripsi TEXT,
        durasi_menit INT DEFAULT 60,
        jumlah_soal INT DEFAULT 50,
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";
    
    $conn->exec($sql_jenis_asesmen);
    echo "✅ Tabel 'jenis_asesmen' berhasil dibuat\n";

    // 2. Tabel asesmen_bakat_minat - Data hasil tes siswa
    $sql_asesmen = "
    CREATE TABLE IF NOT EXISTS asesmen_bakat_minat (
        id INT AUTO_INCREMENT PRIMARY KEY,
        siswa_id INT NOT NULL,
        jenis_asesmen_id INT NOT NULL,
        guru_id INT NOT NULL,
        sesi_id VARCHAR(50),
        kategori_bakat VARCHAR(50),
        kategori_minat VARCHAR(50),
        skor_detail JSON,
        hasil_interpretasi TEXT,
        rekomendasi_jurusan TEXT,
        keterangan TEXT,
        waktu_mulai TIMESTAMP NULL,
        waktu_selesai TIMESTAMP NULL,
        status ENUM('pending', 'berlangsung', 'selesai', 'dibatalkan') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
        FOREIGN KEY (jenis_asesmen_id) REFERENCES jenis_asesmen(id) ON DELETE CASCADE,
        FOREIGN KEY (guru_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB";
    
    $conn->exec($sql_asesmen);
    echo "✅ Tabel 'asesmen_bakat_minat' berhasil dibuat\n";

    // 3. Tabel sesi_asesmen - Manajemen sesi tes online
    $sql_sesi = "
    CREATE TABLE IF NOT EXISTS sesi_asesmen (
        id INT AUTO_INCREMENT PRIMARY KEY,
        kode_sesi VARCHAR(50) UNIQUE NOT NULL,
        jenis_asesmen_id INT NOT NULL,
        guru_id INT NOT NULL,
        nama_sesi VARCHAR(100) NOT NULL,
        kelas_target VARCHAR(50),
        tanggal_sesi DATE NOT NULL,
        waktu_mulai TIME NOT NULL,
        durasi_menit INT NOT NULL,
        batas_waktu TIMESTAMP,
        status ENUM('draft', 'aktif', 'berlangsung', 'selesai', 'dibatalkan') DEFAULT 'draft',
        jumlah_peserta INT DEFAULT 0,
        instruksi_khusus TEXT,
        allow_retake BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (jenis_asesmen_id) REFERENCES jenis_asesmen(id) ON DELETE CASCADE,
        FOREIGN KEY (guru_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB";
    
    $conn->exec($sql_sesi);
    echo "✅ Tabel 'sesi_asesmen' berhasil dibuat\n";

    // 4. Tabel rekomendasi_jurusan - Master data rekomendasi jurusan
    $sql_rekomendasi = "
    CREATE TABLE IF NOT EXISTS rekomendasi_jurusan (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_jurusan VARCHAR(100) NOT NULL,
        jenjang ENUM('SMA/MA', 'SMK', 'Perguruan Tinggi') NOT NULL,
        kategori_bakat VARCHAR(50),
        kategori_minat VARCHAR(50),
        deskripsi TEXT,
        prospek_karir TEXT,
        mata_pelajaran_pendukung JSON,
        universitas_rekomendasi JSON,
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";
    
    $conn->exec($sql_rekomendasi);
    echo "✅ Tabel 'rekomendasi_jurusan' berhasil dibuat\n";

    // Insert sample data jenis asesmen
    $sample_jenis = [
        ['Holland RIASEC', 'HOLLAND', 'minat', 'Tes minat berdasarkan teori Holland dengan 6 tipe kepribadian: Realistic, Investigative, Artistic, Social, Enterprising, Conventional', 60, 60],
        ['Gardner Multiple Intelligence', 'GARDNER', 'bakat', 'Tes kecerdasan majemuk Gardner untuk mengidentifikasi 8 jenis kecerdasan', 45, 80],
        ['MBTI Personality Test', 'MBTI', 'kepribadian', 'Tes kepribadian Myers-Briggs Type Indicator untuk mengidentifikasi 16 tipe kepribadian', 50, 70],
        ['Gaya Belajar VAK', 'VAK', 'gaya_belajar', 'Tes gaya belajar Visual, Auditory, Kinesthetic', 30, 30],
        ['Tes Bakat Scholastic', 'SCHOLASTIC', 'bakat', 'Tes bakat akademik untuk bidang sains, matematika, dan bahasa', 90, 100]
    ];

    $stmt = $conn->prepare("INSERT INTO jenis_asesmen (nama_asesmen, kode_asesmen, kategori, deskripsi, durasi_menit, jumlah_soal) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE nama_asesmen = VALUES(nama_asesmen)");
    
    foreach ($sample_jenis as $jenis) {
        $stmt->execute($jenis);
    }
    echo "✅ Sample data jenis asesmen berhasil diinsert\n";

    // Insert sample rekomendasi jurusan
    $sample_rekomendasi = [
        ['Teknik Informatika', 'Perguruan Tinggi', 'Logis-Matematis', 'Investigative', 'Program studi yang mempelajari teknologi informasi dan komputer', 'Software Engineer, Data Scientist, Web Developer', '["Matematika", "Fisika", "TIK"]', '["ITB", "UI", "UGM", "ITS"]'],
        ['Psikologi', 'Perguruan Tinggi', 'Interpersonal', 'Social', 'Ilmu yang mempelajari perilaku dan mental manusia', 'Psikolog, HR Specialist, Konselor', '["Biologi", "Sosiologi", "Bahasa Indonesia"]', '["UI", "UGM", "UNPAD", "UNAIR"]'],
        ['Desain Komunikasi Visual', 'Perguruan Tinggi', 'Visual-Spasial', 'Artistic', 'Program studi yang menggabungkan seni, desain, dan komunikasi', 'Graphic Designer, UI/UX Designer, Creative Director', '["Seni Budaya", "TIK", "Bahasa Inggris"]', '["ITB", "IKJ", "ISI", "FSRD"]'],
        ['Teknik Mesin', 'SMK', 'Kinestetik', 'Realistic', 'Bidang keahlian yang mempelajari mesin dan teknologi otomotif', 'Teknisi Mesin, Operator Alat Berat, Montir', '["Matematika", "Fisika", "Kimia"]', '["SMK Negeri 1", "SMK Teknik", "SMK Otomotif"]'],
        ['Akuntansi', 'Perguruan Tinggi', 'Logis-Matematis', 'Conventional', 'Ilmu yang mempelajari pencatatan dan pelaporan keuangan', 'Akuntan, Auditor, Financial Analyst', '["Matematika", "Ekonomi", "TIK"]', '["UI", "UGM", "UNPAD", "FE"]']
    ];

    $stmt2 = $conn->prepare("INSERT INTO rekomendasi_jurusan (nama_jurusan, jenjang, kategori_bakat, kategori_minat, deskripsi, prospek_karir, mata_pelajaran_pendukung, universitas_rekomendasi) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE nama_jurusan = VALUES(nama_jurusan)");
    
    foreach ($sample_rekomendasi as $rek) {
        $stmt2->execute($rek);
    }
    echo "✅ Sample data rekomendasi jurusan berhasil diinsert\n";

    // Insert sample hasil tes (dummy data)
    $sample_hasil = [
        [1, 1, 2, 'Holland-2025-001', 'Realistic', 'Realistic', '{"R": 85, "I": 65, "A": 45, "S": 55, "E": 70, "C": 60}', 'Siswa memiliki kecenderungan kuat pada bidang Realistic dengan minat pada pekerjaan praktis dan teknis', 'Teknik Mesin, Teknik Sipil, Pertanian', 'selesai'],
        [2, 2, 2, 'Gardner-2025-001', 'Logis-Matematis', 'Investigative', '{"Linguistic": 70, "Logical": 90, "Spatial": 75, "Musical": 50, "Bodily": 60, "Interpersonal": 65, "Intrapersonal": 80, "Naturalistic": 55}', 'Siswa menunjukkan kecerdasan logis-matematis yang tinggi dengan kemampuan analisis yang baik', 'Matematika, Teknik Informatika, Fisika', 'selesai'],
        [3, 1, 2, 'Holland-2025-002', 'Artistic', 'Artistic', '{"R": 45, "I": 55, "A": 90, "S": 70, "E": 60, "C": 40}', 'Siswa memiliki bakat artistik yang tinggi dengan kreativitas dan imajinasi yang kuat', 'Desain Grafis, Seni Rupa, Arsitektur', 'selesai']
    ];

    $stmt3 = $conn->prepare("INSERT INTO asesmen_bakat_minat (siswa_id, jenis_asesmen_id, guru_id, sesi_id, kategori_bakat, kategori_minat, skor_detail, hasil_interpretasi, rekomendasi_jurusan, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE siswa_id = VALUES(siswa_id)");
    
    foreach ($sample_hasil as $hasil) {
        $stmt3->execute($hasil);
    }
    echo "✅ Sample data hasil asesmen berhasil diinsert\n";

    echo "\n=== SETUP DATABASE ASESMEN SELESAI ===\n";
    echo "Semua tabel dan data sample untuk fitur Asesmen Bakat Minat telah berhasil dibuat!\n\n";

    // Tampilkan ringkasan
    echo "RINGKASAN TABEL YANG DIBUAT:\n";
    echo "1. jenis_asesmen - Master jenis tes (5 records)\n";
    echo "2. asesmen_bakat_minat - Hasil tes siswa (3 sample records)\n";
    echo "3. sesi_asesmen - Manajemen sesi tes online\n";
    echo "4. rekomendasi_jurusan - Master rekomendasi jurusan (5 records)\n\n";

} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
