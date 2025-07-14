<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard - Super Admin' ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #1e293b;
            line-height: 1.6;
            min-height: 100vh;
        }
        
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1e40af 0%, #2563eb 50%, #3b82f6 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.3);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        .sidebar.collapsed {
            margin-left: -260px;
        }
        
        .sidebar-header {
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            text-align: center;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
            position: relative;
        }
        
        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .sidebar-header h3 {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }
        
        .sidebar-header p {
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
            font-weight: 400;
            position: relative;
            z-index: 1;
        }
        
        .sidebar-nav {
            padding: 20px 0;
        }
        
        .nav-item {
            margin: 0;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            border-left: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .nav-link:hover::before {
            left: 100%;
        }
        
        .nav-link:hover {
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.05) 100%);
            color: #ffffff;
            border-left-color: #60a5fa;
            padding-left: 30px;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.3) 0%, rgba(59, 130, 246, 0.2) 100%);
            color: #ffffff;
            border-left-color: #60a5fa;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(96, 165, 250, 0.3);
        }
        
        .nav-icon {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: 260px;
            transition: margin-left 0.3s ease;
        }
        
        .main-content.expanded {
            margin-left: 0;
        }
        
        /* Top Navigation */
        .top-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-bottom: 1px solid #e9ecef;
        }
        
        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .sidebar-toggle {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background: #5a6fd8;
            transform: scale(1.05);
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
        }
        
        .user-role {
            font-size: 0.8rem;
            color: #7f8c8d;
        }
        
        .logout-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: #c0392b;
            transform: translateY(-1px);
        }
        
        /* Content Area */
        .content {
            padding: 30px;
            min-height: calc(100vh - 80px);
        }
        
        .welcome-section {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            color: white;
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .welcome-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .welcome-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
        }
        
        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .stat-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 8px;
        }
        
        .stat-label {
            color: #7f8c8d;
            font-size: 1rem;
            font-weight: 500;
        }
        
        /* Quick Actions */
        .quick-actions {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }
        
        .section-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ecf0f1;
        }
        
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        
        .action-card {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            color: white;
        }
        
        .action-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }
        
        .action-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }
        
        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
                z-index: 2000;
            }
            
            .sidebar.active {
                margin-left: 0;
                box-shadow: 0 0 20px rgba(0,0,0,0.5);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .content {
                padding: 20px;
            }
            
            .welcome-section {
                padding: 25px;
            }
            
            .welcome-title {
                font-size: 1.8rem;
            }
            
            .top-navbar {
                padding: 15px 20px;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .actions-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            /* Mobile overlay when sidebar is open */
            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1500;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }
            
            .mobile-overlay.active {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <!-- Mobile Overlay -->
        <div class="mobile-overlay" id="mobileOverlay"></div>
        
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Super Admin</h3>
                <p>Control Panel</p>
            </div>
            <div class="sidebar-nav">
                <div class="nav-item">
                    <a href="/dashboard" class="nav-link active">
                        <span class="nav-icon">📊</span>
                        Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="/users" class="nav-link">
                        <span class="nav-icon">👥</span>
                        Kelola Pengguna
                    </a>
                </div>
                <div class="nav-item">
                    <a href="/schools" class="nav-link">
                        <span class="nav-icon">🏫</span>
                        Kelola Sekolah
                    </a>
                </div>
                <div class="nav-item">
                    <a href="/classes" class="nav-link">
                        <span class="nav-icon">🎓</span>
                        Kelola Kelas
                    </a>
                </div>
                <div class="nav-item">
                    <a href="/subjects" class="nav-link">
                        <span class="nav-icon">📚</span>
                        Mata Pelajaran
                    </a>
                </div>
                <div class="nav-item">
                    <a href="/school-years" class="nav-link">
                        <span class="nav-icon">📅</span>
                        Tahun Ajaran
                    </a>
                </div>
                <div class="nav-item">
                    <a href="/reports" class="nav-link">
                        <span class="nav-icon">📈</span>
                        Laporan
                    </a>
                </div>
                <div class="nav-item">
                    <a href="/settings" class="nav-link">
                        <span class="nav-icon">⚙️</span>
                        Pengaturan
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content Area -->
        <div class="main-content" id="mainContent">
            <!-- Top Navigation -->
            <header class="top-navbar">
                <div class="navbar-content">
                    <div class="navbar-left">
                        <button class="sidebar-toggle" onclick="toggleSidebar()">
                            ☰
                        </button>
                        <h1 class="page-title">Dashboard</h1>
                    </div>
                    <div class="user-menu">
                        <div class="user-info">
                            <div class="user-name"><?= $user['full_name'] ?? 'Administrator' ?></div>
                            <div class="user-role"><?= $user['role_name'] ?? 'Super Admin' ?></div>
                        </div>
                        <a href="/logout" class="logout-btn">Logout</a>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="content">
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- Welcome Section -->
                <section class="welcome-section">
                    <h2 class="welcome-title">Selamat Datang, <?= $user['full_name'] ?? 'Administrator' ?>!</h2>
                    <p class="welcome-subtitle">Kelola sistem sekolah multi-aplikasi dari panel administrasi ini</p>
                </section>

                <!-- Statistics Cards -->
                <section class="stats-container">
                    <div class="stat-card">
                        <span class="stat-icon">👥</span>
                        <div class="stat-number">1</div>
                        <div class="stat-label">Total Pengguna</div>
                    </div>
                    <div class="stat-card">
                        <span class="stat-icon">🏫</span>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Total Sekolah</div>
                    </div>
                    <div class="stat-card">
                        <span class="stat-icon">📚</span>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Mata Pelajaran</div>
                    </div>
                    <div class="stat-card">
                        <span class="stat-icon">🎓</span>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Total Kelas</div>
                    </div>
                </section>

                <!-- Quick Actions -->
                <section class="quick-actions">
                    <h3 class="section-title">Menu Aksi Cepat</h3>
                    <div class="actions-grid">
                        <a href="/users" class="action-card">
                            <span class="action-icon">👥</span>
                            <h4 class="action-title">Kelola Pengguna</h4>
                        </a>
                        <a href="/schools" class="action-card">
                            <span class="action-icon">🏫</span>
                            <h4 class="action-title">Kelola Sekolah</h4>
                        </a>
                        <a href="/classes" class="action-card">
                            <span class="action-icon">🎓</span>
                            <h4 class="action-title">Kelola Kelas</h4>
                        </a>
                        <a href="/subjects" class="action-card">
                            <span class="action-icon">📚</span>
                            <h4 class="action-title">Mata Pelajaran</h4>
                        </a>
                        <a href="/school-years" class="action-card">
                            <span class="action-icon">📅</span>
                            <h4 class="action-title">Tahun Ajaran</h4>
                        </a>
                        <a href="/reports" class="action-card">
                            <span class="action-icon">📈</span>
                            <h4 class="action-title">Laporan</h4>
                        </a>
                    </div>
                </section>

                <!-- Debug Info (akan dihapus nanti) -->
                <section style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 30px; border: 1px solid #dee2e6;">
                    <h4 style="color: #495057; margin-bottom: 15px;">Debug Info:</h4>
                    <div style="font-family: monospace; font-size: 0.9rem; color: #6c757d;">
                        <p><strong>Session Status:</strong> <?= session()->get('isLoggedIn') ? 'Logged In' : 'Not Logged In' ?></p>
                        <p><strong>User ID:</strong> <?= session()->get('user_id') ?? 'N/A' ?></p>
                        <p><strong>Username:</strong> <?= session()->get('username') ?? 'N/A' ?></p>
                        <p><strong>Role:</strong> <?= session()->get('role_name') ?? 'N/A' ?></p>
                        <p><strong>Current Time:</strong> <?= date('Y-m-d H:i:s') ?></p>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const mobileOverlay = document.getElementById('mobileOverlay');
            
            if (window.innerWidth <= 768) {
                // Mobile mode
                sidebar.classList.toggle('active');
                mobileOverlay.classList.toggle('active');
            } else {
                // Desktop mode
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        }

        // Close sidebar when clicking overlay (mobile)
        document.getElementById('mobileOverlay').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');
            
            sidebar.classList.remove('active');
            mobileOverlay.classList.remove('active');
        });

        // Responsive sidebar handling
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const mobileOverlay = document.getElementById('mobileOverlay');
            
            if (window.innerWidth <= 768) {
                // Mobile mode
                sidebar.classList.remove('collapsed');
                sidebar.classList.remove('active');
                mainContent.classList.remove('expanded');
                mobileOverlay.classList.remove('active');
            } else {
                // Desktop mode
                sidebar.classList.remove('active');
                mobileOverlay.classList.remove('active');
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            }
        }

        // Initialize responsive behavior
        handleResize();
        window.addEventListener('resize', handleResize);

        // Close sidebar when clicking nav links on mobile
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    const sidebar = document.getElementById('sidebar');
                    const mobileOverlay = document.getElementById('mobileOverlay');
                    
                    sidebar.classList.remove('active');
                    mobileOverlay.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
