<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>

<style>
/* AdminLTE-inspired Layout for Guru Kelas */
:root {
    --primary-color: #28a745;
    --secondary-color: #6c757d;
    --success-color: #20c997;
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

.teacher-stats-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border-radius: var(--border-radius);
    overflow: hidden;
}

.teacher-stats-card:hover {
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
            <h5 class="mb-0 text-success">Dashboard Guru Kelas</h5>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <div class="search-box position-relative d-none d-md-block">
                <input type="text" class="form-control form-control-sm" placeholder="Cari siswa..." style="width: 200px; border-radius: 20px; padding-left: 35px;">
                <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 0.8rem;"></i>
            </div>
            
            <div class="dropdown">
                <button class="btn btn-link p-0 position-relative" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bell text-muted fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning" style="font-size: 0.6rem;">5</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">Notifikasi Pembelajaran</h6></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-tasks text-success me-2"></i>Tugas perlu dinilai (3)</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-clock text-warning me-2"></i>Siswa terlambat hari ini (2)</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Lihat semua</a></li>
                </ul>
            </div>
            
            <div class="dropdown">
                <button class="btn btn-link p-0 d-flex align-items-center text-decoration-none" type="button" data-bs-toggle="dropdown">
                    <div class="user-avatar bg-success rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-chalkboard-teacher text-white" style="font-size: 0.8rem;"></i>
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
        
        <!-- Statistik Pembelajaran -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm teacher-stats-card" style="border-left: 4px solid #28a745 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Siswa</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">32</div>
                                <div class="text-xs text-success mt-1">
                                    <i class="fas fa-user-graduate"></i> Kelas XI-A
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm teacher-stats-card" style="border-left: 4px solid #17a2b8 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Mata Pelajaran</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                                <div class="text-xs text-info mt-1">
                                    <i class="fas fa-book"></i> Diampu
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-info">
                                    <i class="fas fa-book-open text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm teacher-stats-card" style="border-left: 4px solid #ffc107 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tugas Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                                <div class="text-xs text-warning mt-1">
                                    <i class="fas fa-clock"></i> Perlu dinilai
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-tasks text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm teacher-stats-card" style="border-left: 4px solid #dc3545 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Kehadiran Hari Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">94%</div>
                                <div class="text-xs text-success mt-1">
                                    <i class="fas fa-arrow-up"></i> 30/32 hadir
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-danger">
                                    <i class="fas fa-user-check text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analisis Pembelajaran -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-success">Perkembangan Nilai Siswa</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="studentProgressChart" style="height: 320px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-success">Distribusi Nilai</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="gradeDistributionChart" style="height: 245px;"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="me-2"><i class="fas fa-circle text-success"></i> A (25%)</span>
                            <span class="me-2"><i class="fas fa-circle text-info"></i> B (40%)</span>
                            <span class="me-2"><i class="fas fa-circle text-warning"></i> C (35%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi Cepat Guru Kelas -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-success">Aksi Cepat Pembelajaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="#" class="btn btn-outline-success w-100 p-3 text-decoration-none">
                                    <i class="fas fa-clipboard-list fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Absensi Siswa</span>
                                    <small class="d-block text-muted">Catat kehadiran harian</small>
                                </a>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="#" class="btn btn-outline-info w-100 p-3 text-decoration-none">
                                    <i class="fas fa-file-alt fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Input Nilai</span>
                                    <small class="d-block text-muted">Masukkan penilaian</small>
                                </a>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="#" class="btn btn-outline-warning w-100 p-3 text-decoration-none">
                                    <i class="fas fa-tasks fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Buat Tugas</span>
                                    <small class="d-block text-muted">Buat tugas baru</small>
                                </a>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="#" class="btn btn-outline-primary w-100 p-3 text-decoration-none">
                                    <i class="fas fa-chart-bar fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Laporan Kelas</span>
                                    <small class="d-block text-muted">Lihat laporan lengkap</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas & Progress -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-success">Aktivitas Pembelajaran Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <div class="timeline-header">Tugas Matematika dikumpulkan</div>
                                    <div class="timeline-body">25 dari 32 siswa telah mengumpulkan tugas Aljabar Linear</div>
                                    <div class="timeline-time text-muted">2 jam yang lalu</div>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <div class="timeline-header">Quiz Fisika selesai dinilai</div>
                                    <div class="timeline-body">Rata-rata nilai kelas: 82.5 (Baik)</div>
                                    <div class="timeline-time text-muted">5 jam yang lalu</div>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <div class="timeline-header">Absensi diperbarui</div>
                                    <div class="timeline-body">2 siswa tidak hadir hari ini (sakit: 1, izin: 1)</div>
                                    <div class="timeline-time text-muted">1 hari yang lalu</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-success">Ringkasan Kelas</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm font-weight-bold">Rata-rata Kehadiran</span>
                                <span class="text-sm text-success">92%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: 92%;"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm font-weight-bold">Tugas Terkumpul</span>
                                <span class="text-sm text-info">78%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" style="width: 78%;"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm font-weight-bold">Rata-rata Nilai</span>
                                <span class="text-sm text-warning">82.5</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: 82.5%;"></div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="text-center">
                            <h5 class="text-success mb-1">Kelas XI-A</h5>
                            <p class="text-muted mb-3">Tahun Ajaran 2024/2025</p>
                            <a href="#" class="btn btn-success btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Detail Kelas
                            </a>
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
    // Student Progress Chart
    const progressCtx = document.getElementById('studentProgressChart');
    if (progressCtx) {
        new Chart(progressCtx, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5', 'Minggu 6'],
                datasets: [{
                    label: 'Matematika',
                    data: [75, 78, 82, 79, 85, 88],
                    borderColor: 'rgba(40, 167, 69, 1)',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Fisika',
                    data: [72, 76, 74, 81, 83, 86],
                    borderColor: 'rgba(23, 162, 184, 1)',
                    backgroundColor: 'rgba(23, 162, 184, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Kimia',
                    data: [70, 73, 77, 75, 80, 82],
                    borderColor: 'rgba(255, 193, 7, 1)',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    }

    // Grade Distribution Chart
    const gradeCtx = document.getElementById('gradeDistributionChart');
    if (gradeCtx) {
        new Chart(gradeCtx, {
            type: 'doughnut',
            data: {
                labels: ['A (85-100)', 'B (70-84)', 'C (55-69)'],
                datasets: [{
                    data: [25, 40, 35],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(23, 162, 184, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
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
