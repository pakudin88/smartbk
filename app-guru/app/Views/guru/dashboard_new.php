<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>

<style>
/* AdminLTE-inspired Layout Structure */
:root {
    /* AdminLTE Color Scheme */
    --primary-color: #007bff;
    --primary-gradient: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    --success-color: #28a745;
    --success-gradient: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    --warning-color: #ffc107;
    --warning-gradient: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    --info-color: #17a2b8;
    --info-gradient: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
    --danger-color: #dc3545;
    --danger-gradient: linear-gradient(135deg, #dc3545 0%, #bd2130 100%);
    --secondary-color: #6c757d;
    --light-color: #f8f9fa;
    --dark-color: #343a40;
    
    /* AdminLTE Spacing */
    --spacing-xs: 0.25rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
    --spacing-2xl: 3rem;
    
    /* AdminLTE Border & Shadow */
    --border-radius: 0.375rem;
    --border-radius-lg: 0.5rem;
    --border-radius-xl: 0.75rem;
    --border-color: #dee2e6;
    --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    --shadow-card: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    --shadow-hover: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    
    /* AdminLTE Transitions */
    --transition: all 0.15s ease-in-out;
    --transition-fast: all 0.1s ease-in-out;
}

/* Override default layout untuk AdminLTE structure */
.content-card {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
    margin: 0 !important;
}

.main-header {
    margin-bottom: 0 !important;
    border-radius: 0 !important;
}

/* AdminLTE Content Header */
.content-header {
    background: white;
    padding: 1rem 1.5rem;
    margin: 0 -24px 1.5rem -24px;
    border-bottom: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
}

.content-header h1 {
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--dark-color);
    margin: 0 0 0.5rem 0;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
    font-size: 0.875rem;
}

.breadcrumb-item {
    color: var(--secondary-color);
}

.breadcrumb-item.active {
    color: var(--primary-color);
}

/* AdminLTE Main Content */
.content {
    padding: 0;
}

/* AdminLTE Info Box Styles */
.info-box {
    display: flex;
    align-items: center;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-card);
    padding: 1rem;
    margin-bottom: 1rem;
    transition: var(--transition);
    border: 1px solid var(--border-color);
}

.info-box:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-2px);
}

.info-box-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 70px;
    height: 70px;
    border-radius: var(--border-radius);
    color: white;
    font-size: 1.75rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.info-box-content {
    flex: 1;
}

.info-box-text {
    color: var(--secondary-color);
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    margin: 0 0 0.25rem 0;
}

.info-box-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark-color);
    margin: 0;
    line-height: 1.2;
}

.info-box-more {
    margin-top: 0.5rem;
}

.info-box-more .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

/* AdminLTE Small Box (Alternative Style) */
.small-box {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-card);
    overflow: hidden;
    position: relative;
    transition: var(--transition);
    border: 1px solid var(--border-color);
}

.small-box:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-2px);
}

.small-box-header {
    padding: 1.5rem 1rem 0 1rem;
    position: relative;
    z-index: 2;
}

.small-box h3 {
    font-size: 2.2rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
    color: white;
}

.small-box p {
    font-size: 0.9rem;
    margin: 0;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

.small-box-icon {
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 4rem;
    color: rgba(255, 255, 255, 0.3);
    z-index: 1;
}

.small-box-footer {
    background: rgba(0, 0, 0, 0.1);
    color: rgba(255, 255, 255, 0.9);
    padding: 0.75rem 1rem;
    text-align: center;
    text-decoration: none;
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    transition: var(--transition);
}

.small-box-footer:hover {
    background: rgba(0, 0, 0, 0.2);
    color: white;
    text-decoration: none;
}

/* AdminLTE Box Styles */
.box {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-card);
    margin-bottom: 1.5rem;
    border: 1px solid var(--border-color);
}

.box-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--border-color);
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: var(--border-radius) var(--border-radius) 0 0;
}

