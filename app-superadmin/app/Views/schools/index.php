<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Data Sekolah</h1>
    <a href="<?= base_url('schools/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Sekolah
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Sekolah</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Sekolah</th>
                        <th>NPSN</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Kepala Sekolah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($schools)): ?>
                        <?php foreach ($schools as $index => $school): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($school['nama_sekolah']) ?></td>
                                <td><?= esc($school['npsn']) ?></td>
                                <td><?= esc($school['alamat']) ?></td>
                                <td><?= esc($school['telepon']) ?></td>
                                <td><?= esc($school['email']) ?></td>
                                <td><?= esc($school['kepala_sekolah']) ?></td>
                                <td>
                                    <?php if ($school['status'] == 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('schools/edit/' . $school['id']) ?>" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('schools/delete/' . $school['id']) ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus sekolah ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
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
