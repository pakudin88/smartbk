<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-tachometer-alt me-3"></i>Dashboard Guru
        </h1>
        <p class="page-subtitle">Selamat datang di portal guru Smart BookKeeping</p>
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

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Welcome Section -->
<div class="dashboard-card">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="text-primary mb-2">
                    <i class="fas fa-hand-wave me-2"></i>Selamat Datang, <?= esc($user_name) ?>!
                </h4>
                <p class="mb-2">Anda berhasil login ke sistem Smart BookKeeping sebagai Guru.</p>
                <div class="d-flex flex-wrap gap-3 mt-3">
                            <span class="badge bg-primary px-3 py-2">
                                <i class="fas fa-user me-1"></i>Username: <?= esc($username) ?>
                            </span>
                            <span class="badge bg-success px-3 py-2">
                                <i class="fas fa-envelope me-1"></i>Email: <?= esc($email) ?>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h6 class="text-muted">Portal Guru Aktif</h6>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="dashboard-card">
            <div class="stats-card">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stats-number"><?= number_format($stats['total_siswa']) ?></div>
                <div class="stats-label">Total Siswa</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="dashboard-card">
            <div class="stats-card">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #38a169, #2f855a);">
                    <i class="fas fa-school"></i>
                </div>
                <div class="stats-number"><?= number_format($stats['total_kelas']) ?></div>
                <div class="stats-label">Total Kelas</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="dashboard-card">
            <div class="stats-card">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #ed8936, #dd6b20);">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-number"><?= number_format($stats['total_orang_tua']) ?></div>
                <div class="stats-label">Total Orang Tua</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="dashboard-card">
            <div class="stats-card">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #3182ce, #2c5282);">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stats-number"><?= $stats['active_tahun_ajaran'] ?></div>
                <div class="stats-label">Tahun Ajaran</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="dashboard-card">
    <div class="card-body p-4">
        <h5 class="mb-4">
            <i class="fas fa-bolt me-2"></i>Aksi Cepat
        </h5>
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
                <a href="#" class="btn btn-outline-primary w-100 p-3">
                    <i class="fas fa-user-graduate d-block mb-2" style="font-size: 1.5rem;"></i>
                    <strong>Data Siswa</strong><br>
                    <small>Kelola data siswa</small>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <a href="#" class="btn btn-outline-success w-100 p-3">
                    <i class="fas fa-book d-block mb-2" style="font-size: 1.5rem;"></i>
                    <strong>Nilai & Rapor</strong><br>
                    <small>Input nilai siswa</small>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <a href="#" class="btn btn-outline-warning w-100 p-3">
                    <i class="fas fa-calendar-alt d-block mb-2" style="font-size: 1.5rem;"></i>
                            <strong>Jadwal</strong><br>
                            <small>Jadwal mengajar</small>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="#" class="btn btn-outline-info w-100 p-3">
                            <i class="fas fa-chart-line d-block mb-2" style="font-size: 1.5rem;"></i>
                            <strong>Laporan</strong><br>
                            <small>Laporan akademik</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-md-8">
        <div class="dashboard-card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>Aktivitas Terbaru
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Sistem Aktif!</strong><br>
                    Anda berhasil login ke portal guru Smart BookKeeping. Semua fitur siap digunakan.
                </div>
                
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex align-items-center">
                        <div class="avatar-sm bg-success rounded-circle me-3">
                            <i class="fas fa-sign-in-alt text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Login Berhasil</h6>
                            <small class="text-muted"><?= date('d M Y, H:i') ?> WIB</small>
                        </div>
                    </div>
                    
                    <div class="list-group-item d-flex align-items-center">
                        <div class="avatar-sm bg-primary rounded-circle me-3">
                            <i class="fas fa-database text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Database Terhubung</h6>
                            <small class="text-muted">Koneksi ke database remote berhasil</small>
                        </div>
                    </div>
                    
                    <div class="list-group-item d-flex align-items-center">
                        <div class="avatar-sm bg-info rounded-circle me-3">
                            <i class="fas fa-sync text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Data Sinkronisasi</h6>
                            <small class="text-muted">Data statistik berhasil dimuat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <strong>Status Database:</strong><br>
                    <span class="badge bg-success">Connected</span>
                </div>
                
                <div class="mb-3">
                    <strong>Login Terakhir:</strong><br>
                    <small class="text-muted"><?= date('d M Y, H:i') ?> WIB</small>
                </div>
                
                <div class="mb-3">
                    <strong>Role:</strong><br>
                    <span class="badge bg-primary">Guru</span>
                </div>
                
                <div class="mb-3">
                    <strong>Versi Sistem:</strong><br>
                    <small class="text-muted">Smart BookKeeping v1.0</small>
                </div>
                
                <hr>
                
                <div class="text-center">
                    <a href="<?= base_url('/profile') ?>" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-user-cog me-1"></i>Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<?= $this->endSection() ?>
