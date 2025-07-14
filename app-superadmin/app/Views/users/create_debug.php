<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h3>Debug - Tambah User Baru</h3>
    <div class="alert alert-info">
        <strong>Debug Mode:</strong> Semua aktivitas akan dicatat di log file
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Form Tambah User (Debug Mode)</h5>
    </div>
    <div class="card-body">
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <h6>Validation Errors:</h6>
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <h6>Error:</h6>
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('success')): ?>
            <div class="alert alert-success">
                <h6>Success:</h6>
                <?= session('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('debug/users/store') ?>" method="post" id="userForm">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= old('username', 'debuguser_' . time()) ?>" required>
                        <div class="form-text">Minimal 3 karakter, maksimal 50 karakter</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email', 'debug' . time() . '@example.com') ?>" required>
                        <div class="form-text">Alamat email yang valid</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="<?= old('full_name', 'Debug User ' . time()) ?>" required>
                        <div class="form-text">Minimal 3 karakter</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" 
                               value="password123" required>
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
                            <?php if (isset($roles) && !empty($roles)): ?>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>" <?= old('role_id', 3) == $role['id'] ? 'selected' : '' ?>>
                                        <?= $role['role_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="1">Super Admin</option>
                                <option value="2">Admin</option>
                                <option value="3" selected>Guru</option>
                                <option value="4">Siswa</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   value="1" <?= old('is_active', 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan User (Debug)
                </button>
                <a href="<?= base_url('users') ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h5 class="card-title">Debug Information</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Form Details:</h6>
                <p><strong>Form Action:</strong> <?= base_url('debug/users/store') ?></p>
                <p><strong>Form Method:</strong> POST</p>
                <p><strong>CSRF Token:</strong> <?= csrf_hash() ?></p>
                <p><strong>Success Redirect:</strong> <?= base_url('users') ?></p>
            </div>
            <div class="col-md-6">
                <h6>Environment:</h6>
                <p><strong>Base URL:</strong> <?= base_url() ?></p>
                <p><strong>Current URL:</strong> <?= current_url() ?></p>
                <p><strong>Environment:</strong> <?= ENVIRONMENT ?></p>
                <p><strong>Session ID:</strong> <?= session_id() ?></p>
            </div>
        </div>
        
        <div class="mt-3">
            <h6>Expected Flow:</h6>
            <ol>
                <li>Form submit ke: <code><?= base_url('debug/users/store') ?></code></li>
                <li>Validasi data form</li>
                <li>Insert ke database</li>
                <li>Redirect ke: <code><?= base_url('users') ?></code></li>
            </ol>
        </div>
    </div>
</div>

<script>
document.getElementById('userForm').addEventListener('submit', function(e) {
    console.log('Form submitted');
    console.log('Action:', this.action);
    console.log('Method:', this.method);
    
    // Log form data
    const formData = new FormData(this);
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
});
</script>
<?= $this->endSection() ?>
