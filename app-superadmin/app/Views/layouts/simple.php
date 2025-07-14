<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Super Admin' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar-brand {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-nav {
            padding: 1rem 0;
        }
        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s ease;
        }
        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }
        .sidebar-nav .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background: #f8fafc;
        }
        .topbar {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .content-wrapper {
            padding: 2rem;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        .card-header {
            border-bottom: 1px solid #f1f3f4;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 15px 15px 0 0 !important;
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #3730a3 0%, #4338ca 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem;
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f8f9fa;
        }
        .badge {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            border-radius: 20px;
            font-weight: 500;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #f1f3f4;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.15);
        }
        .input-group-text {
            border-radius: 10px 0 0 10px;
            border: 2px solid #f1f3f4;
            border-right: none;
        }
        .stats-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid #f1f3f4;
            border-radius: 15px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .dropdown-item {
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .dropdown-item:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
            transform: translateX(5px);
        }
        .text-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .alert {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .avatar-sm {
            width: 32px;
            height: 32px;
        }
        .avatar-initial {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }
        .position-relative .badge {
            font-size: 0.6rem;
        }
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
                transition: margin-left 0.3s ease;
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .content-wrapper {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4 class="text-white mb-0">
                <i class="fas fa-user-shield me-2"></i>Super Admin
            </h4>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard') ?>">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('users') ?>">
                        <i class="fas fa-users me-2"></i>Manajemen User
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('schools') ?>">
                        <i class="fas fa-school me-2"></i>Sekolah
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('classes') ?>">
                        <i class="fas fa-chalkboard me-2"></i>Kelas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('subjects') ?>">
                        <i class="fas fa-book me-2"></i>Mata Pelajaran
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Mobile Overlay -->
    <div class="position-fixed w-100 h-100 bg-dark opacity-50 d-none" 
         id="sidebarOverlay" style="z-index: 999;"></div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-primary d-md-none me-3" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h5 class="mb-0 text-gradient"><?= $title ?? 'Dashboard' ?></h5>
                        <small class="text-muted">Selamat datang kembali, Administrator!</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <!-- Notifications -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary position-relative" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Notifikasi</h6></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-user-plus me-2 text-success"></i>
                                Pengguna baru terdaftar
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                                System update tersedia
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="#">Lihat semua</a></li>
                        </ul>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" 
                                data-bs-toggle="dropdown">
                            <div class="avatar-sm me-2">
                                <div class="avatar-initial rounded-circle bg-primary text-white">
                                    A
                                </div>
                            </div>
                            <span class="d-none d-sm-block">Administrator</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">
                                <i class="fas fa-user-circle me-2"></i>Administrator
                            </h6></li>
                            <li><a class="dropdown-item" href="<?= base_url('profile') ?>">
                                <i class="fas fa-user me-2"></i>Profile Saya
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('settings') ?>">
                                <i class="fas fa-cog me-2"></i>Pengaturan
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('show');
            overlay.classList.toggle('d-none');
        });

        // Close sidebar when clicking overlay
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.remove('show');
            overlay.classList.add('d-none');
        });

        // Close sidebar when clicking on a link (mobile)
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('sidebarOverlay');
                    
                    sidebar.classList.remove('show');
                    overlay.classList.add('d-none');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                
                sidebar.classList.remove('show');
                overlay.classList.add('d-none');
            }
        });
    </script>
</body>
</html>
