<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('content') ?>
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <h2 class="auth-title">Portal Guru</h2>
        <p class="auth-subtitle">Smart BookKeeping - Sistem Manajemen Sekolah</p>
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
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <ul class="mb-0 ps-3">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="<?= base_url('/authenticate') ?>" method="POST" class="auth-form">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label for="username" class="form-label">
                <i class="fas fa-user me-2"></i>Username
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="username" 
                name="username" 
                value="<?= old('username') ?>" 
                placeholder="Masukkan username guru Anda"
                required
            >
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">
                <i class="fas fa-lock me-2"></i>Password
            </label>
            <div class="input-group">
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="password" 
                    placeholder="Masukkan password Anda"
                    required
                >
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        
        <button type="submit" class="btn btn-login">
            <i class="fas fa-sign-in-alt me-2"></i>Login ke Dashboard
        </button>
        
    </form>
    
    <!-- Demo Users Section -->
    <div class="demo-section">
        <h6 class="demo-title">
            <i class="fas fa-users me-2"></i>
            Akun Demo
        </h6>
        
        <div class="demo-note">
            <i class="fas fa-info-circle me-1"></i>
            Tersedia akun demo untuk testing sistem
        </div>
    </div>
    
    <div class="auth-footer">
        <i class="fas fa-shield-alt me-2"></i>
        Portal khusus guru yang terdaftar di sistem Smart BookKeeping<br>
        <small class="text-muted">Autentikasi menggunakan database users - v1.0 (2025)</small>
    </div>
</div>
<?= $this->endSection() ?>
