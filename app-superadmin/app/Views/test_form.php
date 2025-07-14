<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h3>Test Form - Debug User Creation</h3>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Test Form Submit</h5>
    </div>
    <div class="card-body">
        <!-- Debug Info -->
        <?php if (session()->has('debug_info')): ?>
            <div class="alert alert-info">
                <h6>Debug Info:</h6>
                <pre><?= json_encode(session('debug_info'), JSON_PRETTY_PRINT) ?></pre>
            </div>
        <?php endif; ?>

        <?php if (session()->has('insert_result')): ?>
            <div class="alert alert-<?= session('insert_result') === 'Success' ? 'success' : 'danger' ?>">
                <strong>Insert Result:</strong> <?= session('insert_result') ?>
                <?php if (session()->has('insert_id')): ?>
                    <br><strong>Insert ID:</strong> <?= session('insert_id') ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('insert_error')): ?>
            <div class="alert alert-danger">
                <strong>Insert Error:</strong> <?= session('insert_error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('test-form/store') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="testuser_<?= time() ?>" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="test_<?= time() ?>@example.com" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="Test User <?= time() ?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               value="password123" required>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="role_id">Role</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="1">Super Admin</option>
                    <option value="2">Admin</option>
                    <option value="3" selected>Guru</option>
                    <option value="4">Siswa</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Test Submit
                </button>
                <a href="<?= base_url('users') ?>" class="btn btn-secondary">
                    Ke Users
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h5>Current Session Data</h5>
    </div>
    <div class="card-body">
        <pre><?= json_encode(session()->get(), JSON_PRETTY_PRINT) ?></pre>
    </div>
</div>
<?= $this->endSection() ?>
