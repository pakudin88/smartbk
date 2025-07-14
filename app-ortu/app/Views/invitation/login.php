<?= $this->extend('layouts/modern_layout') ?>

<?= $this->section('content') ?>
<div class="login-container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-xl-5 col-lg-6 col-md-8">
            <!-- Login Card -->
            <div class="card login-card shadow-lg border-0">
                <div class="card-body p-5">
                    <!-- Header Section -->
                    <div class="text-center mb-5">
                        <div class="login-logo mb-4">
                            <div class="logo-container">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        </div>
                        <h2 class="login-title fw-bold text-primary mb-2">Jendela Kemitraan</h2>
                        <p class="login-subtitle text-muted">Portal Kolaborasi Orang Tua & Sekolah</p>
                    </div>

                    <!-- Welcome Message -->
                    <div class="welcome-section mb-4">
                        <div class="alert alert-light border-0" style="background: linear-gradient(135deg, #f8f9ff 0%, #e3f2fd 100%);">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-handshake text-primary fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-primary mb-1">Selamat Datang!</h6>
                                    <small class="text-muted">Akses menggunakan link undangan dari sekolah</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Token Input Form -->
                    <form id="loginForm" class="needs-validation" novalidate>
                        <div class="mb-4">
                            <label for="invitationToken" class="form-label fw-semibold">
                                <i class="fas fa-key me-2 text-primary"></i>Token Undangan
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-ticket-alt text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 ps-0" 
                                       id="invitationToken" 
                                       name="token"
                                       placeholder="Masukkan token undangan Anda"
                                       required>
                                <div class="invalid-feedback">
                                    Token undangan wajib diisi
                                </div>
                            </div>
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Token didapat dari link undangan yang dikirim oleh pihak sekolah
                            </small>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Masuk ke Portal
                            </button>
                        </div>
                    </form>

                    <!-- Demo Access -->
                    <div class="demo-section">
                        <div class="text-center">
                            <div class="divider mb-3">
                                <span class="divider-text text-muted">atau</span>
                            </div>
                            <button onclick="loginDemo()" class="btn btn-outline-info">
                                <i class="fas fa-play-circle me-2"></i>
                                Akses Demo
                            </button>
                        </div>
                    </div>

                    <!-- Features Preview -->
                    <div class="features-preview mt-5">
                        <h6 class="text-center text-muted mb-3">Fitur Portal Kemitraan</h6>
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="feature-item">
                                    <i class="fas fa-chart-bar text-primary mb-2"></i>
                                    <small class="d-block text-muted">Laporan Perkembangan</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="feature-item">
                                    <i class="fas fa-tasks text-success mb-2"></i>
                                    <small class="d-block text-muted">Rencana Aksi</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="feature-item">
                                    <i class="fas fa-comments text-warning mb-2"></i>
                                    <small class="d-block text-muted">Feedback</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="text-center mt-4">
                <div class="card border-0 bg-transparent">
                    <div class="card-body py-3">
                        <p class="text-muted mb-2">
                            <i class="fas fa-question-circle me-1"></i>
                            Butuh bantuan?
                        </p>
                        <small class="text-muted">
                            Hubungi Guru BK atau bagian administrasi sekolah untuk mendapatkan akses
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.login-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    position: relative;
}

.login-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 1px, transparent 1px),
        radial-gradient(circle at 80% 50%, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 50px 50px;
}

.login-card {
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    position: relative;
    z-index: 1;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
}

.logo-container {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.logo-container i {
    font-size: 2.5rem;
    color: white;
}

.login-title {
    font-size: 1.8rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
}

.divider {
    position: relative;
}

.divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e9ecef;
}

.divider-text {
    background: white;
    padding: 0 15px;
    font-size: 0.875rem;
}

.feature-item i {
    font-size: 1.2rem;
}

.input-group-text {
    border-radius: 12px 0 0 12px;
}

.form-control {
    border-radius: 0 12px 12px 0;
}

@media (max-width: 576px) {
    .login-card .card-body {
        padding: 2rem !important;
    }
    
    .login-title {
        font-size: 1.5rem;
    }
    
    .logo-container {
        width: 60px;
        height: 60px;
    }
    
    .logo-container i {
        font-size: 2rem;
    }
}
</style>

<script>
// Form validation and submission
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const token = document.getElementById('invitationToken').value.trim();
    
    // Bootstrap validation
    if (!form.checkValidity()) {
        e.stopPropagation();
        form.classList.add('was-validated');
        return;
    }
    
    if (token) {
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
        submitBtn.disabled = true;
        
        // Redirect with token
        setTimeout(() => {
            window.location.href = '<?= base_url() ?>?token=' + encodeURIComponent(token);
        }, 1000);
    }
});

// Demo login function
function loginDemo() {
    const demoToken = 'DEMO2024ORTU';
    window.location.href = '<?= base_url() ?>?token=' + demoToken;
}

// Auto-fill token from URL if available
window.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');
    if (token) {
        document.getElementById('invitationToken').value = token;
    }
});
</script>
<?= $this->endSection() ?>
