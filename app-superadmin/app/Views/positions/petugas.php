<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kelola Petugas - <?= esc($jabatan['nama_jabatan']) ?></h1>
    <a href="<?= base_url('positions') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Jabatan
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

<!-- Jabatan Info Card -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <h5 class="mb-1"><?= esc($jabatan['nama_jabatan']) ?> (<?= esc($jabatan['kode_jabatan']) ?>)</h5>
                <p class="text-muted mb-2"><?= esc($jabatan['deskripsi']) ?></p>
                <div class="d-flex gap-2">
                    <?php 
                    $kategoriLabels = [
                        'guru_mapel' => ['label' => 'Guru Mapel', 'class' => 'primary'],
                        'kepala_sekolah' => ['label' => 'Kepala Sekolah', 'class' => 'danger'],
                        'wakil_kepala_sekolah' => ['label' => 'Wakil Kepala Sekolah', 'class' => 'warning'],
                        'guru_bk' => ['label' => 'Guru BK', 'class' => 'info'],
                        'admin' => ['label' => 'Admin', 'class' => 'secondary'],
                        'staff' => ['label' => 'Staff', 'class' => 'dark']
                    ];
                    $kategori = $kategoriLabels[$jabatan['kategori']] ?? ['label' => $jabatan['kategori'], 'class' => 'light'];
                    ?>
                    <span class="badge bg-<?= $kategori['class'] ?>"><?= $kategori['label'] ?></span>
                    <span class="badge bg-info"><?= ucfirst($jabatan['departemen']) ?></span>
                    <span class="badge bg-success"><?= ucfirst($jabatan['level']) ?></span>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <div class="row g-2">
                    <div class="col-4">
                        <div class="text-center">
                            <div class="h4 mb-0 text-primary"><?= $stats['total_petugas'] ?></div>
                            <small class="text-muted">Total Petugas</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <div class="h4 mb-0 text-success"><?= $stats['petugas_aktif'] ?></div>
                            <small class="text-muted">Aktif</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <div class="h4 mb-0 text-secondary"><?= $stats['petugas_nonaktif'] ?></div>
                            <small class="text-muted">Nonaktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Petugas yang Sudah Ditugaskan -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Petugas yang Ditugaskan</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignPetugasModal">
                    <i class="fas fa-plus me-2"></i>Tugaskan Petugas
                </button>
            </div>
            <div class="card-body">
                <?php if (!empty($assigned_petugas)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Petugas</th>
                                    <th>NIP</th>
                                    <th>Role</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assigned_petugas as $index => $petugas): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <strong><?= esc($petugas['nama_lengkap']) ?></strong><br>
                                            <small class="text-muted"><?= esc($petugas['email']) ?></small>
                                        </td>
                                        <td><?= esc($petugas['nip']) ?></td>
                                        <td><span class="badge bg-info"><?= esc($petugas['role_name']) ?></span></td>
                                        <td><?= date('d/m/Y', strtotime($petugas['tanggal_mulai'])) ?></td>
                                        <td>
                                            <?php if ($petugas['status'] == 'aktif'): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="removePetugas(<?= $jabatan['id'] ?>, <?= $petugas['petugas_id'] ?>, '<?= esc($petugas['nama_lengkap']) ?>')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada petugas yang ditugaskan untuk jabatan ini</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignPetugasModal">
                            <i class="fas fa-plus me-2"></i>Tugaskan Petugas Pertama
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Petugas yang Tersedia -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Petugas Tersedia</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($available_petugas)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach (array_slice($available_petugas, 0, 10) as $petugas): ?>
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= esc($petugas['nama_lengkap']) ?></h6>
                                        <p class="mb-1"><small class="text-muted"><?= esc($petugas['nip']) ?></small></p>
                                        <small class="text-info"><?= esc($petugas['role_name']) ?></small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="quickAssign(<?= $petugas['id'] ?>, '<?= esc($petugas['nama_lengkap']) ?>')">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if (count($available_petugas) > 10): ?>
                            <div class="list-group-item px-0 text-center">
                                <small class="text-muted">Dan <?= count($available_petugas) - 10 ?> petugas lainnya...</small>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-3">
                        <i class="fas fa-exclamation-circle fa-2x text-warning mb-2"></i>
                        <p class="text-muted">Semua petugas sudah ditugaskan</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Assign Petugas -->
<div class="modal fade" id="assignPetugasModal" tabindex="-1" aria-labelledby="assignPetugasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignPetugasModalLabel">Tugaskan Petugas ke Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="petugas_id" class="form-label">Pilih Petugas <span class="text-danger">*</span></label>
                        <select class="form-select" id="petugas_id" name="petugas_id" required>
                            <option value="">-- Pilih Petugas --</option>
                            <?php if (!empty($available_petugas)): ?>
                                <?php foreach ($available_petugas as $petugas): ?>
                                    <option value="<?= $petugas['id'] ?>"><?= esc($petugas['nama_lengkap']) ?> (<?= esc($petugas['nip']) ?>) - <?= esc($petugas['role_name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai (Opsional)</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                        <div class="form-text">Kosongkan jika penugasan tidak memiliki batas waktu</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tugaskan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Assign petugas form handler
document.getElementById('assignForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Processing...';
    
    fetch('<?= base_url('positions/assign-petugas/' . $jabatan['id']) ?>', {
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

// Quick assign function
function quickAssign(petugasId, namaPetugas) {
    if (confirm(`Tugaskan ${namaPetugas} ke jabatan <?= esc($jabatan['nama_jabatan']) ?>?`)) {
        const formData = new FormData();
        formData.append('petugas_id', petugasId);
        formData.append('tanggal_mulai', '<?= date('Y-m-d') ?>');
        
        fetch('<?= base_url('positions/assign-petugas/' . $jabatan['id']) ?>', {
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
        });
    }
}

// Remove petugas function
function removePetugas(jabatanId, petugasId, namaPetugas) {
    if (confirm(`Hapus ${namaPetugas} dari jabatan <?= esc($jabatan['nama_jabatan']) ?>?`)) {
        fetch(`<?= base_url('positions/remove-petugas') ?>/${jabatanId}/${petugasId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_token() ?>'
            }
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
        });
    }
}
</script>

<?= $this->endSection() ?>
