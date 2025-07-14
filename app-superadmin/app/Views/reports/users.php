<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Laporan Pengguna</h1>
    <div>
        <a href="<?= base_url('reports') ?>" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <a href="<?= base_url('reports/export/users') ?>" class="btn btn-success">
            <i class="fas fa-download me-2"></i>Export Excel
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Total Pengguna</h5>
                        <h2><?= number_format($userStats['total']) ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Aktif</h5>
                        <h2><?= number_format($userStats['aktif']) ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Nonaktif</h5>
                        <h2><?= number_format($userStats['nonaktif']) ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-times fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Roles</h5>
                        <h2><?= count($userStats['by_role']) ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-tag fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Pengguna</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Terakhir Login</th>
                        <th>Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['full_name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td>
                                    <span class="badge bg-primary"><?= $user['role_name'] ?></span>
                                </td>
                                <td>
                                    <?php if ($user['is_active'] == 1): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Belum login' ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pengguna</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Role Statistics -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Statistik Berdasarkan Role</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if (!empty($userStats['by_role'])): ?>
                <?php foreach ($userStats['by_role'] as $role): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5><?= $role['role_name'] ?></h5>
                                <h3 class="text-primary"><?= number_format($role['count']) ?></h3>
                                <p class="text-muted">Pengguna</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-muted">Tidak ada data statistik role</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
