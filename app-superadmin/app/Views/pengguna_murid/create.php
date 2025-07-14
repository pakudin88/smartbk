<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Pengguna Murid
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-plus"></i> Tambah Pengguna Murid
                            </h4>
                            <p class="card-text mb-0">Form untuk menambah data murid baru</p>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('pengguna-murid') ?>" class="btn btn-light">
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

                    <form action="<?= base_url('pengguna-murid/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('nisn') ? 'is-invalid' : '' ?>" 
                                           id="nisn" name="nisn" value="<?= old('nisn', $generated_nisn ?? '') ?>" required>
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
                                           id="nis" name="nis" value="<?= old('nis') ?>">
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
                                           id="username" name="username" value="<?= old('username') ?>" required>
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
                                           id="email" name="email" value="<?= old('email') ?>">
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
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                                           id="password" name="password" required>
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
                                           id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required>
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
                                        <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                    <?php if (isset($validation) && $validation->hasError('jenis_kelamin')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('jenis_kelamin') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Info: Kelas akan diatur dari Pengelolaan Kelas -->
                                <div class="mb-3">
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Informasi Kelas:</strong><br>
                                        Penempatan kelas untuk murid ini akan diatur melalui menu 
                                        <strong>Pengelolaan Kelas</strong>. Setelah murid dibuat, admin dapat menambahkan murid ke kelas yang sesuai.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('tempat_lahir') ? 'is-invalid' : '' ?>" 
                                           id="tempat_lahir" name="tempat_lahir" value="<?= old('tempat_lahir') ?>">
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
                                           id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir') ?>">
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
                                        <option value="Islam" <?= old('agama') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                        <option value="Kristen" <?= old('agama') == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                                        <option value="Katolik" <?= old('agama') == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                        <option value="Hindu" <?= old('agama') == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                        <option value="Buddha" <?= old('agama') == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                                        <option value="Konghucu" <?= old('agama') == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
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
                                           id="no_telepon" name="no_telepon" value="<?= old('no_telepon') ?>">
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
                                                <option value="<?= $ta['id'] ?>" <?= old('tahun_ajaran_id') == $ta['id'] ? 'selected' : '' ?>>
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
                                    <label for="profile_picture" class="form-label">Foto Profil</label>
                                    <input type="file" class="form-control <?= isset($validation) && $validation->hasError('profile_picture') ? 'is-invalid' : '' ?>" 
                                           id="profile_picture" name="profile_picture" accept="image/*">
                                    <div class="form-text">Upload file gambar (jpg, png, gif). Maksimal 2MB.</div>
                                    <?php if (isset($validation) && $validation->hasError('profile_picture')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('profile_picture') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control <?= isset($validation) && $validation->hasError('alamat') ? 'is-invalid' : '' ?>" 
                                      id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"><?= old('alamat') ?></textarea>
                            <?php if (isset($validation) && $validation->hasError('alamat')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('alamat') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('pengguna-murid') ?>" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
