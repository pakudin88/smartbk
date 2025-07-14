<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h3>Simple - Tambah User Baru</h3>
    <div class="alert alert-warning">
        <strong>Simple Mode:</strong> Minimal validation, langsung insert ke database
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Form Tambah User (Simple Mode)</h5>
    </div>
    <div class="card-body">
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('simple/users/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="simple_<?= time() ?>">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="simple_<?= time() ?>@test.com">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="full_name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="Simple User <?= time() ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               value="password123">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="role_id" class="form-label">Role</label>
                        <select class="form-control" id="role_id" name="role_id">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>" <?= $role['id'] == 3 ? 'selected' : '' ?>>
                                    <?= $role['role_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan User (Simple)
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
        <h5 class="card-title">Simple Mode Info</h5>
    </div>
    <div class="card-body">
        <p><strong>Form Action:</strong> <?= base_url('simple/users/store') ?></p>
        <p><strong>Success Redirect:</strong> <?= base_url('users') ?></p>
        <p><strong>Method:</strong> Direct header redirect</p>
        <p><strong>Validation:</strong> Minimal (akan otomatis generate data jika kosong)</p>
    </div>
</div>
<?= $this->endSection() ?>
