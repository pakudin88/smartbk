<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-brain text-primary"></i> Dashboard Asesmen Bakat Minat</h2>
                    <p class="text-muted">Kelola dan pantau asesmen bakat minat siswa</p>
                </div>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahTes">
                        <i class="fas fa-plus"></i> Tambah Tes Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Siswa Sudah Tes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $stats['total_siswa_tes'] ?? 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Jenis Tes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $stats['total_tes'] ?? 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Hasil Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $stats['hasil_bulan_ini'] ?? 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Perlu Rekomendasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $stats['perlu_rekomendasi'] ?? 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i> Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('/asesmen-bakat-minat/tes-online') ?>" class="btn btn-outline-primary btn-block h-100">
                                <i class="fas fa-laptop-code fa-2x mb-2"></i><br>
                                <strong>Tes Online</strong><br>
                                <small>Kelola tes bakat minat online</small>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('/asesmen-bakat-minat/hasil-tes') ?>" class="btn btn-outline-success btn-block h-100">
                                <i class="fas fa-poll fa-2x mb-2"></i><br>
                                <strong>Hasil Tes</strong><br>
                                <small>Lihat hasil tes siswa</small>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('/asesmen-bakat-minat/analisis') ?>" class="btn btn-outline-info btn-block h-100">
                                <i class="fas fa-chart-pie fa-2x mb-2"></i><br>
                                <strong>Analisis</strong><br>
                                <small>Analisis data bakat minat</small>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('/asesmen-bakat-minat/rekomendasi') ?>" class="btn btn-outline-warning btn-block h-100">
                                <i class="fas fa-lightbulb fa-2x mb-2"></i><br>
                                <strong>Rekomendasi</strong><br>
                                <small>Rekomendasi jurusan</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history"></i> Aktivitas Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Siswa</th>
                                    <th>Jenis Tes</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>10:30</td>
                                    <td>Ahmad Fadli</td>
                                    <td>Tes Minat Holland</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>09:15</td>
                                    <td>Siti Nurhaliza</td>
                                    <td>Tes Bakat Gardner</td>
                                    <td><span class="badge badge-warning">Berlangsung</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>08:45</td>
                                    <td>Budi Santoso</td>
                                    <td>Tes Kepribadian MBTI</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-doughnut"></i> Distribusi Bakat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="chartBakat"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Linguistik
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Logis
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Visual
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Tes -->
<div class="modal fade" id="modalTambahTes" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus"></i> Tambah Tes Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Nama Tes</label>
                        <input type="text" class="form-control" placeholder="Contoh: Tes Minat Holland">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select">
                            <option>Pilih kategori...</option>
                            <option>Tes Bakat</option>
                            <option>Tes Minat</option>
                            <option>Tes Kepribadian</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" rows="3" placeholder="Deskripsi tes..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.text-xs {
    font-size: 0.7rem;
}
.btn-block {
    width: 100%;
}
</style>

<script>
// Chart for Bakat Distribution
if (document.getElementById('chartBakat')) {
    var ctx = document.getElementById('chartBakat');
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Linguistik", "Logis-Matematis", "Visual-Spasial", "Musikal", "Kinestetik"],
            datasets: [{
                data: [25, 20, 15, 10, 30],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#f4b619', '#e02d1b'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
}
</script>
