<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>

<style>
/* AdminLTE-inspired Layout for Kepala Sekolah */
:root {
    --primary-color: #e74c3c;
    --secondary-color: #6c757d;
    --success-color: #27ae60;
    --warning-color: #f39c12;
    --info-color: #3498db;
    --danger-color: #e74c3c;
    --light-color: #f8f9fa;
    --dark-color: #2c3e50;
    
    --border-radius: 0.375rem;
    --border-color: #dee2e6;
    --shadow-card: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    --shadow-hover: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    --transition: all 0.15s ease-in-out;
}

.content-card {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
    margin: 0 !important;
}

.navbar-fixed-top {
    position: fixed;
    top: 0;
    left: 280px;
    right: 0;
    z-index: 1030;
    background: white !important;
    border-bottom: 1px solid var(--border-color);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    padding: 0.75rem 1.5rem;
}

.main-content {
    padding-top: 80px !important;
    transition: margin-left 0.3s ease;
}

.principal-stats-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border-radius: var(--border-radius);
    overflow: hidden;
}

.principal-stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.icon-circle {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    transition: all 0.3s ease;
}

.executive-card {
    background: linear-gradient(135deg, #ffffff 0%, #f1f2f6 100%);
    border: 1px solid #e3e6f0;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
}

.executive-card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    transform: translateY(-3px);
}

