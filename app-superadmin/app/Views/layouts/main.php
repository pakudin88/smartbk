<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> | Super Admin</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#1e40af">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Super Admin">
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    
    <!-- Icons -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('assets/img/icon-192x192.png') ?>">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <?= $this->renderSection('styles') ?>
    
    <style>
        /* CSS Variables for Theme Colors */
        :root {
            --primary-blue: #1e40af;
            --light-blue: #3b82f6;
            --dark-blue: #1e3a8a;
            --gradient-blue: linear-gradient(135deg, #1e40af 0%, #2563eb 50%, #3b82f6 100%);
            --sidebar-bg: linear-gradient(180deg, #1e40af 0%, #2563eb 50%, #3b82f6 100%);
            --sidebar-header-bg: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            --sidebar-border: rgba(255,255,255,0.2);
            --sidebar-width: 260px;
            --text-dark: #1e293b;
            --text-muted: #6b7280;
            --text-light: #9ca3af;
            --hover-bg: rgba(255,255,255,0.15);
            --active-bg: rgba(96, 165, 250, 0.3);
            --active-border: #60a5fa;
            --border-light: #e5e7eb;
            --card-bg: #ffffff;
            --card-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
        }
        
        /* App Wrapper */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: white;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.3);
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar-header {
            background: var(--sidebar-header-bg);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid var(--sidebar-border);
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
        
        .sidebar.collapsed .sidebar-header h3,
        .sidebar.collapsed .sidebar-header p {
            opacity: 0;
            visibility: hidden;
        }
        
        .sidebar.collapsed .nav-link {
            padding: 15px 20px;
            justify-content: center;
        }
        
        .sidebar.collapsed .nav-link span:not(.nav-icon) {
            opacity: 0;
            visibility: hidden;
            width: 0;
            overflow: hidden;
        }
        
        .sidebar.collapsed .nav-icon {
            margin-right: 0;
            font-size: 1.2rem;
        }
        
        .sidebar.collapsed .nav-link:hover {
            padding-left: 20px;
            transform: none;
        }
        
        /* Tooltip for collapsed sidebar */
        .sidebar.collapsed .nav-link {
            position: relative;
        }
        
        .sidebar.collapsed .nav-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            margin-left: 10px;
            font-size: 0.9rem;
        }
        
        .sidebar.collapsed .nav-link:hover::after {
            opacity: 1;
            visibility: visible;
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
            background: var(--hover-bg);
            color: #ffffff;
            border-left-color: var(--active-border);
            padding-left: 30px;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .nav-link.active {
            background: var(--active-bg);
            color: #ffffff;
            border-left-color: var(--active-border);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(96, 165, 250, 0.3);
        }
        
        .nav-icon {
            margin-right: 12px;
            font-size: 1.1rem;
            min-width: 20px;
            text-align: center;
            transition: transform 0.2s ease;
        }
        
        .nav-link:hover .nav-icon {
            transform: scale(1.1);
        }
        
        /* Submenu Styles */
        .has-submenu .submenu-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }
        
        .has-submenu .nav-link.active .submenu-arrow {
            transform: rotate(180deg);
        }
        
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
            background: rgba(255,255,255,0.08);
            border-radius: 8px;
            margin: 5px 15px;
            padding: 0;
        }
        
        .submenu.show {
            max-height: 600px;
            padding: 8px 0;
        }
        
        .submenu-item {
            padding: 0;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
            transition-delay: 0.1s;
        }
        
        .submenu.show .submenu-item {
            opacity: 1;
            transform: translateX(0);
        }
        
        .submenu-item:nth-child(2) {
            transition-delay: 0.15s;
        }
        
        .submenu-item:nth-child(3) {
            transition-delay: 0.2s;
        }
        
        .submenu-item:nth-child(4) {
            transition-delay: 0.25s;
        }
        
        .submenu-item:nth-child(5) {
            transition-delay: 0.3s;
        }
        
        .submenu-link {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 6px;
            margin: 1px 8px;
            position: relative;
            overflow: hidden;
        }
        
        .submenu-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }
        
        .submenu-link:hover::before {
            left: 100%;
        }
        
        .submenu-link:hover {
            background: rgba(255,255,255,0.15);
            color: #ffffff;
            transform: translateX(5px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .submenu-link.active {
            background: rgba(96, 165, 250, 0.4);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(96, 165, 250, 0.3);
        }
        
        .submenu-icon {
            margin-right: 10px;
            font-size: 1rem;
            min-width: 18px;
            text-align: center;
        }
        
        .sidebar.collapsed .nav-link span:not(.nav-icon) {
            display: none;
        }
        
        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
        }
        
        .main-content.expanded {
            margin-left: 80px;
        }
        
        /* Top Navigation */
        .top-navbar, .topbar {
            background: white;
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 80px;
        }
        
        .navbar-content, .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
            width: 100%;
            justify-content: space-between;
        }
        
        .navbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 1;
        }
        
        .sidebar-toggle, .toggle-sidebar {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }
        
        .sidebar-toggle:hover, .toggle-sidebar:hover {
            background: #5a6fd8;
            transform: scale(1.05);
        }
        
        .page-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
            white-space: nowrap;
        }
        
        .user-menu, .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-shrink: 0;
            margin-left: auto;
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
        .content, .content-area {
            padding: 30px;
            min-height: calc(100vh - 80px);
        }
        
        /* Welcome Section */
        .welcome-section, .welcome-banner {
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
        
        .welcome-banner h3 {
            margin: 0 0 10px 0;
            font-weight: 600;
        }
        
        .welcome-banner p {
            margin: 0;
            opacity: 0.9;
        }
        
        /* Stats Cards */
        .stats-container, .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            display: block;
            opacity: 0.9;
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
        
        .stat-sublabel {
            color: #95a5a6;
            font-size: 0.85rem;
            font-weight: 400;
            margin-top: 5px;
        }
        
        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .stat-card-title {
            color: #6b7280;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .stat-card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .stat-card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }
        
        .stat-card-change {
            font-size: 0.85rem;
            color: #059669;
            margin-top: 5px;
        }
        
        /* Quick Actions */
        .quick-actions {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
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
            font-size: 2.2rem;
            margin-bottom: 15px;
            display: block;
            opacity: 0.9;
        }
        
        .action-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }
        
        .quick-actions .quick-action-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        .quick-action-btn:hover {
            background: rgba(255,255,255,0.3);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .quick-action-btn i {
            font-size: 1.1rem;
        }
        /* Cards & Components */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            background: var(--card-bg);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 20px;
            font-weight: 600;
            color: #1f2937;
            border-radius: 16px 16px 0 0;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Tables */
        .table {
            margin: 0;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #374151;
            background: #f9fafb;
            padding: 15px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .table td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .table tbody tr:hover {
            background-color: #f8fafc;
        }
        
        /* Badges */
        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge.bg-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: white;
        }
        
        .badge.bg-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            color: white;
        }
        
        .badge.bg-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            color: white;
        }
        
        .badge.bg-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
            color: white;
        }
        
        .badge.bg-primary {
            background: var(--gradient-blue) !important;
            color: white;
        }
        
        /* Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        
        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-color: #ffeaa7;
        }
        
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-color: #bee5eb;
        }
        
        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.75rem 1.5rem;
            border: none;
            font-size: 0.9rem;
        }
        
        .btn:hover {
            transform: translateY(-1px);
        }
        
        .btn-primary {
            background: var(--gradient-blue);
            border: none;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--dark-blue) 0%, #1e3a8a 100%);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--gradient-blue);
            color: white;
            border-color: var(--primary-blue);
        }
        
        /* Forms */
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #f1f3f4;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.15);
        }
        
        .input-group-text {
            border-radius: 10px 0 0 10px;
            border: 2px solid #f1f3f4;
            border-right: none;
            background: #f8fafc;
        }
        
        /* Dropdowns */
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            min-width: 220px;
            padding: 10px 0;
            margin-top: 10px;
        }
        
        .dropdown-item {
            padding: 12px 20px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            border-radius: 8px;
            margin: 2px 10px;
        }
        
        .dropdown-item:hover {
            background: var(--gradient-blue);
            color: white;
            transform: translateX(5px);
        }
        
        .dropdown-header {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
            padding: 12px 20px 8px 20px;
        }
        
        .dropdown-item-text {
            font-size: 0.8rem;
            padding: 0px 20px 8px 20px;
        }
        
        .dropdown-divider {
            margin: 8px 20px;
            border-color: var(--border-light);
        }
        
        /* User Elements */
        .user-dropdown {
            position: relative;
        }
        
        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--gradient-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            font-size: 1.1rem;
            margin-left: 15px;
            position: relative;
            overflow: hidden;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            transition: opacity 0.3s ease;
        }
        
        .user-avatar img:error,
        .user-avatar img[src=""] {
            display: none;
        }
        
        .user-avatar .initials {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }
        
        .user-avatar:hover {
            transform: scale(1.05);
            border-color: var(--primary-blue);
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--gradient-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }
        
        .avatar-initial {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
        }
        
        /* Utility Classes */
        .text-xs {
            font-size: 0.75rem;
        }
        
        .font-weight-bold {
            font-weight: 600;
        }
        
        .text-gray-800 {
            color: #1f2937;
        }
        
        /* Breadcrumbs */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item {
            color: var(--text-muted);
        }
        
        .breadcrumb-item.active {
            color: var(--primary-blue);
            font-weight: 600;
        }
        
        .breadcrumb-item a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .breadcrumb-item a:hover {
            color: var(--primary-blue);
        }
        
        /* Search & Filter */
        .search-box {
            position: relative;
        }
        
        .search-box input {
            padding-left: 40px;
        }
        
        .search-box .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                margin-left: 0;
                z-index: 2000;
                transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            }
            
            .sidebar.active {
                transform: translateX(0);
                box-shadow: 0 0 20px rgba(0,0,0,0.5);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .content, .content-area {
                padding: 15px;
            }
            
            .welcome-section, .welcome-banner {
                padding: 20px;
            }
            
            .welcome-title {
                font-size: 1.6rem;
            }
            
            .top-navbar, .topbar {
                padding: 15px 20px;
                min-height: 70px;
            }
            
            .navbar-content, .topbar-left {
                gap: 15px;
            }
            
            .navbar-left {
                gap: 15px;
            }
            
            .page-title {
                font-size: 1.3rem;
            }
            
            .user-avatar {
                width: 36px;
                height: 36px;
                font-size: 0.9rem;
                margin-left: 8px;
            }
            
            .user-menu {
                gap: 10px;
            }
            
            .sidebar-toggle, .toggle-sidebar {
                padding: 10px 12px;
                font-size: 1rem;
            }
            
            .stats-container, .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .actions-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .table-responsive {
                border-radius: 12px;
            }
            
            .welcome-banner .d-flex {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .welcome-banner .btn {
                align-self: center;
            }
            
            /* Ensure sidebar is properly hidden on mobile */
            .sidebar.collapsed {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }
        }
        
        /* Desktop Responsiveness */
        @media (min-width: 769px) {
            .sidebar {
                transform: translateX(0);
                margin-left: 0;
            }
            
            .sidebar.active {
                /* No effect on desktop */
            }
            
            .main-content {
                margin-left: var(--sidebar-width);
            }
            
            .main-content.expanded {
                margin-left: 80px;
            }
        }
        
        /* Tablet specific adjustments */
        @media (min-width: 769px) and (max-width: 1024px) {
            .top-navbar, .topbar {
                padding: 15px 25px;
            }
            
            .content, .content-area {
                padding: 20px;
            }
            
            .page-title {
                font-size: 1.4rem;
            }
        }
        
        /* Large desktop adjustments */
        @media (min-width: 1200px) {
            .content, .content-area {
                padding: 30px;
            }
            
            .top-navbar, .topbar {
                padding: 20px 40px;
            }
        }
        
        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1500;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Additional Mobile Styles */
        @media (max-width: 768px) {
            .sidebar.active + .mobile-overlay {
                opacity: 1;
                visibility: visible;
            }
        }
        
        /* Smooth transitions for all elements */
        .sidebar, .main-content, .sidebar-toggle, .toggle-sidebar, .mobile-overlay {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        /* School Year Status Card */
        .school-year-status-container {
            margin-bottom: 30px;
        }
        
        .school-year-status-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .school-year-status-card.active {
            background: linear-gradient(135deg, #e8f5e8 0%, #f0f9f0 100%);
            border-left: 5px solid #28a745;
        }
        
        .school-year-status-card.inactive {
            background: linear-gradient(135deg, #fff3e0 0%, #ffeaa7 100%);
            border-left: 5px solid #ffc107;
        }
        
        .school-year-status-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.15);
        }
        
        .status-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .status-icon {
            font-size: 2.5rem;
            margin-right: 20px;
            color: #28a745;
        }
        
        .school-year-status-card.inactive .status-icon {
            color: #ffc107;
        }
        
        .status-info {
            flex: 1;
        }
        
        .status-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 5px 0;
        }
        
        .status-period {
            font-size: 1.5rem;
            font-weight: 700;
            color: #28a745;
            margin: 0;
        }
        
        .school-year-status-card.inactive .status-period {
            color: #e67e22;
        }
        
        .status-details {
            display: flex;
            gap: 30px;
            margin-bottom: 20px;
        }
        
        .status-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .status-label {
            font-size: 0.9rem;
            color: #7f8c8d;
            font-weight: 500;
        }
        
        .status-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .status-message {
            color: #7f8c8d;
            font-size: 1rem;
            margin: 0;
        }
        
        .status-badge {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        
        .badge-active {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
        }
        
        .badge-inactive {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 10px rgba(255, 193, 7, 0.3);
        }
        
        .status-action {
            text-align: center;
            margin-top: 15px;
        }
        
        .btn-set-active {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        
        .btn-set-active:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
            color: white;
            text-decoration: none;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .status-details {
                flex-direction: column;
                gap: 15px;
            }
            
            .status-header {
                flex-direction: column;
                text-align: center;
            }
            
            .status-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
            
            .status-badge {
                position: static;
                text-align: center;
                margin-top: 15px;
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
                    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : '' ?>" data-tooltip="Dashboard">
                        <span class="nav-icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <!-- Kelola Pengguna dengan Submenu -->
                <div class="nav-item has-submenu">
                    <a href="#" class="nav-link <?= (strpos(uri_string(), 'pengguna-') !== false || strpos(uri_string(), 'users') !== false) ? 'active' : '' ?>" data-tooltip="Kelola Pengguna" onclick="toggleSubmenu(this)">
                        <span class="nav-icon">👥</span>
                        <span>Kelola Pengguna</span>
                        <i class="fas fa-chevron-down submenu-arrow"></i>
                    </a>
                    <div class="submenu <?= (strpos(uri_string(), 'pengguna-') !== false || strpos(uri_string(), 'users') !== false) ? 'show' : '' ?>">
                        <div class="submenu-item">
                            <a href="<?= base_url('pengguna-sekolah') ?>" class="submenu-link <?= (strpos(uri_string(), 'pengguna-sekolah') !== false) ? 'active' : '' ?>">
                                <span>Pengguna Sekolah</span>
                            </a>
                        </div>
                        <div class="submenu-item">
                            <a href="<?= base_url('pengguna-murid') ?>" class="submenu-link <?= (strpos(uri_string(), 'pengguna-murid') !== false) ? 'active' : '' ?>">
                                <span>Murid</span>
                            </a>
                        </div>
                        <div class="submenu-item">
                            <a href="<?= base_url('pengguna-orang-tua') ?>" class="submenu-link <?= (strpos(uri_string(), 'pengguna-orang-tua') !== false) ? 'active' : '' ?>">
                                <span>Orang Tua</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Manajemen Sekolah dengan Submenu -->
                <div class="nav-item has-submenu">
                    <a href="#" class="nav-link <?= (strpos(uri_string(), 'schools') !== false || strpos(uri_string(), 'classes') !== false || strpos(uri_string(), 'positions') !== false || strpos(uri_string(), 'school-years') !== false || strpos(uri_string(), 'reports') !== false) ? 'active' : '' ?>" data-tooltip="Manajemen Sekolah" onclick="toggleSubmenu(this)">
                        <span class="nav-icon">🏫</span>
                        <span>Manajemen Sekolah</span>
                        <i class="fas fa-chevron-down submenu-arrow"></i>
                    </a>
                    <div class="submenu <?= (strpos(uri_string(), 'schools') !== false || strpos(uri_string(), 'classes') !== false || strpos(uri_string(), 'positions') !== false || strpos(uri_string(), 'school-years') !== false || strpos(uri_string(), 'reports') !== false) ? 'show' : '' ?>">
                        <div class="submenu-item">
                            <a href="<?= base_url('schools') ?>" class="submenu-link <?= (strpos(uri_string(), 'schools') !== false) ? 'active' : '' ?>">
                                <span>Kelola Sekolah</span>
                            </a>
                        </div>
                        <div class="submenu-item">
                            <a href="<?= base_url('classes') ?>" class="submenu-link <?= (strpos(uri_string(), 'classes') !== false) ? 'active' : '' ?>">
                                <span>Kelola Kelas</span>
                            </a>
                        </div>
                        <div class="submenu-item">
                            <a href="<?= base_url('positions') ?>" class="submenu-link <?= (strpos(uri_string(), 'positions') !== false) ? 'active' : '' ?>">
                                <span>Kelola Jabatan</span>
                            </a>
                        </div>
                        <div class="submenu-item">
                            <a href="<?= base_url('school-years') ?>" class="submenu-link <?= (strpos(uri_string(), 'school-years') !== false) ? 'active' : '' ?>">
                                <span>Tahun Ajaran</span>
                            </a>
                        </div>
                        <div class="submenu-item">
                            <a href="<?= base_url('reports') ?>" class="submenu-link <?= (strpos(uri_string(), 'reports') !== false) ? 'active' : '' ?>">
                                <span>Laporan</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="nav-item">
                    <a href="<?= base_url('settings') ?>" class="nav-link <?= (strpos(uri_string(), 'settings') !== false) ? 'active' : '' ?>" data-tooltip="Pengaturan">
                        <span class="nav-icon">⚙️</span>
                        <span>Pengaturan</span>
                    </a>
                </div>
            </div>
        </nav>
        
        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Top Navigation -->
            <header class="top-navbar">
                <div class="navbar-content">
                    <div class="navbar-left">
                        <button class="sidebar-toggle" id="toggleSidebar">
                            ☰
                        </button>
                        <h1 class="page-title"><?= $title ?? 'Dashboard' ?></h1>
                    </div>
                    <div class="user-menu">
                        <div class="dropdown user-dropdown">
                            <div class="user-avatar" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php 
                                    $displayName = 'Administrator';
                                    $profilePicture = null;
                                    
                                    // Get user data and profile picture
                                    if (isset($user) && is_array($user)) {
                                        $displayName = $user['full_name'] ?? $user['name'] ?? 'Administrator';
                                        $profilePicture = $user['profile_picture'] ?? null;
                                    } else if (session()->get('isLoggedIn')) {
                                        // Fallback to session data
                                        $displayName = session()->get('full_name') ?? session()->get('username') ?? 'Administrator';
                                        $profilePicture = session()->get('profile_picture') ?? null;
                                    }
                                    
                                    // Check if profile picture exists and file is accessible
                                    $showProfilePicture = false;
                                    if (!empty($profilePicture)) {
                                        $profilePicturePath = FCPATH . 'uploads/profile_pictures/' . $profilePicture;
                                        if (file_exists($profilePicturePath)) {
                                            $showProfilePicture = true;
                                        }
                                    }
                                ?>
                                
                                <?php if ($showProfilePicture): ?>
                                    <img src="<?= base_url('uploads/profile_pictures/' . $profilePicture) ?>" alt="Profile Picture" loading="lazy">
                                <?php else: ?>
                                    <span class="initials"><?= strtoupper(substr($displayName, 0, 1)) ?></span>
                                <?php endif; ?>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header"><?php 
                                    if (isset($user) && is_array($user)) {
                                        echo $user['full_name'] ?? $user['name'] ?? 'Administrator';
                                    } else {
                                        echo 'Administrator';
                                    }
                                ?></h6></li>
                                <li><small class="dropdown-item-text text-muted"><?php 
                                    if (isset($user) && is_array($user)) {
                                        echo $user['role_name'] ?? $user['role'] ?? 'Super Admin';
                                    } else {
                                        echo 'Super Admin';
                                    }
                                ?></small></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('settings/profile') ?>">
                                    <i class="fas fa-user me-2"></i>Profil
                                </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('settings') ?>">
                                    <i class="fas fa-cog me-2"></i>Pengaturan
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Content Area -->
            <div class="content">
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success fade-in">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger fade-in">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('warning')): ?>
                    <div class="alert alert-warning fade-in">
                        <?= session()->getFlashdata('warning') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('info')): ?>
                    <div class="alert alert-info fade-in">
                        <?= session()->getFlashdata('info') ?>
                    </div>
                <?php endif; ?>
                
                <!-- Main Content -->
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>
    
    <script>
        /* Sidebar Toggle Functionality */
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const mobileOverlay = document.getElementById('mobileOverlay');
            
            if (toggleBtn && sidebar && mainContent) {
                // Toggle sidebar function
                function toggleSidebar() {
                    if (window.innerWidth <= 768) {
                        // Mobile: Toggle active class for slide-in/out
                        sidebar.classList.toggle('active');
                        if (mobileOverlay) {
                            mobileOverlay.classList.toggle('active');
                        }
                    } else {
                        // Desktop: Toggle collapsed class for minimize/expand
                        sidebar.classList.toggle('collapsed');
                        mainContent.classList.toggle('expanded');
                    }
                }
                
                // Toggle button click event
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
                
                // Mobile overlay click event
                if (mobileOverlay) {
                    mobileOverlay.addEventListener('click', function() {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.remove('active');
                            mobileOverlay.classList.remove('active');
                        }
                    });
                }
                
                // Close sidebar when clicking outside (mobile only)
                document.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768 && 
                        !sidebar.contains(e.target) && 
                        !toggleBtn.contains(e.target) && 
                        sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                        if (mobileOverlay) {
                            mobileOverlay.classList.remove('active');
                        }
                    }
                });
                
                // Handle window resize
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        // Desktop: Remove mobile classes
                        sidebar.classList.remove('active');
                        if (mobileOverlay) {
                            mobileOverlay.classList.remove('active');
                        }
                    } else {
                        // Mobile: Remove desktop classes
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('expanded');
                    }
                });
                
                // Initialize proper state based on screen size
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                    if (mobileOverlay) {
                        mobileOverlay.classList.remove('active');
                    }
                }
            }
            
            // Toggle submenu function
            function toggleSubmenu(element) {
                event.preventDefault();
                const submenu = element.nextElementSibling;
                if (submenu && submenu.classList.contains('submenu')) {
                    const isCurrentlyOpen = submenu.classList.contains('show');
                    
                    // Close all other submenus first
                    const allSubmenus = document.querySelectorAll('.submenu');
                    allSubmenus.forEach(otherSubmenu => {
                        if (otherSubmenu !== submenu) {
                            otherSubmenu.classList.remove('show');
                        }
                    });
                    
                    // Toggle current submenu
                    if (isCurrentlyOpen) {
                        submenu.classList.remove('show');
                    } else {
                        submenu.classList.add('show');
                    }
                    
                    // Update arrow rotation
                    const arrow = element.querySelector('.submenu-arrow');
                    if (arrow) {
                        if (submenu.classList.contains('show')) {
                            arrow.style.transform = 'rotate(180deg)';
                        } else {
                            arrow.style.transform = 'rotate(0deg)';
                        }
                    }
                }
            }
            
            // Make toggleSubmenu available globally
            window.toggleSubmenu = toggleSubmenu;
            
            // Handle avatar image load errors
            const avatarImg = document.querySelector('.user-avatar img');
            if (avatarImg) {
                avatarImg.addEventListener('error', function() {
                    this.style.display = 'none';
                    // Show initials fallback
                    const initials = this.parentElement.querySelector('.initials');
                    if (initials) {
                        initials.style.display = 'flex';
                    }
                });
                
                avatarImg.addEventListener('load', function() {
                    // Hide initials when image loads successfully
                    const initials = this.parentElement.querySelector('.initials');
                    if (initials) {
                        initials.style.display = 'none';
                    }
                });
            }
            
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });
        
        // Update avatar globally when changed
        function updateAvatarGlobally(newImageSrc) {
            const avatars = document.querySelectorAll('.user-avatar');
            avatars.forEach(function(avatar) {
                const img = avatar.querySelector('img');
                const initials = avatar.querySelector('.initials');
                
                if (newImageSrc) {
                    if (img) {
                        img.src = newImageSrc;
                        img.style.display = 'block';
                    } else {
                        // Create new img element
                        const newImg = document.createElement('img');
                        newImg.src = newImageSrc;
                        newImg.alt = 'Profile Picture';
                        newImg.loading = 'lazy';
                        avatar.prepend(newImg);
                    }
                    
                    if (initials) {
                        initials.style.display = 'none';
                    }
                } else {
                    if (img) {
                        img.style.display = 'none';
                    }
                    if (initials) {
                        initials.style.display = 'flex';
                    }
                }
            });
        }
    </script>
</body>
</html>
