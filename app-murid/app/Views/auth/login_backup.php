<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login - Aplikasi Murid' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #06b6d4;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --border-radius: 16px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, 
                #f0f9ff 0%, 
                #e0f2fe 25%, 
                #f0fdf4 50%, 
                #fefce8 75%, 
                #fdf2f8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow: hidden;
            line-height: 1.6;
        }
        
        /* Modern animated background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 20%, rgba(37, 99, 235, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 30%, rgba(6, 182, 212, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 70%, rgba(16, 185, 129, 0.06) 0%, transparent 50%),
                radial-gradient(circle at 90% 80%, rgba(245, 158, 11, 0.08) 0%, transparent 50%);
            z-index: -2;
            animation: backgroundFloat 20s ease-in-out infinite;
        }
        
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(37, 99, 235, 0.03) 1px, transparent 1px),
                radial-gradient(circle at 75% 75%, rgba(6, 182, 212, 0.03) 1px, transparent 1px);
            background-size: 50px 50px, 80px 80px;
            z-index: -1;
        }
        
        @keyframes backgroundFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-10px) rotate(1deg); }
            66% { transform: translateY(5px) rotate(-1deg); }
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow-2xl);
            width: 100%;
            max-width: 420px;
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.6s ease-out;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.02) 0%, transparent 50%);
            z-index: -1;
        }
        
        @keyframes slideInUp {
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
            margin-bottom: 2rem;
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }
        
        .login-logo::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
            100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        }
        
        .login-title {
            color: var(--gray-800);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            color: var(--gray-600);
            font-size: 1rem;
            font-weight: 400;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .input-group {
            position: relative;
        }
        
        .form-control {
            border: 2px solid var(--gray-200);
            border-radius: var(--border-radius);
            padding: 0.875rem 1rem 0.875rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            width: 100%;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
            background: rgba(255, 255, 255, 0.95);
        }
        
        .input-group-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            z-index: 5;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus + .input-group-icon {
            color: var(--primary-color);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: var(--border-radius);
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(248, 113, 113, 0.05));
            color: var(--danger-color);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.05));
            color: var(--success-color);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-200);
        }
        
        .demo-credentials {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(6, 182, 212, 0.03));
            border: 1px solid rgba(16, 185, 129, 0.15);
            border-radius: var(--border-radius);
            padding: 1.25rem;
            margin-top: 1.5rem;
            border-left: 4px solid var(--success-color);
        }
        
        .demo-credentials h6 {
            color: var(--success-color);
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }
        
        .demo-credentials p {
            margin: 0.25rem 0;
            font-size: 0.85rem;
            color: var(--gray-600);
        }
        
        .demo-credentials strong {
            color: var(--gray-700);
            font-weight: 600;
        }
        
        /* Responsive design */
        @media (max-width: 480px) {
            .login-container {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
            
            .login-logo {
                width: 70px;
                height: 70px;
                font-size: 1.75rem;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
            
            .login-subtitle {
                font-size: 0.9rem;
            }
            
            .form-control {
                padding: 0.75rem 0.875rem 0.75rem 2.75rem;
            }
            
            .input-group-icon {
                left: 0.875rem;
                font-size: 1rem;
            }
            
            .btn-login {
                padding: 0.75rem 1.25rem;
            }
        }
        
        /* Loading state */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.7;
        }
        
        .btn-login.loading::after {
            content: '';
            width: 16px;
            height: 16px;
            margin-left: 8px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            color: #666;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group .form-control {
            padding-left: 3rem;
        }
        
        .input-group-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            z-index: 5;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
            color: white;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102,126,234,0.3);
            color: white;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #ff7675 0%, #fd79a8 100%);
            color: white;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #00b894 0%, #00cec9 100%);
            color: white;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e9ecef;
        }
        
        .demo-credentials {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1.5rem;
            border-left: 4px solid #28a745;
        }
        
        .demo-credentials h6 {
            color: #28a745;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .demo-credentials small {
            color: #666;
            display: block;
            margin-bottom: 0.25rem;
        }
        
        .credential-item {
            background: white;
            border-radius: 5px;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            font-family: monospace;
            font-size: 0.9rem;
        }
        
        .show-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            z-index: 5;
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
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .shape:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @media (max-width: 576px) {
            .login-container {
                margin: 1rem;
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1 class="login-title">Safe Space</h1>
            <p class="login-subtitle">Masuk ke Ruang Aman Anda</p>
        </div>
        
        <!-- Alert Messages -->
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
        <form action="<?= isset($current_url) ? $current_url . '/login' : base_url('login') ?>" method="POST" id="loginForm">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="username" name="username" 
                           placeholder="Masukkan username" required autocomplete="username">
                    <i class="fas fa-user input-group-icon"></i>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Masukkan password" required autocomplete="current-password">
                    <i class="fas fa-lock input-group-icon"></i>
                </div>
            </div>
            
            <button type="submit" class="btn btn-login" id="loginBtn">
                <i class="fas fa-sign-in-alt me-2"></i>
                Masuk
            </button>
        </form>
        
        <!-- Demo Credentials -->
        <div class="demo-credentials">
            <h6><i class="fas fa-info-circle me-2"></i>Demo Login</h6>
            <p><strong>Username:</strong> siswa_001</p>
            <p><strong>Password:</strong> password123</p>
            <p style="margin-top: 0.5rem; font-style: italic;">atau gunakan akun siswa lainnya</p>
        </div>
        
        <div class="login-footer">
            <small class="text-muted">
                © 2024 Safe Space - Aplikasi Murid<br>
                Ruang Aman untuk Konseling & Bimbingan
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            
            // Form submission with loading state
            form.addEventListener('submit', function(e) {
                loginBtn.classList.add('loading');
                loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                loginBtn.disabled = true;
            });
            
            // Input animations
            [usernameInput, passwordInput].forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                    this.parentElement.style.boxShadow = '0 4px 12px rgba(37, 99, 235, 0.15)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                    this.parentElement.style.boxShadow = 'none';
                });
            });
            
            // Auto-fill demo credentials
            const demoCredentials = document.querySelector('.demo-credentials');
            if (demoCredentials) {
                demoCredentials.addEventListener('click', function() {
                    usernameInput.value = 'siswa_001';
                    passwordInput.value = 'password123';
                    usernameInput.focus();
                });
            }
        });
    </script>
</body>
</html>
                <strong>Username:</strong> siti.aisyah<br>
                <strong>Password:</strong> 123456
            </div>
            
            <button class="btn btn-sm btn-outline-success mt-2" onclick="fillDemo()">
                <i class="fas fa-magic me-1"></i>
                Isi Otomatis Demo
            </button>
        </div>
        
        <div class="login-footer">
            <small class="text-muted">
                <i class="fas fa-shield-alt me-1"></i>
                Sistem Informasi Manajemen Sekolah
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set current URL for JavaScript
        window.phpCurrentUrl = '<?= $current_url ?? '' ?>';
    </script>
    <script src="<?= isset($current_url) ? $current_url . '/js/url-helper.js' : base_url('js/url-helper.js') ?>"></script>
    <script>
        // Toggle password visibility
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
        
        // Fill demo credentials
        function fillDemo() {
            document.getElementById('username').value = 'ahmad.budi';
            document.getElementById('password').value = '123456';
        }
        
        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                e.preventDefault();
                alert('Username dan password harus diisi!');
                return false;
            }
        });
        
        // Auto-focus on username field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').focus();
        });
        
        // Enter key handling
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('loginForm').submit();
            }
        });
    </script>
</body>
</html>
