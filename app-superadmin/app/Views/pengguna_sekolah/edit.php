<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Pengguna Sekolah
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
                                <i class="fas fa-user-edit"></i> Edit Pengguna Sekolah
                            </h4>
                            <p class="card-text mb-0">Edit data petugas: <?= esc($petugas['nama_lengkap']) ?></p>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('pengguna-sekolah') ?>" class="btn btn-dark">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($validation) && $validation->getErrors()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($validation->getErrors() as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('pengguna-sekolah/update/' . $petugas['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                                           id="username" name="username" value="<?= old('username', $petugas['username']) ?>" required>
                                    <?php if (isset($validation) && $validation->hasError('username')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                                           id="email" name="email" value="<?= old('email', $petugas['email']) ?>" required>
                                    <?php if (isset($validation) && $validation->hasError('email')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <small class="text-muted">(kosongkan jika tidak ingin mengubah)</small></label>
                                    <input type="password" class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                                           id="password" name="password">
                                    <?php if (isset($validation) && $validation->hasError('password')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('nama_lengkap') ? 'is-invalid' : '' ?>" 
                                           id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap', $petugas['nama_lengkap']) ?>" required>
                                    <?php if (isset($validation) && $validation->hasError('nama_lengkap')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('nama_lengkap') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-select <?= isset($validation) && $validation->hasError('role_id') ? 'is-invalid' : '' ?>" 
                                            id="role_id" name="role_id" required>
                                        <option value="">Pilih Role</option>
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?= $role['id'] ?>" <?= old('role_id', $petugas['role_id']) == $role['id'] ? 'selected' : '' ?>>
                                                <?= esc($role['role_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($validation) && $validation->hasError('role_id')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('role_id') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip" value="<?= old('nip', $petugas['nip']) ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= old('jabatan', $petugas['jabatan']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="departemen" class="form-label">Departemen</label>
                                    <input type="text" class="form-control" id="departemen" name="departemen" value="<?= old('departemen', $petugas['departemen']) ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_telepon" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?= old('no_telepon', $petugas['no_telepon']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" <?= old('jenis_kelamin', $petugas['jenis_kelamin']) == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="P" <?= old('jenis_kelamin', $petugas['jenis_kelamin']) == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <select class="form-select" id="is_active" name="is_active">
                                        <option value="1" <?= old('is_active', $petugas['is_active']) == '1' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="0" <?= old('is_active', $petugas['is_active']) == '0' ? 'selected' : '' ?>>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir', $petugas['tanggal_lahir']) ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= old('alamat', $petugas['alamat']) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('pengguna-sekolah') ?>" class="btn btn-secondary">
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
