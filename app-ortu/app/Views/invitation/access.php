<?= $this->extend('layouts/modern_layout') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Welcome Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-envelope-open-text me-2"></i>Selamat Datang di Jendela Kemitraan</h3>
            </div>
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="fas fa-handshake" style="font-size: 4rem; color: #667eea; margin-bottom: 1rem;"></i>
                    <h4 class="text-primary mb-3">Portal Kemitraan Orang Tua & Sekolah</h4>
                    <p class="lead text-muted">
                        Sistem ini memungkinkan kolaborasi yang bermakna antara keluarga dan sekolah 
                        untuk mendukung perkembangan putra/putri Anda.
                    </p>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Akses Berbasis Undangan</strong><br>
                    Untuk mengakses portal ini, Anda memerlukan link undangan khusus dari Guru BK atau pihak sekolah.
                </div>
                
                <div class="row text-start mt-4">
                    <div class="col-md-6">
                        <div class="feature-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-shield-alt text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Privasi Terjaga</h6>
                                    <small class="text-muted">Informasi yang dibagikan sudah dikurasi dengan bijak oleh tim profesional</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="feature-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-users text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Kolaborasi Konstruktif</h6>
                                    <small class="text-muted">Rencana aksi yang jelas untuk kemitraan rumah dan sekolah</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="feature-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-chart-line text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Pantau Progress</h6>
                                    <small class="text-muted">Lihat perkembangan dan berikan feedback secara real-time</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="feature-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-heart text-danger"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Pendekatan Positif</h6>
                                    <small class="text-muted">Fokus pada solusi dan kekuatan, bukan masalah</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Access Instructions -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-key me-2"></i>Cara Mengakses</h3>
            </div>
            <div class="card-body">
                <div class="steps">
                    <div class="step-item d-flex align-items-start mb-3">
                        <div class="step-number me-3">
                            <span class="badge bg-primary rounded-pill">1</span>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Terima Undangan</h6>
                            <p class="text-muted mb-0">Guru BK akan mengirimkan link undangan khusus melalui WhatsApp, email, atau SMS</p>
                        </div>
                    </div>
                    
                    <div class="step-item d-flex align-items-start mb-3">
                        <div class="step-number me-3">
                            <span class="badge bg-primary rounded-pill">2</span>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Klik Link Undangan</h6>
                            <p class="text-muted mb-0">Link akan membawa Anda langsung ke dashboard dengan akses otomatis</p>
                        </div>
                    </div>
                    
                    <div class="step-item d-flex align-items-start mb-3">
                        <div class="step-number me-3">
                            <span class="badge bg-primary rounded-pill">3</span>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Akses Portal</h6>
                            <p class="text-muted mb-0">Lihat ringkasan, rencana aksi, dan berkolaborasi untuk mendukung anak Anda</p>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <i class="fas fa-clock me-2"></i>
                    <strong>Catatan:</strong> Link undangan memiliki masa berlaku terbatas untuk menjaga keamanan data
                </div>
            </div>
        </div>
        
        <!-- Contact Information -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-phone me-2"></i>Butuh Bantuan?</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-item mb-3">
                            <h6 class="fw-bold text-primary">
                                <i class="fas fa-user-tie me-2"></i>Guru BK
                            </h6>
                            <p class="mb-1">Ibu Sarah Wijaya, S.Pd</p>
                            <p class="text-muted mb-0">
                                <i class="fas fa-phone me-1"></i> (021) 1234-5678<br>
                                <i class="fas fa-envelope me-1"></i> bk@sekolah.sch.id
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="contact-item mb-3">
                            <h6 class="fw-bold text-success">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp Support
                            </h6>
                            <p class="mb-1">Tim Dukungan Teknis</p>
                            <p class="text-muted mb-0">
                                <i class="fab fa-whatsapp me-1"></i> +62 812-3456-7890<br>
                                <small>Senin - Jumat: 08:00 - 16:00 WIB</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.feature-icon {
    font-size: 1.2rem;
    width: 30px;
}

.step-number .badge {
    font-size: 0.9rem;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.contact-item {
    padding: 1rem;
    background: rgba(102, 126, 234, 0.05);
    border-radius: 12px;
    border-left: 4px solid #667eea;
}
</style>
<?= $this->endSection() ?>
