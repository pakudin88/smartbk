<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Guru Pengajar - <?= esc($subject['nama_mapel']) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('subjects') ?>">Data Mata Pelajaran</a></li>
                <li class="breadcrumb-item active" aria-current="page">Guru Pengajar</li>
            </ol>
        </nav>
    </div>
    <a href="<?= base_url('subjects') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
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

<!-- Subject Info Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Mata Pelajaran</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <strong>Nama Mata Pelajaran:</strong><br>
                        <?= esc($subject['nama_mapel']) ?>
                    </div>
                    <div class="col-md-2">
                        <strong>Kode:</strong><br>
                        <?= esc($subject['kode_mapel']) ?>
                    </div>
                    <div class="col-md-2">
                        <strong>Kategori:</strong><br>
                        <?php if ($subject['kategori'] == 'wajib'): ?>
                            <span class="badge bg-primary">Wajib</span>
                        <?php elseif ($subject['kategori'] == 'pilihan'): ?>
                            <span class="badge bg-info">Pilihan</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Muatan Lokal</span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2">
                        <strong>Tingkat:</strong><br>
                        <?= esc($subject['tingkat']) ?>
                    </div>
                    <div class="col-md-2">
                        <strong>Jam Pelajaran:</strong><br>
                        <?= esc($subject['jam_pelajaran']) ?> jam
                    </div>
                    <div class="col-md-2">
                        <strong>Status:</strong><br>
                        <?php if ($subject['status'] == 'aktif'): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Teachers List -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Guru Pengajar</h5>
        <div>
            <span class="badge bg-primary me-2">
                Total: <?= count($teachers) ?> guru
            </span>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                <i class="fas fa-plus me-1"></i>Tambah Guru
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>NIP</th>
                        <th>Spesialisasi</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($teachers)): ?>
                        <?php foreach ($teachers as $index => $teacher): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 32px; height: 32px; font-size: 14px;">
                                                <?= strtoupper(substr($teacher['full_name'], 0, 1)) ?>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold"><?= esc($teacher['full_name']) ?></div>
                                            <div class="text-muted small"><?= esc($teacher['email']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= esc($teacher['nip'] ?? '-') ?></td>
                                <td><?= esc($teacher['specialization'] ?? '-') ?></td>
                                <td>
                                    <?php if ($teacher['nama_kelas']): ?>
                                        <span class="badge bg-info"><?= esc($teacher['nama_kelas']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Semua Kelas</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($teacher['tahun_ajaran']) ?></td>
                                <td>
                                    <?php if ($teacher['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('subjects/remove-teacher/' . $subject['id'] . '/' . $teacher['id']) ?>" 
                                           class="btn btn-sm btn-danger" 
                                           title="Hapus Guru"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini dari mata pelajaran?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada guru yang ditugaskan</h5>
                                <p class="text-muted">Tambahkan guru untuk mengajar mata pelajaran ini</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Teacher Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTeacherModalLabel">Tambah Guru Pengajar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('subjects/assign-teacher/' . $subject['id']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Pilih Guru *</label>
                        <select class="form-select" id="teacher_id" name="teacher_id" required>
                            <option value="">Pilih Guru</option>
                            <?php foreach ($availableTeachers as $teacher): ?>
                                <option value="<?= $teacher['id'] ?>">
                                    <?= esc($teacher['full_name']) ?>
                                    <?= $teacher['specialization'] ? ' - ' . esc($teacher['specialization']) : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Kelas (Opsional)</label>
                        <select class="form-select" id="class_id" name="class_id">
                            <option value="">Semua Kelas</option>
                            <!-- Classes will be loaded here if needed -->
                        </select>
                        <div class="form-text">Kosongkan jika guru mengajar di semua kelas</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tugaskan Guru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
