<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('content') ?>
<div class="auth-container">
    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1>Jendela Kemitraan</h1>
            <p>Portal Orang Tua & Sekolah</p>
        </div>

        <!-- Login Form -->
        <form action="/authenticate" method="post" class="login-form">
            <?= csrf_field() ?>
            
            <!-- Alert Messages -->
            <?php if (session('error')): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?= session('success') ?>
                </div>
            <?php endif; ?>

            <!-- Username Field -->
            <div class="form-group">
                <label for="username">
                    <i class="fas fa-user"></i>
                    Username
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="<?= old('username') ?>"
                    placeholder="Masukkan username Anda"
                    required
                >
                <?php if (isset($validation) && $validation->hasError('username')): ?>
                    <span class="error"><?= $validation->getError('username') ?></span>
                <?php endif; ?>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i>
                    Password
                </label>
                <div class="password-input">
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        placeholder="Masukkan password Anda"
                        required
                    >
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggle-icon"></i>
                    </button>
                </div>
                <?php if (isset($validation) && $validation->hasError('password')): ?>
                    <span class="error"><?= $validation->getError('password') ?></span>
                <?php endif; ?>
            </div>

            <!-- Remember Me -->
            <div class="form-options">
                <label class="checkbox-container">
                    <input type="checkbox" name="remember">
                    <span class="checkmark"></span>
                    Ingat saya
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                Masuk
            </button>
        </form>

        <!-- Footer -->
        <div class="login-footer">
            <p>Kesulitan login? Hubungi admin sekolah</p>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggle-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
<?= $this->endSection() ?>
