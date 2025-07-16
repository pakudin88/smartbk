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
        /* Clean White Blue Gray Theme Variables */
        :root {
            --primary-blue: #3B82F6;
            --primary-blue-light: #60A5FA;
            --primary-blue-dark: #1E40AF;
            --accent-blue: #1D4ED8;
            --light-blue: #EFF6FF;
            --sky-blue: #0EA5E9;
            
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
            
            --white: #FFFFFF;
            --white-soft: #FEFEFE;
            
            --primary-gradient: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
            --secondary-gradient: linear-gradient(135deg, #60A5FA 0%, #3B82F6 100%);
            --success-gradient: linear-gradient(135deg, #10B981 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            --info-gradient: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%);
            --danger-gradient: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            
            --sidebar-bg: var(--white);
            --header-bg: var(--white);
            --content-bg: var(--gray-50);
            --card-bg: var(--white);
            
            --text-primary: var(--gray-900);
            --text-secondary: var(--gray-600);
            --text-light: var(--gray-400);
            --text-white: var(--white);
            
            --border-color: var(--gray-200);
            --border-light: var(--gray-100);
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--content-bg);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Layout Container */
        .main-container {
            display: flex;
            min-height: 100vh;
        }

        /* Fixed Header Navbar */
        .navbar-fixed-top {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            height: 70px;
            background: var(--header-bg);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            z-index: 1040;
            display: flex;
            align-items: center;
            padding: 0 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-fixed-top.collapsed {
            left: 70px;
        }

        .navbar-brand {
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 700;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            margin-right: 8px;
            font-size: 1.5rem;
            color: var(--primary-blue);
        }

        .navbar-nav {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar-nav .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            padding: 10px 16px;
            border-radius: var(--radius-lg);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            background: var(--light-blue);
            color: var(--primary-blue);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .user-info {
            color: var(--text-secondary);
            font-size: 0.875rem;
            padding: 8px 16px;
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
        }

        .user-info strong {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .user-info small {
            color: var(--text-secondary);
            font-weight: 400;
        }

        /* Mobile Menu Toggle in Header */
        .mobile-menu-toggle {
            display: none;
            background: var(--gray-100);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 10px 12px;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-menu-toggle:hover {
            background: var(--light-blue);
            color: var(--primary-blue);
            transform: scale(1.05);
        }

        /* Elegant Sidebar Styling */
        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            scrollbar-width: thin;
            scrollbar-color: var(--gray-300) transparent;
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
            background: var(--gray-300);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 24px 20px;
            background: var(--gray-50);
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 20px 15px;
            text-align: center;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            color: var(--text-primary);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed .sidebar-brand .brand-text {
            display: none;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1.25rem;
            color: var(--text-white);
            box-shadow: var(--shadow-md);
        }

        .sidebar.collapsed .brand-icon {
            margin-right: 0;
        }

        .brand-text h5 {
            font-weight: 700;
            font-size: 1.125rem;
            margin-bottom: 4px;
            color: var(--text-primary);
            letter-spacing: -0.025em;
        }

        .brand-text small {
            color: var(--text-secondary);
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            position: absolute;
            top: 50%;
            right: -15px;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-lg);
        }

        .sidebar-toggle:hover {
            background: var(--primary-gradient);
            border-color: transparent;
            transform: translateY(-50%) scale(1.1);
        }

        .sidebar-toggle:hover i {
            color: var(--text-white);
        }

        .sidebar-toggle i {
            font-size: 0.875rem;
            color: var(--text-secondary);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Navigation Sections */
        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 24px;
        }

        .nav-section-title {
            color: var(--text-secondary);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 12px 20px 16px;
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
            background: var(--border-color);
        }

        .sidebar.collapsed .nav-section-title {
            display: none;
        }

        /* Navigation Items */
        .nav-item {
            margin: 4px 16px;
            animation: slideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 14px 16px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: var(--radius-lg);
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
            background: var(--light-blue);
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link:hover {
            color: var(--primary-blue);
            transform: translateX(6px);
            box-shadow: var(--shadow-md);
        }

        .nav-link.active {
            background: var(--light-blue);
            color: var(--primary-blue);
            box-shadow: var(--shadow-md);
        }

        .nav-link.active::before {
            width: 100%;
        }

        .nav-icon {
            font-size: 1.125rem;
            margin-right: 12px;
            width: 24px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .nav-text {
            font-size: 0.875rem;
            font-weight: 500;
            position: relative;
            z-index: 1;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 14px;
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
            background: var(--primary-blue);
            color: var(--text-white);
            font-size: 0.6875rem;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 700;
            position: relative;
            z-index: 1;
            box-shadow: var(--shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav-badge.bg-warning {
            background: #F59E0B !important;
        }

        .nav-badge.bg-success {
            background: #10B981 !important;
        }

        .nav-badge.bg-info {
            background: #0EA5E9 !important;
        }

        .nav-badge.bg-danger {
            background: #EF4444 !important;
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
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            background: var(--content-bg);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 0;
            width: calc(100% - 280px);
        }

        .main-content.expanded {
            margin-left: 70px;
            width: calc(100% - 70px);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .navbar-fixed-top {
                left: 0 !important;
                padding: 0 15px;
            }

            .navbar-fixed-top.collapsed {
                left: 0 !important;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }

            .user-info {
                display: none;
            }

            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                z-index: 1050;
                top: 0;
                height: 100vh;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 16px;
            }

            .main-content.expanded {
                margin-left: 0;
                width: 100%;
            }

            .sidebar-toggle {
                display: none;
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
            background: var(--card-bg);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            padding: 32px;
            margin-bottom: 24px;
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .content-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        /* Prevent content from going under navbar */
        .main-content > * {
            position: relative;
            z-index: 1;
        }

        /* Ensure proper spacing */
        .container-fluid {
            padding: 24px;
        }

        /* Statistics Cards */
        .stats-card {
            background: var(--card-bg);
            border-radius: var(--radius-xl);
            padding: 24px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .stats-card.success::before {
            background: var(--success-gradient);
        }

        .stats-card.warning::before {
            background: var(--warning-gradient);
        }

        .stats-card.info::before {
            background: var(--info-gradient);
        }

        .stats-card.danger::before {
            background: var(--danger-gradient);
        }

        /* Fix potential z-index issues */
        .modal {
            z-index: 1055;
        }

        .dropdown-menu {
            z-index: 1000;
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
    <!-- Fixed Header Navbar -->
    <nav class="navbar-fixed-top" id="navbarTop">
        <div class="d-flex align-items-center">
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <a href="<?= base_url('dashboard') ?>" class="navbar-brand ms-2">
                <i class="fas fa-graduation-cap"></i>
                <span class="d-none d-sm-inline">SmartBK Dashboard</span>
            </a>
        </div>
        
        <div class="navbar-nav">
            <div class="nav-item dropdown user-profile-dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="userMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-info-text text-start d-none d-md-block">
                        <strong><?= session('nama') ?? 'Administrator' ?></strong>
                        <small><?= session('role_name') ?? 'Guru' ?></small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                    <li class="dropdown-header">
                        <h6><?= session('nama') ?? 'Administrator' ?></h6>
                        <p><?= session('role_name') ?? 'Guru' ?></p>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="<?= base_url('profile') ?>">
                            <i class="fas fa-user-circle"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= base_url('settings') ?>">
                            <i class="fas fa-cog"></i>
                            <span>Pengaturan Akun</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="<?= base_url('logout') ?>">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
                        <a href="<?= base_url('radar-kelas/riwayat-sinyal') ?>" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <span class="nav-text">Riwayat Sinyal Pribadi</span>
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
                    <div class="nav-item">
                        <a href="<?= base_url('radar-kelas/dashboard-wali') ?>" class="nav-link">
                            <i class="nav-icon fas fa-chart-radar"></i>
                            <span class="nav-text">Dashboard Pendampingan</span>
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
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
                    const mainContent = document.getElementById('mainContent');
                    const navbarTop = document.getElementById('navbarTop');
                    
                    if (mainContent) mainContent.classList.add('expanded');
                    if (navbarTop) navbarTop.classList.add('collapsed');
                    
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
                    const mainContent = document.getElementById('mainContent');
                    const navbarTop = document.getElementById('navbarTop');
                    
                    if (mainContent) mainContent.classList.remove('expanded');
                    if (navbarTop) navbarTop.classList.remove('collapsed');
                }
            });
        });
    </script>
</body>
</html>