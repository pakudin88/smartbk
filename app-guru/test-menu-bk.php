<?php
/**
 * Test file untuk melihat menu sistem BK
 * Simulasi login dengan role berbeda
 */

// Simulasi session untuk testing
session_start();

// Simulasi data user dengan role yang berbeda
$test_users = [
    'guru_mapel' => [
        'username' => 'guru_mapel',
        'full_name' => 'Budi Guru Mapel',
        'user_role' => 'guru_mapel'
    ],
    'wali_kelas' => [
        'username' => 'wali_kelas',
        'full_name' => 'Sari Wali Kelas',
        'user_role' => 'wali_kelas'
    ],
    'guru_bk' => [
        'username' => 'guru_bk',
        'full_name' => 'Andi Guru BK',
        'user_role' => 'guru_bk'
    ],
    'kepala_sekolah' => [
        'username' => 'kepala_sekolah',
        'full_name' => 'Pak Kepala Sekolah',
        'user_role' => 'kepala_sekolah'
    ]
];

// Ambil role dari parameter GET atau default ke guru_bk
$selected_role = $_GET['role'] ?? 'guru_bk';
$current_user = $test_users[$selected_role] ?? $test_users['guru_bk'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Menu Sistem BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .test-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 1200px;
            margin: 0 auto;
        }
        .role-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin: 5px;
        }
        .role-guru_mapel { background: #007bff; color: white; }
        .role-wali_kelas { background: #28a745; color: white; }
        .role-guru_bk { background: #dc3545; color: white; }
        .role-kepala_sekolah { background: #ffc107; color: black; }
        .menu-preview {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <div class="text-center mb-4">
            <h1><i class="fas fa-heart text-danger"></i> Sistem Bimbingan Konseling</h1>
            <p class="lead">Test Menu Berdasarkan Role</p>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <h3>Pilih Role untuk Testing:</h3>
                <div class="d-flex flex-wrap">
                    <?php foreach ($test_users as $role => $user): ?>
                        <a href="?role=<?= $role ?>" class="role-badge role-<?= $role ?> <?= $role === $selected_role ? 'fw-bold' : '' ?>">
                            <?= $user['full_name'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-info">
                    <h5><i class="fas fa-user"></i> User Saat Ini:</h5>
                    <strong><?= $current_user['full_name'] ?></strong><br>
                    <small>Role: <?= $current_user['user_role'] ?></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-success">
                    <h5><i class="fas fa-info-circle"></i> Informasi:</h5>
                    Sistem akan menampilkan menu sesuai dengan role yang dipilih.
                    Anda dapat mengubah filter di sidebar.
                </div>
            </div>
        </div>

        <div class="menu-preview">
            <h4><i class="fas fa-list"></i> Preview Menu untuk Role: <?= ucfirst(str_replace('_', ' ', $selected_role)) ?></h4>
            
            <?php if ($selected_role === 'guru_mapel'): ?>
                <div class="border-start border-primary border-3 ps-3 mb-3">
                    <h6 class="text-primary"><i class="fas fa-search"></i> Deteksi Dini Siswa</h6>
                    <ul class="list-unstyled ms-3">
                        <li><i class="fas fa-radar"></i> Monitor Perilaku</li>
                        <li><i class="fas fa-exclamation-triangle"></i> Laporan Masalah Siswa</li>
                        <li><i class="fas fa-history"></i> Riwayat Laporan</li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($selected_role === 'wali_kelas'): ?>
                <div class="border-start border-success border-3 ps-3 mb-3">
                    <h6 class="text-success"><i class="fas fa-users-cog"></i> Pendampingan Kelas</h6>
                    <ul class="list-unstyled ms-3">
                        <li><i class="fas fa-clipboard-list"></i> Dashboard Kelas</li>
                        <li><i class="fas fa-exclamation-circle"></i> Masalah Siswa Kelas</li>
                        <li><i class="fas fa-handshake"></i> Konsultasi Orang Tua</li>
                        <li><i class="fas fa-share-alt"></i> Rujukan ke BK</li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($selected_role === 'guru_bk'): ?>
                <div class="border-start border-danger border-3 ps-3 mb-3">
                    <h6 class="text-danger"><i class="fas fa-heart"></i> Layanan Konseling</h6>
                    <ul class="list-unstyled ms-3">
                        <li><i class="fas fa-heart"></i> Dashboard Konseling</li>
                        <li><i class="fas fa-folder-open"></i> Kasus Konseling</li>
                        <li><i class="fas fa-calendar-check"></i> Jadwal Konseling</li>
                        <li><i class="fas fa-user-friends"></i> Konseling Kelompok</li>
                        <li><i class="fas fa-chart-bar"></i> Laporan BK</li>
                    </ul>
                </div>
                
                <div class="border-start border-success border-3 ps-3 mb-3">
                    <h6 class="text-success"><i class="fas fa-brain"></i> Asesmen Bakat Minat (Khusus Guru BK)</h6>
                    <ul class="list-unstyled ms-3">
                        <li><i class="fas fa-brain"></i> Dashboard Asesmen</li>
                        <li><i class="fas fa-laptop-code"></i> Tes Bakat Minat Online</li>
                        <li><i class="fas fa-poll"></i> Hasil Tes Siswa</li>
                        <li><i class="fas fa-chart-pie"></i> Analisis Bakat Minat</li>
                        <li><i class="fas fa-lightbulb"></i> Rekomendasi Jurusan</li>
                        <li><i class="fas fa-file-pdf"></i> Laporan Asesmen</li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($selected_role === 'kepala_sekolah'): ?>
                <div class="border-start border-warning border-3 ps-3 mb-3">
                    <h6 class="text-warning"><i class="fas fa-crown"></i> Supervisi Program BK</h6>
                    <ul class="list-unstyled ms-3">
                        <li><i class="fas fa-chart-line"></i> Overview BK Sekolah</li>
                        <li><i class="fas fa-file-alt"></i> Laporan Program BK</li>
                        <li><i class="fas fa-tasks"></i> Evaluasi Layanan BK</li>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="border-start border-secondary border-3 ps-3 mb-3">
                <h6 class="text-secondary"><i class="fas fa-database"></i> Menu Umum (Semua Role)</h6>
                <ul class="list-unstyled ms-3">
                    <li><i class="fas fa-tachometer-alt"></i> Dashboard Bimbingan Konseling</li>
                    <li><i class="fas fa-users"></i> Data Siswa</li>
                    <li><i class="fas fa-user-graduate"></i> Profil Siswa</li>
                    <li><i class="fas fa-clipboard-list"></i> Asesmen Siswa</li>
                </ul>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="../public/index.php" class="btn btn-primary">
                <i class="fas fa-external-link-alt"></i> Akses Sistem Sebenarnya
            </a>
        </div>
    </div>

    <script>
        // Simulasi session untuk testing
        <?php if ($selected_role): ?>
        sessionStorage.setItem('test_user_role', '<?= $selected_role ?>');
        <?php endif; ?>
    </script>
</body>
</html>
