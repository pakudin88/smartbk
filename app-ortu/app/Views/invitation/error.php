<?= $this->extend('layouts/modern_layout') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h4><i class="fas fa-exclamation-circle me-2"></i><?= $title ?></h4>
            </div>
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="fas fa-server" style="font-size: 4rem; color: #dc3545; margin-bottom: 1rem;"></i>
                    <h5 class="text-danger mb-3"><?= $message ?></h5>
                </div>
                
                <div class="alert alert-light">
                    <i class="fas fa-tools me-2"></i>
                    <strong>Langkah yang dapat dilakukan:</strong><br>
                    • Coba muat ulang halaman ini<br>
                    • Tunggu beberapa saat dan coba lagi<br>
                    • Hubungi administrator sekolah jika masalah berlanjut
                </div>
                
                <div class="d-flex gap-2 justify-content-center">
                    <a href="javascript:location.reload()" class="btn btn-secondary">
                        <i class="fas fa-sync-alt me-2"></i>Muat Ulang
                    </a>
                    <a href="/" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
