<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Tambah Tahun Ajaran</h1>
    <a href="<?= base_url('school-years') ?>" class="btn btn-secondary">
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
        <h5 class="card-title mb-0">Form Tambah Tahun Ajaran</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('school-years/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_tahun_ajaran" class="form-label">Nama Tahun Ajaran *</label>
                        <input type="text" class="form-control <?= $validation->hasError('nama_tahun_ajaran') ? 'is-invalid' : '' ?>" 
                               id="nama_tahun_ajaran" name="nama_tahun_ajaran" value="<?= old('nama_tahun_ajaran') ?>" 
                               placeholder="Contoh: 2024/2025" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_tahun_ajaran') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="semester" class="form-label">Semester *</label>
                        <select class="form-select <?= $validation->hasError('semester') ? 'is-invalid' : '' ?>" 
                                id="semester" name="semester" required>
                            <option value="">Pilih Semester</option>
                            <option value="Ganjil" <?= old('semester') == 'Ganjil' ? 'selected' : '' ?>>Semester Ganjil</option>
                            <option value="Genap" <?= old('semester') == 'Genap' ? 'selected' : '' ?>>Semester Genap</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('semester') ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tahun_mulai" class="form-label">Tahun Mulai *</label>
                        <input type="number" class="form-control <?= $validation->hasError('tahun_mulai') ? 'is-invalid' : '' ?>" 
                               id="tahun_mulai" name="tahun_mulai" value="<?= old('tahun_mulai', date('Y')) ?>" 
                               min="2020" max="2030" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('tahun_mulai') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tahun_selesai" class="form-label">Tahun Selesai *</label>
                        <input type="number" class="form-control <?= $validation->hasError('tahun_selesai') ? 'is-invalid' : '' ?>" 
                               id="tahun_selesai" name="tahun_selesai" value="<?= old('tahun_selesai', date('Y') + 1) ?>" 
                               min="2020" max="2030" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('tahun_selesai') ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai *</label>
                        <input type="date" class="form-control <?= $validation->hasError('start_date') ? 'is-invalid' : '' ?>" 
                               id="start_date" name="start_date" value="<?= old('start_date') ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('start_date') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai *</label>
                        <input type="date" class="form-control <?= $validation->hasError('end_date') ? 'is-invalid' : '' ?>" 
                               id="end_date" name="end_date" value="<?= old('end_date') ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('end_date') ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="is_active" class="form-label">Status *</label>
                <select class="form-select <?= $validation->hasError('is_active') ? 'is-invalid' : '' ?>" 
                        id="is_active" name="is_active" required>
                    <option value="">Pilih Status</option>
                    <option value="1" <?= old('is_active') == '1' ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= old('is_active') == '0' ? 'selected' : '' ?>>Nonaktif</option>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('is_active') ?>
                </div>
                <div class="form-text">Hanya satu tahun ajaran yang bisa aktif dalam satu waktu</div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="<?= base_url('school-years') ?>" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tahunMulai = document.getElementById('tahun_mulai');
    const tahunSelesai = document.getElementById('tahun_selesai');
    const namaTA = document.getElementById('nama_tahun_ajaran');
    
    function updateNamaTA() {
        if (tahunMulai.value && tahunSelesai.value) {
            namaTA.value = tahunMulai.value + '/' + tahunSelesai.value;
        }
    }
    
    tahunMulai.addEventListener('change', function() {
        tahunSelesai.value = parseInt(this.value) + 1;
        updateNamaTA();
    });
    
    tahunSelesai.addEventListener('change', updateNamaTA);
});
</script>

<?= $this->endSection() ?>
