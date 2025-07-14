<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Detail Pengguna Sekolah
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-user"></i> Detail Pengguna Sekolah
                            </h4>
                            <p class="card-text mb-0">Informasi lengkap petugas</p>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('pengguna-sekolah') ?>" class="btn btn-light">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="<?= base_url('pengguna-sekolah/edit/' . $petugas['id']) ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                <img src="<?= base_url('uploads/profiles/' . ($petugas['profile_picture'] ?? 'default.png')) ?>" 
                                     alt="Profile Picture" class="rounded-circle img-fluid" 
                                     style="width: 200px; height: 200px; object-fit: cover; border: 5px solid #dee2e6;">
                                <h4 class="mt-3 mb-1"><?= esc($petugas['nama_lengkap']) ?></h4>
                                <span class="badge bg-primary fs-6"><?= esc($petugas['role_name']) ?></span>
                                <?php if ($petugas['is_active']): ?>
                                    <span class="badge bg-success fs-6">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger fs-6">Nonaktif</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Username</label>
                                        <p class="form-control-plaintext"><?= esc($petugas['username']) ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <p class="form-control-plaintext"><?= esc($petugas['email']) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">NIP</label>
                                        <p class="form-control-plaintext"><?= esc($petugas['nip'] ?: '-') ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jabatan</label>
                                        <p class="form-control-plaintext"><?= esc($petugas['jabatan'] ?: '-') ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Departemen</label>
                                        <p class="form-control-plaintext"><?= esc($petugas['departemen'] ?: '-') ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">No. Telepon</label>
                                        <p class="form-control-plaintext"><?= esc($petugas['no_telepon'] ?: '-') ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jenis Kelamin</label>
                                        <p class="form-control-plaintext">
                                            <?php if ($petugas['jenis_kelamin'] == 'L'): ?>
                                                Laki-laki
                                            <?php elseif ($petugas['jenis_kelamin'] == 'P'): ?>
                                                Perempuan
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Lahir</label>
                                        <p class="form-control-plaintext">
                                            <?= $petugas['tanggal_lahir'] ? date('d/m/Y', strtotime($petugas['tanggal_lahir'])) : '-' ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Alamat</label>
                                        <p class="form-control-plaintext"><?= esc($petugas['alamat'] ?: '-') ?></p>
                                    </div>
                                </div>
                            </div>

                            <?php if (isset($petugas['nama_tahun_ajaran'])): ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tahun Ajaran</label>
                                        <p class="form-control-plaintext"><?= esc($petugas['nama_tahun_ajaran']) ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Informasi Sistem</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td class="fw-bold">Terakhir Login:</td>
                                    <td>
                                        <?php if ($petugas['last_login']): ?>
                                            <?= date('d/m/Y H:i:s', strtotime($petugas['last_login'])) ?>
                                        <?php else: ?>
                                            Belum pernah login
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Dibuat:</td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($petugas['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Diperbarui:</td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($petugas['updated_at'])) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Role & Permissions</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td class="fw-bold">Role:</td>
                                    <td><span class="badge bg-primary"><?= esc($petugas['role_name']) ?></span></td>
                                </tr>
                                <?php if (isset($petugas['role_description'])): ?>
                                <tr>
                                    <td class="fw-bold">Deskripsi:</td>
                                    <td><?= esc($petugas['role_description']) ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="fw-bold">Status:</td>
                                    <td>
                                        <?php if ($petugas['is_active']): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('pengguna-sekolah') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        <div>
                            <a href="<?= base_url('pengguna-sekolah/edit/' . $petugas['id']) ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Data
                            </a>
                            <button type="button" class="btn btn-danger" onclick="deletePetugas(<?= $petugas['id'] ?>)">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deletePetugas(id) {
    if (confirm('Apakah Anda yakin ingin menghapus petugas ini?')) {
        fetch('<?= base_url('pengguna-sekolah/delete/') ?>' + id, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Petugas berhasil dihapus');
                window.location.href = '<?= base_url('pengguna-sekolah') ?>';
            } else {
                alert('Error: ' + (data.message || 'Gagal menghapus petugas'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        });
    }
}
</script>
<?= $this->endSection() ?>
