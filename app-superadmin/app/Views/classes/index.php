<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Data Kelas</h1>
    <a href="<?= base_url('classes/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Kelas
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
        <h5 class="card-title mb-0">Daftar Kelas</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Sekolah</th>
                        <th>Tingkat</th>
                        <th>Jurusan</th>
                        <th>Kapasitas</th>
                        <th>Jumlah Siswa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($classes)): ?>
                        <?php foreach ($classes as $index => $class): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($class['nama_kelas']) ?></td>
                                <td><?= esc($class['nama_sekolah']) ?></td>
                                <td><?= esc($class['tingkat']) ?></td>
                                <td><?= esc($class['jurusan']) ?: '-' ?></td>
                                <td><?= esc($class['kapasitas']) ?></td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= $class['jumlah_siswa'] ?? 0 ?> siswa
                                    </span>
                                </td>
                                <td>
                                    <?php if ($class['status'] == 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('classes/students/' . $class['id']) ?>" 
                                           class="btn btn-sm btn-info" 
                                           title="Lihat Siswa">
                                            <i class="fas fa-users"></i>
                                        </a>
                                        <a href="<?= base_url('classes/edit/' . $class['id']) ?>" 
                                           class="btn btn-sm btn-warning"
                                           title="Edit Kelas">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('classes/delete/' . $class['id']) ?>" 
                                           class="btn btn-sm btn-danger"
                                           title="Hapus Kelas"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data kelas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