.box-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--dark-color);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.box-tools {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.box-body {
    padding: 1.25rem;
}

.box-footer {
    padding: 1rem 1.25rem;
    border-top: 1px solid var(--border-color);
    background: var(--light-color);
    border-radius: 0 0 var(--border-radius) var(--border-radius);
}

/* AdminLTE Button Styles */
.btn {
    border-radius: var(--border-radius);
    font-weight: 500;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border: 1px solid transparent;
    transition: var(--transition);
}

.btn-app {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-card);
    color: var(--secondary-color);
    padding: 1.5rem 1rem;
    text-align: center;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    transition: var(--transition);
    min-height: 140px;
    justify-content: center;
}

.btn-app:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
    text-decoration: none;
    color: var(--primary-color);
}

.btn-app i {
    font-size: 2rem;
    color: var(--primary-color);
}

.btn-app .btn-app-label {
    font-weight: 600;
    font-size: 0.9rem;
    margin: 0;
}

.btn-app .btn-app-description {
    font-size: 0.75rem;
    color: var(--secondary-color);
    margin: 0;
    line-height: 1.3;
}

/* AdminLTE Timeline */
.timeline {
    position: relative;
    margin: 0;
    padding: 0;
    list-style: none;
}

.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 1.75rem;
    width: 2px;
    background: var(--border-color);
}

.timeline-item {
    position: relative;
    padding-left: 4rem;
    margin-bottom: 1.5rem;
}

.timeline-marker {
    position: absolute;
    left: 1.25rem;
    top: 0.5rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    background: var(--primary-color);
    border: 2px solid white;
    box-shadow: 0 0 0 2px var(--border-color);
}

.timeline-content {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-card);
    padding: 1rem;
    border: 1px solid var(--border-color);
}

