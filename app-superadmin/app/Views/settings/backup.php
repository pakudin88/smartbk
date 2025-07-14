<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .backup-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .backup-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px 15px 0 0;
        color: white;
        padding: 1.5rem;
    }
    
    .backup-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .btn-create-backup {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-create-backup:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .backup-file {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .backup-file:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .backup-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .backup-details h6 {
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .backup-meta {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .backup-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-sm {
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .alert {
        border-radius: 10px;
        border: none;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 4rem;
        opacity: 0.3;
        margin-bottom: 1rem;
    }
    
    .file-size {
        background: #e9ecef;
        padding: 0.25rem 0.5rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #495057;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-database text-primary me-2"></i>
            Backup & Restore
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('settings') ?>">Pengaturan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Backup</li>
            </ol>
        </nav>
    </div>

    <!-- Backup Header -->
    <div class="backup-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="h4 mb-2">
                    <i class="fas fa-shield-alt me-2"></i>
                    Kelola Backup Database
                </h2>
                <p class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Buat backup database secara berkala untuk menjaga keamanan data Anda
                </p>
            </div>
            <div class="col-md-4 text-center">
                <i class="fas fa-database" style="font-size: 4rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Create Backup Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card backup-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Buat Backup Baru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-2">Backup Database Sistem</h6>
                            <p class="text-muted mb-3">
                                Backup akan mencakup semua data dalam database termasuk users, roles, dan konfigurasi sistem.
                                Proses backup biasanya memakan waktu beberapa menit tergantung ukuran database.
                            </p>
                            <small class="text-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Pastikan tidak ada proses penting yang sedang berjalan saat membuat backup.
                            </small>
                        </div>
                        <div class="col-md-4 text-center">
                            <form action="<?= base_url('settings/backup') ?>" method="post" id="backupForm">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-create-backup" id="createBackupBtn">
                                    <i class="fas fa-database me-2"></i>
                                    Buat Backup Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup Files List -->
    <div class="row">
        <div class="col-12">
            <div class="card backup-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-archive me-2"></i>
                            File Backup Tersedia
                        </h5>
                        <span class="badge bg-light text-dark">
                            <?= count($backupFiles) ?> file
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($backupFiles)): ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h6>Belum Ada File Backup</h6>
                            <p>Belum ada file backup yang tersedia. Buat backup pertama Anda sekarang!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($backupFiles as $file): ?>
                            <div class="backup-file">
                                <div class="backup-info">
                                    <div class="backup-details">
                                        <h6>
                                            <i class="fas fa-file-archive text-primary me-2"></i>
                                            <?= esc($file['name']) ?>
                                        </h6>
                                        <div class="backup-meta">
                                            <span class="me-3">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= date('d/m/Y H:i:s', strtotime($file['date'])) ?>
                                            </span>
                                            <span class="file-size">
                                                <i class="fas fa-weight me-1"></i>
                                                <?= number_format($file['size'] / 1024, 2) ?> KB
                                            </span>
                                        </div>
                                    </div>
                                    <div class="backup-actions">
                                        <a href="<?= base_url('settings/backup/download/' . $file['name']) ?>" 
                                           class="btn btn-success btn-sm" 
                                           title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="<?= base_url('settings/backup/delete/' . $file['name']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus file backup ini?')"
                                           title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup Guidelines -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card backup-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        Panduan Backup
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-success">
                                <i class="fas fa-check-circle me-2"></i>
                                Best Practices
                            </h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Buat backup secara berkala (harian/mingguan)
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-cloud text-primary me-2"></i>
                                    Simpan backup di lokasi yang aman dan terpisah
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-test-tube text-primary me-2"></i>
                                    Test backup secara berkala
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-tags text-primary me-2"></i>
                                    Beri nama backup yang mudah diidentifikasi
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Perhatian
                            </h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-pause text-warning me-2"></i>
                                    Jangan membuat backup saat sistem sedang sibuk
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-hdd text-warning me-2"></i>
                                    Pastikan ruang disk mencukupi
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-shield-alt text-warning me-2"></i>
                                    File backup mengandung data sensitif
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-trash text-warning me-2"></i>
                                    Hapus backup lama secara berkala
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const backupForm = document.getElementById('backupForm');
    const createBackupBtn = document.getElementById('createBackupBtn');
    
    if (backupForm && createBackupBtn) {
        backupForm.addEventListener('submit', function(e) {
            // Konfirmasi sebelum membuat backup
            if (!confirm('Apakah Anda yakin ingin membuat backup database sekarang?')) {
                e.preventDefault();
                return false;
            }
            
            // Loading state
            createBackupBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuat Backup...';
            createBackupBtn.disabled = true;
            
            // Show progress message
            const progressAlert = document.createElement('div');
            progressAlert.className = 'alert alert-info alert-dismissible fade show mt-3';
            progressAlert.innerHTML = `
                <i class="fas fa-info-circle me-2"></i>
                Proses backup sedang berjalan. Mohon tunggu beberapa saat...
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            backupForm.appendChild(progressAlert);
        });
    }
    
    // Auto refresh backup list setiap 30 detik jika ada proses backup
    if (window.location.search.includes('creating=true')) {
        setTimeout(function() {
            window.location.reload();
        }, 30000);
    }
});

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>
<?= $this->endSection() ?>
