<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Edit Mata Pelajaran</h1>
    <a href="<?= base_url('subjects') ?>" class="btn btn-secondary">
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
        <h5 class="card-title mb-0">Form Edit Mata Pelajaran</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('subjects/update/' . $subject['id']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_mapel" class="form-label">Nama Mata Pelajaran *</label>
                        <input type="text" class="form-control <?= $validation->hasError('nama_mapel') ? 'is-invalid' : '' ?>" 
                               id="nama_mapel" name="nama_mapel" value="<?= old('nama_mapel', $subject['nama_mapel']) ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_mapel') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kode_mapel" class="form-label">Kode Mata Pelajaran *</label>
                        <input type="text" class="form-control <?= $validation->hasError('kode_mapel') ? 'is-invalid' : '' ?>" 
                               id="kode_mapel" name="kode_mapel" value="<?= old('kode_mapel', $subject['kode_mapel']) ?>" maxlength="10" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('kode_mapel') ?>
                        </div>
                        <div class="form-text">Contoh: MTK, IPA, IPS, BIN, dll</div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori *</label>
                        <select class="form-select <?= $validation->hasError('kategori') ? 'is-invalid' : '' ?>" 
                                id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="wajib" <?= old('kategori', $subject['kategori']) == 'wajib' ? 'selected' : '' ?>>Wajib</option>
                            <option value="pilihan" <?= old('kategori', $subject['kategori']) == 'pilihan' ? 'selected' : '' ?>>Pilihan</option>
                            <option value="muatan_lokal" <?= old('kategori', $subject['kategori']) == 'muatan_lokal' ? 'selected' : '' ?>>Muatan Lokal</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('kategori') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tingkat" class="form-label">Tingkat *</label>
                        <select class="form-select <?= $validation->hasError('tingkat') ? 'is-invalid' : '' ?>" 
                                id="tingkat" name="tingkat" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="SD" <?= old('tingkat', $subject['tingkat']) == 'SD' ? 'selected' : '' ?>>SD</option>
                            <option value="SMP" <?= old('tingkat', $subject['tingkat']) == 'SMP' ? 'selected' : '' ?>>SMP</option>
                            <option value="SMA" <?= old('tingkat', $subject['tingkat']) == 'SMA' ? 'selected' : '' ?>>SMA</option>
                            <option value="SMK" <?= old('tingkat', $subject['tingkat']) == 'SMK' ? 'selected' : '' ?>>SMK</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('tingkat') ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jam_pelajaran" class="form-label">Jam Pelajaran *</label>
                        <input type="number" class="form-control <?= $validation->hasError('jam_pelajaran') ? 'is-invalid' : '' ?>" 
                               id="jam_pelajaran" name="jam_pelajaran" value="<?= old('jam_pelajaran', $subject['jam_pelajaran']) ?>" min="1" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('jam_pelajaran') ?>
                        </div>
                        <div class="form-text">Jumlah jam pelajaran per minggu</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select <?= $validation->hasError('status') ? 'is-invalid' : '' ?>" 
                                id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="aktif" <?= old('status', $subject['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status', $subject['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('status') ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control <?= $validation->hasError('deskripsi') ? 'is-invalid' : '' ?>" 
                          id="deskripsi" name="deskripsi" rows="3" 
                          placeholder="Deskripsi mata pelajaran (opsional)"><?= old('deskripsi', $subject['deskripsi']) ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('deskripsi') ?>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="<?= base_url('subjects') ?>" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
