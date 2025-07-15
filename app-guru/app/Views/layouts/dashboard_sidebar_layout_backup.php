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
        /* Modern Light Elegant Theme Variables */
        :root {
            --primary-blue: #4A90E2;
            --light-blue: #E3F2FD;
            --accent-blue: #2196F3;
            --elegant-gray: #F8F9FA;
            --text-primary: #2C3E50;
            --text-secondary: #6C757D;
            --border-light: #E9ECEF;
            --shadow-soft: rgba(74, 144, 226, 0.1);
            --gradient-primary: linear-gradient(135deg, #4A90E2 0%, #2196F3 100%);
            --gradient-light: linear-gradient(135deg, #F8F9FA 0%, #FFFFFF 100%);
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
            background: linear-gradient(180deg, #FFFFFF 0%, #F8F9FA 100%);
            border-right: 1px solid var(--border-light);
            box-shadow: 4px 0 15px var(--shadow-soft);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            scrollbar-width: thin;
            scrollbar-color: var(--border-light) transparent;
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
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 20px 15px;
            justify-content: center;
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

        /* Role-based styling */
        /* Navigation Items */
        .nav-item {
            margin: 2px 12px;
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid var(--border-light);
        }

        .role-section .nav-section-title::after {
            display: none;
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

        .role-info {
            padding: 8px 12px;
        }

        .role-info small {
            color: var(--text-secondary);
            font-size: 0.75rem;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: var(--elegant-gray);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 24px;
        }
            margin-right: 0;
        }

        .nav-text {
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .nav-text {
            display: none;
        }

        .nav-badge {
            background: #e53e3e;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: auto;
        }

        .sidebar.collapsed .nav-badge {
            display: none;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        /* Header */
        .main-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 15px 25px;
        }

        .header-content {
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .menu-toggle {
            background: transparent;
            border: none;
            font-size: 1.3rem;
            color: #4a5568;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            margin-right: 15px;
            transition: all 0.3s ease;
        }

        .menu-toggle:hover {
            background: #f7fafc;
            color: #2d3748;
        }

        .header-user {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: white;
            font-weight: 600;
        }

        .user-info h6 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: #2d3748;
        }

        .user-info small {
            color: #718096;
            font-size: 0.8rem;
        }

        /* Content Area */
        .content-area {
            padding: 25px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .page-subtitle {
            color: #718096;
            font-size: 0.95rem;
            margin-bottom: 25px;
        }

        /* Cards */
        .dashboard-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            margin-bottom: 25px;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .stats-card {
            padding: 25px;
            text-align: center;
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
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.5rem;
            color: white;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .stats-label {
            color: #718096;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }

        .alert-success {
            background: #f0fff4;
            color: #2f855a;
            border-left-color: #38a169;
        }

        .alert-danger {
            background: #fef5e7;
            color: #c53030;
            border-left-color: #e53e3e;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 0;
            }
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="<?= base_url('/dashboard') ?>" class="sidebar-brand">
                    <div class="brand-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="brand-text">Smart BookKeeping</div>
                </a>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>

            <div class="sidebar-nav">
                <!-- Dashboard Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Dashboard Bimbingan Konseling</div>
                    <div class="nav-item">
                        <a href="<?= base_url('/dashboard') ?>" class="nav-link <?= (current_url() == base_url('/dashboard')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <span class="nav-text">Beranda BK</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/profile') ?>" class="nav-link <?= (current_url() == base_url('/profile')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <span class="nav-text">Profil Konselor</span>
                        </a>
                    </div>
                </div>

                <!-- GURU MATA PELAJARAN - Deteksi Dini Section -->
                <div class="nav-section role-section" data-role="guru_mapel">
                    <div class="nav-section-title">
                        <i class="fas fa-search me-2"></i>Deteksi Dini Siswa
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/radar-kelas') ?>" class="nav-link <?= (strpos(current_url(), '/radar-kelas') !== false && strpos(current_url(), 'dashboard-wali') === false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-radar"></i>
                            <span class="nav-text">Monitor Perilaku</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/radar-kelas/lapor-cepat') ?>" class="nav-link <?= (strpos(current_url(), 'lapor-cepat') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-exclamation-triangle"></i>
                            <span class="nav-text">Laporan Masalah Siswa</span>
                            <span class="nav-badge bg-danger">!</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/radar-kelas/riwayat-sinyal') ?>" class="nav-link <?= (strpos(current_url(), 'riwayat-sinyal') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-history"></i>
                            <span class="nav-text">Riwayat Laporan</span>
                        </a>
                    </div>
                </div>

                <!-- WALI KELAS - Pendampingan Kelas Section -->
                <div class="nav-section role-section" data-role="wali_kelas">
                    <div class="nav-section-title">
                        <i class="fas fa-users-cog me-2"></i>Pendampingan Kelas
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/radar-kelas/dashboard-wali') ?>" class="nav-link <?= (strpos(current_url(), 'dashboard-wali') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <span class="nav-text">Dashboard Kelas</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/radar-kelas/dashboard-wali') ?>" class="nav-link">
                            <i class="nav-icon fas fa-exclamation-circle"></i>
                            <span class="nav-text">Masalah Siswa Kelas</span>
                            <span class="nav-badge bg-warning">5</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <span class="nav-text">Konsultasi Orang Tua</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-share-alt"></i>
                            <span class="nav-text">Rujukan ke BK</span>
                        </a>
                    </div>
                </div>

                <!-- GURU BK - Layanan Konseling Section -->
                <div class="nav-section role-section" data-role="guru_bk">
                    <div class="nav-section-title">
                        <i class="fas fa-heart me-2"></i>Layanan Konseling
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/konseling') ?>" class="nav-link <?= (strpos(current_url(), '/konseling') !== false && strpos(current_url(), 'manajemen-kasus') === false && strpos(current_url(), 'laporan-statistik') === false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-heart"></i>
                            <span class="nav-text">Dashboard Konseling</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/konseling/manajemen-kasus') ?>" class="nav-link <?= (strpos(current_url(), 'manajemen-kasus') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <span class="nav-text">Kasus Konseling</span>
                            <span class="nav-badge bg-danger">8</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <span class="nav-text">Jadwal Konseling</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <span class="nav-text">Konseling Kelompok</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/konseling/laporan-statistik') ?>" class="nav-link <?= (strpos(current_url(), 'laporan-statistik') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <span class="nav-text">Laporan BK</span>
                        </a>
                    </div>
                </div>

                <!-- GURU BK - Asesmen Bakat Minat Section -->
                <div class="nav-section role-section" data-role="guru_bk">
                    <div class="nav-section-title">
                        <i class="fas fa-brain me-2"></i>Asesmen Bakat Minat
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/asesmen-bakat-minat') ?>" class="nav-link <?= (strpos(current_url(), '/asesmen-bakat-minat') !== false && strpos(current_url(), 'hasil-tes') === false && strpos(current_url(), 'analisis') === false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-brain"></i>
                            <span class="nav-text">Dashboard Asesmen</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/asesmen-bakat-minat/tes-online') ?>" class="nav-link <?= (strpos(current_url(), 'tes-online') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-laptop-code"></i>
                            <span class="nav-text">Tes Bakat Minat Online</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/asesmen-bakat-minat/hasil-tes') ?>" class="nav-link <?= (strpos(current_url(), 'hasil-tes') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-poll"></i>
                            <span class="nav-text">Hasil Tes Siswa</span>
                            <span class="nav-badge bg-warning">23</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/asesmen-bakat-minat/analisis') ?>" class="nav-link <?= (strpos(current_url(), '/analisis') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <span class="nav-text">Analisis Bakat Minat</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/asesmen-bakat-minat/rekomendasi') ?>" class="nav-link">
                            <i class="nav-icon fas fa-lightbulb"></i>
                            <span class="nav-text">Rekomendasi Jurusan</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/asesmen-bakat-minat/laporan') ?>" class="nav-link">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <span class="nav-text">Laporan Asesmen</span>
                        </a>
                    </div>
                </div>

                <!-- KEPALA SEKOLAH - Supervisi BK Section -->
                <div class="nav-section role-section" data-role="kepala_sekolah">
                    <div class="nav-section-title">
                        <i class="fas fa-crown me-2"></i>Supervisi Program BK
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <span class="nav-text">Overview BK Sekolah</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <span class="nav-text">Laporan Program BK</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tasks"></i>
                            <span class="nav-text">Evaluasi Layanan BK</span>
                        </a>
                    </div>
                </div>

                <!-- Data Siswa untuk Konseling -->
                <div class="nav-section">
                    <div class="nav-section-title">Data Konseling</div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <span class="nav-text">Data Siswa</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <span class="nav-text">Profil Siswa</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <span class="nav-text">Asesmen Siswa</span>
                        </a>
                    </div>
                </div>

                <!-- Filter Role Section -->
                <div class="nav-section">
                    <div class="nav-section-title">
                        <i class="fas fa-filter me-2"></i>Filter Menu
                    </div>
                    <div class="nav-item">
                        <div class="role-selector">
                            <select id="roleSelector" class="form-select form-select-sm">
                                <option value="all">Tampilkan Semua Menu</option>
                                <option value="guru_mapel">Guru Mata Pelajaran</option>
                                <option value="wali_kelas">Wali Kelas</option>
                                <option value="guru_bk">Guru BK</option>
                                <option value="kepala_sekolah">Kepala Sekolah</option>
                            </select>
                        </div>
                    </div>
                    <div class="nav-item">
                        <div class="role-info">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Filter menu berdasarkan peran
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Pengaturan BK -->
                <div class="nav-section">
                    <div class="nav-section-title">Pengaturan</div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <span class="nav-text">Pengaturan BK</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/logout') ?>" class="nav-link text-danger">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <span class="nav-text">Keluar</span>
                        </a>
                    </div>
                </div>

                <!-- Pengaturan Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Pengaturan</div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <span class="nav-text">Pengaturan</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="<?= base_url('/logout') ?>" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <span class="nav-text">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Header -->
            <header class="main-header">
                <div class="header-content">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="header-user">
                        <div class="user-avatar">
                            <?= strtoupper(substr(session()->get('full_name') ?? 'G', 0, 1)) ?>
                        </div>
                        <div class="user-info">
                            <h6><?= esc(session()->get('full_name') ?? 'Guru') ?></h6>
                            <small><?= esc(session()->get('username') ?? '') ?></small>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const menuToggle = document.getElementById('menuToggle');
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Desktop toggle (collapse/expand)
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                
                // Save state to localStorage
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
                
                // Update toggle icon
                const toggleIcon = sidebarToggle.querySelector('i');
                if (isCollapsed) {
                    toggleIcon.className = 'fas fa-chevron-right';
                } else {
                    toggleIcon.className = 'fas fa-chevron-left';
                }
            }

            // Mobile toggle (show/hide)
            function toggleMobileSidebar() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.toggle('show');
                } else {
                    toggleSidebar();
                }
            }

            // Event listeners
            menuToggle.addEventListener('click', toggleMobileSidebar);
            sidebarToggle.addEventListener('click', toggleSidebar);

            // Restore sidebar state from localStorage
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true' && window.innerWidth > 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                sidebarToggle.querySelector('i').className = 'fas fa-chevron-right';
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                    sidebar.classList.remove('show');
                } else {
                    // Restore desktop state
                    const savedState = localStorage.getItem('sidebarCollapsed');
                    if (savedState === 'true') {
                        sidebar.classList.add('collapsed');
                        mainContent.classList.add('expanded');
                    }
                }
            });

            // Close mobile sidebar when clicking outside
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });

            // Role-based Menu Control
            const roleSelector = document.getElementById('roleSelector');
            const roleSections = document.querySelectorAll('.role-section');
            
            // Function to show/hide menu sections based on role
            function filterMenuByRole(selectedRole) {
                roleSections.forEach(section => {
                    const sectionRole = section.getAttribute('data-role');
                    
                    if (selectedRole === 'all') {
                        section.style.display = 'block';
                        section.classList.remove('hidden');
                    } else if (sectionRole === selectedRole) {
                        section.style.display = 'block';
                        section.classList.remove('hidden');
                    } else {
                        section.style.display = 'none';
                        section.classList.add('hidden');
                    }
                });
                
                // Save selected role to localStorage
                localStorage.setItem('selectedBKRole', selectedRole);
            }
            
            // Event listener for role selector
            if (roleSelector) {
                roleSelector.addEventListener('change', function() {
                    filterMenuByRole(this.value);
                });
                
                // Load saved role filter on page load
                const savedRole = localStorage.getItem('selectedBKRole');
                if (savedRole) {
                    roleSelector.value = savedRole;
                    filterMenuByRole(savedRole);
                } else {
                    // Default behavior: show user's actual role if available, otherwise show all
                    <?php if (session()->has('user_role')): ?>
                    const userRole = '<?= session()->get('user_role') ?>';
                    roleSelector.value = userRole;
                    filterMenuByRole(userRole);
                    <?php else: ?>
                    // Show all menus by default if no user role detected
                    filterMenuByRole('all');
                    <?php endif; ?>
                }
            }

            // Add active class to current page
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const linkPath = new URL(link.href).pathname;
                if (linkPath === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
