<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SmartBK Dashboard' ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Modern Light Elegant Theme Variables */
        :root {
            --primary-blue: #4A90E2;
            --light-blue: #E3F2FD;
            --accent-blue: #2196F3;
            --elegant-gray: #F8F9FA;
            --white: #FFFFFF;
            --text-primary: #2C3E50;
            --text-secondary: #6C757D;
            --text-muted: #8E9AAF;
            --border-light: #E9ECEF;
            --shadow-soft: rgba(74, 144, 226, 0.1);
            --shadow-card: rgba(0, 0, 0, 0.08);
            --gradient-primary: linear-gradient(135deg, #4A90E2 0%, #2196F3 100%);
            --gradient-light: linear-gradient(135deg, #F8F9FA 0%, #FFFFFF 100%);
            --gradient-subtle: linear-gradient(135deg, #FFFFFF 0%, #F5F7FA 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--elegant-gray);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Layout Container */
        .main-container {
            display: flex;
            min-height: 100vh;
        }

        /* Elegant Sidebar Styling */
        .sidebar {
            width: 280px;
            background: var(--gradient-subtle);
            border-right: 1px solid var(--border-light);
            box-shadow: 4px 0 20px var(--shadow-soft);
            position: fixed;
            top: 70px; /* Space for fixed header */
            left: 0;
            height: calc(100vh - 70px); /* Adjust height for header */
            overflow-y: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1010; /* Lower than header */
            scrollbar-width: thin;
            scrollbar-color: var(--border-light) transparent;
        }

        /* Collapsed Sidebar */
        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .submenu {
            display: none;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 20px 10px;
            text-align: center;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 15px;
        }

        /* Custom Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--border-light);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--primary-blue);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 24px 20px;
            background: var(--gradient-primary);
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 20px 15px;
            text-align: center;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-brand .brand-text {
            display: none;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1.2rem;
            color: white;
        }

        .sidebar.collapsed .brand-icon {
            margin-right: 0;
        }

        .brand-text h4 {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 4px;
        }

        .brand-text small {
            opacity: 0.9;
            font-size: 0.85rem;
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            position: absolute;
            top: 50%;
            right: -15px;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px var(--shadow-soft);
        }

        .sidebar-toggle:hover {
            background: var(--light-blue);
            border-color: var(--primary-blue);
        }

        .sidebar-toggle i {
            font-size: 0.8rem;
            color: var(--primary-blue);
            transition: all 0.3s ease;
        }

        /* Navigation Sections */
        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 20px;
        }

        .nav-section-title {
            color: var(--text-secondary);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 20px 12px;
            margin-bottom: 8px;
            position: relative;
        }

        .nav-section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 20px;
            right: 20px;
            height: 1px;
            background: var(--border-light);
        }

        .sidebar.collapsed .nav-section-title {
            display: none;
        }

        /* Navigation Items */
        .nav-item {
            margin: 2px 12px;
            animation: slideIn 0.3s ease forwards;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: var(--text-primary);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
            z-index: 0;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link:hover {
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 12px var(--shadow-soft);
        }

        .nav-link.active {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 12px var(--shadow-soft);
        }

        .nav-link.active::before {
            width: 100%;
        }

        .nav-icon {
            font-size: 1rem;
            margin-right: 12px;
            width: 20px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .nav-text {
            font-size: 0.9rem;
            font-weight: 500;
            position: relative;
            z-index: 1;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px;
        }

        .sidebar.collapsed .nav-icon {
            margin-right: 0;
        }

        .sidebar.collapsed .nav-text {
            display: none;
        }

        /* Navigation Badges */
        .nav-badge {
            margin-left: auto;
            background: #FF6B6B;
            color: white;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }

        .nav-badge.bg-warning {
            background: #FFB74D !important;
            color: #333;
        }

        .nav-badge.bg-success {
            background: #4CAF50 !important;
        }

        .sidebar.collapsed .nav-badge {
            display: none;
        }

        /* Role-based Section Styling */
        .role-section {
            position: relative;
            margin-bottom: 24px;
        }

        .role-section::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            border-radius: 0 3px 3px 0;
            opacity: 0.7;
        }

        .role-section[data-role="guru_mapel"]::before {
            background: var(--primary-blue);
        }

        .role-section[data-role="wali_kelas"]::before {
            background: #4CAF50;
        }

        .role-section[data-role="guru_bk"]::before {
            background: #FF6B6B;
        }

        .role-section[data-role="kepala_sekolah"]::before {
            background: #FFB74D;
        }

        .role-section.hidden {
            display: none;
        }

        .role-section .nav-section-title {
            background: var(--gradient-light);
            border-radius: 8px;
            margin: 8px 12px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px var(--shadow-card);
            border: 1px solid var(--border-light);
        }

        .role-section .nav-section-title::after {
            display: none;
        }

        .sidebar.collapsed .role-section .nav-section-title {
            height: 2px;
            padding: 0;
            margin: 8px;
            min-height: auto;
        }

        /* Filter Menu Section */
        .role-selector {
            padding: 0 12px;
        }

        .role-selector .form-select {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.85rem;
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .role-selector .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
            outline: none;
        }

        .sidebar.collapsed .role-selector {
            display: none;
        }

        .role-info {
            padding: 8px 12px;
        }

        .role-info small {
            color: var(--text-secondary);
            font-size: 0.75rem;
        }

        .sidebar.collapsed .role-info {
            display: none;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 280px;
            margin-top: 70px; /* Space for fixed header */
            min-height: calc(100vh - 70px); /* Adjust height for header */
            background: var(--elegant-gray);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 0; /* Remove padding for AdminLTE style */
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                z-index: 1050;
                top: 70px; /* Keep header space on mobile */
                height: calc(100vh - 70px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                margin-top: 70px; /* Space for fixed header on mobile */
                padding: 16px;
                width: 100%;
                min-height: calc(100vh - 70px);
            }

            .main-content.expanded {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: none;
            }

            /* Hide desktop navbar on mobile */
            .navbar-fixed-top {
                left: 0 !important;
                padding: 0.5rem 1rem;
                z-index: 1025 !important;
            }

            .navbar-fixed-top.collapsed {
                left: 0 !important;
            }
        }

        /* Mobile Header */
        .mobile-header {
            display: none;
            background: var(--gradient-primary);
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 8px var(--shadow-soft);
            color: white;
        }

        .mobile-header h5 {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .menu-toggle {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            padding: 10px 12px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: scale(1.05);
        }

        .menu-toggle:active {
            transform: scale(0.95);
        }

        .menu-toggle i {
            color: white;
        }

        @media (max-width: 768px) {
            .mobile-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
        }

        /* Content Cards */
        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px var(--shadow-card);
            border: 1px solid var(--border-light);
            padding: 24px;
            margin-bottom: 24px;
        }

        /* Elegant animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .nav-item:nth-child(1) { animation-delay: 0.1s; }
        .nav-item:nth-child(2) { animation-delay: 0.2s; }
        .nav-item:nth-child(3) { animation-delay: 0.3s; }
        .nav-item:nth-child(4) { animation-delay: 0.4s; }
        .nav-item:nth-child(5) { animation-delay: 0.5s; }

        /* Focus states for accessibility */
        .nav-link:focus {
            outline: 2px solid var(--primary-blue);
            outline-offset: 2px;
        }

        /* Loading states */
        .nav-badge.loading {
            background: var(--border-light);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <?= $this->renderSection('header') ?>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <!-- Sidebar Header -->
            <div class="sidebar-header">
                <a href="#" class="sidebar-brand">
                    <div class="brand-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="brand-text">
                        <h4>SmartBK</h4>
                    </div>
                </a>
            </div>

            <!-- Sidebar Navigation -->
            <div class="sidebar-nav">
                <!-- Filter Role Section -->
                <div class="role-selector mb-3">
                    <select class="form-select form-select-sm" id="roleFilter">
                        <option value="">Semua Menu</option>
                        <option value="guru_mapel">Menu Guru Mapel</option>
                        <option value="wali_kelas">Menu Wali Kelas</option>
                        <option value="guru_bk">Menu Guru BK</option>
                        <option value="kepala_sekolah">Menu Kepala Sekolah</option>
                    </select>
                </div>

                <!-- Current Role Info -->
                <div class="role-info">
                    <small><strong>Role Aktif:</strong> <?= session('role_name') ?? 'Guru' ?></small>
                </div>

                <!-- Navigation Sections -->
                <!-- Dashboard Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Dashboard</div>
                    <div class="nav-item">
                        <a href="<?= base_url('dashboard') ?>" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </div>
                </div>

                <!-- Guru Mapel Section -->
                <div class="role-section" data-role="guru_mapel">
                    <div class="nav-section-title">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Guru Mata Pelajaran
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('radar-kelas') ?>" class="nav-link">
                            <i class="nav-icon fas fa-chart-radar"></i>
                            <span class="nav-text">Radar Kelas</span>
                            <span class="nav-badge bg-warning">New</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('analisis-pembelajaran') ?>" class="nav-link">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <span class="nav-text">Analisis Pembelajaran</span>
                        </a>
                    </div>
                </div>

                <!-- Wali Kelas Section -->
                <div class="role-section" data-role="wali_kelas">
                    <div class="nav-section-title">
                        <i class="fas fa-users me-2"></i>
                        Wali Kelas
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('profil-kelas') ?>" class="nav-link">
                            <i class="nav-icon fas fa-id-card"></i>
                            <span class="nav-text">Profil Kelas</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('monitoring-siswa') ?>" class="nav-link">
                            <i class="nav-icon fas fa-user-check"></i>
                            <span class="nav-text">Monitoring Siswa</span>
                        </a>
                    </div>
                </div>

                <!-- Guru BK Section -->
                <div class="role-section" data-role="guru_bk">
                    <div class="nav-section-title">
                        <i class="fas fa-heart me-2"></i>
                        Bimbingan Konseling
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('pusat-kendali-konseling') ?>" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <span class="nav-text">Pusat Kendali</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('konseling-individu') ?>" class="nav-link">
                            <i class="nav-icon fas fa-user-md"></i>
                            <span class="nav-text">Konseling Individu</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('konseling-kelompok') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users-medical"></i>
                            <span class="nav-text">Konseling Kelompok</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('asesmen-bakat-minat') ?>" class="nav-link">
                            <i class="nav-icon fas fa-brain"></i>
                            <span class="nav-text">Asesmen Bakat Minat</span>
                            <span class="nav-badge bg-success">BK</span>
                        </a>
                    </div>
                </div>

                <!-- Kepala Sekolah Section -->
                <div class="role-section" data-role="kepala_sekolah">
                    <div class="nav-section-title">
                        <i class="fas fa-crown me-2"></i>
                        Kepala Sekolah
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('laporan-eksekutif') ?>" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <span class="nav-text">Laporan Eksekutif</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('evaluasi-program') ?>" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-check"></i>
                            <span class="nav-text">Evaluasi Program</span>
                        </a>
                    </div>
                </div>

                <!-- System Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Sistem</div>
                    <div class="nav-item">
                        <a href="<?= base_url('logout') ?>" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <span class="nav-text">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Page Content -->
            <div class="content-card">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const roleFilter = document.getElementById('roleFilter');

            // Mobile menu toggle
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (sidebar) {
                        sidebar.classList.toggle('show');
                        if (sidebarOverlay) {
                            sidebarOverlay.classList.toggle('show');
                        }
                    }
                    
                    return false;
                });
            }

            // Overlay click to close mobile sidebar
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    }
                });
            }

            // Sidebar toggle for desktop only (in sidebar)
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (window.innerWidth > 768) {
                        sidebar.classList.toggle('collapsed');
                        
                        const icon = sidebarToggle.querySelector('i');
                        if (sidebar.classList.contains('collapsed')) {
                            icon.classList.remove('fa-chevron-left');
                            icon.classList.add('fa-chevron-right');
                        } else {
                            icon.classList.remove('fa-chevron-right');
                            icon.classList.add('fa-chevron-left');
                        }
                        
                        // Save state
                        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                    }
                    
                    return false;
                });
            }

            // Role-based menu filtering
            if (roleFilter) {
                roleFilter.addEventListener('change', function() {
                    const selectedRole = this.value;
                    const roleSections = document.querySelectorAll('.role-section');
                    
                    roleSections.forEach(section => {
                        if (selectedRole === '' || section.getAttribute('data-role') === selectedRole) {
                            section.classList.remove('hidden');
                        } else {
                            section.classList.add('hidden');
                        }
                    });
                    
                    // Save filter state
                    localStorage.setItem('roleFilter', selectedRole);
                });

                // Restore filter state
                const savedFilter = localStorage.getItem('roleFilter');
                if (savedFilter) {
                    roleFilter.value = savedFilter;
                    roleFilter.dispatchEvent(new Event('change'));
                }
            }

            // Restore sidebar state (desktop only)
            if (window.innerWidth > 768) {
                const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (sidebarCollapsed) {
                    sidebar.classList.add('collapsed');
                    if (sidebarToggle) {
                        const icon = sidebarToggle.querySelector('i');
                        icon.classList.remove('fa-chevron-left');
                        icon.classList.add('fa-chevron-right');
                    }
                }
            }

            // Active menu highlighting
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Auto-hide mobile sidebar on navigation
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('show');
                        if (sidebarOverlay) {
                            sidebarOverlay.classList.remove('show');
                        }
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    // Clear mobile classes when switching to desktop
                    sidebar.classList.remove('show');
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.remove('show');
                    }
                } else {
                    // Clear desktop collapsed state on mobile
                    sidebar.classList.remove('collapsed');
                }
            });
        });
    </script>
</body>
</html>
