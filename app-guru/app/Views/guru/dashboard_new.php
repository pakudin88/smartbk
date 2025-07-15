<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('header') ?>
<!-- Fixed Top Header -->
<div class="fixed-header bg-white shadow-sm border-bottom">
    <div class="container-fluid px-4">
        <div class="row align-items-center" style="height: 70px;">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <!-- Hamburger Menu Button -->
                    <button class="btn btn-light me-3 d-flex align-items-center justify-content-center" 
                            id="sidebarToggle" 
                            style="width: 40px; height: 40px; border-radius: 8px;">
                        <span class="navbar-toggler-icon-custom">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                    
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="fas fa-graduation-cap me-2"></i>SmartBK Dashboard
                    </h5>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- Notifications -->
                    <div class="dropdown me-3">
                        <button class="btn btn-light position-relative rounded-circle" type="button" data-bs-toggle="dropdown" style="width: 40px; height: 40px;">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                3
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Notifikasi</h6></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-plus me-2"></i>Siswa baru terdaftar</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>Jadwal konseling hari ini</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-exclamation-triangle me-2"></i>Kasus prioritas</a></li>
                        </ul>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="dropdown">
                        <button class="btn btn-light text-decoration-none d-flex align-items-center rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                            <div class="user-avatar me-2">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user_name ?? 'Guru BK') ?>&background=4A90E2&color=fff&size=32" 
                                     alt="Profile" class="rounded-circle" width="32" height="32">
                            </div>
                            <div class="user-info text-start d-none d-md-block">
                                <div class="user-name text-dark fw-medium" style="font-size: 0.9rem;">
                                    <?= esc($user_name ?? 'Guru BK') ?>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down ms-2 text-muted" style="font-size: 0.7rem;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('/profile') ?>"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard v3</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item active">Dashboard v3</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Welcome Card -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="text-primary mb-2">
                                <i class="fas fa-hand-wave me-2"></i>Selamat Datang, Guru BK!
                            </h4>
                            <p class="mb-2">Anda berhasil login ke sistem Bimbingan dan Konseling SmartBK.</p>
                            <div class="d-flex flex-wrap gap-3 mt-3">
                                <span class="badge bg-primary px-3 py-2">
                                    <i class="fas fa-users me-1"></i>Siswa Terbimbing: <?= isset($stats['siswa_terbimbing']) ? $stats['siswa_terbimbing'] : '145' ?>
                                </span>
                                <span class="badge bg-success px-3 py-2">
                                    <i class="fas fa-calendar-check me-1"></i>Sesi Konseling: <?= isset($stats['sesi_konseling']) ? $stats['sesi_konseling'] : '28' ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-friends fs-2"></i>
                            </div>
                            <h6 class="text-muted mt-2">Portal Guru BK Aktif</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards Row -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="inner text-white">
                            <h3><?= isset($stats['siswa_terbimbing']) ? number_format($stats['siswa_terbimbing']) : '820' ?></h3>
                            <p>Online Store Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="#" class="small-box-footer">View Report <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div class="inner text-white">
                            <h3>$<?= isset($stats['sesi_konseling']) ? number_format($stats['sesi_konseling']) : '18,230' ?></h3>
                            <p>Sales</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <a href="#" class="small-box-footer">View Report <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="inner text-white">
                            <h3><?= isset($stats['kasus_prioritas']) ? number_format($stats['kasus_prioritas']) : '44' ?></h3>
                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                        <div class="inner text-white">
                            <h3><?= isset($stats['asesmen_selesai']) ? number_format($stats['asesmen_selesai']) : '65' ?></h3>
                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat Konseling
                    </h5>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?= base_url('/konseling/individual') ?>" class="btn btn-outline-primary w-100 p-3 text-decoration-none">
                                <i class="fas fa-user d-block mb-2 fs-2"></i>
                                <strong>Konseling Individual</strong><br>
                                <small>Sesi konseling perorangan</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?= base_url('/konseling/kelompok') ?>" class="btn btn-outline-success w-100 p-3 text-decoration-none">
                                <i class="fas fa-users d-block mb-2 fs-2"></i>
                                <strong>Konseling Kelompok</strong><br>
                                <small>Bimbingan kelompok siswa</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?= base_url('/asesmen') ?>" class="btn btn-outline-warning w-100 p-3 text-decoration-none">
                                <i class="fas fa-clipboard-list d-block mb-2 fs-2"></i>
                                <strong>Asesmen</strong><br>
                                <small>Tes psikologi & bakat</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?= base_url('/bimbingan-karir') ?>" class="btn btn-outline-info w-100 p-3 text-decoration-none">
                                <i class="fas fa-briefcase d-block mb-2 fs-2"></i>
                                <strong>Bimbingan Karir</strong><br>
                                <small>Panduan pilihan karir</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Activities -->
            <div class="row">
                <div class="col-md-6">
                    <!-- Online Store Visitors -->
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Online Store Visitors</h3>
                                <a href="javascript:void(0);" class="text-primary">View Report</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">820</span>
                                    <span>Visitors Over Time</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> 12.5%
                                    </span>
                                    <span class="text-muted">Since last week</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="visitorsChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <!-- Sales Chart -->
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Sales</h3>
                                <a href="javascript:void(0);" class="text-primary">View Report</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">$18,230.00</span>
                                    <span>Sales Over Time</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> 33.1%
                                    </span>
                                    <span class="text-muted">Since last month</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="salesChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table and Online Store Overview -->
            <div class="row">
                <div class="col-md-8">
                    <!-- Products -->
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Products</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Sales</th>
                                        <th>More</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <img src="https://via.placeholder.com/40" alt="Product" class="img-circle img-size-32 mr-2">
                                            Some Product
                                        </td>
                                        <td>$13 USD</td>
                                        <td><span class="text-success"><i class="fas fa-arrow-up"></i> 12%</span> 12,000 Sold</td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="https://via.placeholder.com/40" alt="Product" class="img-circle img-size-32 mr-2">
                                            Another Product
                                        </td>
                                        <td>$29 USD</td>
                                        <td><span class="text-warning"><i class="fas fa-arrow-down"></i> 0.5%</span> 123,234 Sold</td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- Online Store Overview -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Online Store Overview</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="far fa-bookmark"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Bookmarks</span>
                                            <span class="info-box-number">12%</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-info" style="width: 12%"></div>
                                            </div>
                                            <span class="progress-description">
                                                CONVERSION RATE
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

