<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'SmartBK - Sistem Bimbingan Konseling' ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: <?= $theme['primary_color'] ?>;
            --sidebar-bg: <?= $theme['sidebar_bg'] ?>;
            --accent-color: <?= $theme['accent_color'] ?>;
        }
        
        .content-wrapper {
            background-color: #f4f6f9;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .info-box-icon {
            background-color: var(--primary-color) !important;
        }
        
        .small-box > .small-box-footer {
            background-color: rgba(0,0,0,0.1);
        }
        
        .navbar-light .navbar-nav .nav-link {
            color: #495057;
        }
        
        .main-header {
            border-bottom: 1px solid var(--accent-color);
        }
        
        /* Role-specific card colors */
        .card-guru-bk .card-header { background: linear-gradient(45deg, #007bff, #17a2b8); }
        .card-guru-kelas .card-header { background: linear-gradient(45deg, #28a745, #20c997); }
        .card-wali-kelas .card-header { background: linear-gradient(45deg, #6f42c1, #e83e8c); }
        .card-kepala-sekolah .card-header { background: linear-gradient(45deg, #e74c3c, #fd79a8); }
        
        /* Animation for cards */
        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        /* Custom scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: var(--sidebar-bg);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--accent-color);
            border-radius: 3px;
        }
        
        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content-header h1 {
                font-size: 1.5rem;
            }
            
            .card-header h3 {
                font-size: 1.1rem;
            }
        }
    </style>
    
    <?= $this->renderSection('css') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/assets/img/school-logo.png" alt="SmartBK Logo" height="60" width="60">
            <p class="mt-2">Loading SmartBK...</p>
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/dashboard" class="nav-link">Dashboard</a>
                </li>
                <?php if ($userRole === 'guru_bk'): ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/konseling" class="nav-link">Konseling</a>
                    </li>
                <?php elseif ($userRole === 'guru_kelas'): ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/pembelajaran" class="nav-link">Pembelajaran</a>
                    </li>
                <?php elseif ($userRole === 'wali_kelas'): ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/monitoring" class="nav-link">Monitoring</a>
                    </li>
                <?php elseif ($userRole === 'kepala_sekolah'): ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/analytics" class="nav-link">Analytics</a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge" id="notification-count">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">3 Notifikasi</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> Pesan baru
                            <span class="float-right text-muted text-sm">3 menit</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> Siswa perlu perhatian
                            <span class="float-right text-muted text-sm">12 menit</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> Laporan selesai
                            <span class="float-right text-muted text-sm">2 jam</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
                    </div>
                </li>
                
                <!-- User Account Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <img src="/assets/img/user-avatar.png" alt="User Avatar" class="img-circle" style="width: 25px; height: 25px;">
                        <span class="d-none d-md-inline ml-1"><?= session()->get('user_name') ?? 'Admin' ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-header">
                            <strong><?= session()->get('user_name') ?? 'Admin User' ?></strong><br>
                            <small class="text-muted"><?= $roleDisplayName ?></small>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="/profile" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profil Saya
                        </a>
                        <a href="/settings" class="dropdown-item">
                            <i class="fas fa-cogs mr-2"></i> Pengaturan
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="/logout" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                        </a>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <?= $this->include('layouts/sidebar') ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?= $pageTitle ?? 'Dashboard' ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <?php if (isset($breadcrumbs) && is_array($breadcrumbs)): ?>
                                    <?php foreach ($breadcrumbs as $crumb): ?>
                                        <?php if (isset($crumb['url'])): ?>
                                            <li class="breadcrumb-item"><a href="<?= $crumb['url'] ?>"><?= $crumb['title'] ?></a></li>
                                        <?php else: ?>
                                            <li class="breadcrumb-item active"><?= $crumb['title'] ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?= date('Y') ?> <a href="#">SmartBK</a>.</strong>
            Sistem Bimbingan Konseling Digital.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0 | <span class="text-muted"><?= $roleDisplayName ?></span>
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Initialize page
        $(document).ready(function() {
            // Remove preloader after page load
            setTimeout(function() {
                $('.preloader').fadeOut('slow');
            }, 500);
            
            // Auto-collapse sidebar on mobile
            if ($(window).width() < 768) {
                $('body').addClass('sidebar-collapse');
            }
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Sidebar search functionality
            $('.sidebar-search input').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('.nav-sidebar .nav-item').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
            
            // Update notification count (example)
            updateNotificationCount();
        });
        
        // Function to update notification count
        function updateNotificationCount() {
            // This would typically fetch from an API
            // For now, we'll simulate with random number
            var count = Math.floor(Math.random() * 10);
            $('#notification-count').text(count).toggle(count > 0);
        }
        
        // Function to show loading state
        function showLoading(element) {
            $(element).html('<span class="loading"></span> Loading...');
        }
        
        // Function to show toast notification
        function showToast(message, type = 'info') {
            var toastClass = 'toast-' + type;
            var toast = `
                <div class="toast ${toastClass}" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                    <div class="toast-header">
                        <strong class="mr-auto">SmartBK</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">${message}</div>
                </div>
            `;
            
            // Add toast container if not exists
            if ($('.toast-container').length === 0) {
                $('body').append('<div class="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>');
            }
            
            $('.toast-container').append(toast);
            $('.toast').last().toast('show');
        }
        
        // Global AJAX error handler
        $(document).ajaxError(function(event, xhr, settings, thrownError) {
            showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        });
    </script>
    
    <?= $this->renderSection('javascript') ?>
</body>
</html>
