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
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border: 2px solid #e6efff;
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .demo-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .demo-header {
            margin-bottom: 20px;
        }
        
        .demo-title {
            color: #4c63d2;
            font-weight: 600;
            margin-bottom: 8px;
            text-align: center;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .demo-badge {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .demo-description {
            text-align: center;
            color: #6b7280;
            font-size: 0.85rem;
            margin: 0;
            padding: 10px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
            text-align: center;
            font-size: 1rem;
        }
        
        .demo-table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin: 15px 0;
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
            background: linear-gradient(135deg, #e6f3ff, #dbeafe);
            color: #1e40af;
            padding: 6px 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            display: inline-block;
            border: 1px solid #bfdbfe;
        }
        
        .demo-username:hover {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }
        
        .demo-password {
            background: linear-gradient(135deg, #f0f9f0, #dcfce7);
            color: #16a34a;
            padding: 6px 10px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #bbf7d0;
        }
        
        .demo-password:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
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
            margin-top: 15px;
            padding: 12px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08), rgba(118, 75, 162, 0.08));
            border-radius: 10px;
            border: 1px solid rgba(102, 126, 234, 0.15);
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
                padding: 20px 15px;
                margin: 25px 0;
            }
            
            .demo-title {
                font-size: 1rem;
            }
            
            .demo-description {
                font-size: 0.8rem;
                padding: 8px;
            }
            
            .demo-table {
                font-size: 0.75rem;
            }
            
            .demo-table th, .demo-table td {
                padding: 8px 6px;
            }
            
            .demo-username, .demo-password {
                padding: 4px 7px;
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
            
            // Add visual feedback with animation
            usernameInput.style.borderColor = '#10b981';
            passwordInput.style.borderColor = '#10b981';
            usernameInput.style.backgroundColor = '#f0fdf4';
            passwordInput.style.backgroundColor = '#f0fdf4';
            
            // Add a subtle success message
            const form = document.querySelector('.auth-form');
            let successMsg = document.querySelector('.auto-fill-success');
            if (!successMsg) {
                successMsg = document.createElement('div');
                successMsg.className = 'auto-fill-success';
                successMsg.innerHTML = '<i class="fas fa-check-circle me-2"></i>Form berhasil diisi otomatis!';
                successMsg.style.cssText = `
                    background: linear-gradient(135deg, #10b981, #059669);
                    color: white;
                    padding: 8px 12px;
                    border-radius: 8px;
                    font-size: 0.8rem;
                    margin-top: 10px;
                    text-align: center;
                    animation: slideIn 0.3s ease;
                `;
                form.appendChild(successMsg);
            }
            
            // Focus on password field
            passwordInput.focus();
            
            // Remove effects after 3 seconds
            setTimeout(() => {
                usernameInput.style.borderColor = '#e2e8f0';
                passwordInput.style.borderColor = '#e2e8f0';
                usernameInput.style.backgroundColor = '';
                passwordInput.style.backgroundColor = '';
                if (successMsg) {
                    successMsg.remove();
                }
            }, 3000);
        }
        
        // Add click-to-copy functionality for password
        document.addEventListener('DOMContentLoaded', function() {
            // Add CSS animation for slide in effect
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateY(-10px); opacity: 0; }
                    to { transform: translateY(0); opacity: 1; }
                }
            `;
            document.head.appendChild(style);
            
            const passwordCodes = document.querySelectorAll('.demo-password');
            passwordCodes.forEach(function(code) {
                code.title = 'Klik untuk copy password ke clipboard';
                
                code.addEventListener('click', function() {
                    navigator.clipboard.writeText('password123').then(function() {
                        const originalText = code.textContent;
                        const originalBg = code.style.background;
                        const originalColor = code.style.color;
                        
                        code.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                        code.style.color = 'white';
                        code.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
                        
                        setTimeout(() => {
                            code.style.background = originalBg;
                            code.style.color = originalColor;
                            code.textContent = originalText;
                        }, 1500);
                    }).catch(function() {
                        // Fallback if clipboard API fails
                        code.style.background = '#ef4444';
                        code.style.color = 'white';
                        code.innerHTML = '<i class="fas fa-times me-1"></i>Failed';
                        
                        setTimeout(() => {
                            code.style.background = '';
                            code.style.color = '';
                            code.textContent = 'password123';
                        }, 1500);
                    });
                });
            });
        });
    </script>
</body>
</html>