/* Enhanced Header Styles */
<style>
/* Base body styling */
body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* Fixed Header Styles */
.fixed-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 9999;
    backdrop-filter: blur(10px);
    width: 100%;
    height: 70px;
}

/* Content Wrapper - AdminLTE Style */
.content-wrapper {
    margin-left: 280px;
    margin-top: 70px;
    min-height: calc(100vh - 70px);
    background-color: #f4f6f9;
    padding: 0;
    position: relative;
    top: 0;
}

.content-wrapper.expanded {
    margin-left: 70px;
}

/* Content Header */
.content-header {
    padding: 15px 30px 0 30px;
    margin-bottom: 0;
}

.content-header h1 {
    font-size: 1.8rem;
    margin: 0;
    color: #343a40;
}

/* Main Content Section */
.content {
    padding: 0 30px 30px 30px;
}

/* Breadcrumb Styling */
.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
    font-size: 0.9rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "/";
    color: #6c757d;
    padding: 0 8px;
}

.breadcrumb-item a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #6c757d;
}

/* Small Box Components (AdminLTE Style) */
.small-box {
    border-radius: 0.25rem;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    display: block;
    margin-bottom: 20px;
    position: relative;
}

.small-box > .inner {
    padding: 20px;
}

.small-box > .inner h3 {
    font-size: 2.2rem;
    font-weight: 700;
    margin: 0;
    white-space: nowrap;
    padding: 0;
}

.small-box > .inner p {
    font-size: 1rem;
    margin: 0;
}

.small-box .icon {
    color: rgba(255,255,255,.8);
    z-index: 0;
}

.small-box .icon > i {
    font-size: 90px;
    position: absolute;
    right: 15px;
    top: 15px;
    transition: all .3s linear;
}

.small-box .small-box-footer {
    background-color: rgba(0,0,0,.1);
    color: rgba(255,255,255,.8);
    display: block;
    padding: 3px 0;
    position: relative;
    text-align: center;
    text-decoration: none;
    z-index: 10;
}

.small-box .small-box-footer:hover {
    background-color: rgba(0,0,0,.15);
    color: #fff;
}

/* Card Styling */
.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 1rem;
    border: 0;
    border-radius: 0.25rem;
}

.card-header {
    background-color: transparent;
    border-bottom: 1px solid rgba(0,0,0,.125);
    padding: 0.75rem 1.25rem;
    position: relative;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

.card-title {
    float: left;
    font-size: 1.1rem;
    font-weight: 400;
    margin: 0;
}

.card-tools {
    float: right;
    margin-right: -0.625rem;
}

/* Info Box */
.info-box {
    display: flex;
    margin-bottom: 1rem;
    min-height: 80px;
    padding: 10px;
    position: relative;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    border-radius: 0.25rem;
    background-color: #fff;
}

.info-box .info-box-icon {
    border-radius: 0.25rem;
    align-items: center;
    display: flex;
    font-size: 1.875rem;
    justify-content: center;
    text-align: center;
    width: 70px;
}

.info-box .info-box-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    line-height: 1.8;
    flex: 1;
    padding: 0 10px;
}

.info-box .info-box-number {
    display: block;
    margin-top: auto;
    font-weight: 700;
}

