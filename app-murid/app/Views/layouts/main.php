<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?? 'Safe Space - App Murid' ?></title>
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
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .navbar-nav .nav-link {
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            transform: translateY(-2px);
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg main-header">
        <div class="container">
            <a class="navbar-brand text-primary" href="<?= base_url('safe-space/dashboard') ?>">
                <i class="fas fa-heart me-2"></i>Safe Space
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('safe-space/dashboard') ?>">
                            <i class="fas fa-home me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('safe-space/konsul-cepat') ?>">
                            <i class="fas fa-comments me-2"></i>Konsul Cepat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('safe-space/jadwal-konseling') ?>">
                            <i class="fas fa-calendar me-2"></i>Jadwal Konseling
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('safe-space/jurnal-digital') ?>">
                            <i class="fas fa-book me-2"></i>Jurnal Digital
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('safe-space/pusat-informasi') ?>">
                            <i class="fas fa-info-circle me-2"></i>Pusat Informasi
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i><?= $nama ?? 'Guest' ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('dashboard') ?>">
                                <i class="fas fa-home me-2"></i>Dashboard Utama
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
