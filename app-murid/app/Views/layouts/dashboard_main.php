<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="theme-color" content="#2563eb">
    <title><?= $this->hasSection('title') ? $this->renderSection('title') : 'Ruang Aman - Safe Space' ?></title>
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
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --border-radius: 16px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
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
            margin: 0;
            padding: 0;
            position: relative;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
            color: var(--gray-800);
            /* Better mobile font size */
            font-size: 16px;
            -webkit-text-size-adjust: 100%;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Modern glassmorphism background */
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
                radial-gradient(circle at 90% 80%, rgba(245, 158, 11, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.6) 0%, transparent 60%);
            z-index: -2;
        }
        
        /* Floating elements for visual interest */
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
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-10px) rotate(1deg); }
            66% { transform: translateY(5px) rotate(-1deg); }
        }
        
        /* Modern navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: 700;
            font-size: 1.25rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            color: var(--secondary-color) !important;
            transform: translateY(-1px);
        }
        
        .navbar-nav .nav-link {
            color: var(--gray-700) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
            background: rgba(37, 99, 235, 0.05);
            transform: translateY(-1px);
        }
        
        /* Notification bell with modern styling */
        #notificationBell {
            position: relative;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            color: var(--gray-600);
        }
        
        #notificationBell:hover {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
            transform: scale(1.1);
        }
        
        #notificationBell:hover .fas.fa-bell {
            animation: bellRing 0.6s ease-in-out;
        }
        
        @keyframes bellRing {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-15deg); }
            75% { transform: rotate(15deg); }
        }
        
        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: linear-gradient(135deg, var(--danger-color), #f87171);
            color: white;
            font-size: 0.65rem;
            font-weight: 600;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-md);
            border: 2px solid white;
        }
        
        .notification-new {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
            100% { transform: scale(1); }
        }
        
        /* Notification Modal Styling */
        .swal-wide {
            width: 90% !important;
            max-width: 500px !important;
        }
        
        .notification-item {
            transition: background-color 0.3s ease;
        }
        
        .notification-item:hover {
            background-color: rgba(76, 175, 80, 0.05);
        }
        
        /* Date header */
        .date-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 255, 0.9) 100%);
            color: #1976d2;
            padding: 1rem 1rem;
            font-size: 0.8rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 500;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(25, 118, 210, 0.15);
            text-align: center;
            box-shadow: 
                0 2px 12px rgba(25, 118, 210, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
        }
        
        .date-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 20%, rgba(25, 118, 210, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(33, 150, 243, 0.04) 0%, transparent 40%);
            z-index: -1;
        }
        
        .current-date {
            font-weight: 600;
            font-size: 0.85rem;
            color: #2e7d32;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-shadow: 0 1px 2px rgba(76, 175, 80, 0.1);
            letter-spacing: 0.2px;
        }
        
        .current-time {
            font-weight: 600;
            font-size: 1.3rem;
            color: #2e7d32;
            font-family: 'Segoe UI', 'Courier New', monospace;
            text-shadow: 0 1px 3px rgba(76, 175, 80, 0.12);
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            position: relative;
        }
        
        .current-time::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, #2e7d32 50%, transparent 100%);
            opacity: 0.25;
        }
        
        .date-day {
            font-size: 0.65rem;
            font-weight: 500;
            opacity: 0.7;
            margin-bottom: 0.15rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        
        .date-full {
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.1;
        }
        
        .time-separator {
            animation: blink 2s infinite;
            margin: 0 1px;
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.4; }
        }
        
        /* Alert styling */
        .alert {
            border-radius: 20px;
            border: none;
            padding: 1rem 1.5rem;
            margin: 1rem;
            background: rgba(76, 175, 80, 0.15);
            backdrop-filter: blur(15px);
            color: #2e7d32;
            border: 1px solid rgba(76, 175, 80, 0.3);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.1);
        }
        
        .alert i {
            filter: none;
            color: #2e7d32;
        }
        
        /* Layout Structure */
        .header-section {
            flex-shrink: 0;
        }
        
        .footer-section {
            flex-shrink: 0;
        }
        
        /* Content wrapper */
        .content-wrapper {
            flex: 1;
            padding: 2rem 1rem 6rem 1rem;
            position: relative;
            z-index: 1;
        }
        
        /* Modern Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid rgba(37, 99, 235, 0.1);
            padding: 0.75rem 0 calc(0.75rem + env(safe-area-inset-bottom));
            z-index: 1000;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .nav-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 600px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--gray-500);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 0.5rem;
            border-radius: 12px;
            min-width: 60px;
            position: relative;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(37, 99, 235, 0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
            transform: translate(-50%, -50%);
        }
        
        .nav-item:hover::before {
            width: 100%;
            height: 100%;
        }
        
        .nav-item:hover {
            color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .nav-item.active {
            color: var(--primary-color);
            background: rgba(37, 99, 235, 0.08);
        }
        
        .nav-item.active::after {
            content: '';
            position: absolute;
            top: -2px;
            left: 50%;
            width: 20px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 0 0 6px 6px;
            transform: translateX(-50%);
        }
        
        .nav-item i {
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        
        .nav-item span {
            font-size: 0.7rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        
        .nav-item:hover i {
            transform: scale(1.1);
        }
        
        /* Back button styling */
        .btn-back {
            background: rgba(255, 255, 255, 0.9);
            color: var(--gray-700);
            border: 1px solid rgba(37, 99, 235, 0.15);
            border-radius: 16px;
            padding: 0.5rem 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-weight: 500;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
        }
        
        .btn-back:hover {
            background: rgba(37, 99, 235, 0.05);
            color: var(--primary-color);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-color);
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .navbar {
                padding: 0.75rem 0;
            }
            
            .navbar-brand {
                font-size: 1.1rem;
            }
            
            .content-wrapper {
                padding: 1.5rem 1rem 5rem 1rem;
            }
            
            .bottom-nav {
                padding: 0.5rem 0 calc(0.5rem + env(safe-area-inset-bottom));
            }
            
            .nav-item {
                min-width: 50px;
                padding: 0.4rem;
            }
            
            .nav-item i {
                font-size: 1.1rem;
            }
            
            .nav-item span {
                font-size: 0.65rem;
            }
        }
        
        @media (max-width: 480px) {
            /* Larger mobile fonts and touch-friendly sizes */
            html {
                font-size: 18px; /* Increase base font size */
            }
            
            .content-wrapper {
                padding: 1.5rem 1rem 5rem 1rem; /* More padding for mobile */
            }
            
            .bottom-nav {
                padding: 0.75rem 0 calc(0.75rem + env(safe-area-inset-bottom));
                height: auto;
                min-height: 70px; /* Taller bottom nav */
            }
            
            .nav-container {
                padding: 0 0.75rem;
            }
            
            .nav-item {
                min-width: 60px; /* Larger touch targets */
                padding: 0.5rem;
                border-radius: 12px;
            }
            
            .nav-item i {
                font-size: 1.4rem; /* Larger icons */
                margin-bottom: 0.3rem;
            }
            
            .nav-item span {
                font-size: 0.75rem; /* Larger text */
                font-weight: 500;
            }
            
            /* Larger navbar elements */
            .navbar-brand {
                font-size: 1.3rem;
                font-weight: 600;
            }
            
            .date-header {
                padding: 1rem;
            }
            
            .current-time {
                font-size: 2.5rem; /* Larger time display */
                font-weight: 300;
            }
            
            .current-date .date-day {
                font-size: 1rem;
                font-weight: 600;
            }
            
            .current-date .date-full {
                font-size: 0.9rem;
            }
            
            /* Notification bell larger */
            .nav-link i {
                font-size: 1.2rem;
            }
        }
        
        /* Animation for page transitions */
        .page-transition {
            animation: slideInUp 0.4s ease-out;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(37, 99, 235, 0.3);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(37, 99, 235, 0.5);
        }
        
        /* Safe area inset support for iPhone */
        @supports (padding: max(0px)) {
            .bottom-nav {
                padding-bottom: max(0.75rem, env(safe-area-inset-bottom));
            }
        }
    </style>
    
    <?php if ($this->hasSection('styles')): ?>
        <?= $this->renderSection('styles') ?>
    <?php endif; ?>
