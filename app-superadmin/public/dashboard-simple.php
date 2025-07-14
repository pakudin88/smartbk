<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Simple - Super Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            color: #333;
            line-height: 1.6;
        }
        
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .sidebar.collapsed {
            margin-left: -260px;
        }
        
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            background: rgba(0,0,0,0.2);
        }
        
        .sidebar-header h3 {
            color: #ecf0f1;
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .sidebar-header p {
            color: #bdc3c7;
            font-size: 0.9rem;
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
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #ecf0f1;
            border-left-color: #3498db;
            padding-left: 30px;
        }
        
        .nav-link.active {
            background: rgba(52, 152, 219, 0.2);
            color: #3498db;
            border-left-color: #3498db;
            font-weight: 500;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
            }
            
            .sidebar.active {
                margin-left: 0;
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
        }
    </style>
</head>
<body>
    <?php
    $userName = $_GET['user'] ?? 'Administrator';
    ?>
    
    <div class="app-wrapper">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Super Admin</h3>
                <p>Control Panel</p>
            </div>
            <div class="sidebar-nav">
                <div class="nav-item">
                    <a href="#" class="nav-link active">
                        <span class="nav-icon">📊</span>
                        Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">👥</span>
                        Kelola Pengguna
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">🏫</span>
                        Kelola Sekolah
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">🎓</span>
                        Kelola Kelas
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">📚</span>
                        Mata Pelajaran
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">📅</span>
                        Tahun Ajaran
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">📈</span>
                        Laporan
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
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
                            <div class="user-name"><?= htmlspecialchars($userName) ?></div>
                            <div class="user-role">Super Admin</div>
                        </div>
                        <a href="simple-login.php" class="logout-btn">Logout</a>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="content">
                <div class="success-message">
                    ✅ Login berhasil! Selamat datang di dashboard Super Admin.
                </div>
                
                <!-- Welcome Section -->
                <section class="welcome-section">
                    <h2 class="welcome-title">Selamat Datang, <?= htmlspecialchars($userName) ?>!</h2>
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
                        <a href="#" class="action-card">
                            <span class="action-icon">👥</span>
                            <h4 class="action-title">Kelola Pengguna</h4>
                        </a>
                        <a href="#" class="action-card">
                            <span class="action-icon">🏫</span>
                            <h4 class="action-title">Kelola Sekolah</h4>
                        </a>
                        <a href="#" class="action-card">
                            <span class="action-icon">🎓</span>
                            <h4 class="action-title">Kelola Kelas</h4>
                        </a>
                        <a href="#" class="action-card">
                            <span class="action-icon">📚</span>
                            <h4 class="action-title">Mata Pelajaran</h4>
                        </a>
                        <a href="#" class="action-card">
                            <span class="action-icon">📅</span>
                            <h4 class="action-title">Tahun Ajaran</h4>
                        </a>
                        <a href="#" class="action-card">
                            <span class="action-icon">📈</span>
                            <h4 class="action-title">Laporan</h4>
                        </a>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }

        // Responsive sidebar handling
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            }
        }

        // Initialize responsive behavior
        handleResize();
        window.addEventListener('resize', handleResize);

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target) &&
                !sidebar.classList.contains('collapsed')) {
                sidebar.classList.add('collapsed');
                document.getElementById('mainContent').classList.add('expanded');
            }
        });
    </script>
</body>
</html>
