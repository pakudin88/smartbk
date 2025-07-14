<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('users') ?>">Manajemen User</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail User</li>
    </ol>
</nav>

<!-- User Detail Card -->
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-circle me-2"></i>Detail Pengguna
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Username:</strong>
                    </div>
                    <div class="col-md-9">
                        <span class="badge bg-light text-dark border">
                            <i class="fas fa-user me-1"></i><?= esc($userData['username']) ?>
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-md-9">
                        <i class="fas fa-envelope me-1 text-muted"></i><?= esc($userData['email']) ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Nama Lengkap:</strong>
                    </div>
                    <div class="col-md-9">
                        <i class="fas fa-user me-1 text-muted"></i><?= esc($userData['full_name']) ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Role:</strong>
                    </div>
                    <div class="col-md-9">
                        <?php
                        $roleColors = [
                            'Super Admin' => 'bg-danger',
                            'Admin' => 'bg-primary',
                            'Guru' => 'bg-success',
                            'Siswa' => 'bg-info',
                            'Wali' => 'bg-warning'
                        ];
                        $roleColor = $roleColors[$userData['role_name'] ?? ''] ?? 'bg-secondary';
                        ?>
                        <span class="badge <?= $roleColor ?> px-3 py-2">
                            <i class="fas fa-user-tag me-1"></i><?= esc($userData['role_name'] ?? 'No Role') ?>
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-md-9">
                        <span class="badge <?= ($userData['is_active'] ?? 0) ? 'bg-success' : 'bg-secondary' ?> px-3 py-2">
                            <i class="fas <?= ($userData['is_active'] ?? 0) ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                            <?= ($userData['is_active'] ?? 0) ? 'Aktif' : 'Nonaktif' ?>
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Tanggal Dibuat:</strong>
                    </div>
                    <div class="col-md-9">
                        <i class="fas fa-calendar me-1 text-muted"></i><?= date('d/m/Y H:i:s', strtotime($userData['created_at'])) ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Terakhir Diupdate:</strong>
                    </div>
                    <div class="col-md-9">
                        <i class="fas fa-calendar-alt me-1 text-muted"></i><?= date('d/m/Y H:i:s', strtotime($userData['updated_at'])) ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Terakhir Login:</strong>
                    </div>
                    <div class="col-md-9">
                        <i class="fas fa-clock me-1 text-muted"></i>
                        <?= $userData['last_login'] ? date('d/m/Y H:i:s', strtotime($userData['last_login'])) : 'Belum pernah login' ?>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('users') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <div class="btn-group">
                        <a href="<?= base_url('users/edit/' . $userData['id']) ?>" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <?php if (($userData['role_name'] ?? '') !== 'Super Admin'): ?>
                            <a href="<?= base_url('users/toggle/' . $userData['id']) ?>" 
                               class="btn btn-<?= ($userData['is_active'] ?? 0) ? 'secondary' : 'success' ?>"
                               onclick="return confirm('Apakah Anda yakin ingin mengubah status user ini?')">
                                <i class="fas fa-<?= ($userData['is_active'] ?? 0) ? 'ban' : 'check' ?> me-2"></i>
                                <?= ($userData['is_active'] ?? 0) ? 'Nonaktifkan' : 'Aktifkan' ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="avatar-xl mx-auto mb-3">
                        <div class="avatar-initial-xl rounded-circle bg-primary text-white">
                            <?= strtoupper(substr($userData['full_name'] ?? $userData['username'], 0, 1)) ?>
                        </div>
                    </div>
                    <h6 class="mb-1"><?= esc($userData['full_name'] ?? $userData['username']) ?></h6>
                    <small class="text-muted">@<?= esc($userData['username']) ?></small>
                </div>
                
                <hr>
                
                <div class="small text-muted">
                    <div class="d-flex justify-content-between mb-2">
                        <span>User ID:</span>
                        <span>#<?= $userData['id'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Role ID:</span>
                        <span><?= $userData['role_id'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Account Status:</span>
                        <span class="badge badge-sm <?= ($userData['is_active'] ?? 0) ? 'bg-success' : 'bg-secondary' ?>">
                            <?= ($userData['is_active'] ?? 0) ? 'Active' : 'Inactive' ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-xl {
    width: 80px;
    height: 80px;
}
.avatar-initial-xl {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 24px;
}
.badge-sm {
    font-size: 0.65rem;
}
</style>

<?= $this->endSection() ?>
