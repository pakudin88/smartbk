<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Tambah Kelas</h1>
    <a href="<?= base_url('classes') ?>" class="btn btn-secondary">
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
        <h5 class="card-title mb-0">Form Tambah Kelas</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('classes/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Nama Kelas *</label>
                        <input type="text" class="form-control <?= $validation->hasError('nama_kelas') ? 'is-invalid' : '' ?>" 
                               id="nama_kelas" name="nama_kelas" value="<?= old('nama_kelas') ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_kelas') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sekolah_id" class="form-label">Sekolah *</label>
                        <select class="form-select <?= $validation->hasError('sekolah_id') ? 'is-invalid' : '' ?>" 
                                id="sekolah_id" name="sekolah_id" required>
                            <option value="">Pilih Sekolah</option>
                            <?php foreach ($schools as $school): ?>
                                <option value="<?= $school['id'] ?>" <?= old('sekolah_id') == $school['id'] ? 'selected' : '' ?>>
                                    <?= esc($school['nama_sekolah']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('sekolah_id') ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tingkat" class="form-label">Tingkat *</label>
                        <select class="form-select <?= $validation->hasError('tingkat') ? 'is-invalid' : '' ?>" 
                                id="tingkat" name="tingkat" required>
                            <option value="">Pilih Tingkat</option>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i ?>" <?= old('tingkat') == $i ? 'selected' : '' ?>>
                                    Kelas <?= $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('tingkat') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control <?= $validation->hasError('jurusan') ? 'is-invalid' : '' ?>" 
                               id="jurusan" name="jurusan" value="<?= old('jurusan') ?>" 
                               placeholder="Contoh: IPA, IPS, Bahasa, dll">
                        <div class="invalid-feedback">
                            <?= $validation->getError('jurusan') ?>
                        </div>
                        <div class="form-text">Kosongkan jika tidak ada jurusan</div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kapasitas" class="form-label">Kapasitas *</label>
                        <input type="number" class="form-control <?= $validation->hasError('kapasitas') ? 'is-invalid' : '' ?>" 
                               id="kapasitas" name="kapasitas" value="<?= old('kapasitas') ?>" min="1" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('kapasitas') ?>
                        </div>
                        <div class="form-text">Jumlah maksimal siswa dalam kelas</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select <?= $validation->hasError('status') ? 'is-invalid' : '' ?>" 
                                id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('status') ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="<?= base_url('classes') ?>" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
