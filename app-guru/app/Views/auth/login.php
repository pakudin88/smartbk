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
    
    <?= form_open(base_url('/authenticate'), ['class' => 'auth-form']) ?>
        
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
        
    <?= form_close() ?>
    
    <div class="auth-footer">
        <i class="fas fa-info-circle me-2"></i>
        Hanya untuk guru yang terdaftar di sistem<br>
        <small class="text-muted">Smart BookKeeping v1.0 - 2025</small>
    </div>
</div>
<?= $this->endSection() ?>
