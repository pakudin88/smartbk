<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>

<style>
    /* Dashboard Specific Styling */
    .dashboard-welcome {
        background: linear-gradient(135deg, #4A90E2 0%, #2196F3 100%);
        border-radius: 16px;
        color: white;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 8px 32px rgba(74, 144, 226, 0.3);
        position: relative;
        overflow: hidden;
    }

    .dashboard-welcome::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .dashboard-welcome::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .stats-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }

    .stats-icon.blue {
        background: linear-gradient(135deg, #E3F2FD, #BBDEFB);
        color: #2196F3;
    }

    .stats-icon.green {
        background: linear-gradient(135deg, #E8F5E8, #C8E6C9);
        color: #4CAF50;
    }

    .stats-icon.orange {
        background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
        color: #FF9800;
    }

    .stats-icon.purple {
        background: linear-gradient(135deg, #F3E5F5, #E1BEE7);
        color: #9C27B0;
    }

    .activity-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
        overflow: hidden;
    }

    .activity-header {
        background: linear-gradient(135deg, #F8F9FA 0%, #FFFFFF 100%);
        padding: 20px 24px;
        border-bottom: 1px solid #E9ECEF;
    }

    .activity-item {
        padding: 16px 24px;
        border-bottom: 1px solid #F5F5F5;
        transition: background-color 0.3s ease;
    }

    .activity-item:hover {
        background-color: #F8F9FA;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        margin-right: 16px;
    }

    .info-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
        overflow: hidden;
    }

    .info-header {
        background: linear-gradient(135deg, #F8F9FA 0%, #FFFFFF 100%);
        padding: 20px 24px;
        border-bottom: 1px solid #E9ECEF;
    }

    .info-body {
        padding: 24px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge.success {
        background: #E8F5E8;
        color: #2E7D32;
    }

    .status-badge.warning {
        background: #FFF3E0;
        color: #F57C00;
    }

    .status-badge.info {
        background: #E3F2FD;
        color: #1976D2;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2C3E50;
        margin-bottom: 8px;
    }

    .page-subtitle {
        color: #6C757D;
        font-size: 1.1rem;
        margin-bottom: 0;
    }

    .btn-elegant {
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .btn-elegant.btn-primary {
        background: linear-gradient(135deg, #4A90E2 0%, #2196F3 100%);
        border: none;
        color: white;
    }

    .btn-elegant.btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
    }

    .btn-elegant.btn-outline-primary {
        border-color: #4A90E2;
        color: #4A90E2;
        background: transparent;
    }

    .btn-elegant.btn-outline-primary:hover {
        background: #4A90E2;
        color: white;
        transform: translateY(-2px);
    }
</style>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-tachometer-alt me-3"></i>Dashboard Guru
        </h1>
        <p class="page-subtitle">Selamat datang di portal SmartBK - Sistem Bimbingan Konseling</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('/profile') ?>" class="btn btn-elegant btn-outline-primary">
            <i class="fas fa-user me-2"></i>Profil
        </a>
        <a href="#" class="btn btn-elegant btn-primary">
            <i class="fas fa-cog me-2"></i>Pengaturan
        </a>
    </div>
</div>

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

<!-- Welcome Section -->
<div class="dashboard-welcome">
    <div class="welcome-content">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-3">
                    <i class="fas fa-hand-wave me-2"></i>Selamat Datang, <?= esc($user_name) ?>!
                </h2>
                <p class="mb-3 opacity-90">Anda berhasil login ke portal guru SmartBK. Semua fitur siap digunakan.</p>
                <div class="d-flex flex-wrap gap-3">
                    <span class="badge bg-white bg-opacity-25 px-3 py-2 fs-6">
                        <i class="fas fa-user me-1"></i>Username: <?= esc($username) ?>
                    </span>
                    <span class="badge bg-white bg-opacity-25 px-3 py-2 fs-6">
                        <i class="fas fa-envelope me-1"></i>Email: <?= esc($email) ?>
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <i class="fas fa-graduation-cap" style="font-size: 120px; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<section class="mb-5">
    <h3 class="mb-4">
        <i class="fas fa-bolt text-warning me-2"></i>Aksi Cepat
    </h3>
    <div class="row g-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-icon blue mx-auto">
                    <i class="fas fa-database"></i>
                </div>
                <h5 class="fw-bold mb-2">Data Siswa</h5>
                <p class="text-muted small mb-3">Kelola data siswa</p>
                <a href="<?= base_url('data-siswa') ?>" class="btn btn-elegant btn-primary btn-sm">
                    <i class="fas fa-arrow-right me-1"></i>Akses
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-icon green mx-auto">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h5 class="fw-bold mb-2">Nilai Rapor</h5>
                <p class="text-muted small mb-3">Input nilai siswa</p>
                <a href="<?= base_url('nilai-rapor') ?>" class="btn btn-elegant btn-primary btn-sm">
                    <i class="fas fa-arrow-right me-1"></i>Akses
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-icon orange mx-auto">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h5 class="fw-bold mb-2">Jadwal Mengajar</h5>
                <p class="text-muted small mb-3">Lihat jadwal mengajar</p>
                <a href="<?= base_url('jadwal-mengajar') ?>" class="btn btn-elegant btn-primary btn-sm">
                    <i class="fas fa-arrow-right me-1"></i>Akses
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-icon purple mx-auto">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h5 class="fw-bold mb-2">Laporan</h5>
                <p class="text-muted small mb-3">Laporan akademik</p>
                <a href="<?= base_url('laporan') ?>" class="btn btn-elegant btn-primary btn-sm">
                    <i class="fas fa-arrow-right me-1"></i>Akses
                </a>
            </div>
        </div>
    </div>
</section>

<div class="row g-4">
    <!-- Recent Activities -->
    <div class="col-lg-8">
        <div class="activity-card">
            <div class="activity-header">
                <h4 class="mb-0">
                    <i class="fas fa-clock text-primary me-2"></i>Aktivitas Terbaru
                </h4>
            </div>
            <div class="activity-body">
                <div class="activity-item d-flex align-items-start">
                    <div class="activity-icon bg-success text-white">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Sistem Aktif!</h6>
                        <p class="text-muted small mb-1">Anda berhasil login ke portal guru SmartBK. Semua fitur siap digunakan.</p>
                        <small class="text-muted">Baru saja</small>
                    </div>
                </div>
                
                <div class="activity-item d-flex align-items-start">
                    <div class="activity-icon bg-primary text-white">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Login Berhasil</h6>
                        <p class="text-muted small mb-1">15 Jul 2025, 15:13 WIB</p>
                        <small class="text-muted">Login terakhir</small>
                    </div>
                </div>
                
                <div class="activity-item d-flex align-items-start">
                    <div class="activity-icon bg-info text-white">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Database Terhubung</h6>
                        <p class="text-muted small mb-1">Koneksi ke database remote berhasil</p>
                        <small class="text-muted">Status terkini</small>
                    </div>
                </div>
                
                <div class="activity-item d-flex align-items-start">
                    <div class="activity-icon bg-warning text-white">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Data Sinkronisasi</h6>
                        <p class="text-muted small mb-1">Data statistik berhasil dimuat</p>
                        <small class="text-muted">Selesai diperbarui</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- System Info -->
    <div class="col-lg-4">
        <div class="info-card">
            <div class="info-header">
                <h4 class="mb-0">
                    <i class="fas fa-info-circle text-info me-2"></i>Informasi Sistem
                </h4>
            </div>
            <div class="info-body">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Status Database:</label>
                    <div>
                        <span class="status-badge success">
                            <i class="fas fa-check-circle me-1"></i>Connected
                        </span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Login Terakhir:</label>
                    <div class="text-dark">15 Jul 2025, 15:13 WIB</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Role:</label>
                    <div>
                        <span class="status-badge info">
                            <i class="fas fa-user me-1"></i>Guru
                        </span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted">Versi Sistem:</label>
                    <div class="text-dark">SmartBK v1.0</div>
                </div>
                
                <a href="<?= base_url('profile') ?>" class="btn btn-elegant btn-outline-primary w-100">
                    <i class="fas fa-edit me-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
