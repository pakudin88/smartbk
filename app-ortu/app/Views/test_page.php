<?= $this->extend('layouts/modern_layout') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4><i class="fas fa-check-circle me-2"></i>Test Page - App Ortu</h4>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="fas fa-cogs fa-3x text-success mb-3"></i>
                    <h5>Aplikasi App-Ortu Berjalan Normal</h5>
                    <p class="text-muted">Semua komponen sistem telah berhasil dimuat</p>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6>Status Sistem:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>CodeIgniter Framework</li>
                            <li><i class="fas fa-check text-success me-2"></i>Database Connection</li>
                            <li><i class="fas fa-check text-success me-2"></i>Routing System</li>
                            <li><i class="fas fa-check text-success me-2"></i>View Templates</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Informasi Teknis:</h6>
                        <ul class="list-unstyled">
                            <li><small><strong>PHP:</strong> <?= PHP_VERSION ?></small></li>
                            <li><small><strong>CI:</strong> <?= \CodeIgniter\CodeIgniter::CI_VERSION ?></small></li>
                            <li><small><strong>Time:</strong> <?= date('Y-m-d H:i:s') ?></small></li>
                            <li><small><strong>Environment:</strong> <?= ENVIRONMENT ?></small></li>
                        </ul>
                    </div>
                </div>
                
                <hr>
                
                <div class="text-center">
                    <a href="<?= base_url('/') ?>" class="btn btn-primary me-2">
                        <i class="fas fa-home me-2"></i>Halaman Utama
                    </a>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard (Perlu Login)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
