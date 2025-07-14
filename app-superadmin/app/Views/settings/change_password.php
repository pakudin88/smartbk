<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .password-strength {
        height: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
        overflow: hidden;
        margin-top: 5px;
    }
    .password-strength-bar {
        height: 100%;
        transition: all 0.3s ease;
    }
    .strength-weak { background-color: #dc3545; }
    .strength-medium { background-color: #fd7e14; }
    .strength-strong { background-color: #198754; }
    .strength-very-strong { background-color: #0d6efd; }
    
    .form-floating > .form-control {
        height: calc(3.5rem + 2px);
        padding: 1rem 0.75rem;
    }
    
    .form-floating > label {
        padding: 1rem 0.75rem;
    }
    
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px 15px 0 0;
        color: white;
        padding: 1.5rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-secondary {
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
    }
    
    .alert {
        border-radius: 10px;
        border: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-key text-primary me-2"></i>
            Ubah Password
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('settings') ?>">Pengaturan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ubah Password</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Keamanan Akun
                    </h5>
                </div>
                <div class="card-body p-4">
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

                    <form action="<?= base_url('settings/change-password') ?>" method="post" id="changePasswordForm">
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Password Lama" required>
                                <label for="current_password">
                                    <i class="fas fa-lock me-2"></i>Password Lama
                                </label>
                            </div>
                            <?php if (isset($validation) && $validation->hasError('current_password')): ?>
                                <div class="text-danger mt-1">
                                    <small><?= $validation->getError('current_password') ?></small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password Baru" required>
                                <label for="new_password">
                                    <i class="fas fa-key me-2"></i>Password Baru
                                </label>
                            </div>
                            <div class="password-strength mt-2">
                                <div class="password-strength-bar" id="strengthBar"></div>
                            </div>
                            <small class="text-muted">Password minimal 8 karakter dengan kombinasi huruf dan angka</small>
                            <?php if (isset($validation) && $validation->hasError('new_password')): ?>
                                <div class="text-danger mt-1">
                                    <small><?= $validation->getError('new_password') ?></small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
                                <label for="confirm_password">
                                    <i class="fas fa-check-circle me-2"></i>Konfirmasi Password
                                </label>
                            </div>
                            <div id="passwordMatch" class="mt-1"></div>
                            <?php if (isset($validation) && $validation->hasError('confirm_password')): ?>
                                <div class="text-danger mt-1">
                                    <small><?= $validation->getError('confirm_password') ?></small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('settings') ?>" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Simpan Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const strengthBar = document.getElementById('strengthBar');
    const passwordMatch = document.getElementById('passwordMatch');
    const submitBtn = document.getElementById('submitBtn');
    
    // Password strength checker
    newPasswordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = checkPasswordStrength(password);
        
        strengthBar.style.width = strength.percentage + '%';
        strengthBar.className = 'password-strength-bar ' + strength.class;
    });
    
    // Password match checker
    confirmPasswordInput.addEventListener('input', function() {
        const newPassword = newPasswordInput.value;
        const confirmPassword = this.value;
        
        if (confirmPassword.length > 0) {
            if (newPassword === confirmPassword) {
                passwordMatch.innerHTML = '<small class="text-success"><i class="fas fa-check me-1"></i>Password cocok</small>';
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                passwordMatch.innerHTML = '<small class="text-danger"><i class="fas fa-times me-1"></i>Password tidak cocok</small>';
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        } else {
            passwordMatch.innerHTML = '';
            this.classList.remove('is-valid', 'is-invalid');
        }
    });
    
    // Form validation
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('Password baru dan konfirmasi password tidak cocok!');
            return false;
        }
        
        if (newPassword.length < 8) {
            e.preventDefault();
            alert('Password minimal 8 karakter!');
            return false;
        }
        
        // Loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
    });
    
    function checkPasswordStrength(password) {
        let strength = 0;
        let tips = [];
        
        // Length check
        if (password.length >= 8) strength += 25;
        else tips.push('minimal 8 karakter');
        
        // Lowercase check
        if (password.match(/[a-z]/)) strength += 25;
        else tips.push('huruf kecil');
        
        // Uppercase check
        if (password.match(/[A-Z]/)) strength += 25;
        else tips.push('huruf besar');
        
        // Number check
        if (password.match(/[0-9]/)) strength += 25;
        else tips.push('angka');
        
        // Determine strength level
        if (strength <= 25) {
            return { percentage: 25, class: 'strength-weak' };
        } else if (strength <= 50) {
            return { percentage: 50, class: 'strength-medium' };
        } else if (strength <= 75) {
            return { percentage: 75, class: 'strength-strong' };
        } else {
            return { percentage: 100, class: 'strength-very-strong' };
        }
    }
});
</script>
<?= $this->endSection() ?>
