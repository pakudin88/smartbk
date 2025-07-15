<?php
/**
 * Demo Authorization System untuk Asesmen Bakat Minat
 * Menunjukkan bahwa fitur asesmen hanya bisa diakses oleh Guru BK
 */

// Simulasi session
session_start();

// Simulasi data user dengan role berbeda
$test_users = [
    'guru_mapel' => [
        'username' => 'guru_mapel',
        'full_name' => 'Budi Guru Mapel',
        'user_role' => 'guru_mapel',
        'access_asesmen' => false
    ],
    'wali_kelas' => [
        'username' => 'wali_kelas', 
        'full_name' => 'Sari Wali Kelas',
        'user_role' => 'wali_kelas',
        'access_asesmen' => false
    ],
    'guru_bk' => [
        'username' => 'guru_bk',
        'full_name' => 'Andi Guru BK',
        'user_role' => 'guru_bk',
        'access_asesmen' => true
    ],
    'kepala_sekolah' => [
        'username' => 'kepala_sekolah',
        'full_name' => 'Pak Kepala Sekolah', 
        'user_role' => 'kepala_sekolah',
        'access_asesmen' => false
    ]
];

// Ambil role dari parameter
$selected_role = $_GET['role'] ?? 'guru_bk';
$current_user = $test_users[$selected_role] ?? $test_users['guru_bk'];

// Simulasi cek authorization
function checkAsesmenAccess($user_role) {
    return $user_role === 'guru_bk';
}

$has_access = checkAsesmenAccess($current_user['user_role']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Authorization Asesmen BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .demo-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 1000px;
            margin: 0 auto;
        }
        .role-badge {
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .role-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .role-guru_mapel { background: #007bff; color: white; }
        .role-wali_kelas { background: #28a745; color: white; }
        .role-guru_bk { background: #dc3545; color: white; }
        .role-kepala_sekolah { background: #ffc107; color: black; }
        .access-granted { border: 3px solid #28a745; background: #d4edda; }
        .access-denied { border: 3px solid #dc3545; background: #f8d7da; }
    </style>
</head>
<body>
    <div class="demo-container">
        <div class="text-center mb-4">
            <h1><i class="fas fa-shield-alt text-primary"></i> Demo Authorization System</h1>
            <p class="lead">Fitur Asesmen Bakat Minat - Khusus Guru BK</p>
        </div>

        <!-- Role Selector -->
        <div class="text-center mb-4">
            <h4>Pilih Role untuk Testing:</h4>
            <div class="d-flex flex-wrap justify-content-center">
                <?php foreach ($test_users as $role => $user): ?>
                    <a href="?role=<?= $role ?>" class="role-badge role-<?= $role ?> <?= $role === $selected_role ? 'fw-bold border border-dark' : '' ?>">
                        <?= $user['full_name'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Current User Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card <?= $has_access ? 'access-granted' : 'access-denied' ?>">
                    <div class="card-body">
                        <h5><i class="fas fa-user"></i> User Saat Ini</h5>
                        <p class="mb-1"><strong>Nama:</strong> <?= $current_user['full_name'] ?></p>
                        <p class="mb-1"><strong>Role:</strong> <?= ucfirst(str_replace('_', ' ', $current_user['user_role'])) ?></p>
                        <p class="mb-0">
                            <strong>Status Akses:</strong> 
                            <?php if ($has_access): ?>
                                <span class="badge bg-success"><i class="fas fa-check"></i> DIIZINKAN</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><i class="fas fa-times"></i> DITOLAK</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-info">
                    <div class="card-body">
                        <h5><i class="fas fa-info-circle"></i> Aturan Akses</h5>
                        <p class="mb-1">✅ <strong>Guru BK:</strong> Akses penuh</p>
                        <p class="mb-1">❌ <strong>Guru Mapel:</strong> Tidak ada akses</p>
                        <p class="mb-1">❌ <strong>Wali Kelas:</strong> Tidak ada akses</p>
                        <p class="mb-0">❌ <strong>Kepala Sekolah:</strong> Tidak ada akses</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Access Test Result -->
        <div class="card <?= $has_access ? 'border-success' : 'border-danger' ?>">
            <div class="card-header <?= $has_access ? 'bg-success text-white' : 'bg-danger text-white' ?>">
                <h5 class="mb-0">
                    <i class="fas fa-<?= $has_access ? 'unlock' : 'lock' ?>"></i>
                    Hasil Test Akses Asesmen Bakat Minat
                </h5>
            </div>
            <div class="card-body">
                <?php if ($has_access): ?>
                    <div class="alert alert-success">
                        <h4><i class="fas fa-check-circle"></i> AKSES DIBERIKAN</h4>
                        <p>Selamat datang, <strong><?= $current_user['full_name'] ?></strong>!</p>
                        <p>Sebagai Guru BK, Anda memiliki akses penuh ke fitur Asesmen Bakat Minat:</p>
                        <ul>
                            <li><i class="fas fa-brain"></i> Dashboard Asesmen</li>
                            <li><i class="fas fa-laptop-code"></i> Tes Bakat Minat Online</li>
                            <li><i class="fas fa-poll"></i> Hasil Tes Siswa</li>
                            <li><i class="fas fa-chart-pie"></i> Analisis Bakat Minat</li>
                            <li><i class="fas fa-lightbulb"></i> Rekomendasi Jurusan</li>
                            <li><i class="fas fa-file-pdf"></i> Laporan Asesmen</li>
                        </ul>
                        <a href="../public/index.php/asesmen-bakat-minat" class="btn btn-success">
                            <i class="fas fa-arrow-right"></i> Akses Asesmen Bakat Minat
                        </a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <h4><i class="fas fa-times-circle"></i> AKSES DITOLAK</h4>
                        <p>Maaf, <strong><?= $current_user['full_name'] ?></strong>.</p>
                        <p>Sebagai <strong><?= ucfirst(str_replace('_', ' ', $current_user['user_role'])) ?></strong>, Anda tidak memiliki akses ke fitur Asesmen Bakat Minat.</p>
                        <div class="bg-light p-3 rounded">
                            <strong>Alasan:</strong> Fitur asesmen bakat minat merupakan layanan khusus yang diberikan oleh Guru BK untuk membantu siswa dalam menentukan pilihan jurusan dan karir sesuai dengan bakat dan minat mereka.
                        </div>
                        <div class="mt-3">
                            <p><strong>Saran:</strong></p>
                            <ul>
                                <li>Hubungi Guru BK untuk mendapat hasil asesmen siswa</li>
                                <li>Gunakan menu sesuai dengan role Anda</li>
                                <li>Berkolaborasi dengan Guru BK dalam bimbingan siswa</li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Authorization Code Example -->
        <div class="mt-4">
            <div class="card border-secondary">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-code"></i> Contoh Kode Authorization</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>// Di Controller AsesmenBakatMinat.php
private function checkBKAuthorization()
{
    if (!$this->session->get('guru_logged_in')) {
        return redirect()->to('/login');
    }

    if ($this->session->get('user_role') !== 'guru_bk') {
        return redirect()->to('/dashboard')
            ->with('error', 'Akses ditolak. Fitur khusus Guru BK.');
    }

    return null; // Access granted
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
