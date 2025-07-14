<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Detail Pengguna Murid
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
                                <i class="fas fa-eye"></i> Detail Pengguna Murid
                            </h4>
                            <p class="card-text mb-0">Informasi lengkap data murid</p>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('pengguna-murid') ?>" class="btn btn-light">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <a href="<?= base_url('pengguna-murid/edit/' . $murid['id']) ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Profile Picture and Basic Info -->
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                <img src="<?= base_url('uploads/profiles/' . ($murid['profile_picture'] ?? 'default.png')) ?>" 
                                     alt="Profile Picture" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                <h4 class="mt-3"><?= esc($murid['nama_lengkap'] ?? $murid['nama'] ?? 'Nama Tidak Tersedia') ?></h4>
                                <p class="text-muted"><?= esc($murid['nisn'] ?? '-') ?></p>
                                <?php if ($murid['is_active'] ?? true): ?>
                                    <span class="badge bg-success fs-6">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger fs-6">Nonaktif</span>
                                <?php endif; ?>
                            </div>

                            <!-- Quick Stats -->
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Quick Info</h6>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="border-end">
                                                <h5 class="mb-0 text-primary"><?= esc($murid['kelas_name'] ?? 'Belum Ada') ?></h5>
                                                <small class="text-muted">Kelas</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="mb-0 text-success"><?= ($murid['jenis_kelamin'] ?? '') == 'L' ? 'Laki-laki' : (($murid['jenis_kelamin'] ?? '') == 'P' ? 'Perempuan' : 'Belum Diisi') ?></h5>
                                            <small class="text-muted">Jenis Kelamin</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Information -->
                        <div class="col-md-8">
                            <div class="row">
                                <!-- Personal Information -->
                                <div class="col-12">
                                    <h5 class="mb-3 text-primary">
                                        <i class="fas fa-user"></i> Informasi Personal
                                    </h5>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>NISN:</strong></td>
                                            <td><?= esc($murid['nisn'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>NIS:</strong></td>
                                            <td><?= esc($murid['nis'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Username:</strong></td>
                                            <td><?= esc($murid['username'] ?? $murid['nis'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td><?= esc($murid['email'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>No. Telepon:</strong></td>
                                            <td><?= esc($murid['no_telepon'] ?? '-') ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Tempat Lahir:</strong></td>
                                            <td><?= esc($murid['tempat_lahir'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Lahir:</strong></td>
                                            <td>
                                                <?php if (!empty($murid['tanggal_lahir'])): ?>
                                                    <?= date('d F Y', strtotime($murid['tanggal_lahir'])) ?>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Agama:</strong></td>
                                            <td><?= esc($murid['agama'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jenis Kelamin:</strong></td>
                                            <td>
                                                <?php if (($murid['jenis_kelamin'] ?? '') == 'L'): ?>
                                                    <span class="badge bg-primary">Laki-laki</span>
                                                <?php elseif (($murid['jenis_kelamin'] ?? '') == 'P'): ?>
                                                    <span class="badge bg-pink">Perempuan</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Belum Diisi</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <?php if (($murid['is_active'] ?? true)): ?>
                                                    <span class="badge bg-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Nonaktif</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Academic Information -->
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3 text-success">
                                        <i class="fas fa-graduation-cap"></i> Informasi Akademik
                                    </h5>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Kelas:</strong></td>
                                            <td>
                                                <?php if (!empty($murid['nama_kelas'])): ?>
                                                    <span class="badge bg-primary"><?= esc($murid['nama_kelas']) ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Belum Ditentukan</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tingkat:</strong></td>
                                            <td><?= esc($murid['tingkat'] ?? '-') ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Tahun Ajaran:</strong></td>
                                            <td>
                                                <?php if (!empty($murid['nama_tahun_ajaran'])): ?>
                                                    <span class="badge bg-info"><?= esc($murid['nama_tahun_ajaran']) ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Belum Ditentukan</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Wali Kelas:</strong></td>
                                            <td><?= esc($murid['wali_kelas'] ?? '-') ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3 text-warning">
                                        <i class="fas fa-info-circle"></i> Informasi Tambahan
                                    </h5>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td style="width: 150px;"><strong>Alamat:</strong></td>
                                            <td><?= esc($murid['alamat'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Terakhir Login:</strong></td>
                                            <td>
                                                <?php if (!empty($murid['last_login'])): ?>
                                                    <?= date('d F Y, H:i', strtotime($murid['last_login'])) ?> WIB
                                                <?php else: ?>
                                                    <span class="text-muted">Belum pernah login</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dibuat:</strong></td>
                                            <td>
                                                <?php if (!empty($murid['created_at'])): ?>
                                                    <?= date('d F Y, H:i', strtotime($murid['created_at'])) ?> WIB
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Diupdate:</strong></td>
                                            <td>
                                                <?php if (!empty($murid['updated_at'])): ?>
                                                    <?= date('d F Y, H:i', strtotime($murid['updated_at'])) ?> WIB
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <a href="<?= base_url('pengguna-murid/edit/' . $murid['id']) ?>" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Edit Data
                                        </a>
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $murid['id'] ?>)">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                        <?php if ($murid['is_active']): ?>
                                            <a href="<?= base_url('pengguna-murid/toggle-status/' . $murid['id']) ?>" class="btn btn-secondary">
                                                <i class="fas fa-user-slash"></i> Nonaktifkan
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= base_url('pengguna-murid/toggle-status/' . $murid['id']) ?>" class="btn btn-success">
                                                <i class="fas fa-user-check"></i> Aktifkan
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data murid ini? Tindakan ini tidak dapat dibatalkan.')) {
        window.location.href = '<?= base_url('pengguna-murid/delete/') ?>' + id;
    }
}
</script>

<style>
.badge.bg-pink {
    background-color: #e91e63 !important;
}
</style>
<?= $this->endSection() ?>
