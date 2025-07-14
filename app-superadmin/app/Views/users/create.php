<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h3>Tambah User Baru</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('/users') ?>">Manajemen User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Form Tambah User</h5>
    </div>
    <div class="card-body">
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('users/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= old('username') ?>" required>
                        <div class="form-text">Minimal 3 karakter, maksimal 50 karakter</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email') ?>" required>
                        <div class="form-text">Alamat email yang valid</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="<?= old('full_name') ?>" required>
                        <div class="form-text">Minimal 3 karakter</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" 
                               value="<?= old('password') ?>" required>
                        <div class="form-text">Minimal 6 karakter</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            <option value="">Pilih Role</option>
                            <option value="1" <?= old('role_id') == '1' ? 'selected' : '' ?>>Super Admin</option>
                            <option value="2" <?= old('role_id') == '2' ? 'selected' : '' ?>>Guru Mapel</option>
                            <option value="3" <?= old('role_id') == '3' ? 'selected' : '' ?>>Wali Kelas</option>
                            <option value="4" <?= old('role_id') == '4' ? 'selected' : '' ?>>Siswa</option>
                            <option value="5" <?= old('role_id') == '5' ? 'selected' : '' ?>>Orangtua</option>
                            <option value="6" <?= old('role_id') == '6' ? 'selected' : '' ?>>Staff Administrasi</option>
                            <option value="7" <?= old('role_id') == '7' ? 'selected' : '' ?>>Kepala Sekolah</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        <select class="form-control" id="kelas_id" name="kelas_id">
                            <option value="">Pilih Kelas (Khusus Siswa)</option>
                            <!-- Options will be loaded dynamically -->
                        </select>
                        <small class="text-muted">Hanya perlu diisi jika role adalah Siswa</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   value="1" <?= old('is_active') ? 'checked' : 'checked' ?>>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan User
                </button>
                <a href="<?= base_url('/users') ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role_id');
    const kelasSelect = document.getElementById('kelas_id');
    const kelasGroup = kelasSelect.closest('.form-group');
    
    // Initially hide class selection
    toggleKelasField();
    
    // Toggle class field when role changes
    roleSelect.addEventListener('change', function() {
        toggleKelasField();
        loadClasses();
    });
    
    function toggleKelasField() {
        const selectedRole = roleSelect.options[roleSelect.selectedIndex].text;
        if (selectedRole === 'Siswa') {
            kelasGroup.style.display = 'block';
            loadClasses();
        } else {
            kelasGroup.style.display = 'none';
            kelasSelect.innerHTML = '<option value="">Pilih Kelas (Khusus Siswa)</option>';
        }
    }
    
    function loadClasses() {
        const selectedRole = roleSelect.options[roleSelect.selectedIndex].text;
        if (selectedRole !== 'Siswa') return;
        
        fetch('<?= base_url('api/classes-with-capacity') ?>')
            .then(response => response.json())
            .then(data => {
                kelasSelect.innerHTML = '<option value="">Pilih Kelas</option>';
                
                if (data.success && data.classes.length > 0) {
                    data.classes.forEach(kelas => {
                        const option = document.createElement('option');
                        option.value = kelas.id;
                        option.textContent = `${kelas.nama_kelas} - ${kelas.nama_sekolah} (${kelas.terisi}/${kelas.kapasitas})`;
                        if (kelas.tersisa <= 0) {
                            option.disabled = true;
                            option.textContent += ' - PENUH';
                        }
                        kelasSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Tidak ada kelas tersedia';
                    option.disabled = true;
                    kelasSelect.appendChild(option);
                }
            })
            .catch(error => {
                console.error('Error loading classes:', error);
            });
    }
});
</script>
<?= $this->endSection() ?>
