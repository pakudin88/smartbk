<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Pengguna Murid
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-edit"></i> Edit Pengguna Murid
                            </h4>
                            <p class="card-text mb-0">Form untuk mengedit data murid: <?= esc($murid['nama_lengkap']) ?></p>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('pengguna-murid') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('pengguna-murid/update/' . $murid['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('nisn') ? 'is-invalid' : '' ?>" 
                                           id="nisn" name="nisn" value="<?= old('nisn', $murid['nisn']) ?>" required>
                                    <?php if (isset($validation) && $validation->hasError('nisn')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nisn') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nis" class="form-label">NIS</label>
                                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('nis') ? 'is-invalid' : '' ?>" 
                                           id="nis" name="nis" value="<?= old('nis', $murid['nis']) ?>">
                                    <?php if (isset($validation) && $validation->hasError('nis')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nis') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                                           id="username" name="username" value="<?= old('username', $murid['username']) ?>" required>
                                    <?php if (isset($validation) && $validation->hasError('username')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('username') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                                           id="email" name="email" value="<?= old('email', $murid['email']) ?>">
                                    <?php if (isset($validation) && $validation->hasError('email')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('email') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                                    <input type="password" class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                                           id="password" name="password">
                                    <?php if (isset($validation) && $validation->hasError('password')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('password') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('nama_lengkap') ? 'is-invalid' : '' ?>" 
                                           id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap', $murid['nama_lengkap']) ?>" required>
                                    <?php if (isset($validation) && $validation->hasError('nama_lengkap')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama_lengkap') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-select <?= isset($validation) && $validation->hasError('jenis_kelamin') ? 'is-invalid' : '' ?>" 
                                            id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" <?= old('jenis_kelamin', $murid['jenis_kelamin']) == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="P" <?= old('jenis_kelamin', $murid['jenis_kelamin']) == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                    <?php if (isset($validation) && $validation->hasError('jenis_kelamin')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('jenis_kelamin') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Info: Kelas saat ini (read-only) -->
                                <div class="mb-3">
                                    <label class="form-label">Kelas Saat Ini</label>
                                    <div class="form-control bg-light" style="min-height: 38px; display: flex; align-items: center;">
                                        <?php if (isset($murid['nama_kelas']) && $murid['nama_kelas']): ?>
                                            <span class="badge bg-primary me-2"><?= esc($murid['nama_kelas']) ?></span>
                                            <small class="text-muted">Tingkat <?= esc($murid['tingkat'] ?? '-') ?></small>
                                        <?php else: ?>
                                            <span class="text-muted"><i class="fas fa-info-circle me-1"></i>Belum ditempatkan di kelas</span>
                                        <?php endif; ?>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Untuk mengubah kelas, gunakan menu <strong>Pengelolaan Kelas</strong>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('tempat_lahir') ? 'is-invalid' : '' ?>" 
                                           id="tempat_lahir" name="tempat_lahir" value="<?= old('tempat_lahir', $murid['tempat_lahir']) ?>">
                                    <?php if (isset($validation) && $validation->hasError('tempat_lahir')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('tempat_lahir') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control <?= isset($validation) && $validation->hasError('tanggal_lahir') ? 'is-invalid' : '' ?>" 
                                           id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir', $murid['tanggal_lahir']) ?>">
                                    <?php if (isset($validation) && $validation->hasError('tanggal_lahir')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('tanggal_lahir') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="agama" class="form-label">Agama</label>
                                    <select class="form-select <?= isset($validation) && $validation->hasError('agama') ? 'is-invalid' : '' ?>" 
                                            id="agama" name="agama">
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" <?= old('agama', $murid['agama']) == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                        <option value="Kristen" <?= old('agama', $murid['agama']) == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                                        <option value="Katolik" <?= old('agama', $murid['agama']) == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                        <option value="Hindu" <?= old('agama', $murid['agama']) == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                        <option value="Buddha" <?= old('agama', $murid['agama']) == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                                        <option value="Konghucu" <?= old('agama', $murid['agama']) == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                                    </select>
                                    <?php if (isset($validation) && $validation->hasError('agama')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('agama') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_telepon" class="form-label">No. Telepon</label>
                                    <input type="tel" class="form-control <?= isset($validation) && $validation->hasError('no_telepon') ? 'is-invalid' : '' ?>" 
                                           id="no_telepon" name="no_telepon" value="<?= old('no_telepon', $murid['no_telepon']) ?>">
                                    <?php if (isset($validation) && $validation->hasError('no_telepon')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('no_telepon') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                                    <select class="form-select <?= isset($validation) && $validation->hasError('tahun_ajaran_id') ? 'is-invalid' : '' ?>" 
                                            id="tahun_ajaran_id" name="tahun_ajaran_id">
                                        <option value="">Pilih Tahun Ajaran</option>
                                        <?php if (isset($tahun_ajaran) && !empty($tahun_ajaran)): ?>
                                            <?php foreach ($tahun_ajaran as $ta): ?>
                                                <option value="<?= $ta['id'] ?>" <?= old('tahun_ajaran_id', $murid['tahun_ajaran_id']) == $ta['id'] ? 'selected' : '' ?>>
                                                    <?= esc($ta['nama_tahun_ajaran']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if (isset($validation) && $validation->hasError('tahun_ajaran_id')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('tahun_ajaran_id') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <select class="form-select <?= isset($validation) && $validation->hasError('is_active') ? 'is-invalid' : '' ?>" 
                                            id="is_active" name="is_active">
                                        <option value="1" <?= old('is_active', $murid['is_active']) == '1' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="0" <?= old('is_active', $murid['is_active']) == '0' ? 'selected' : '' ?>>Nonaktif</option>
                                    </select>
                                    <?php if (isset($validation) && $validation->hasError('is_active')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('is_active') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Foto Profil</label>
                                    <input type="file" class="form-control <?= isset($validation) && $validation->hasError('profile_picture') ? 'is-invalid' : '' ?>" 
                                           id="profile_picture" name="profile_picture" accept="image/*">
                                    <div class="form-text">Upload file gambar (jpg, png, gif). Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</div>
                                    <?php if (isset($validation) && $validation->hasError('profile_picture')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('profile_picture') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($murid['profile_picture'])): ?>
                                    <div class="mb-3">
                                        <label class="form-label">Foto Saat Ini:</label>
                                        <div>
                                            <img src="<?= base_url('uploads/profiles/' . $murid['profile_picture']) ?>" 
                                                 alt="Current Profile Picture" class="img-thumbnail" style="max-width: 100px;">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control <?= isset($validation) && $validation->hasError('alamat') ? 'is-invalid' : '' ?>" 
                                              id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat lengkap"><?= old('alamat', $murid['alamat']) ?></textarea>
                                    <?php if (isset($validation) && $validation->hasError('alamat')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('alamat') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('pengguna-murid') ?>" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
