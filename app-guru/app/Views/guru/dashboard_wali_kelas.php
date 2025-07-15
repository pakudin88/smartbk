<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>

<style>
/* AdminLTE-inspired Layout for Wali Kelas */
:root {
    --primary-color: #6f42c1;
    --secondary-color: #6c757d;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --info-color: #17a2b8;
    --danger-color: #dc3545;
    --light-color: #f8f9fa;
    --dark-color: #343a40;
    
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

.homeroom-stats-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border-radius: var(--border-radius);
    overflow: hidden;
}

.homeroom-stats-card:hover {
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

.student-card {
    border: 1px solid #e3e6f0;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.student-card:hover {
    box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
    transform: translateY(-2px);
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
            <h5 class="mb-0" style="color: #6f42c1;">Dashboard Wali Kelas</h5>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <div class="search-box position-relative d-none d-md-block">
                <input type="text" class="form-control form-control-sm" placeholder="Cari siswa..." style="width: 200px; border-radius: 20px; padding-left: 35px;">
                <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 0.8rem;"></i>
            </div>
            
            <div class="dropdown">
                <button class="btn btn-link p-0 position-relative" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bell text-muted fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">4</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">Notifikasi Wali Kelas</h6></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-times text-danger me-2"></i>Siswa tidak hadir (3 hari)</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Prestasi menurun - Ahmad</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Lihat semua</a></li>
                </ul>
            </div>
            
            <div class="dropdown">
                <button class="btn btn-link p-0 d-flex align-items-center text-decoration-none" type="button" data-bs-toggle="dropdown">
                    <div class="user-avatar rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background: #6f42c1;">
                        <i class="fas fa-user-tie text-white" style="font-size: 0.8rem;"></i>
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
        
        <!-- Statistik Wali Kelas -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm homeroom-stats-card" style="border-left: 4px solid #6f42c1 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #6f42c1;">Siswa Wali</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">32</div>
                                <div class="text-xs mt-1" style="color: #6f42c1;">
                                    <i class="fas fa-users"></i> Kelas XI-IPA 1
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle" style="background: #6f42c1;">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm homeroom-stats-card" style="border-left: 4px solid #28a745 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kehadiran Rata-rata</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">94.5%</div>
                                <div class="text-xs text-success mt-1">
                                    <i class="fas fa-arrow-up"></i> +2.3% bulan ini
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-user-check text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm homeroom-stats-card" style="border-left: 4px solid #ffc107 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Perlu Perhatian</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                                <div class="text-xs text-warning mt-1">
                                    <i class="fas fa-exclamation-triangle"></i> Siswa
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm homeroom-stats-card" style="border-left: 4px solid #17a2b8 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rata-rata Nilai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">82.8</div>
                                <div class="text-xs text-info mt-1">
                                    <i class="fas fa-chart-line"></i> Semester ini
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-info">
                                    <i class="fas fa-chart-bar text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monitoring Siswa -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold" style="color: #6f42c1;">Monitoring Kehadiran & Prestasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="studentMonitoringChart" style="height: 320px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold" style="color: #6f42c1;">Status Siswa</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="studentStatusChart" style="height: 245px;"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="me-2"><i class="fas fa-circle text-success"></i> Baik (70%)</span>
                            <span class="me-2"><i class="fas fa-circle text-warning"></i> Perhatian (20%)</span>
                            <span class="me-2"><i class="fas fa-circle text-danger"></i> Urgent (10%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi Cepat Wali Kelas -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold" style="color: #6f42c1;">Aksi Cepat Wali Kelas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="#" class="btn w-100 p-3 text-decoration-none" style="border: 2px solid #6f42c1; color: #6f42c1;">
                                    <i class="fas fa-user-friends fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Data Siswa</span>
                                    <small class="d-block text-muted">Kelola profil siswa</small>
                                </a>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="#" class="btn btn-outline-success w-100 p-3 text-decoration-none">
                                    <i class="fas fa-calendar-check fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Rekap Absensi</span>
                                    <small class="d-block text-muted">Monitor kehadiran</small>
                                </a>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="#" class="btn btn-outline-warning w-100 p-3 text-decoration-none">
                                    <i class="fas fa-phone fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Kontak Ortu</span>
                                    <small class="d-block text-muted">Komunikasi orang tua</small>
                                </a>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="#" class="btn btn-outline-info w-100 p-3 text-decoration-none">
                                    <i class="fas fa-file-alt fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Laporan Wali</span>
                                    <small class="d-block text-muted">Buat laporan bulanan</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Siswa Perlu Perhatian -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold" style="color: #6f42c1;">Siswa Perlu Perhatian Khusus</h6>
                    </div>
                    <div class="card-body">
                        <div class="student-card p-3 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-danger rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <span class="text-white fw-bold">AH</span>
                                </div>
                                <div class="flex-fill">
                                    <h6 class="mb-1">Ahmad Hidayat</h6>
                                    <p class="text-muted mb-1">NISN: 0012345678</p>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-danger">Absen 3 hari</span>
                                        <span class="badge bg-warning">Nilai turun</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-outline-primary">Detail</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="student-card p-3 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-warning rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <span class="text-white fw-bold">SP</span>
                                </div>
                                <div class="flex-fill">
                                    <h6 class="mb-1">Siti Permata</h6>
                                    <p class="text-muted mb-1">NISN: 0012345679</p>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-warning">Sering terlambat</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-outline-primary">Detail</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="student-card p-3 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-info rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <span class="text-white fw-bold">RD</span>
                                </div>
                                <div class="flex-fill">
                                    <h6 class="mb-1">Rian Dwi</h6>
                                    <p class="text-muted mb-1">NISN: 0012345680</p>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-info">Konseling BK</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-outline-primary">Detail</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-sm" style="background: #6f42c1; color: white;">
                                <i class="fas fa-eye me-1"></i>Lihat Semua Siswa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold" style="color: #6f42c1;">Ringkasan Kelas</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm font-weight-bold">Kehadiran Hari Ini</span>
                                <span class="text-sm text-success">30/32</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: 93.75%;"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm font-weight-bold">Tugas Terkumpul</span>
                                <span class="text-sm text-info">28/32</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" style="width: 87.5%;"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm font-weight-bold">Prestasi Akademik</span>
                                <span class="text-sm" style="color: #6f42c1;">Baik</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" style="width: 82.8%; background: #6f42c1;"></div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="text-center">
                            <h5 style="color: #6f42c1;" class="mb-1">XI-IPA 1</h5>
                            <p class="text-muted mb-3">Wali Kelas: Bapak/Ibu [Nama]</p>
                            <div class="row">
                                <div class="col-6">
                                    <a href="#" class="btn btn-sm btn-outline-success w-100">
                                        <i class="fas fa-phone"></i> Kontak Ortu
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-sm w-100" style="background: #6f42c1; color: white;">
                                        <i class="fas fa-file"></i> Laporan
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
    // Student Monitoring Chart
    const monitoringCtx = document.getElementById('studentMonitoringChart');
    if (monitoringCtx) {
        new Chart(monitoringCtx, {
            type: 'line',
            data: {
                labels: ['Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb'],
                datasets: [{
                    label: 'Rata-rata Kehadiran (%)',
                    data: [92, 94, 91, 95, 93, 94.5],
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4,
                    yAxisID: 'y'
                }, {
                    label: 'Rata-rata Nilai',
                    data: [78, 80, 79, 83, 81, 82.8],
                    borderColor: '#6f42c1',
                    backgroundColor: 'rgba(111, 66, 193, 0.1)',
                    tension: 0.4,
                    yAxisID: 'y1'
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
                        max: 100,
                        title: {
                            display: true,
                            text: 'Kehadiran (%)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        min: 70,
                        max: 90,
                        title: {
                            display: true,
                            text: 'Nilai Rata-rata'
                        },
                        grid: {
                            drawOnChartArea: false,
                        }
                    }
                }
            }
        });
    }

    // Student Status Chart
    const statusCtx = document.getElementById('studentStatusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Baik', 'Perlu Perhatian', 'Urgent'],
                datasets: [{
                    data: [70, 20, 10],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(220, 53, 69, 0.8)'
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
