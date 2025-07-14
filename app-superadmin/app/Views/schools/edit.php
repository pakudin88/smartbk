<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Edit Sekolah</h1>
    <a href="<?= base_url('schools') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Form Edit Sekolah</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('schools/update/' . $school['id']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_sekolah" class="form-label">Nama Sekolah *</label>
                        <input type="text" class="form-control <?= $validation->hasError('nama_sekolah') ? 'is-invalid' : '' ?>" 
                               id="nama_sekolah" name="nama_sekolah" value="<?= old('nama_sekolah', $school['nama_sekolah']) ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_sekolah') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="npsn" class="form-label">NPSN *</label>
                        <input type="text" class="form-control <?= $validation->hasError('npsn') ? 'is-invalid' : '' ?>" 
                               id="npsn" name="npsn" value="<?= old('npsn', $school['npsn']) ?>" maxlength="8" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('npsn') ?>
                        </div>
                        <div class="form-text">Nomor Pokok Sekolah Nasional (8 digit)</div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat *</label>
                <textarea class="form-control <?= $validation->hasError('alamat') ? 'is-invalid' : '' ?>" 
                          id="alamat" name="alamat" rows="3" required><?= old('alamat', $school['alamat']) ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('alamat') ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon *</label>
                        <input type="text" class="form-control <?= $validation->hasError('telepon') ? 'is-invalid' : '' ?>" 
                               id="telepon" name="telepon" value="<?= old('telepon', $school['telepon']) ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('telepon') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                               id="email" name="email" value="<?= old('email', $school['email']) ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('email') ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kepala_sekolah" class="form-label">Kepala Sekolah *</label>
                        <input type="text" class="form-control <?= $validation->hasError('kepala_sekolah') ? 'is-invalid' : '' ?>" 
                               id="kepala_sekolah" name="kepala_sekolah" value="<?= old('kepala_sekolah', $school['kepala_sekolah']) ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('kepala_sekolah') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select <?= $validation->hasError('status') ? 'is-invalid' : '' ?>" 
                                id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="aktif" <?= old('status', $school['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status', $school['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('status') ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="<?= base_url('schools') ?>" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
