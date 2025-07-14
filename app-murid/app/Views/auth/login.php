<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login - Safe Space' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        
        .login-title {
            color: #333;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }
        
        .login-subtitle {
            color: #666;
            font-size: 1rem;
            font-weight: 400;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 2;
        }
        
        .form-control {
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            padding: 15px 15px 15px 45px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .form-control::placeholder {
            color: #999;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            z-index: 2;
        }
        
        .password-toggle:hover {
            color: #667eea;
        }
        
        .form-check {
            margin: 20px 0;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .form-check-label {
            color: #666;
            font-size: 0.95rem;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            padding: 15px;
            width: 100%;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }
        
        .demo-credentials {
            background: rgba(102, 126, 234, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-top: 25px;
            text-align: center;
        }
        
        .demo-credentials h6 {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .demo-item {
            background: white;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            font-size: 0.9rem;
            color: #666;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .demo-item:last-child {
            margin-bottom: 0;
        }
        
        .demo-label {
            font-weight: 500;
            color: #333;
        }
        
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            opacity: 0.1;
        }
        
        .shape-1 {
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape-2 {
            top: 20%;
            right: 10%;
            width: 150px;
            height: 150px;
            background: linear-gradient(45deg, #f093fb, #f5576c);
            border-radius: 30%;
            animation: float 8s ease-in-out infinite reverse;
        }
        
        .shape-3 {
            bottom: 20%;
            left: 20%;
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            border-radius: 20px;
            animation: float 7s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 25px;
                margin: 10px;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
            
            .login-logo {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="login-container">
        <!-- Login Header -->
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-shield-heart"></i>
            </div>
            <h1 class="login-title">Safe Space</h1>
            <p class="login-subtitle">Masuk ke Ruang Aman Anda</p>
        </div>

        <!-- Error/Success Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form id="loginForm" action="<?= base_url('login') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <i class="fas fa-user input-group-icon"></i>
                    <input type="text" 
                           class="form-control" 
                           id="username" 
                           name="username" 
                           placeholder="Masukkan username Anda"
                           value="<?= old('username') ?>"
                           required>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <i class="fas fa-lock input-group-icon"></i>
                    <input type="password" 
                           class="form-control" 
                           id="password" 
                           name="password" 
                           placeholder="Masukkan password Anda"
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="passwordIcon"></i>
                    </button>
                </div>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn btn-login" id="loginBtn">
                <span id="loginText">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Masuk
                </span>
                <span id="loginLoading" style="display: none;">
                    <i class="fas fa-spinner fa-spin me-2"></i>
                    Memproses...
                </span>
            </button>
        </form>

        <!-- Demo Credentials -->
        <div class="demo-credentials">
            <h6><i class="fas fa-key me-2"></i>Demo Login Siswa</h6>
            <div class="demo-item" onclick="fillLogin('siswa001', '123456')">
                <span class="demo-label">Ahmad Rizki:</span>
                <span>siswa001 / 123456</span>
            </div>
            <div class="demo-item" onclick="fillLogin('siti_nurhaliza', '123456')">
                <span class="demo-label">Siti Nurhaliza:</span>
                <span>siti_nurhaliza / 123456</span>
            </div>
            <div class="demo-item" onclick="fillLogin('dimas_prakoso', '123456')">
                <span class="demo-label">Dimas Prakoso:</span>
                <span>dimas_prakoso / 123456</span>
            </div>
            <small class="text-muted mt-2 d-block">
                <i class="fas fa-info-circle me-1"></i>
                Klik salah satu akun demo untuk login otomatis
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Form Submit Handler
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginBtn = document.getElementById('loginBtn');
            const loginText = document.getElementById('loginText');
            const loginLoading = document.getElementById('loginLoading');
            
            // Show loading state
            loginBtn.disabled = true;
            loginText.style.display = 'none';
            loginLoading.style.display = 'inline';
            
            // Optional: Add timeout to re-enable button if something goes wrong
            setTimeout(() => {
                loginBtn.disabled = false;
                loginText.style.display = 'inline';
                loginLoading.style.display = 'none';
            }, 10000);
        });

        // Fill login form with demo credentials
        function fillLogin(username, password) {
            document.getElementById('username').value = username;
            document.getElementById('password').value = password;
            
            // Add visual feedback
            const usernameField = document.getElementById('username');
            const passwordField = document.getElementById('password');
            
            usernameField.style.background = '#e7f3ff';
            passwordField.style.background = '#e7f3ff';
            
            setTimeout(() => {
                usernameField.style.background = '';
                passwordField.style.background = '';
            }, 1000);
        }

        // Auto-fill demo credentials (legacy support)
        document.addEventListener('DOMContentLoaded', function() {
            const demoItems = document.querySelectorAll('.demo-item');
            
            demoItems.forEach(item => {
                // Skip items that already have onclick
                if (item.hasAttribute('onclick')) return;
                
                item.addEventListener('click', function() {
                    const label = this.querySelector('.demo-label').textContent.toLowerCase();
                    const value = this.querySelector('span:last-child').textContent;
                    
                    if (label.includes('username')) {
                        document.getElementById('username').value = value;
                    } else if (label.includes('password')) {
                        document.getElementById('password').value = value;
                    }
                    
                    // Add visual feedback
                    this.style.background = '#667eea';
                    this.style.color = 'white';
                    setTimeout(() => {
                        this.style.background = 'white';
                        this.style.color = '';
                    }, 200);
                });
            });
        });

        // Input focus effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>
