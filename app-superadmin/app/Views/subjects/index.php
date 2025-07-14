<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Data Mata Pelajaran</h1>
    <div class="btn-group">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#copyFromPreviousYearModal">
            <i class="fas fa-copy me-2"></i>Copy dari Tahun Sebelumnya
        </button>
        <a href="<?= base_url('subjects/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Mata Pelajaran
        </a>
    </div>
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
        <h5 class="card-title mb-0">Daftar Mata Pelajaran</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mata Pelajaran</th>
                        <th>Kode</th>
                        <th>Kategori</th>
                        <th>Tingkat</th>
                        <th>Jam Pelajaran</th>
                        <th>Guru Pengajar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($subjects)): ?>
                        <?php foreach ($subjects as $index => $subject): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($subject['nama_mapel']) ?></td>
                                <td><?= esc($subject['kode_mapel']) ?></td>
                                <td>
                                    <?php if ($subject['kategori'] == 'wajib'): ?>
                                        <span class="badge bg-primary">Wajib</span>
                                    <?php elseif ($subject['kategori'] == 'pilihan'): ?>
                                        <span class="badge bg-info">Pilihan</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Muatan Lokal</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($subject['tingkat']) ?></td>
                                <td><?= esc($subject['jam_pelajaran']) ?> jam</td>
                                <td>
                                    <?php if (!empty($subject['nama_guru'])): ?>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2"><?= $subject['jumlah_guru'] ?> guru</span>
                                            <small class="text-muted"><?= esc($subject['nama_guru']) ?></small>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Belum ada guru</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($subject['status'] == 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('subjects/teachers/' . $subject['id']) ?>" 
                                           class="btn btn-sm btn-info"
                                           title="Kelola Guru">
                                            <i class="fas fa-users"></i>
                                        </a>
                                        <a href="<?= base_url('subjects/edit/' . $subject['id']) ?>" 
                                           class="btn btn-sm btn-warning"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('subjects/delete/' . $subject['id']) ?>" 
                                           class="btn btn-sm btn-danger"
                                           title="Hapus"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data mata pelajaran</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Copy dari Tahun Sebelumnya -->
<div class="modal fade" id="copyFromPreviousYearModal" tabindex="-1" aria-labelledby="copyFromPreviousYearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="copyFromPreviousYearModalLabel">Copy Mata Pelajaran dari Tahun Sebelumnya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="copyFromPreviousYearForm" method="post" action="<?= base_url('subjects/copy-from-previous-year') ?>">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong> Fitur ini hanya akan menyalin nama mata pelajaran dari tahun ajaran sebelumnya ke tahun ajaran aktif saat ini. Data lain seperti kode, kategori, dan guru perlu diatur ulang.
                    </div>
                    
                    <div class="mb-3">
                        <label for="previous_year" class="form-label">Pilih Tahun Ajaran Sebelumnya</label>
                        <select class="form-select" id="previous_year" name="previous_year" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php if (!empty($previous_years)): ?>
                                <?php foreach ($previous_years as $year): ?>
                                    <option value="<?= $year['id'] ?>"><?= esc($year['nama_tahun_ajaran']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirm_copy" name="confirm_copy" required>
                        <label class="form-check-label" for="confirm_copy">
                            Saya yakin ingin menyalin data mata pelajaran dari tahun sebelumnya
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-copy me-2"></i>Copy Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
