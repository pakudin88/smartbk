<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-banner">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="welcome-title">Selamat Datang, Guru BK!</h2>
                        <p class="welcome-subtitle">Anda berhasil login ke sistem Bimbingan dan Konseling SmartBK.</p>
                        <div class="welcome-badges">
                            <span class="badge badge-primary">
                                <i class="fas fa-users me-1"></i>
                                Siswa Terbimbing: <?= $totalSiswa ?? 145 ?>
                            </span>
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle me-1"></i>
                                Sesi Konseling: <?= $sesiKonseling ?? 28 ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="portal-widget">
                            <div class="portal-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="portal-text">
                                <strong>Portal Guru BK Aktif</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="stats-card stats-card-blue">
                <div class="stats-content">
                    <div class="stats-number"><?= $totalSiswa ?? 145 ?></div>
                    <div class="stats-label">Siswa Terbimbing</div>
                    <div class="stats-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                </div>
                <div class="stats-footer">
                    <a href="<?= base_url('data-siswa') ?>" class="stats-link">
                        Kelola Siswa <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="stats-card stats-card-green">
                <div class="stats-content">
                    <div class="stats-number"><?= $sesiKonselingBulanIni ?? 28 ?></div>
                    <div class="stats-label">Sesi Konseling Bulan Ini</div>
                    <div class="stats-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                </div>
                <div class="stats-footer">
                    <a href="<?= base_url('konseling/riwayat') ?>" class="stats-link">
                        Lihat Riwayat <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="stats-card stats-card-yellow">
                <div class="stats-content">
                    <div class="stats-number"><?= $asesmenPending ?? 12 ?></div>
                    <div class="stats-label">Asesmen Pending</div>
                    <div class="stats-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="stats-footer">
                    <a href="<?= base_url('asesmen/pending') ?>" class="stats-link">
                        Proses Asesmen <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="stats-card stats-card-red">
                <div class="stats-content">
                    <div class="stats-number"><?= $kasusPrioritas ?? 7 ?></div>
                    <div class="stats-label">Kasus Prioritas Tinggi</div>
                    <div class="stats-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="stats-footer">
                    <a href="<?= base_url('konseling/prioritas') ?>" class="stats-link">
                        Tindak Lanjut <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5>Tren Konseling 6 Bulan Terakhir</h5>
                </div>
                <div class="chart-body">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5>Kategori Masalah Konseling</h5>
                </div>
                <div class="chart-body">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ... existing styles ... */
.chart-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.chart-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
    background: var(--gray-50);
}

.chart-header h5 {
    margin: 0;
    font-weight: 600;
    color: var(--text-primary);
}

.chart-body {
    padding: 24px;
    min-height: 300px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Data from PHP
    const trendData = <?= json_encode($trendData ?? []) ?>;
    const categoryData = <?= json_encode($categoryData ?? []) ?>;

    // Trend Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: trendData.labels,
            datasets: trendData.datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryData.labels,
            datasets: categoryData.datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
});
</script>

<?= $this->endSection() ?>