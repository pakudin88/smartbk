<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h3>Tambah User Baru - TEST CSRF</h3>
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
        
        <!-- Debug info -->
        <div class="alert alert-info">
            <h6>Debug Info:</h6>
            <p>Form action: <?= base_url('test-csrf/users/store') ?></p>
            <p>Base URL: <?= base_url() ?></p>
            <p>Current URL: <?= current_url() ?></p>
        </div>
        
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

        <?php if (session()->has('success')): ?>
            <div class="alert alert-success">
                <?= session('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('test-csrf/users/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= old('username', 'testuser_' . time()) ?>" required>
                        <div class="form-text">Minimal 3 karakter, maksimal 50 karakter</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email', 'test_' . time() . '@example.com') ?>" required>
                        <div class="form-text">Alamat email yang valid</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="<?= old('full_name', 'Test User ' . time()) ?>" required>
                        <div class="form-text">Minimal 3 karakter</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" 
                               value="<?= old('password', 'password123') ?>" required>
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
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   value="1" <?= old('is_active', '1') ? 'checked' : '' ?>>
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
