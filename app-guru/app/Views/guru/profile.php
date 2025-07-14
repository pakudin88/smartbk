<?= $this->extend('layouts/dashboard_layout') ?>

<?= $this->section('content') ?>

<!-- Content Header -->
<div class="content-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="page-title">
                <i class="fas fa-user-cog me-3"></i>Profil Guru
            </h1>
            <p class="page-subtitle">Kelola informasi profil dan pengaturan akun Anda</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="/dashboard" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Profile Information -->
<div class="row">
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-body p-4 text-center">
                <div class="profile-avatar mb-3">
                    <div class="avatar-lg mx-auto">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
                <h5 class="card-title"><?= esc($user_name) ?></h5>
                <p class="text-muted mb-3">Guru - Smart BookKeeping</p>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-primary">
                        <i class="fas fa-camera me-2"></i>Ubah Foto
                    </button>
                    <button class="btn btn-outline-secondary">
                        <i class="fas fa-key me-2"></i>Ubah Password
                    </button>
                </div>
                
                <hr class="my-4">
                
                <div class="text-start">
                    <h6 class="text-muted mb-3">Status Akun</h6>
                    <div class="mb-2">
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Aktif
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-primary">
                            <i class="fas fa-shield-alt me-1"></i>Terverifikasi
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-info">
                            <i class="fas fa-chalkboard-teacher me-1"></i>Guru
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="dashboard-card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Pribadi
                </h5>
            </div>
            <div class="card-body p-4">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="<?= esc($user_name) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?= esc($username) ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?= esc($email) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="Guru" readonly>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">User ID</label>
                            <input type="text" class="form-control" value="<?= session('user_id') ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun Ajaran ID</label>
                            <input type="text" class="form-control" value="<?= session('tahun_ajaran_id') ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Login Terakhir</label>
                        <input type="text" class="form-control" value="<?= date('d M Y, H:i') ?> WIB" readonly>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi:</strong> Data profil saat ini bersifat read-only. 
                        Untuk mengubah informasi profil, hubungi administrator sistem.
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Mode Edit
                        </button>
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="fas fa-sync me-2"></i>Refresh Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Account Security -->
        <div class="dashboard-card mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-shield-alt me-2"></i>Keamanan Akun
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Aktivitas Login</h6>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-desktop text-primary me-2"></i>
                                    <strong>Desktop Login</strong><br>
                                    <small class="text-muted"><?= date('d M Y, H:i') ?> WIB</small>
                                </div>
                                <span class="badge bg-success">Aktif</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Pengaturan Keamanan</h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-warning">
                                <i class="fas fa-key me-2"></i>Ubah Password
                            </button>
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout Semua Device
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-avatar .avatar-lg {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}
</style>

<?= $this->endSection() ?>
