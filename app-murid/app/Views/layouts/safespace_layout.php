<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Safe Space - App Murid' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(135deg, #e8f5e8 0%, #e3f2fd 25%, #f3e5f5 50%, #fff3e0 75%, #e1f5fe 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .content-wrapper {
            min-height: calc(100vh - 80px);
            padding: 20px 0;
        }
        
        .card-custom {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .btn-safe-space {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-safe-space:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
            color: white;
        }
        
        .navigation-menu {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .nav-item-safe {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-item-safe:hover {
            background: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
        }
        
        .nav-item-safe.active {
            background: #4CAF50;
            color: white;
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Main Header with Navigation and Notifications -->
    <header class="main-header sticky-top">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <!-- Logo and Title -->
                <div class="d-flex align-items-center">
                    <i class="fas fa-shield-alt text-success me-2" style="font-size: 1.8rem;"></i>
                    <div>
                        <h4 class="mb-0 text-success">Safe Space</h4>
                        <small class="text-muted">Ruang Aman untuk Konsultasi</small>
                    </div>
                </div>
                
                <!-- Navigation Menu -->
                <nav class="d-none d-md-flex align-items-center">
                    <a href="<?= base_url('safe-space/dashboard') ?>" class="nav-item-safe <?= (current_url() == base_url('safe-space/dashboard')) ? 'active' : '' ?>">
                        <i class="fas fa-home me-1"></i> Dashboard
                    </a>
                    <a href="<?= base_url('safe-space/konsul-cepat') ?>" class="nav-item-safe <?= (current_url() == base_url('safe-space/konsul-cepat')) ? 'active' : '' ?>">
                        <i class="fas fa-comments me-1"></i> Konsul Cepat
                    </a>
                    <a href="<?= base_url('safe-space/jadwal-konseling') ?>" class="nav-item-safe <?= (current_url() == base_url('safe-space/jadwal-konseling')) ? 'active' : '' ?>">
                        <i class="fas fa-calendar me-1"></i> Jadwal
                    </a>
                    <a href="<?= base_url('safe-space/jurnal-digital') ?>" class="nav-item-safe <?= (current_url() == base_url('safe-space/jurnal-digital')) ? 'active' : '' ?>">
                        <i class="fas fa-book me-1"></i> Jurnal
                    </a>
                    <a href="<?= base_url('safe-space/pusat-informasi') ?>" class="nav-item-safe <?= (current_url() == base_url('safe-space/pusat-informasi')) ? 'active' : '' ?>">
                        <i class="fas fa-info-circle me-1"></i> Info
                    </a>
                    <div class="dropdown">
                        <a class="nav-item-safe dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell me-1"></i> Notifikasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('safe-space/all-notifications-demo') ?>">
                                <i class="fas fa-magic me-2"></i>Demo Notifikasi
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('safe-space/notification-overview') ?>">
                                <i class="fas fa-chart-line me-2"></i>Overview Integrasi
                            </a></li>
                        </ul>
                    </div>
                </nav>
                
                <!-- Right Section: Notifications + User -->
                <div class="d-flex align-items-center">
                    <!-- Notification Bell Component -->
                    <?php include APPPATH . 'Views/components/notification_bell.php'; ?>
                    
                    <!-- User Menu -->
                    <div class="dropdown ms-3">
                        <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            <?= $nama ?? 'User' ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('settings') ?>"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Navigation -->
            <div class="d-md-none">
                <div class="navigation-menu">
                    <div class="row text-center">
                        <div class="col">
                            <a href="<?= base_url('safe-space/dashboard') ?>" class="nav-item-safe d-block">
                                <i class="fas fa-home d-block mb-1"></i>
                                <small>Dashboard</small>
                            </a>
                        </div>
                        <div class="col">
                            <a href="<?= base_url('safe-space/konsul-cepat') ?>" class="nav-item-safe d-block">
                                <i class="fas fa-comments d-block mb-1"></i>
                                <small>Chat</small>
                            </a>
                        </div>
                        <div class="col">
                            <a href="<?= base_url('safe-space/jadwal-konseling') ?>" class="nav-item-safe d-block">
                                <i class="fas fa-calendar d-block mb-1"></i>
                                <small>Jadwal</small>
                            </a>
                        </div>
                        <div class="col">
                            <a href="<?= base_url('safe-space/jurnal-digital') ?>" class="nav-item-safe d-block">
                                <i class="fas fa-book d-block mb-1"></i>
                                <small>Jurnal</small>
                            </a>
                        </div>
                        <div class="col">
                            <a href="<?= base_url('safe-space/pusat-informasi') ?>" class="nav-item-safe d-block">
                                <i class="fas fa-info-circle d-block mb-1"></i>
                                <small>Info</small>
                            </a>
                        </div>
                        <div class="col">
                            <a href="<?= base_url('safe-space/all-notifications-demo') ?>" class="nav-item-safe d-block">
                                <i class="fas fa-bell d-block mb-1"></i>
                                <small>Demo</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Auto-trigger notification untuk demo halaman baru -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trigger welcome notification setelah 2 detik
            setTimeout(() => {
                const currentPage = window.location.pathname;
                let pageTitle = 'Halaman Safe Space';
                
                if (currentPage.includes('konsul-cepat')) pageTitle = 'Konsul Cepat & Anonim';
                else if (currentPage.includes('jadwal-konseling')) pageTitle = 'Jadwal Konseling';
                else if (currentPage.includes('jurnal-digital')) pageTitle = 'Jurnal Digital';
                else if (currentPage.includes('pusat-informasi')) pageTitle = 'Pusat Informasi';
                else if (currentPage.includes('dashboard')) pageTitle = 'Dashboard Safe Space';
                
                const welcomeNotification = {
                    id: 'page-welcome-' + Date.now(),
                    type: 'info',
                    title: 'Selamat Datang!',
                    message: `Anda sedang mengakses ${pageTitle}. Sistem notifikasi realtime aktif.`,
                    timestamp: new Date().toISOString(),
                    read: false,
                    icon: 'fas fa-info-circle',
                    color: 'info',
                    url: '#'
                };
                
                // Only show if showToastNotification function exists (from notification component)
                if (typeof showToastNotification === 'function') {
                    showToastNotification(welcomeNotification);
                }
            }, 3000);
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
