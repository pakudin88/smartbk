<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Pengaturan Sistem</h1>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Profil Pengguna</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Kelola profil dan informasi akun Anda</p>
                <a href="<?= base_url('settings/profile') ?>" class="btn btn-primary">
                    <i class="fas fa-user me-2"></i>Kelola Profil
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Keamanan</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Ubah password dan pengaturan keamanan</p>
                <a href="<?= base_url('settings/change-password') ?>" class="btn btn-warning">
                    <i class="fas fa-lock me-2"></i>Ubah Password
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Sistem</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Informasi sistem dan pengaturan aplikasi</p>
                <a href="<?= base_url('settings/system') ?>" class="btn btn-info">
                    <i class="fas fa-cogs me-2"></i>Info Sistem
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Backup & Restore</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Backup dan restore data sistem</p>
                <a href="<?= base_url('settings/backup') ?>" class="btn btn-success">
                    <i class="fas fa-database me-2"></i>Kelola Backup
                </a>
            </div>
        </div>
    </div>
</div>

<!-- User Information -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Informasi Pengguna</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td><?= esc($user['full_name'] ?? $user['name'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><?= esc($user['email'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Username:</strong></td>
                        <td><?= esc($user['username'] ?? 'N/A') ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Role:</strong></td>
                        <td><span class="badge bg-primary"><?= esc($user['role_name'] ?? 'Super Admin') ?></span></td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <?php if ($user['is_active'] ?? true): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Login Terakhir:</strong></td>
                        <td><?= ($user['last_login'] ?? false) ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Belum pernah login' ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
