<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Jendela Kemitraan - Portal Orang Tua' ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            color: #2d3748;
            line-height: 1.6;
        }
        
        /* Modern Header */
        .modern-header {
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
            padding: 16px 0;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .brand-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .brand-logo {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .brand-logo i {
            font-size: 1.5rem;
            color: white;
        }
        
        .brand-info h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .brand-info p {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-info {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 8px 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .user-name {
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            margin: 0;
        }
        
        .user-role {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.75rem;
            margin: 0;
        }
        
        .logout-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-1px);
        }
        
        /* Navigation */
        .nav-menu {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .nav-container {
            display: flex;
            gap: 8px;
            padding: 12px 0;
        }
        
        .nav-item {
            padding: 8px 16px;
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .nav-item:hover,
        .nav-item.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .notification-badge {
            background: #dc3545;
            color: white;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 50px;
            margin-left: 8px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse-notification 2s infinite;
        }
        
        @keyframes pulse-notification {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }
            70% {
                box-shadow: 0 0 0 6px rgba(220, 53, 69, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }
        
        /* Main Content */
        .main-content {
            background: #f8fafc;
            min-height: calc(100vh - 200px);
            padding: 32px 0;
        }
        
        /* Footer */
        .modern-footer {
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            color: white;
            padding: 24px 0;
            margin-top: auto;
        }
        
        .footer-content {
            text-align: center;
        }
        
        .footer-title {
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .header-info {
                flex-direction: column;
                gap: 4px;
                text-align: center;
            }
            
            .header-content {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }
            
            .header-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .nav-container {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .brand-info h1 {
                font-size: 1.25rem;
            }
            
            .user-info {
                text-align: center;
                width: 100%;
            }
        }
        
        /* Animation */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Modern Header -->
    <header class="modern-header">
        <!-- Header Top -->
        <div class="header-top">
            <div class="container">
                <div class="header-info">
                    <div class="header-date">
                        <i class="fas fa-calendar-day me-2"></i>
                        <span id="currentDate"></span>
                    </div>
                    <div class="header-time">
                        <i class="fas fa-clock me-2"></i>
                        <span id="currentTime"></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Header Main -->
        <div class="header-main">
            <div class="container">
                <div class="header-content">
                    <div class="brand-section">
                        <div class="brand-logo">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="brand-info">
                            <h1>Jendela Kemitraan</h1>
                            <p>Portal Kolaborasi Orang Tua & Sekolah</p>
                        </div>
                    </div>
                    
                    <div class="header-actions">
                        <?php if (session()->get('parent_logged_in')): ?>
                        <div class="user-info">
                            <p class="user-name"><?= esc(session()->get('parent_name')) ?></p>
                            <p class="user-role">Orang Tua Siswa</p>
                        </div>
                        <a href="<?= base_url('logout') ?>" class="logout-btn">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            Keluar
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <?php if (session()->get('parent_logged_in')): ?>
        <div class="nav-menu">
            <div class="container">
                <div class="nav-container">
                    <a href="<?= base_url('dashboard') ?>" class="nav-item <?= (current_url() === base_url('dashboard')) ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('profile') ?>" class="nav-item <?= (current_url() === base_url('profile')) ? 'active' : '' ?>">
                        <i class="fas fa-user me-2"></i>Profil Anak
                    </a>
                    <a href="<?= base_url('academic') ?>" class="nav-item <?= (current_url() === base_url('academic')) ? 'active' : '' ?>">
                        <i class="fas fa-graduation-cap me-2"></i>Akademik
                    </a>
                    <a href="<?= base_url('finance') ?>" class="nav-item <?= (current_url() === base_url('finance')) ? 'active' : '' ?>">
                        <i class="fas fa-credit-card me-2"></i>Keuangan
                    </a>
                    <a href="<?= base_url('notifications') ?>" class="nav-item <?= (current_url() === base_url('notifications')) ? 'active' : '' ?>">
                        <i class="fas fa-bell me-2"></i>Notifikasi
                        <span class="notification-badge">5</span>
                    </a>
                    <a href="<?= base_url('summary') ?>" class="nav-item <?= (current_url() === base_url('summary')) ? 'active' : '' ?>">
                        <i class="fas fa-file-alt me-2"></i>Laporan
                    </a>
                    <a href="<?= base_url('progress') ?>" class="nav-item <?= (current_url() === base_url('progress')) ? 'active' : '' ?>">
                        <i class="fas fa-chart-line me-2"></i>Progress
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="fade-in">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </main>
    
    <!-- Modern Footer -->
    <footer class="modern-footer">
        <div class="container">
            <div class="footer-content">
                <h6 class="footer-title">Jendela Kemitraan</h6>
                <p class="footer-text">
                    Portal Kolaborasi untuk Mendukung Perkembangan Siswa<br>
                    &copy; <?= date('Y') ?> - Sistem Informasi Bimbingan Konseling
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Date Time Script -->
    <script>
        function updateDateTime() {
            const now = new Date();
            
            // Format date
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                timeZone: 'Asia/Jakarta'
            };
            const dateStr = now.toLocaleDateString('id-ID', options);
            
            // Format time
            const timeStr = now.toLocaleTimeString('id-ID', {
                timeZone: 'Asia/Jakarta',
                hour12: false
            }) + ' WIB';
            
            // Update elements
            const dateElement = document.getElementById('currentDate');
            const timeElement = document.getElementById('currentTime');
            
            if (dateElement) dateElement.textContent = dateStr;
            if (timeElement) timeElement.textContent = timeStr;
        }
        
        // Update immediately and then every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
        
        // Add smooth scrolling
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Add loading state for buttons
            document.querySelectorAll('button[type="submit"]').forEach(button => {
                button.addEventListener('click', function() {
                    if (this.form && this.form.checkValidity()) {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                        this.disabled = true;
                        
                        // Reset after 3 seconds if still on page
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }, 3000);
                    }
                });
            });
        });
    </script>
</body>
</html>
