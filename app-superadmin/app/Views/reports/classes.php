<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Laporan Kelas</h1>
    <div>
        <a href="<?= base_url('reports') ?>" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <a href="<?= base_url('reports/export/classes') ?>" class="btn btn-success">
            <i class="fas fa-download me-2"></i>Export Excel
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Total Kelas</h5>
                        <h2><?= number_format($classStats['total']) ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chalkboard fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Aktif</h5>
                        <h2><?= number_format($classStats['aktif']) ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Nonaktif</h5>
                        <h2><?= number_format($classStats['nonaktif']) ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Classes Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Kelas</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Kelas</th>
                        <th>Sekolah</th>
                        <th>Tingkat</th>
                        <th>Jurusan</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($classes)): ?>
                        <?php foreach ($classes as $class): ?>
                            <tr>
                                <td><?= $class['id'] ?></td>
                                <td><?= $class['nama_kelas'] ?></td>
                                <td><?= $class['nama_sekolah'] ?></td>
                                <td><?= $class['tingkat'] ?></td>
                                <td><?= $class['jurusan'] ?></td>
                                <td><?= $class['kapasitas'] ?></td>
                                <td>
                                    <?php if ($class['status'] == 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($class['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data kelas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tingkat Statistics -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Statistik Berdasarkan Tingkat</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if (!empty($classStats['by_tingkat'])): ?>
                <?php foreach ($classStats['by_tingkat'] as $tingkat): ?>
                    <div class="col-md-3 mb-3">                            <div class="card">
                                <div class="card-body text-center">
                                    <h5>Tingkat <?= $tingkat['tingkat'] ?></h5>
                                    <h3 class="text-primary"><?= isset($tingkat['count']) ? number_format($tingkat['count']) : '0' ?></h3>
                                    <p class="text-muted">Kelas</p>
                                </div>
                            </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-muted">Tidak ada data statistik tingkat</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
