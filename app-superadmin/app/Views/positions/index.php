<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kelola Jabatan</h1>
    <div class="btn-group">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#copyFromPreviousYearModal">
            <i class="fas fa-copy me-2"></i>Copy dari Tahun Sebelumnya
        </button>
        <a href="<?= base_url('positions/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Jabatan
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
        <h5 class="card-title mb-0">Daftar Jabatan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jabatan</th>
                        <th>Kode</th>
                        <th>Kategori</th>
                        <th>Departemen</th>
                        <th>Level</th>
                        <th>Petugas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($jabatan)): ?>
                        <?php foreach ($jabatan as $index => $position): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($position['nama_jabatan']) ?></td>
                                <td><?= esc($position['kode_jabatan']) ?></td>
                                <td>
                                    <?php 
                                    $kategoriLabels = [
                                        'guru_mapel' => ['label' => 'Guru Mapel', 'class' => 'primary'],
                                        'kepala_sekolah' => ['label' => 'Kepala Sekolah', 'class' => 'danger'],
                                        'wakil_kepala_sekolah' => ['label' => 'Wakil Kepala Sekolah', 'class' => 'warning'],
                                        'guru_bk' => ['label' => 'Guru BK', 'class' => 'info'],
                                        'admin' => ['label' => 'Admin', 'class' => 'secondary'],
                                        'staff' => ['label' => 'Staff', 'class' => 'dark']
                                    ];
                                    $kategori = $kategoriLabels[$position['kategori']] ?? ['label' => $position['kategori'], 'class' => 'light'];
                                    ?>
                                    <span class="badge bg-<?= $kategori['class'] ?>"><?= $kategori['label'] ?></span>
                                </td>
                                <td>
                                    <?php 
                                    $departemenLabels = [
                                        'akademik' => 'Akademik',
                                        'administrasi' => 'Administrasi',
                                        'bimbingan_konseling' => 'Bimbingan Konseling',
                                        'kepala_sekolah' => 'Kepala Sekolah'
                                    ];
                                    ?>
                                    <?= $departemenLabels[$position['departemen']] ?? $position['departemen'] ?>
                                </td>
                                <td>
                                    <?php 
                                    $levelLabels = [
                                        'pimpinan' => ['label' => 'Pimpinan', 'class' => 'danger'],
                                        'koordinator' => ['label' => 'Koordinator', 'class' => 'warning'],
                                        'pelaksana' => ['label' => 'Pelaksana', 'class' => 'success']
                                    ];
                                    $level = $levelLabels[$position['level']] ?? ['label' => $position['level'], 'class' => 'secondary'];
                                    ?>
                                    <span class="badge bg-<?= $level['class'] ?>"><?= $level['label'] ?></span>
                                </td>
                                <td>
                                    <?php if (!empty($position['nama_petugas'])): ?>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2"><?= $position['jumlah_petugas'] ?> orang</span>
                                            <small class="text-muted"><?= esc(substr($position['nama_petugas'], 0, 30)) ?><?= strlen($position['nama_petugas']) > 30 ? '...' : '' ?></small>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Belum ada petugas</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($position['status'] == 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('positions/petugas/' . $position['id']) ?>" 
                                           class="btn btn-sm btn-info"
                                           title="Kelola Petugas">
                                            <i class="fas fa-users"></i>
                                        </a>
                                        <a href="<?= base_url('positions/edit/' . $position['id']) ?>" 
                                           class="btn btn-sm btn-warning"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('positions/delete/' . $position['id']) ?>" 
                                           class="btn btn-sm btn-danger"
                                           title="Hapus"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus jabatan ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data jabatan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Copy from Previous Year -->
<div class="modal fade" id="copyFromPreviousYearModal" tabindex="-1" aria-labelledby="copyFromPreviousYearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="copyFromPreviousYearModalLabel">Copy Jabatan dari Tahun Sebelumnya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="copyForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="from_tahun_ajaran_id" class="form-label">Pilih Tahun Ajaran Sumber</label>
                        <select class="form-select" id="from_tahun_ajaran_id" name="from_tahun_ajaran_id" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php if (!empty($previous_years)): ?>
                                <?php foreach ($previous_years as $year): ?>
                                    <option value="<?= $year['id'] ?>"><?= esc($year['nama_tahun_ajaran']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <strong>Info:</strong> Jabatan akan disalin ke tahun ajaran yang sedang aktif. 
                        Jabatan yang sudah ada tidak akan duplikat.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Copy Jabatan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('copyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Processing...';
    
    fetch('<?= base_url('positions/copy-from-previous-year') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_token() ?>'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses permintaan');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});
</script>

<?= $this->endSection() ?>
