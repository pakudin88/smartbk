<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-radar me-3"></i>Radar Kelas
        </h1>
        <p class="page-subtitle">Sistem pelaporan cepat dan senyap untuk monitoring siswa</p>
    </div>
    <div class="btn-group" role="group">
        <a href="<?= base_url('/radar-kelas/lapor-cepat') ?>" class="btn btn-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>Lapor Cepat
        </a>
        <a href="<?= base_url('/radar-kelas/riwayat-sinyal') ?>" class="btn btn-outline-primary">
            <i class="fas fa-history me-2"></i>Riwayat
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stats-card">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #e53e3e, #c53030);">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stats-number">12</div>
                <div class="stats-label">Laporan Bulan Ini</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stats-card">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #ed8936, #dd6b20);">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-number">8</div>
                <div class="stats-label">Siswa Dilaporkan</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stats-card">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #3182ce, #2c5282);">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-number">24</div>
                <div class="stats-label">Jam Response Time</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stats-card">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #38a169, #2f855a);">
                    <i class="fas fa-check"></i>
                </div>
                <div class="stats-number">15</div>
                <div class="stats-label">Kasus Ditangani</div>
            </div>
        </div>
    </div>
</div>

<!-- Radar Kelas Features -->
<div class="row">
    <div class="col-md-6">
        <div class="dashboard-card">
            <div class="card-body p-4">
                <h5 class="mb-4">
                    <i class="fas fa-bolt me-2"></i>Lapor Cepat & Senyap
                </h5>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Rahasia & Aman</strong><br>
                    Laporan Anda akan dikirim langsung ke Wali Kelas dan Guru BK secara rahasia.
                </div>
                
                <div class="d-grid gap-2">
                    <a href="<?= base_url('/radar-kelas/lapor-cepat') ?>" class="btn btn-danger btn-lg">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Buat Laporan Baru
                    </a>
                </div>
                
                <hr>
                
                <h6 class="mb-3">Kategori Laporan:</h6>
                <div class="row">
                    <div class="col-4 text-center">
                        <div class="category-icon academic">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <small class="d-block mt-2">Akademik</small>
                    </div>
                    <div class="col-4 text-center">
                        <div class="category-icon social">
                            <i class="fas fa-users"></i>
                        </div>
                        <small class="d-block mt-2">Sosial</small>
                    </div>
                    <div class="col-4 text-center">
                        <div class="category-icon behavior">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <small class="d-block mt-2">Perilaku</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="dashboard-card">
            <div class="card-body p-4">
                <h5 class="mb-4">
                    <i class="fas fa-history me-2"></i>Riwayat Sinyal Pribadi
                </h5>
                
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-badge bg-warning">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Ahmad Fauzi - Perilaku</h6>
                            <small class="text-muted">2 jam yang lalu</small>
                            <p class="mb-0 mt-1">Sering terlambat masuk kelas setelah istirahat...</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-badge bg-info">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Siti Nurhaliza - Akademik</h6>
                            <small class="text-muted">1 hari yang lalu</small>
                            <p class="mb-0 mt-1">Kesulitan memahami materi matematika...</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-badge bg-success">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Budi Santoso - Sosial</h6>
                            <small class="text-muted">3 hari yang lalu</small>
                            <p class="mb-0 mt-1">Terlihat menarik diri dari teman-teman...</p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <a href="<?= base_url('/radar-kelas/riwayat-sinyal') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>Lihat Semua Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Panduan Penggunaan -->
<div class="dashboard-card">
    <div class="card-body p-4">
        <h5 class="mb-4">
            <i class="fas fa-question-circle me-2"></i>Panduan Radar Kelas
        </h5>
        
        <div class="row">
            <div class="col-md-4">
                <div class="guide-step">
                    <div class="step-number">1</div>
                    <h6>Identifikasi Masalah</h6>
                    <p>Amati dan identifikasi masalah atau kekhawatiran pada siswa Anda.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="guide-step">
                    <div class="step-number">2</div>
                    <h6>Lapor Cepat</h6>
                    <p>Gunakan form "Lapor Cepat & Senyap" untuk melaporkan dalam kurang dari 1 menit.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="guide-step">
                    <div class="step-number">3</div>
                    <h6>Tindak Lanjut</h6>
                    <p>Wali Kelas dan Guru BK akan menerima notifikasi dan menindaklanjuti.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
.category-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 1.2rem;
}

.category-icon.academic {
    background: linear-gradient(135deg, #3182ce, #2c5282);
}

.category-icon.social {
    background: linear-gradient(135deg, #38a169, #2f855a);
}

.category-icon.behavior {
    background: linear-gradient(135deg, #ed8936, #dd6b20);
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e2e8f0;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-badge {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.8rem;
}

.timeline-content {
    background: #f8fafc;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #667eea;
}

.guide-step {
    text-align: center;
    padding: 20px;
}

.step-number {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-weight: bold;
    font-size: 1.1rem;
}
</style>
<?= $this->endSection() ?>
