<?= $this->extend('layouts/modern_layout') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-warning">
            <div class="card-header bg-warning text-white">
                <h4><i class="fas fa-exclamation-triangle me-2"></i><?= $title ?></h4>
            </div>
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="fas fa-times-circle" style="font-size: 4rem; color: #ffc107; margin-bottom: 1rem;"></i>
                    <h5 class="text-warning mb-3"><?= $message ?></h5>
                </div>
                
                <div class="alert alert-light">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Apa yang harus dilakukan?</strong><br>
                    • Pastikan link undangan yang Anda terima adalah yang terbaru<br>
                    • Hubungi Guru BK atau pihak sekolah untuk mendapatkan undangan baru<br>
                    • Periksa masa berlaku undangan Anda
                </div>
                
                <a href="/" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
