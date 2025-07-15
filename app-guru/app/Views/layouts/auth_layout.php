<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Smart BookKeeping - Portal Guru' ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .auth-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        
        .auth-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .auth-header {
            margin-bottom: 30px;
        }
        
        .auth-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .auth-title {
            color: #2d3748;
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 8px;
        }
        
        .auth-subtitle {
            color: #718096;
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        .form-label {
            color: #4a5568;
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group .form-control {
            padding-right: 45px;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #a0aec0;
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #667eea;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            padding: 12px 24px;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
            border: none;
            font-size: 0.9rem;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
        }
        
        .auth-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #718096;
            font-size: 0.85rem;
        }
        
        .demo-section {
            background: #f8f9ff;
            border: 2px solid #e6efff;
            border-radius: 15px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
        }
        
        .demo-title {
            color: #4c63d2;
            font-weight: 600;
            margin-bottom: 15px;
            text-align: center;
            font-size: 1rem;
        }
        
        .demo-table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .demo-table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            font-size: 0.85rem;
        }
        
        .demo-table th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 0.8rem;
        }
        
        .demo-table th:first-child {
            border-top-left-radius: 8px;
        }
        
        .demo-table th:last-child {
            border-top-right-radius: 8px;
        }
        
        .demo-table td {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        
        .demo-table tbody tr:hover {
            background: #f8fafc;
        }
        
        .demo-username {
            background: #e6f3ff;
            color: #1e40af;
            padding: 4px 8px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            display: inline-block;
        }
        
        .demo-username:hover {
            background: #1e40af;
            color: white;
            transform: scale(1.05);
        }
        
        .demo-password {
            background: #f0f9f0;
            color: #16a34a;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 500;
        }
        
        .role-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .role-admin {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
        }
        
        .role-teacher, .role-guru {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
        }
        
        .demo-note {
            text-align: center;
            color: #6b7280;
            font-size: 0.8rem;
            margin-top: 12px;
            padding: 8px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 8px;
        }
        
        .invalid-feedback {
            color: #e53e3e;
            font-size: 0.875rem;
            margin-top: 5px;
        }
        
        @media (max-width: 576px) {
            .auth-container {
                padding: 15px;
            }
            
            .auth-card {
                padding: 30px 20px;
            }
            
            .auth-title {
                font-size: 1.3rem;
            }
            
            .demo-section {
                padding: 15px;
                margin: 20px 0;
            }
            
            .demo-table {
                font-size: 0.75rem;
            }
            
            .demo-table th, .demo-table td {
                padding: 8px 6px;
            }
            
            .demo-username, .demo-password {
                padding: 3px 6px;
                font-size: 0.7rem;
            }
            
            .role-badge {
                padding: 2px 6px;
                font-size: 0.65rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <?= $this->renderSection('content') ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');
            
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
        
        // Auto-fill login form with demo credentials
        function fillLogin(username) {
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            
            // Fill username
            usernameInput.value = username;
            
            // Fill password
            passwordInput.value = 'password123';
            
            // Add visual feedback
            usernameInput.style.borderColor = '#10b981';
            passwordInput.style.borderColor = '#10b981';
            
            // Focus on password field
            passwordInput.focus();
            
            // Remove green border after 2 seconds
            setTimeout(() => {
                usernameInput.style.borderColor = '#e2e8f0';
                passwordInput.style.borderColor = '#e2e8f0';
            }, 2000);
        }
        
        // Add click-to-copy functionality for password
        document.addEventListener('DOMContentLoaded', function() {
            const passwordCodes = document.querySelectorAll('.demo-password');
            passwordCodes.forEach(function(code) {
                code.style.cursor = 'pointer';
                code.title = 'Klik untuk copy password';
                
                code.addEventListener('click', function() {
                    navigator.clipboard.writeText('password123').then(function() {
                        code.style.background = '#10b981';
                        code.style.color = 'white';
                        code.textContent = 'Copied!';
                        
                        setTimeout(() => {
                            code.style.background = '#f0f9f0';
                            code.style.color = '#16a34a';
                            code.textContent = 'password123';
                        }, 1000);
                    });
                });
            });
        });
    </script>
</body>
</html>
