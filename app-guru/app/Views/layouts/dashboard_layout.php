<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Guru - Smart BookKeeping' ?></title>
    
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
            background: #f8fafc;
            color: #2d3748;
            line-height: 1.6;
        }
        
        /* Header Styles */
        .main-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 30px rgba(102, 126, 234, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-top {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .header-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .header-main {
            padding: 15px 0;
        }
        
        .header-brand {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.25rem;
        }
        
        .brand-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1.2rem;
        }
        
        .header-user {
            display: flex;
            align-items: center;
            color: white;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        
        .user-info h6 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
        }
        
        .user-info small {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-header {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        
        .btn-header:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-1px);
        }
        
        /* Main Content */
        .main-content {
            padding: 30px 0;
        }
        
        .content-header {
            margin-bottom: 30px;
        }
        
        .page-title {
            color: #2d3748;
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 8px;
        }
        
        .page-subtitle {
            color: #718096;
            font-size: 1rem;
            margin: 0;
        }
        
        /* Card Styles */
        .dashboard-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 15px;
        }
        
        .card-icon.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        
        .card-icon.success {
            background: linear-gradient(135deg, #48bb78, #38a169);
        }
        
        .card-icon.warning {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
        }
        
        .card-icon.info {
            background: linear-gradient(135deg, #4299e1, #3182ce);
        }
        
        .card-title {
            color: #2d3748;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        
        .card-value {
            color: #4a5568;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .card-description {
            color: #718096;
            font-size: 0.875rem;
            margin: 0;
        }
        
        /* Alert Styles */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
        }
        
        /* Footer */
        .main-footer {
            background: white;
            border-top: 1px solid #e2e8f0;
            padding: 20px 0;
            margin-top: 40px;
            text-align: center;
            color: #718096;
            font-size: 0.875rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-info {
                flex-direction: column;
                gap: 5px;
                text-align: center;
            }
            
            .header-main .row {
                text-align: center;
            }
            
            .header-user {
                justify-content: center;
                margin-top: 10px;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 20px 0;
            }
            
            .content-header {
                margin-bottom: 20px;
            }
            
            .dashboard-card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="header-top">
            <div class="container">
                <div class="header-info">
                    <div>
                        <i class="fas fa-calendar-alt me-2"></i>
                        <?= date('l, d F Y') ?>
                    </div>
                    <div>
                        <i class="fas fa-clock me-2"></i>
                        <span id="current-time"><?= date('H:i:s') ?> WIB</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="header-main">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <a href="/dashboard" class="header-brand">
                            <div class="brand-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            Smart BookKeeping - Portal Guru
                        </a>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end align-items-center">
                            <div class="header-user me-3">
                                <div class="user-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="user-info">
                                    <h6><?= session('full_name') ?? 'Guru' ?></h6>
                                    <small><?= session('username') ?? '' ?></small>
                                </div>
                            </div>
                            <div class="header-actions">
                                <a href="/profile" class="btn-header">
                                    <i class="fas fa-user-cog me-1"></i>Profil
                                </a>
                                <a href="/logout" class="btn-header">
                                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <p class="mb-0">
                <i class="fas fa-school me-2"></i>
                Smart BookKeeping - Sistem Manajemen Sekolah &copy; <?= date('Y') ?>
            </p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update real-time clock
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('current-time').textContent = timeString + ' WIB';
        }
        
        // Update time every second
        setInterval(updateTime, 1000);
        updateTime(); // Initial call
    </script>
</body>
</html>
