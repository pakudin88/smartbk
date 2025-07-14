<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Data Tahun Ajaran</h1>
    <a href="<?= base_url('school-years/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Tahun Ajaran
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Active School Year Alert -->
<?php if ($activeSchoolYear): ?>
<div class="alert alert-info">
    <i class="fas fa-calendar-alt me-2"></i>
    <strong>Tahun Ajaran Aktif:</strong> <?= esc($activeSchoolYear['nama_tahun_ajaran']) ?> 
    (<?= esc($activeSchoolYear['semester']) ?>)
    <br>
    <small>Semua data kelas, siswa, dan guru saat ini mengacu pada tahun ajaran ini.</small>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Tahun Ajaran</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tahun Ajaran</th>
                        <th>Periode</th>
                        <th>Tanggal</th>
                        <th>Semester</th>
                        <th>Statistik</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($schoolYears)): ?>
                        <?php foreach ($schoolYears as $index => $schoolYear): ?>
                            <tr class="<?= $schoolYear['is_active'] ? 'table-primary' : '' ?>">
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($schoolYear['is_active']): ?>
                                            <i class="fas fa-star text-warning me-2" title="Tahun Ajaran Aktif"></i>
                                        <?php endif; ?>
                                        <strong><?= esc($schoolYear['nama_tahun_ajaran']) ?></strong>
                                    </div>
                                </td>
                                <td><?= esc($schoolYear['tahun_mulai']) ?>/<?= esc($schoolYear['tahun_selesai']) ?></td>
                                <td>
                                    <small>
                                        <?= date('d/m/Y', strtotime($schoolYear['start_date'])) ?><br>
                                        s/d <?= date('d/m/Y', strtotime($schoolYear['end_date'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= esc($schoolYear['semester']) ?></span>
                                </td>
                                <td>
                                    <div class="small">
                                        <div><i class="fas fa-school text-primary"></i> <?= $schoolYear['jumlah_kelas'] ?? 0 ?> Kelas</div>
                                        <div><i class="fas fa-user-graduate text-success"></i> <?= $schoolYear['jumlah_siswa'] ?? 0 ?> Siswa</div>
                                        <div><i class="fas fa-chalkboard-teacher text-warning"></i> <?= $schoolYear['jumlah_guru'] ?? 0 ?> Guru</div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($schoolYear['is_active']): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <?php if (!$schoolYear['is_active']): ?>
                                            <button type="button" class="btn btn-sm btn-success" 
                                                    onclick="activateSchoolYear(<?= $schoolYear['id'] ?>, '<?= esc($schoolYear['nama_tahun_ajaran']) ?>')"
                                                    title="Aktifkan Tahun Ajaran">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        <?php else: ?>
                                            <span class="btn btn-sm btn-success disabled">
                                                <i class="fas fa-star"></i>
                                            </span>
                                        <?php endif; ?>
                                        <a href="<?= base_url('school-years/edit/' . $schoolYear['id']) ?>" 
                                           class="btn btn-sm btn-warning"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if (!$schoolYear['is_active']): ?>
                                            <a href="<?= base_url('school-years/delete/' . $schoolYear['id']) ?>" 
                                               class="btn btn-sm btn-danger"
                                               title="Hapus"
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus tahun ajaran ini? Data terkait akan ikut terhapus.')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada tahun ajaran</h5>
                                <p class="text-muted">Tambahkan tahun ajaran pertama untuk memulai</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Activation Confirmation Modal -->
<div class="modal fade" id="activateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Aktivasi Tahun Ajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian!</strong> Mengaktifkan tahun ajaran baru akan:
                </div>
                <ul>
                    <li>Menonaktifkan tahun ajaran yang sedang aktif</li>
                    <li>Mengubah referensi data untuk semua fitur</li>
                    <li>Data tahun ajaran sebelumnya tetap tersimpan sebagai histori</li>
                </ul>
                <p>Apakah Anda yakin ingin mengaktifkan tahun ajaran <strong id="schoolYearName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="activateForm" method="post" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>Ya, Aktifkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function activateSchoolYear(id, name) {
    document.getElementById('schoolYearName').textContent = name;
    document.getElementById('activateForm').action = '<?= base_url('school-years/activate') ?>/' + id;
    
    var modal = new bootstrap.Modal(document.getElementById('activateModal'));
    modal.show();
}
</script>

<?= $this->endSection() ?>
