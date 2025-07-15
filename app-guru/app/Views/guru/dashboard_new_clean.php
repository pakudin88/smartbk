<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Guru BK - SmartBK</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>
<body class="bg-light">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('/dashboard') ?>">
            <i class="fas fa-graduation-cap me-2"></i>SmartBK
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('/dashboard') ?>">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/konseling') ?>">
                        <i class="fas fa-users me-1"></i>Konseling
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/asesmen') ?>">
                        <i class="fas fa-clipboard-list me-1"></i>Asesmen
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>Guru BK
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= base_url('/profile') ?>"><i class="fas fa-user me-2"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid" style="margin-top: 80px;">
    <div class="row">
        <div class="col-12">
            
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-user-friends me-3 text-primary"></i>Dashboard Guru BK
                    </h1>
                    <p class="text-muted">Selamat datang di sistem Bimbingan dan Konseling SmartBK</p>
                </div>
                <div class="btn-group" role="group">
                    <a href="<?= base_url('/profile') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-user me-2"></i>Profil
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="fas fa-cog me-2"></i>Pengaturan
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Welcome Card -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="text-primary mb-2">
                                <i class="fas fa-hand-wave me-2"></i>Selamat Datang, Guru BK!
                            </h4>
                            <p class="mb-2">Anda berhasil login ke sistem Bimbingan dan Konseling SmartBK.</p>
                            <div class="d-flex flex-wrap gap-3 mt-3">
                                <span class="badge bg-primary px-3 py-2">
                                    <i class="fas fa-users me-1"></i>Siswa Terbimbing: <?= isset($stats['siswa_terbimbing']) ? $stats['siswa_terbimbing'] : '145' ?>
                                </span>
                                <span class="badge bg-success px-3 py-2">
                                    <i class="fas fa-calendar-check me-1"></i>Sesi Konseling: <?= isset($stats['sesi_konseling']) ? $stats['sesi_konseling'] : '28' ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-friends fs-2"></i>
                            </div>
                            <h6 class="text-muted mt-2">Portal Guru BK Aktif</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-users fs-4"></i>
                            </div>
                            <h3 class="fw-bold mb-1"><?= isset($stats['siswa_terbimbing']) ? number_format($stats['siswa_terbimbing']) : '145' ?></h3>
                            <p class="text-muted mb-0">Siswa Terbimbing</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-comments fs-4"></i>
                            </div>
                            <h3 class="fw-bold mb-1"><?= isset($stats['sesi_konseling']) ? number_format($stats['sesi_konseling']) : '28' ?></h3>
                            <p class="text-muted mb-0">Sesi Konseling</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-exclamation-triangle fs-4"></i>
                            </div>
                            <h3 class="fw-bold mb-1"><?= isset($stats['kasus_prioritas']) ? number_format($stats['kasus_prioritas']) : '7' ?></h3>
                            <p class="text-muted mb-0">Kasus Prioritas</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-info bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-clipboard-check fs-4"></i>
                            </div>
                            <h3 class="fw-bold mb-1"><?= isset($stats['asesmen_selesai']) ? number_format($stats['asesmen_selesai']) : '42' ?></h3>
                            <p class="text-muted mb-0">Asesmen Selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat Konseling
                    </h5>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?= base_url('/konseling/individual') ?>" class="btn btn-outline-primary w-100 p-3 text-decoration-none">
                                <i class="fas fa-user d-block mb-2 fs-2"></i>
                                <strong>Konseling Individual</strong><br>
                                <small>Sesi konseling perorangan</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?= base_url('/konseling/kelompok') ?>" class="btn btn-outline-success w-100 p-3 text-decoration-none">
                                <i class="fas fa-users d-block mb-2 fs-2"></i>
                                <strong>Konseling Kelompok</strong><br>
                                <small>Bimbingan kelompok siswa</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?= base_url('/asesmen') ?>" class="btn btn-outline-warning w-100 p-3 text-decoration-none">
                                <i class="fas fa-clipboard-list d-block mb-2 fs-2"></i>
                                <strong>Asesmen</strong><br>
                                <small>Tes psikologi & bakat</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?= base_url('/bimbingan-karir') ?>" class="btn btn-outline-info w-100 p-3 text-decoration-none">
                                <i class="fas fa-briefcase d-block mb-2 fs-2"></i>
                                <strong>Bimbingan Karir</strong><br>
                                <small>Panduan pilihan karir</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Activities -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-line me-2"></i>Trend Konseling
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="counselingTrendChart" height="100"></canvas>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clock me-2"></i>Aktivitas Terbaru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex align-items-center border-0">
                                    <div class="rounded-circle bg-success d-flex align-items-center justify-content-center text-white me-3" style="width: 35px; height: 35px;">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Login Berhasil</h6>
                                        <small class="text-muted"><?= date('d M Y, H:i') ?> WIB</small>
                                    </div>
                                </div>
                                
                                <div class="list-group-item d-flex align-items-center border-0">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-3" style="width: 35px; height: 35px;">
                                        <i class="fas fa-database"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Sistem Siap</h6>
                                        <small class="text-muted">Portal Guru BK aktif dan siap digunakan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-pie me-2"></i>Jenis Konseling
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="counselingTypeChart" height="200"></canvas>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>Jadwal Hari Ini
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center text-muted">
                                <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                <p>Tidak ada jadwal hari ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counseling Trend Chart
    const trendCtx = document.getElementById('counselingTrendChart');
    if (trendCtx) {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Sesi Konseling',
                    data: [12, 19, 15, 25, 22, 28],
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Counseling Type Chart
    const typeCtx = document.getElementById('counselingTypeChart');
    if (typeCtx) {
        new Chart(typeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Individual', 'Kelompok', 'Karir'],
                datasets: [{
                    data: [45, 30, 25],
                    backgroundColor: ['#0d6efd', '#198754', '#fd7e14'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
});
</script>

</body>
</html>
