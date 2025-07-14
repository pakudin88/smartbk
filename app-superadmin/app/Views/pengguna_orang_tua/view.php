<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Detail Pengguna Orang Tua
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengguna Orang Tua</h1>
        <div class="btn-group">
            <a href="/pengguna-orang-tua/edit/<?= $orang_tua['id'] ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="/pengguna-orang-tua" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Informasi Orang Tua: <?= esc($orang_tua['nama_lengkap']) ?>
                <span class="badge badge-<?= $orang_tua['is_active'] ? 'success' : 'danger' ?> ml-2">
                    <?= $orang_tua['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                </span>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Data Login -->
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">Data Login</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><strong>Username</strong></td>
                            <td>: <?= esc($orang_tua['username']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>: <?= $orang_tua['email'] ? esc($orang_tua['email']) : '<span class="text-muted">Tidak ada</span>' ?></td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: <span class="badge badge-<?= $orang_tua['is_active'] ? 'success' : 'danger' ?>">
                                <?= $orang_tua['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                            </span></td>
                        </tr>
                    </table>
                </div>

                <!-- Data Pribadi -->
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">Data Pribadi</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><strong>Nama Lengkap</strong></td>
                            <td>: <?= esc($orang_tua['nama_lengkap']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Hubungan</strong></td>
                            <td>: <span class="badge badge-info"><?= esc($orang_tua['hubungan_keluarga']) ?></span></td>
                        </tr>
                        <tr>
                            <td><strong>No. Telepon</strong></td>
                            <td>: <?= $orang_tua['no_telepon'] ? esc($orang_tua['no_telepon']) : '<span class="text-muted">Tidak ada</span>' ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <!-- Data Tambahan -->
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">Data Tambahan</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><strong>Pekerjaan</strong></td>
                            <td>: <?= $orang_tua['pekerjaan'] ? esc($orang_tua['pekerjaan']) : '<span class="text-muted">Tidak ada</span>' ?></td>
                        </tr>
                        <tr>
                            <td><strong>Pendidikan</strong></td>
                            <td>: <?= $orang_tua['pendidikan'] ? esc($orang_tua['pendidikan']) : '<span class="text-muted">Tidak ada</span>' ?></td>
                        </tr>
                        <tr>
                            <td><strong>Penghasilan</strong></td>
                            <td>: <?= $orang_tua['penghasilan'] ? 'Rp ' . number_format($orang_tua['penghasilan'], 0, ',', '.') : '<span class="text-muted">Tidak ada</span>' ?></td>
                        </tr>
                    </table>
                </div>

                <!-- Alamat dan Tahun Ajaran -->
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">Alamat & Tahun Ajaran</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" style="vertical-align: top;"><strong>Alamat</strong></td>
                            <td>: <?= $orang_tua['alamat'] ? nl2br(esc($orang_tua['alamat'])) : '<span class="text-muted">Tidak ada</span>' ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tahun Ajaran</strong></td>
                            <td>: <?= isset($orang_tua['nama_tahun_ajaran']) ? esc($orang_tua['nama_tahun_ajaran']) : '<span class="text-muted">Tidak ada</span>' ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="row">
                <div class="col-12">
                    <h6 class="text-primary mb-3">Informasi Sistem</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td width="15%"><strong>Dibuat pada</strong></td>
                            <td>: <?= isset($orang_tua['created_at']) ? date('d-m-Y H:i', strtotime($orang_tua['created_at'])) : '<span class="text-muted">Tidak ada</span>' ?></td>
                        </tr>
                        <tr>
                            <td><strong>Diupdate pada</strong></td>
                            <td>: <?= isset($orang_tua['updated_at']) ? date('d-m-Y H:i', strtotime($orang_tua['updated_at'])) : '<span class="text-muted">Tidak ada</span>' ?></td>
                        </tr>
                        <tr>
                            <td><strong>Login terakhir</strong></td>
                            <td>: <?= isset($orang_tua['last_login']) && $orang_tua['last_login'] ? date('d-m-Y H:i', strtotime($orang_tua['last_login'])) : '<span class="text-muted">Belum pernah login</span>' ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Murid Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Murid yang Terhubung
                <?php if (!empty($murid_list)): ?>
                    <span class="badge badge-primary ml-2"><?= count($murid_list) ?> Murid</span>
                <?php endif; ?>
            </h6>
        </div>
        <div class="card-body">
            <?php if (!empty($murid_list) && is_array($murid_list)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NISN</th>
                                <th>Kelas</th>
                                <th>Hubungan</th>
                                <th>Status Utama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($murid_list as $index => $murid): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= esc($murid['nama_lengkap']) ?></strong>
                                        <?php if (isset($murid['jenis_kelamin'])): ?>
                                            <small class="text-muted">(<?= $murid['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>)</small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($murid['nisn']) ?></td>
                                    <td>
                                        <?= isset($murid['nama_kelas']) ? esc($murid['nama_kelas']) : '<span class="text-muted">Tidak ada</span>' ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-info"><?= esc($murid['hubungan_keluarga']) ?></span>
                                    </td>
                                    <td>
                                        <?php if (isset($murid['is_primary'])): ?>
                                            <span class="badge badge-<?= $murid['is_primary'] ? 'success' : 'secondary' ?>">
                                                <?= $murid['is_primary'] ? 'Utama' : 'Tambahan' ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Orang tua ini belum terhubung dengan murid manapun.
                    <a href="/pengguna-orang-tua/edit/<?= $orang_tua['id'] ?>" class="alert-link">Edit untuk menambahkan koneksi</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
