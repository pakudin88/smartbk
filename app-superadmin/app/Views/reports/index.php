<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Laporan Sistem</h1>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-4">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-title">Total Pengguna</div>
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #3b82f6, #1e40af);">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <h2 class="stat-card-value"><?= number_format($stats['total_users']) ?></h2>
        <p class="stat-card-change">
            <i class="fas fa-arrow-up me-1"></i>
            Semua pengguna terdaftar
        </p>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-title">Total Sekolah</div>
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                <i class="fas fa-school"></i>
            </div>
        </div>
        <h2 class="stat-card-value"><?= number_format($stats['total_schools']) ?></h2>
        <p class="stat-card-change">
            <i class="fas fa-arrow-up me-1"></i>
            Aktif: <?= number_format($stats['active_schools']) ?>
        </p>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-title">Total Kelas</div>
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <i class="fas fa-chalkboard"></i>
            </div>
        </div>
        <h2 class="stat-card-value"><?= number_format($stats['total_classes']) ?></h2>
        <p class="stat-card-change">
            <i class="fas fa-arrow-up me-1"></i>
            Aktif: <?= number_format($stats['active_classes']) ?>
        </p>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-title">Total Mata Pelajaran</div>
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                <i class="fas fa-book"></i>
            </div>
        </div>
        <h2 class="stat-card-value"><?= number_format($stats['total_subjects']) ?></h2>
        <p class="stat-card-change">
            <i class="fas fa-arrow-up me-1"></i>
            Aktif: <?= number_format($stats['active_subjects']) ?>
        </p>
    </div>
</div>

<!-- Report Menu -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Laporan Pengguna</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Laporan data pengguna sistem berdasarkan role dan status</p>
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('reports/users') ?>" class="btn btn-primary">
                        <i class="fas fa-eye me-2"></i>Lihat Laporan
                    </a>
                    <a href="<?= base_url('reports/export/users') ?>" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Laporan Sekolah</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Laporan data sekolah yang terdaftar dalam sistem</p>
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('reports/schools') ?>" class="btn btn-primary">
                        <i class="fas fa-eye me-2"></i>Lihat Laporan
                    </a>
                    <a href="<?= base_url('reports/export/schools') ?>" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Laporan Kelas</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Laporan data kelas berdasarkan sekolah dan tingkat</p>
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('reports/classes') ?>" class="btn btn-primary">
                        <i class="fas fa-eye me-2"></i>Lihat Laporan
                    </a>
                    <a href="<?= base_url('reports/export/classes') ?>" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Laporan Mata Pelajaran</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Laporan data mata pelajaran berdasarkan kategori dan tingkat</p>
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('reports/subjects') ?>" class="btn btn-primary">
                        <i class="fas fa-eye me-2"></i>Lihat Laporan
                    </a>
                    <a href="<?= base_url('reports/export/subjects') ?>" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
