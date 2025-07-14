<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Tambah Pengguna Orang Tua
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pengguna Orang Tua</h1>
        <div class="btn-group">
            <a href="/pengguna-orang-tua" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Orang Tua</h6>
        </div>
        <div class="card-body">
            <form action="/pengguna-orang-tua/store" method="post" id="formOrangTua">
                <?= csrf_field() ?>
                
                <div class="row">
                    <!-- Data Login -->
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Data Login</h6>
                        
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('username')) ? 'is-invalid' : '' ?>" 
                                   id="username" name="username" value="<?= old('username') ?>" required>
                            <?php if (isset($validation) && $validation->hasError('username')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('username') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                                   id="email" name="email" value="<?= old('email') ?>">
                            <?php if (isset($validation) && $validation->hasError('email')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('email') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : '' ?>" 
                                   id="password" name="password" required>
                            <?php if (isset($validation) && $validation->hasError('password')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Data Pribadi -->
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Data Pribadi</h6>
                        
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('nama_lengkap')) ? 'is-invalid' : '' ?>" 
                                   id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required>
                            <?php if (isset($validation) && $validation->hasError('nama_lengkap')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama_lengkap') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="hubungan_keluarga">Hubungan Keluarga <span class="text-danger">*</span></label>
                            <select class="form-control <?= (isset($validation) && $validation->hasError('hubungan_keluarga')) ? 'is-invalid' : '' ?>" 
                                    id="hubungan_keluarga" name="hubungan_keluarga" required>
                                <option value="">Pilih Hubungan</option>
                                <option value="Ayah" <?= old('hubungan_keluarga') == 'Ayah' ? 'selected' : '' ?>>Ayah</option>
                                <option value="Ibu" <?= old('hubungan_keluarga') == 'Ibu' ? 'selected' : '' ?>>Ibu</option>
                                <option value="Wali" <?= old('hubungan_keluarga') == 'Wali' ? 'selected' : '' ?>>Wali</option>
                            </select>
                            <?php if (isset($validation) && $validation->hasError('hubungan_keluarga')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('hubungan_keluarga') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="no_telepon">No. Telepon</label>
                            <input type="tel" class="form-control" id="no_telepon" name="no_telepon" value="<?= old('no_telepon') ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Data Tambahan -->
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Data Tambahan</h6>
                        
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?= old('pekerjaan') ?>">
                        </div>

                        <div class="form-group">
                            <label for="pendidikan">Pendidikan</label>
                            <select class="form-control" id="pendidikan" name="pendidikan">
                                <option value="">Pilih Pendidikan</option>
                                <option value="SD" <?= old('pendidikan') == 'SD' ? 'selected' : '' ?>>SD</option>
                                <option value="SMP" <?= old('pendidikan') == 'SMP' ? 'selected' : '' ?>>SMP</option>
                                <option value="SMA" <?= old('pendidikan') == 'SMA' ? 'selected' : '' ?>>SMA</option>
                                <option value="D3" <?= old('pendidikan') == 'D3' ? 'selected' : '' ?>>D3</option>
                                <option value="S1" <?= old('pendidikan') == 'S1' ? 'selected' : '' ?>>S1</option>
                                <option value="S2" <?= old('pendidikan') == 'S2' ? 'selected' : '' ?>>S2</option>
                                <option value="S3" <?= old('pendidikan') == 'S3' ? 'selected' : '' ?>>S3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="penghasilan">Penghasilan</label>
                            <input type="text" class="form-control" id="penghasilan" name="penghasilan" value="<?= old('penghasilan') ?>" placeholder="Contoh: 3000000">
                        </div>
                    </div>

                    <!-- Alamat dan Tahun Ajaran -->
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Alamat & Tahun Ajaran</h6>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= old('alamat') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="tahun_ajaran_id">Tahun Ajaran</label>
                            <select class="form-control" id="tahun_ajaran_id" name="tahun_ajaran_id">
                                <option value="">Pilih Tahun Ajaran</option>
                                <?php if (!empty($tahun_ajaran)): ?>
                                    <?php foreach ($tahun_ajaran as $ta): ?>
                                        <option value="<?= $ta['id'] ?>" <?= old('tahun_ajaran_id') == $ta['id'] ? 'selected' : '' ?>>
                                            <?= esc($ta['nama_tahun_ajaran']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Pilih Murid -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-primary mb-3">Pilih Murid yang akan dihubungkan</h6>
                        <div class="form-group">
                            <div class="form-check-container" style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                <?php if (!empty($murid) && is_array($murid)): ?>
                                    <?php foreach ($murid as $m): ?>
                                        <?php if (is_array($m) && isset($m['id'], $m['nama_lengkap'], $m['nisn'])): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="murid_ids[]" value="<?= $m['id'] ?>" id="murid_<?= $m['id'] ?>">
                                                <label class="form-check-label" for="murid_<?= $m['id'] ?>">
                                                    <?= esc($m['nama_lengkap']) ?> (<?= esc($m['nisn']) ?>)
                                                    <?php if (isset($m['nama_kelas']) && $m['nama_kelas']): ?>
                                                        - <?= esc($m['nama_kelas']) ?>
                                                    <?php endif; ?>
                                                </label>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">Tidak ada murid yang tersedia</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="/pengguna-orang-tua" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Form validation
    $('#formOrangTua').on('submit', function(e) {
        const username = $('#username').val().trim();
        const password = $('#password').val().trim();
        const namaLengkap = $('#nama_lengkap').val().trim();
        const hubunganKeluarga = $('#hubungan_keluarga').val();

        if (!username || !password || !namaLengkap || !hubunganKeluarga) {
            e.preventDefault();
            alert('Mohon lengkapi data yang wajib diisi (*)');
            return false;
        }

        if (password.length < 6) {
            e.preventDefault();
            alert('Password minimal 6 karakter');
            return false;
        }
    });

    // Format penghasilan with number separators
    $('#penghasilan').on('input', function() {
        let value = this.value.replace(/[^0-9]/g, '');
        if (value) {
            this.value = parseInt(value).toLocaleString('id-ID');
        }
    });
});
</script>
<?= $this->endSection() ?>
