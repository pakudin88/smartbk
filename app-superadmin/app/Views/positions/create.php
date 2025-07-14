<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Tambah Jabatan</h1>
    <a href="<?= base_url('positions') ?>" class="btn btn-secondary">
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
        <h5 class="card-title mb-0">Form Tambah Jabatan</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('positions/store') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('nama_jabatan')) ? 'is-invalid' : '' ?>" 
                               id="nama_jabatan" name="nama_jabatan" 
                               value="<?= old('nama_jabatan') ?>" 
                               placeholder="Contoh: Guru IPA, Kepala Sekolah">
                        <?php if (isset($validation) && $validation->hasError('nama_jabatan')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_jabatan') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kode_jabatan" class="form-label">Kode Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('kode_jabatan')) ? 'is-invalid' : '' ?>" 
                               id="kode_jabatan" name="kode_jabatan" 
                               value="<?= old('kode_jabatan') ?>" 
                               placeholder="Contoh: GIPA, KASEK">
                        <?php if (isset($validation) && $validation->hasError('kode_jabatan')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kode_jabatan') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select <?= (isset($validation) && $validation->hasError('kategori')) ? 'is-invalid' : '' ?>" 
                                id="kategori" name="kategori">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="guru_mapel" <?= (old('kategori') == 'guru_mapel') ? 'selected' : '' ?>>Guru Mata Pelajaran</option>
                            <option value="kepala_sekolah" <?= (old('kategori') == 'kepala_sekolah') ? 'selected' : '' ?>>Kepala Sekolah</option>
                            <option value="wakil_kepala_sekolah" <?= (old('kategori') == 'wakil_kepala_sekolah') ? 'selected' : '' ?>>Wakil Kepala Sekolah</option>
                            <option value="guru_bk" <?= (old('kategori') == 'guru_bk') ? 'selected' : '' ?>>Guru BK</option>
                            <option value="admin" <?= (old('kategori') == 'admin') ? 'selected' : '' ?>>Admin</option>
                            <option value="staff" <?= (old('kategori') == 'staff') ? 'selected' : '' ?>>Staff</option>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('kategori')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kategori') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="departemen" class="form-label">Departemen <span class="text-danger">*</span></label>
                        <select class="form-select <?= (isset($validation) && $validation->hasError('departemen')) ? 'is-invalid' : '' ?>" 
                                id="departemen" name="departemen">
                            <option value="">-- Pilih Departemen --</option>
                            <option value="akademik" <?= (old('departemen') == 'akademik') ? 'selected' : '' ?>>Akademik</option>
                            <option value="administrasi" <?= (old('departemen') == 'administrasi') ? 'selected' : '' ?>>Administrasi</option>
                            <option value="bimbingan_konseling" <?= (old('departemen') == 'bimbingan_konseling') ? 'selected' : '' ?>>Bimbingan Konseling</option>
                            <option value="kepala_sekolah" <?= (old('departemen') == 'kepala_sekolah') ? 'selected' : '' ?>>Kepala Sekolah</option>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('departemen')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('departemen') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="level" class="form-label">Level <span class="text-danger">*</span></label>
                        <select class="form-select <?= (isset($validation) && $validation->hasError('level')) ? 'is-invalid' : '' ?>" 
                                id="level" name="level">
                            <option value="">-- Pilih Level --</option>
                            <option value="pimpinan" <?= (old('level') == 'pimpinan') ? 'selected' : '' ?>>Pimpinan</option>
                            <option value="koordinator" <?= (old('level') == 'koordinator') ? 'selected' : '' ?>>Koordinator</option>
                            <option value="pelaksana" <?= (old('level') == 'pelaksana') ? 'selected' : '' ?>>Pelaksana</option>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('level')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('level') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select <?= (isset($validation) && $validation->hasError('status')) ? 'is-invalid' : '' ?>" 
                                id="status" name="status">
                            <option value="">-- Pilih Status --</option>
                            <option value="aktif" <?= (old('status') == 'aktif' || old('status') == '') ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= (old('status') == 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('status')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('status') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control <?= (isset($validation) && $validation->hasError('deskripsi')) ? 'is-invalid' : '' ?>" 
                          id="deskripsi" name="deskripsi" rows="3"
                          placeholder="Deskripsi tugas dan tanggung jawab jabatan..."><?= old('deskripsi') ?></textarea>
                <?php if (isset($validation) && $validation->hasError('deskripsi')): ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('deskripsi') ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (isset($active_tahun_ajaran) && $active_tahun_ajaran): ?>
                <input type="hidden" name="tahun_ajaran_id" value="<?= $active_tahun_ajaran['id'] ?>">
                <div class="mb-3">
                    <label class="form-label">Tahun Ajaran</label>
                    <div class="form-control-plaintext">
                        <span class="badge bg-success"><?= esc($active_tahun_ajaran['nama_tahun_ajaran']) ?></span>
                        <small class="text-muted ms-2">(Tahun ajaran aktif)</small>
                    </div>
                </div>
            <?php endif; ?>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
                <a href="<?= base_url('positions') ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Auto generate kode jabatan based on nama jabatan
document.getElementById('nama_jabatan').addEventListener('input', function() {
    const namaJabatan = this.value;
    const kodeJabatan = document.getElementById('kode_jabatan');
    
    // Generate kode from first letters of each word
    if (namaJabatan && !kodeJabatan.value) {
        const words = namaJabatan.split(' ');
        let kode = '';
        
        words.forEach(word => {
            if (word.length > 0) {
                kode += word.charAt(0).toUpperCase();
            }
        });
        
        // Limit to max 10 characters
        kodeJabatan.value = kode.substring(0, 10);
    }
});
</script>

<?= $this->endSection() ?>
