<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Laporan Sekolah</h1>
    <div>
        <a href="<?= base_url('reports') ?>" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <a href="<?= base_url('reports/export/schools') ?>" class="btn btn-success">
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
                        <h5>Total Sekolah</h5>
                        <h2><?= number_format($schoolStats['total']) ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-school fa-2x"></i>
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
                        <h2><?= number_format($schoolStats['aktif']) ?></h2>
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
                        <h2><?= number_format($schoolStats['nonaktif']) ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schools Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Sekolah</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Sekolah</th>
                        <th>NPSN</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Kepala Sekolah</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($schools)): ?>
                        <?php foreach ($schools as $school): ?>
                            <tr>
                                <td><?= $school['id'] ?></td>
                                <td><?= $school['nama_sekolah'] ?></td>
                                <td><?= $school['npsn'] ?></td>
                                <td><?= $school['alamat'] ?></td>
                                <td><?= $school['telepon'] ?></td>
                                <td><?= $school['email'] ?></td>
                                <td><?= $school['kepala_sekolah'] ?></td>
                                <td>
                                    <?php if ($school['status'] == 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($school['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data sekolah</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