.info-box .info-box-text {
    display: block;
    font-size: 0.875rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.info-box .progress {
    background-color: rgba(0,0,0,.125);
    height: 2px;
    margin: 5px 0;
}

.progress-description {
    color: #6c757d;
    font-size: 0.75rem;
}

/* Table Styling */
.table-responsive {
    border-radius: 0.25rem;
}

.table th,
.table td {
    border-top: 1px solid #dee2e6;
    padding: 0.75rem;
    vertical-align: top;
}

.img-circle {
    border-radius: 50%;
}

.img-size-32 {
    height: 32px;
    width: 32px;
}

/* Hamburger Menu Styling */
#sidebarToggle {
    border: 1px solid #e9ecef;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}

#sidebarToggle:hover {
    background-color: #e9ecef;
    border-color: #4A90E2;
}

.navbar-toggler-icon-custom {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 18px;
    height: 14px;
}

.navbar-toggler-icon-custom span {
    display: block;
    height: 2px;
    width: 100%;
    background-color: #6c757d;
    border-radius: 1px;
    transition: all 0.3s ease;
}

#sidebarToggle:hover .navbar-toggler-icon-custom span {
    background-color: #4A90E2;
}

/* Animation for hamburger menu when active */
#sidebarToggle.active .navbar-toggler-icon-custom span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

#sidebarToggle.active .navbar-toggler-icon-custom span:nth-child(2) {
    opacity: 0;
}

#sidebarToggle.active .navbar-toggler-icon-custom span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
}

/* User avatar and profile styling */
.user-avatar img {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.dropdown-toggle:hover .user-avatar img {
    border-color: #4A90E2;
}

/* Enhanced dropdown styling */
.dropdown-menu {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 12px;
    margin-top: 8px;
    min-width: 200px;
}

.dropdown-item {
    padding: 10px 16px;
    font-size: 0.9rem;
    border-radius: 8px;
    margin: 2px 8px;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .content-wrapper {
        margin-left: 0;
        margin-top: 70px;
    }
    
    .content-header {
        padding: 15px;
    }
    
    .content {
        padding: 0 15px 30px 15px;
    }
    
    .fixed-header .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .fixed-header .row {
        flex-direction: column;
        height: auto !important;
        padding: 10px 0;
    }
    
    .fixed-header .col-md-6:first-child {
        margin-bottom: 10px;
    }
}

@media (max-width: 576px) {
    .content-header h1 {
        font-size: 1.5rem;
    }
    
    .small-box > .inner h3 {
        font-size: 1.8rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle Functionality
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const contentWrapper = document.querySelector('.content-wrapper');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            // Toggle active class for button animation
            this.classList.toggle('active');
            
            // Toggle sidebar visibility - hide/show the MENU not content
            if (sidebar) {
                sidebar.classList.toggle('collapsed');
                
                // For mobile - slide sidebar in/out
                if (window.innerWidth <= 768) {
                    sidebar.classList.toggle('show');
                }
            }
            
            // Adjust main content margin when sidebar is collapsed
            if (contentWrapper) {
                contentWrapper.classList.toggle('expanded');
            }
            
            // Toggle overlay for mobile
            if (window.innerWidth <= 768 && sidebarOverlay) {
                sidebarOverlay.classList.toggle('show');
            }
        });
    }

    // Close sidebar when clicking overlay (mobile only)
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            if (sidebar && window.innerWidth <= 768) {
                sidebar.classList.remove('show');
                sidebar.classList.add('collapsed');
            }
            this.classList.remove('show');
            if (sidebarToggle) {
                sidebarToggle.classList.remove('active');
            }
            if (contentWrapper) {
                contentWrapper.classList.add('expanded');
            }
        });
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            // Reset mobile classes on desktop
            if (sidebar) {
                sidebar.classList.remove('show');
            }
            if (sidebarOverlay) {
                sidebarOverlay.classList.remove('show');
            }
        }
    });

    // Visitors Chart
    const visitorsCtx = document.getElementById('visitorsChart');
    if (visitorsCtx) {
        new Chart(visitorsCtx, {
            type: 'line',
            data: {
                labels: ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
                datasets: [{
                    label: 'This Week',
                    data: [100, 120, 140, 160, 150, 170, 180],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Last Week',
                    data: [80, 100, 90, 110, 100, 120, 130],
                    borderColor: '#6c757d',
                    backgroundColor: 'rgba(108, 117, 125, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Sales Chart
    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                datasets: [{
                    label: 'This year',
                    data: [1000, 2000, 3000, 2500, 2700, 2500, 3000],
                    backgroundColor: '#007bff'
                }, {
                    label: 'Last year',
                    data: [800, 1500, 2000, 2200, 2000, 2300, 2500],
                    backgroundColor: '#6c757d'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
