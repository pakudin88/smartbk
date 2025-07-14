<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Laporan Mata Pelajaran</h1>
    <div>
        <a href="<?= base_url('reports') ?>" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <a href="<?= base_url('reports/export/subjects') ?>" class="btn btn-success">
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
                        <h5>Total Mata Pelajaran</h5>
                        <h2><?= number_format($subjectStats['total']) ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-book fa-2x"></i>
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
                        <h2><?= number_format($subjectStats['aktif']) ?></h2>
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
                        <h2><?= number_format($subjectStats['nonaktif']) ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Subjects Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Mata Pelajaran</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Mata Pelajaran</th>
                        <th>Kode</th>
                        <th>Kategori</th>
                        <th>Tingkat</th>
                        <th>Jam Pelajaran</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($subjects)): ?>
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <td><?= $subject['id'] ?></td>
                                <td><?= $subject['nama_mapel'] ?></td>
                                <td><?= $subject['kode_mapel'] ?></td>
                                <td>
                                    <span class="badge bg-info"><?= $subject['kategori'] ?></span>
                                </td>
                                <td><?= $subject['tingkat'] ?></td>
                                <td><?= $subject['jam_pelajaran'] ?> jam</td>
                                <td>
                                    <?php if ($subject['status'] == 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($subject['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data mata pelajaran</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Kategori Statistics -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Statistik Berdasarkan Kategori</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if (!empty($subjectStats['by_kategori'])): ?>
                <?php foreach ($subjectStats['by_kategori'] as $kategori): ?>
                    <div class="col-md-4 mb-3">                            <div class="card">
                                <div class="card-body text-center">
                                    <h5><?= $kategori['kategori'] ?></h5>
                                    <h3 class="text-primary"><?= isset($kategori['count']) ? number_format($kategori['count']) : '0' ?></h3>
                                    <p class="text-muted">Mata Pelajaran</p>
                                </div>
                            </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-muted">Tidak ada data statistik kategori</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