</head>
<body>
    <!-- Header Section -->
    <header class="header-section">
        <!-- Date Header -->
        <div class="date-header">
            <div class="current-time">
                <span id="hours">12</span><span class="time-separator">:</span><span id="minutes">00</span>
            </div>
            <div class="current-date">
                <div class="date-day" id="dayName">SENIN</div>
                <div class="date-full" id="fullDate">1 Januari 2024</div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-shield-heart me-2"></i>
                    RUANG AMAN
                </a>
                <div class="navbar-nav ms-auto d-flex">
                    <span class="nav-link d-none d-md-inline">
                        <i class="fas fa-user me-1"></i><?= $nama ?? 'Guest' ?>
                    </span>
                    <a class="nav-link position-relative" href="#" id="notificationBell">
                        <i class="fas fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationCount" style="display: none;">
                            0
                        </span>
                        <span class="d-none d-md-inline ms-1">Notifikasi</span>
                    </a>
                </div>
            </div>
        </nav>
        
        <!-- Success Alert -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
    </header>
    
    <!-- Main Content Section -->
    <main class="content-wrapper">
        <div class="container">
            <?php if ($this->hasSection('content')): ?>
                <?= $this->renderSection('content') ?>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    No content section defined.
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="footer-section">
        <!-- Bottom Navigation -->
        <nav class="bottom-nav">
            <div class="nav-container">
                <a href="<?= base_url('dashboard') ?>" class="nav-item <?= (strpos(current_url(), 'dashboard') !== false) ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="<?= base_url('safe-space/konsul-cepat') ?>" class="nav-item <?= (strpos(current_url(), 'konsul-cepat') !== false) ? 'active' : '' ?>">
                    <i class="fas fa-comments"></i>
                    <span>Chat</span>
                </a>
                <a href="<?= base_url('safe-space/jurnal-digital') ?>" class="nav-item <?= (strpos(current_url(), 'jurnal-digital') !== false) ? 'active' : '' ?>">
                    <i class="fas fa-heart"></i>
                    <span>Jurnal</span>
                </a>
                <a href="<?= base_url('logout') ?>" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Date and Time Script -->
    <script>
        function updateDateTime() {
            const now = new Date();
            
            // Update time
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            
            document.getElementById('hours').textContent = hours;
            document.getElementById('minutes').textContent = minutes;
            
            // Update date
            const days = ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            
            document.getElementById('dayName').textContent = dayName;
            document.getElementById('fullDate').textContent = `${date} ${month} ${year}`;
        }
        
        // Update immediately and then every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
        
        // Notification System
        let notificationCount = 0;
        const notifications = [];
        
        function updateNotificationBadge() {
            const badge = document.getElementById('notificationCount');
            const bell = document.getElementById('notificationBell');
            
            if (notificationCount > 0) {
                badge.textContent = notificationCount > 99 ? '99+' : notificationCount;
                badge.style.display = 'flex';
                badge.classList.add('notification-new');
                bell.querySelector('.fas.fa-bell').style.color = '#ff6b6b';
            } else {
                badge.style.display = 'none';
                badge.classList.remove('notification-new');
                bell.querySelector('.fas.fa-bell').style.color = '';
            }
        }
        
        function addNotification(title, message, type = 'info') {
            notificationCount++;
            notifications.unshift({
                id: Date.now(),
                title,
                message,
                type,
                time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }),
                read: false
            });
            
            updateNotificationBadge();
            
            // Ring bell animation
            const bell = document.getElementById('notificationBell');
            bell.querySelector('.fas.fa-bell').style.animation = 'bellRing 0.8s ease-in-out';
            setTimeout(() => {
                bell.querySelector('.fas.fa-bell').style.animation = '';
            }, 800);
            
            // Show quiet toast notification - only for new notifications
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: type,
                    title: title,
                    text: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        // Disable sound by removing any audio elements
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            }
        }
        
        function clearNotifications() {
            notificationCount = 0;
            notifications.length = 0;
            updateNotificationBadge();
        }
        
        // Make function available globally
        window.clearNotifications = clearNotifications;
        window.addNotification = addNotification;
        window.getNotificationCount = () => notificationCount;
        window.resetWelcomeNotification = () => {
            localStorage.removeItem('safespace_welcome_shown');
            localStorage.removeItem('safespace_welcome_date');
            sessionStorage.removeItem('safespace_demo_shown');
        };
        
        // Handle notification bell click
        document.getElementById('notificationBell').addEventListener('click', function(e) {
            e.preventDefault();
            
            if (notifications.length === 0) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak ada notifikasi',
                        text: 'Belum ada notifikasi baru untuk Anda.',
                        confirmButtonText: 'OK'
                    });
                }
                return;
            }
            
            // Show notifications modal
            let notificationHtml = notifications.map(notif => `
                <div class="notification-item p-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">${notif.title}</h6>
                            <p class="mb-1 text-muted small">${notif.message}</p>
                            <small class="text-primary">${notif.time}</small>
                        </div>
                        <i class="fas fa-${notif.type === 'success' ? 'check-circle text-success' : notif.type === 'warning' ? 'exclamation-triangle text-warning' : 'info-circle text-info'}"></i>
                    </div>
                </div>
            `).join('');
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: `<i class="fas fa-bell me-2"></i>Notifikasi (${notifications.length})`,
                    html: `
                        <div class="notification-list" style="max-height: 400px; overflow-y: auto;">
                            ${notificationHtml}
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-sm btn-outline-danger" onclick="clearNotifications(); Swal.close();">
                                <i class="fas fa-trash me-1"></i>Hapus Semua
                            </button>
                        </div>
                    `,
                    showConfirmButton: false,
                    showCloseButton: true,
                    customClass: {
                        popup: 'swal-wide'
                    }
                });
                
                // Mark as read
                notificationCount = 0;
                updateNotificationBadge();
            }
        });
        
        // Simulate real-time notifications (demo purposes)
        const demoNotifications = [
            { title: 'Selamat Datang!', message: 'Selamat datang di Safe Space. Ruang aman untuk berbagi cerita.', type: 'success' },
            { title: 'Tips Hari Ini', message: 'Jangan lupa untuk mencatat mood harian Anda di jurnal digital.', type: 'info' },
            { title: 'Konseling Tersedia', message: 'Guru BK sedang online. Yuk konsultasi sekarang!', type: 'warning' },
            { title: 'Jurnal Reminder', message: 'Sudah waktunya menulis jurnal harian Anda.', type: 'info' },
            { title: 'Chat Baru', message: 'Ada pesan baru dari Guru BK untuk Anda.', type: 'success' }
        ];
        
        let demoNotificationIndex = 0;
        let hasShownWelcome = false;
        
        // Check if welcome notification has been shown before (using localStorage)
        const welcomeShown = localStorage.getItem('safespace_welcome_shown');
        const welcomeDate = localStorage.getItem('safespace_welcome_date');
        const today = new Date().toDateString();
        
        // Add welcome notification after 3 seconds (only once per day)
        setTimeout(() => {
            // Only show if not shown today
            if (!welcomeShown || welcomeDate !== today) {
                addNotification(demoNotifications[0].title, demoNotifications[0].message, demoNotifications[0].type);
                hasShownWelcome = true;
                demoNotificationIndex = 1;
                
                // Mark as shown for today
                localStorage.setItem('safespace_welcome_shown', 'true');
                localStorage.setItem('safespace_welcome_date', today);
            } else {
                hasShownWelcome = true;
                demoNotificationIndex = 1;
            }
        }, 3000);
        
        // Add specific notifications at intervals (not continuous) - only for current session
        const sessionKey = 'safespace_demo_notifications_' + Date.now();
        
        setTimeout(() => {
            // Only show if user is still on the same session and hasn't seen demo notifications
            if (!sessionStorage.getItem('safespace_demo_shown') && demoNotificationIndex < demoNotifications.length) {
                const notif = demoNotifications[demoNotificationIndex];
                addNotification(notif.title, notif.message, notif.type);
                demoNotificationIndex++;
            }
        }, 45000); // After 45 seconds
        
        setTimeout(() => {
            // Only show if user is still on the same session
            if (!sessionStorage.getItem('safespace_demo_shown') && demoNotificationIndex < demoNotifications.length) {
                const notif = demoNotifications[demoNotificationIndex];
                addNotification(notif.title, notif.message, notif.type);
                demoNotificationIndex++;
                
                // Mark demo notifications as shown for this session
                sessionStorage.setItem('safespace_demo_shown', 'true');
            }
        }, 120000); // After 2 minutes
    </script>
    
    <?php if ($this->hasSection('scripts')): ?>
        <?= $this->renderSection('scripts') ?>
    <?php endif; ?>
</body>
</html>