.timeline-header {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.timeline-body {
    color: var(--secondary-color);
    font-size: 0.875rem;
    line-height: 1.5;
}

.timeline-time {
    font-size: 0.75rem;
    color: var(--secondary-color);
    margin-top: 0.5rem;
}

/* AdminLTE Alert Styles */
.alert {
    border-radius: var(--border-radius);
    border: 1px solid transparent;
    padding: 0.75rem 1rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.alert-dismissible .btn-close {
    padding: 0.75rem 1rem;
}

/* Background Colors for Different Components */
.bg-primary { background-color: var(--primary-color) !important; }
.bg-success { background-color: var(--success-color) !important; }
.bg-warning { background-color: var(--warning-color) !important; }
.bg-info { background-color: var(--info-color) !important; }
.bg-danger { background-color: var(--danger-color) !important; }

.bg-gradient-primary { background: var(--primary-gradient) !important; }
.bg-gradient-success { background: var(--success-gradient) !important; }
.bg-gradient-warning { background: var(--warning-gradient) !important; }
.bg-gradient-info { background: var(--info-gradient) !important; }
.bg-gradient-danger { background: var(--danger-gradient) !important; }

/* Responsive Grid System */
.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -0.75rem;
    margin-left: -0.75rem;
}

.col,
.col-12,
.col-lg-3,
.col-lg-6,
.col-lg-8,
.col-lg-4,
.col-md-6,
.col-sm-6,
.col-xl-3 {
    position: relative;
    width: 100%;
    padding-right: 0.75rem;
    padding-left: 0.75rem;
}

.col-12 { flex: 0 0 100%; max-width: 100%; }
.col-lg-3 { flex: 0 0 25%; max-width: 25%; }
.col-lg-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
.col-lg-6 { flex: 0 0 50%; max-width: 50%; }
.col-lg-8 { flex: 0 0 66.666667%; max-width: 66.666667%; }

/* Mobile First Responsive Breakpoints */
@media (max-width: 575.98px) {
    .col-lg-3,
    .col-lg-4,
    .col-lg-6,
    .col-lg-8,
    .col-md-6,
    .col-sm-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .content-header {
        margin: 0 -16px 1rem -16px;
        padding: 0.75rem 1rem;
    }
    
    .content-header h1 {
        font-size: 1.5rem;
    }
    
    .btn-app {
        min-height: 120px;
        padding: 1rem 0.75rem;
    }
    
    .btn-app i {
        font-size: 1.5rem;
    }
    
    .info-box {
        flex-direction: column;
        text-align: center;
        padding: 1.5rem 1rem;
    }
    
    .info-box-icon {
        margin-right: 0;
        margin-bottom: 1rem;
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .info-box-number {
        font-size: 1.5rem;
    }
}

@media (min-width: 576px) and (max-width: 767.98px) {
    .col-sm-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (min-width: 768px) and (max-width: 991.98px) {
    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (min-width: 992px) {
    .col-lg-3 { flex: 0 0 25%; max-width: 25%; }
    .col-lg-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
    .col-lg-6 { flex: 0 0 50%; max-width: 50%; }
    .col-lg-8 { flex: 0 0 66.666667%; max-width: 66.666667%; }
}

/* Utility Classes */
.mb-0 { margin-bottom: 0 !important; }
.mb-1 { margin-bottom: 0.25rem !important; }
.mb-2 { margin-bottom: 0.5rem !important; }
.mb-3 { margin-bottom: 1rem !important; }
.mb-4 { margin-bottom: 1.5rem !important; }
.mb-5 { margin-bottom: 3rem !important; }

.mt-0 { margin-top: 0 !important; }
.mt-1 { margin-top: 0.25rem !important; }
.mt-2 { margin-top: 0.5rem !important; }
.mt-3 { margin-top: 1rem !important; }
.mt-4 { margin-top: 1.5rem !important; }
.mt-5 { margin-top: 3rem !important; }

.text-center { text-align: center !important; }
.text-left { text-align: left !important; }
.text-right { text-align: right !important; }

.d-flex { display: flex !important; }
.align-items-center { align-items: center !important; }
.justify-content-between { justify-content: space-between !important; }
.justify-content-center { justify-content: center !important; }

.text-primary { color: var(--primary-color) !important; }
.text-success { color: var(--success-color) !important; }
.text-warning { color: var(--warning-color) !important; }
.text-info { color: var(--info-color) !important; }
.text-danger { color: var(--danger-color) !important; }
.text-muted { color: var(--secondary-color) !important; }

</style>

<!-- Modern Dashboard Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center mb-4">
            <div class="col-sm-8">
                <h1 class="mb-0" style="font-size: 2rem; font-weight: 300; color: #495057;">Dashboard Guru</h1>
                <p class="text-muted mb-0">Selamat datang kembali, <?= esc($user_name) ?>! Berikut ringkasan aktivitas hari ini.</p>
            </div>
            <div class="col-sm-4 text-end">
                <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>Tambah Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
            
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

            <!-- Modern Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm" style="border-left: 4px solid #007bff !important;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Siswa</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['total_siswa']) ?></div>
                                    <div class="text-xs text-success mt-1">
                                        <i class="fas fa-arrow-up"></i> 4.7% dari bulan lalu
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-user-graduate text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm" style="border-left: 4px solid #28a745 !important;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kelas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['total_kelas']) ?></div>
                                    <div class="text-xs text-success mt-1">
                                        <i class="fas fa-arrow-up"></i> 12.4% dari bulan lalu
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-school text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm" style="border-left: 4px solid #ffc107 !important;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Orang Tua</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['total_orang_tua']) ?></div>
                                    <div class="text-xs text-danger mt-1">
                                        <i class="fas fa-arrow-down"></i> 3.1% dari bulan lalu
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm" style="border-left: 4px solid #17a2b8 !important;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tahun Ajaran</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['active_tahun_ajaran'] ?></div>
                                    <div class="text-xs text-info mt-1">
                                        <i class="fas fa-calendar"></i> Semester Genap
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-calendar-check text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Analytics Row -->
            <div class="row mb-4">
                <!-- Main Chart -->
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Aktivitas Siswa</h6>
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end shadow">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myAreaChart" style="height: 320px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pie Chart -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Distribusi Kelas</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="myPieChart" style="height: 245px;"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="me-2">
                                    <i class="fas fa-circle text-primary"></i> Kelas X
                                </span>
                                <span class="me-2">
                                    <i class="fas fa-circle text-success"></i> Kelas XI
                                </span>
                                <span class="me-2">
                                    <i class="fas fa-circle text-info"></i> Kelas XII
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info boxes -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">
                                <i class="fas fa-bolt text-warning"></i>
                                Aksi Cepat
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <a href="#" class="btn-app">
                                        <i class="fas fa-database text-primary"></i>
                                        <span class="btn-app-label">Data Siswa</span>
                                        <small class="btn-app-description">Kelola data siswa dan informasi akademik</small>
                                    </a>
                                </div>
                                
                                <div class="col-lg-3 col-md-6 col-12">
                                    <a href="#" class="btn-app">
                                        <i class="fas fa-chart-line text-success"></i>
                                        <span class="btn-app-label">Nilai & Rapor</span>
                                        <small class="btn-app-description">Input dan kelola nilai rapor siswa</small>
                                    </a>
                                </div>
                                
                                <div class="col-lg-3 col-md-6 col-12">
                                    <a href="#" class="btn-app">
                                        <i class="fas fa-calendar-alt text-warning"></i>
                                        <span class="btn-app-label">Jadwal Mengajar</span>
                                        <small class="btn-app-description">Lihat dan kelola jadwal mengajar</small>
                                    </a>
                                </div>
                                
                                <div class="col-lg-3 col-md-6 col-12">
                                    <a href="#" class="btn-app">
                                        <i class="fas fa-chart-bar text-info"></i>
                                        <span class="btn-app-label">Laporan</span>
                                        <small class="btn-app-description">Laporan akademik dan statistik</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-lg-8">
                    <!-- Activities -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">
                                <i class="fas fa-clock text-primary"></i>
                                Aktivitas Terbaru
                            </h3>
                        </div>
                        <div class="box-body">
                            <ul class="timeline">
                                <li class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">Login Berhasil</div>
                                        <div class="timeline-body">
                                            Sesi dimulai pada <?= date('d M Y, H:i') ?> WIB. Sistem berjalan normal.
                                        </div>
                                        <div class="timeline-time">
                                            <i class="fas fa-clock"></i> Baru saja
                                        </div>
                                    </div>
                                </li>
                                
                                <li class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">Database Terhubung</div>
                                        <div class="timeline-body">
                                            Koneksi ke database remote berhasil dan stabil. Semua data siap diakses.
                                        </div>
                                        <div class="timeline-time">
                                            <i class="fas fa-clock"></i> 1 menit lalu
                                        </div>
                                    </div>
                                </li>
                                
                                <li class="timeline-item">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">Sinkronisasi Data</div>
                                        <div class="timeline-body">
                                            Data statistik berhasil dimuat dan diperbarui dari server.
                                        </div>
                                        <div class="timeline-time">
                                            <i class="fas fa-clock"></i> 2 menit lalu
                                        </div>
                                    </div>
                                </li>
                                
                                <li class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">Keamanan Sistem</div>
                                        <div class="timeline-body">
                                            Sistem keamanan aktif dan berfungsi normal. SSL encryption enabled.
                                        </div>
                                        <div class="timeline-time">
                                            <i class="fas fa-clock"></i> 5 menit lalu
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Right col -->
                <div class="col-lg-4">
                    <!-- Info Box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">
                                <i class="fas fa-info-circle text-primary"></i>
                                Informasi Sistem
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-database"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Status Database</span>
                                    <span class="info-box-number">Connected</span>
                                    <div class="info-box-more">
                                        <span class="badge bg-success">Active</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-user"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Role Pengguna</span>
                                    <span class="info-box-number">Guru</span>
                                    <div class="info-box-more">
                                        <span class="badge bg-primary">Verified</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Login Terakhir</span>
                                    <span class="info-box-number"><?= date('H:i') ?></span>
                                    <div class="info-box-more">
                                        <small class="text-muted"><?= date('d M Y') ?></small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-code-branch"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Versi Sistem</span>
                                    <span class="info-box-number">v1.0.0</span>
                                    <div class="info-box-more">
                                        <span class="badge bg-info">Latest</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="<?= base_url('/profile') ?>" class="btn btn-primary btn-sm btn-block">
                                        <i class="fas fa-user-cog"></i> Profil
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-secondary btn-sm btn-block">
                                        <i class="fas fa-cog"></i> Setting
                                    </a>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt"></i>
                                    Dilindungi dengan enkripsi SSL
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