@media (max-width: 768px) {
    .navbar-fixed-top {
        left: 0 !important;
        z-index: 1025 !important;
        background: white !important;
    }
    
    .main-content {
        padding-top: 70px !important;
        margin-left: 0 !important;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .icon-circle {
        width: 2.5rem;
        height: 2.5rem;
        font-size: 1rem;
    }
}
</style>

<!-- Fixed Top Navbar -->
<nav class="navbar-fixed-top" id="fixedNavbar">
    <div class="d-flex justify-content-between align-items-center w-100">
        <div class="d-flex align-items-center">
            <button class="btn btn-link p-0 me-3" id="sidebarCollapseBtn">
                <i class="fas fa-bars text-muted"></i>
            </button>
            <h5 class="mb-0 text-danger">Dashboard Kepala Sekolah</h5>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <div class="search-box position-relative d-none d-md-block">
                <input type="text" class="form-control form-control-sm" placeholder="Cari data..." style="width: 200px; border-radius: 20px; padding-left: 35px;">
                <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 0.8rem;"></i>
            </div>
            
            <div class="dropdown">
                <button class="btn btn-link p-0 position-relative" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bell text-muted fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">7</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">Notifikasi Sekolah</h6></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-exclamation-circle text-danger me-2"></i>Laporan bulanan pending</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-users text-warning me-2"></i>Meeting staff hari ini</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line text-info me-2"></i>Update prestasi sekolah</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Lihat semua</a></li>
                </ul>
            </div>
            
            <div class="dropdown">
                <button class="btn btn-link p-0 d-flex align-items-center text-decoration-none" type="button" data-bs-toggle="dropdown">
                    <div class="user-avatar bg-danger rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-user-shield text-white" style="font-size: 0.8rem;"></i>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        
        <!-- Statistik Sekolah -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm principal-stats-card" style="border-left: 4px solid #e74c3c !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Siswa</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">1,247</div>
                                <div class="text-xs text-success mt-1">
                                    <i class="fas fa-arrow-up"></i> +3.2% dari tahun lalu
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-danger">
                                    <i class="fas fa-graduation-cap text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm principal-stats-card" style="border-left: 4px solid #27ae60 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Guru</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">78</div>
                                <div class="text-xs text-success mt-1">
                                    <i class="fas fa-users"></i> 65 PNS, 13 Honorer
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-chalkboard-teacher text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm principal-stats-card" style="border-left: 4px solid #f39c12 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Rata-rata Nilai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">84.2</div>
                                <div class="text-xs text-warning mt-1">
                                    <i class="fas fa-chart-line"></i> Semester ini
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-chart-bar text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm principal-stats-card" style="border-left: 4px solid #3498db !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tingkat Kehadiran</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">96.8%</div>
                                <div class="text-xs text-info mt-1">
                                    <i class="fas fa-user-check"></i> Bulan ini
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

        <!-- Analytics Sekolah -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Tren Kinerja Sekolah</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="schoolPerformanceChart" style="height: 320px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Distribusi Kelas</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="classDistributionChart" style="height: 245px;"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="me-2"><i class="fas fa-circle text-info"></i> Kelas X (35%)</span>
                            <span class="me-2"><i class="fas fa-circle text-success"></i> Kelas XI (33%)</span>
                            <span class="me-2"><i class="fas fa-circle text-warning"></i> Kelas XII (32%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Executive Dashboard -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Executive Control Panel</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="executive-card p-4 text-center">
                                    <div class="icon-circle bg-primary mx-auto mb-3">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                    <h6 class="font-weight-bold">Laporan Sekolah</h6>
                                    <p class="text-muted small mb-3">Akses laporan komprehensif</p>
                                    <a href="#" class="btn btn-primary btn-sm">Lihat Laporan</a>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="executive-card p-4 text-center">
                                    <div class="icon-circle bg-success mx-auto mb-3">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                    <h6 class="font-weight-bold">Manajemen Staff</h6>
                                    <p class="text-muted small mb-3">Kelola data guru & staff</p>
                                    <a href="#" class="btn btn-success btn-sm">Kelola Staff</a>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="executive-card p-4 text-center">
                                    <div class="icon-circle bg-warning mx-auto mb-3">
                                        <i class="fas fa-cog text-white"></i>
                                    </div>
                                    <h6 class="font-weight-bold">Pengaturan Sekolah</h6>
                                    <p class="text-muted small mb-3">Konfigurasi sistem sekolah</p>
                                    <a href="#" class="btn btn-warning btn-sm">Pengaturan</a>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="executive-card p-4 text-center">
                                    <div class="icon-circle bg-info mx-auto mb-3">
                                        <i class="fas fa-chart-pie text-white"></i>
                                    </div>
                                    <h6 class="font-weight-bold">Analytics</h6>
                                    <p class="text-muted small mb-3">Dashboard analitik lengkap</p>
                                    <a href="#" class="btn btn-info btn-sm">Lihat Analytics</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monitoring & Alerts -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Monitoring & Alerts</h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info border-left-info">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle fa-2x text-info me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Rapat Koordinasi</h6>
                                    <p class="mb-0">Rapat koordinasi bulanan dijadwalkan hari ini pukul 14:00</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning border-left-warning">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Laporan Pending</h6>
                                    <p class="mb-0">3 laporan bulanan belum diserahkan dari guru kelas</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-success border-left-success">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x text-success me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Prestasi Sekolah</h6>
                                    <p class="mb-0">Sekolah meraih juara 2 lomba OSN tingkat provinsi</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-danger border-left-danger">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle fa-2x text-danger me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Perhatian Khusus</h6>
                                    <p class="mb-0">15 siswa memiliki tingkat absensi di bawah standar bulan ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Key Performance Indicators</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm font-weight-bold">Target Kelulusan</span>
                                <span class="text-sm text-success">98.5%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" style="width: 98.5%;"></div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm font-weight-bold">Akreditasi</span>
                                <span class="text-sm text-info">A</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-info" style="width: 95%;"></div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm font-weight-bold">Kepuasan Ortu</span>
                                <span class="text-sm text-warning">4.2/5</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-warning" style="width: 84%;"></div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm font-weight-bold">Prestasi Sekolah</span>
                                <span class="text-sm text-danger">Sangat Baik</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-danger" style="width: 92%;"></div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="text-center">
                            <h5 class="text-danger mb-1">SMA Negeri 1</h5>
                            <p class="text-muted mb-3">Tahun Ajaran 2024/2025</p>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <a href="#" class="btn btn-danger btn-sm w-100">
                                        <i class="fas fa-file-alt me-1"></i>Generate Laporan
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-cog"></i> Setting
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-outline-success btn-sm w-100">
                                        <i class="fas fa-users"></i> Staff
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // School Performance Chart
    const performanceCtx = document.getElementById('schoolPerformanceChart');
    if (performanceCtx) {
        new Chart(performanceCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Rata-rata Nilai Sekolah',
                    data: [82, 83.5, 84, 83.8, 84.5, 84.2],
                    borderColor: '#e74c3c',
                    backgroundColor: 'rgba(231, 76, 60, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Tingkat Kehadiran (%)',
                    data: [95, 96, 95.5, 97, 96.5, 96.8],
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39, 174, 96, 0.1)',
                    tension: 0.4,
                    yAxisID: 'y1'
                }, {
                    label: 'Kepuasan Orang Tua',
                    data: [4.0, 4.1, 4.0, 4.2, 4.1, 4.2],
                    borderColor: '#f39c12',
                    backgroundColor: 'rgba(243, 156, 18, 0.1)',
                    tension: 0.4,
                    yAxisID: 'y2'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        min: 80,
                        max: 90,
                        title: {
                            display: true,
                            text: 'Nilai Rata-rata'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: false,
                        position: 'right',
                        min: 90,
                        max: 100
                    },
                    y2: {
                        type: 'linear',
                        display: false,
                        position: 'right',
                        min: 3,
                        max: 5
                    }
                }
            }
        });
    }

    // Class Distribution Chart
    const distributionCtx = document.getElementById('classDistributionChart');
    if (distributionCtx) {
        new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Kelas X', 'Kelas XI', 'Kelas XII'],
                datasets: [{
                    data: [35, 33, 32],
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.8)',
                        'rgba(39, 174, 96, 0.8)',
                        'rgba(243, 156, 18, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
