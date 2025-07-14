<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Notifikasi -->
<?php if (session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= session('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3><i class="fas fa-users me-2"></i>Manajemen Pengguna</h3>
            <p>Kelola semua pengguna sistem dengan mudah dan efisien</p>
        </div>
        <div>
            <a href="<?= base_url('users/create') ?>" class="btn btn-light btn-lg">
                <i class="fas fa-plus me-2"></i>Tambah Pengguna
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="bg-primary bg-gradient rounded-circle p-3">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengguna</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($users) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="bg-success bg-gradient rounded-circle p-3">
                            <i class="fas fa-user-check text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pengguna Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($users, function($user) { return ($user['is_active'] ?? 0); })) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="bg-warning bg-gradient rounded-circle p-3">
                            <i class="fas fa-user-shield text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Super Admin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($users, function($user) { return ($user['role_name'] ?? '') === 'Super Admin'; })) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="bg-danger bg-gradient rounded-circle p-3">
                            <i class="fas fa-user-times text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pengguna Nonaktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($users, function($user) { return !($user['is_active'] ?? 0); })) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-0 bg-light" 
                           placeholder="Cari pengguna berdasarkan nama, email, atau username..." 
                           id="searchInput">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select border-0 bg-light" id="roleFilter">
                    <option value="">Semua Role</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role ?>" <?= ($role === ($selectedRole ?? '')) ? 'selected' : '' ?>>
                            <?= $role ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Main Users Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-table me-2 text-primary"></i>Daftar Pengguna
            </h5>
            <div class="d-flex gap-2 align-items-center">
                <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0 text-muted small">Tampilkan:</label>
                    <select class="form-select form-select-sm" id="perPageSelect" onchange="changePerPage()">
                        <option value="10" <?= ($pager['perPage'] == 10) ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= ($pager['perPage'] == 25) ? 'selected' : '' ?>>25</option>
                        <option value="50" <?= ($pager['perPage'] == 50) ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= ($pager['perPage'] == 100) ? 'selected' : '' ?>>100</option>
                    </select>
                    <span class="text-muted small ms-2">entri</span>
                </div>
                <div class="vr"></div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= base_url('users/export-excel?role=' . ($role ?? '')) ?>">
                            <i class="fas fa-file-excel text-success me-2"></i>Export Excel (.xlsx)
                        </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('users/export-csv?role=' . ($role ?? '')) ?>">
                            <i class="fas fa-file-csv text-info me-2"></i>Export CSV (.csv)
                        </a></li>
                    </ul>
                </div>
                <button class="btn btn-outline-secondary btn-sm" onclick="refreshTable()">
                    <i class="fas fa-refresh me-1"></i>Refresh
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="usersTable">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 ps-4">No</th>
                        <th class="border-0">Pengguna</th>
                        <th class="border-0">Username</th>
                        <th class="border-0">Role</th>
                        <th class="border-0">Kelas/Sekolah</th>
                        <th class="border-0">Status</th>
                        <th class="border-0">Terakhir Login</th>
                        <th class="border-0 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                    <?php foreach ($users as $index => $user): ?>
                        <tr class="user-row">
                            <td class="ps-4 fw-semibold text-muted"><?= (($pager['current'] - 1) * $pager['perPage']) + $index + 1 ?></td>
                            <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <div class="avatar-initial rounded-circle bg-primary text-white">
                                                <?= strtoupper(substr($user['full_name'] ?? $user['username'], 0, 1)) ?>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark"><?= esc($user['full_name'] ?? $user['username']) ?></div>
                                            <div class="text-muted small">
                                                <i class="fas fa-envelope me-1"></i><?= esc($user['email']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-user me-1"></i><?= esc($user['username']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $roleColors = [
                                        'Super Admin' => 'bg-danger',
                                        'Admin' => 'bg-primary',
                                        'Guru' => 'bg-success',
                                        'Siswa' => 'bg-info',
                                        'Wali' => 'bg-warning'
                                    ];
                                    $roleColor = $roleColors[$user['role_name'] ?? ''] ?? 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $roleColor ?> px-3 py-2">
                                        <i class="fas fa-user-tag me-1"></i><?= esc($user['role_name'] ?? 'No Role') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['role_name'] === 'Siswa'): ?>
                                        <?php if (!empty($user['nama_kelas'])): ?>
                                            <div class="small">
                                                <div class="fw-semibold text-primary">
                                                    <i class="fas fa-graduation-cap me-1"></i>
                                                    <?= esc($user['nama_kelas']) ?> - Tingkat <?= esc($user['tingkat']) ?>
                                                </div>
                                                <div class="text-muted">
                                                    <i class="fas fa-school me-1"></i>
                                                    <?= esc($user['nama_sekolah']) ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Belum ada kelas
                                            </span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?= ($user['is_active'] ?? 0) ? 'bg-success' : 'bg-secondary' ?> px-3 py-2">
                                        <i class="fas <?= ($user['is_active'] ?? 0) ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                                        <?= ($user['is_active'] ?? 0) ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </td>
                                <td class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    <?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Belum pernah login' ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('users/view/' . $user['id']) ?>" 
                                           class="btn btn-outline-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('users/edit/' . $user['id']) ?>" 
                                           class="btn btn-outline-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if (($user['role_name'] ?? '') !== 'Super Admin'): ?>
                                            <button class="btn btn-outline-danger btn-sm" 
                                                    onclick="deleteUser(<?= $user['id'] ?>, '<?= esc($user['full_name'] ?? $user['username']) ?>')" 
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada pengguna</h5>
                                <p class="text-muted">Mulai dengan menambahkan pengguna pertama</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination Footer -->
    <div class="card-footer bg-white border-0">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Menampilkan <?= count($users) ? (($pager['current'] - 1) * $pager['perPage'] + 1) : 0 ?> - <?= (($pager['current'] - 1) * $pager['perPage']) + count($users) ?> dari <?= $pager['total'] ?> pengguna
            </div>
            <nav>
                <ul class="pagination mb-0">
                    <li class="page-item<?= $pager['current'] == 1 ? ' disabled' : '' ?>">
                        <a class="page-link" href="?page=1&perPage=<?= $pager['perPage'] ?>">&laquo;</a>
                    </li>
                    <li class="page-item<?= $pager['current'] == 1 ? ' disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $pager['current'] - 1 ?>&perPage=<?= $pager['perPage'] ?>">&lsaquo;</a>
                    </li>
                    <?php for ($i = max(1, $pager['current'] - 2); $i <= min($pager['last'], $pager['current'] + 2); $i++): ?>
                        <li class="page-item<?= $pager['current'] == $i ? ' active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&perPage=<?= $pager['perPage'] ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item<?= $pager['current'] == $pager['last'] ? ' disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $pager['current'] + 1 ?>&perPage=<?= $pager['perPage'] ?>">&rsaquo;</a>
                    </li>
                    <li class="page-item<?= $pager['current'] == $pager['last'] ? ' disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $pager['last'] ?>&perPage=<?= $pager['perPage'] ?>">&raquo;</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
.avatar {
    width: 45px;
    height: 45px;
}
.avatar-initial {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
}
.table-hover tbody tr:hover {
    background-color: #f8fafc;
}
.btn-group .btn {
    border-radius: 6px !important;
    margin-right: 3px;
}
.form-control, .form-select {
    border-radius: 10px;
    padding: 0.7rem 1rem;
}
.input-group-text {
    border-radius: 10px 0 0 10px;
}
.text-xs {
    font-size: 0.75rem;
}
.form-select-sm {
    border-radius: 6px;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    min-width: 70px;
}
.vr {
    width: 1px;
    height: 30px;
    background-color: #dee2e6;
}
</style>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tbody tr.user-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Role filter
document.getElementById('roleFilter').addEventListener('change', function() {
    const selectedRole = this.value;
    const rows = document.querySelectorAll('#usersTable tbody tr.user-row');
    
    rows.forEach(row => {
        if (selectedRole === '') {
            row.style.display = '';
        } else {
            const roleText = row.querySelector('td:nth-child(4)').textContent;
            row.style.display = roleText.includes(selectedRole) ? '' : 'none';
        }
    });
});

// Delete user with confirmation
function deleteUser(userId, userName) {
    if (confirm(`Apakah Anda yakin ingin menghapus pengguna "${userName}"?`)) {
        window.location.href = `<?= base_url('users/delete/') ?>${userId}`;
    }
}

// Refresh table
function refreshTable() {
    location.reload();
}

// Change per page
function changePerPage() {
    const perPage = document.getElementById('perPageSelect').value;
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('perPage', perPage);
    currentUrl.searchParams.set('page', 1); // Reset to first page
    window.location.href = currentUrl.toString();
}

// Update export links based on role filter
function updateExportLinks() {
    const selectedRole = document.getElementById('roleFilter').value;
    const excelLink = document.querySelector("a[href*='export-excel']");
    const csvLink = document.querySelector("a[href*='export-csv']");

    if (excelLink) {
        const excelUrl = new URL(excelLink.href);
        excelUrl.searchParams.set('role', selectedRole);
        excelLink.href = excelUrl.toString();
    }

    if (csvLink) {
        const csvUrl = new URL(csvLink.href);
        csvUrl.searchParams.set('role', selectedRole);
        csvLink.href = csvUrl.toString();
    }
}

// Attach event listener to role filter dropdown
const roleFilter = document.getElementById('roleFilter');
roleFilter.addEventListener('change', updateExportLinks);

// Initialize export links on page load
updateExportLinks();

document.getElementById('roleFilter').addEventListener('change', function() {
        const selectedRole = this.value;
        const exportExcelLink = document.querySelector('a[href*="users/export-excel"]');
        const exportCsvLink = document.querySelector('a[href*="users/export-csv"]');

        if (exportExcelLink) {
            exportExcelLink.href = `<?= base_url('users/export-excel') ?>?role=${selectedRole}`;
        }

        if (exportCsvLink) {
            exportCsvLink.href = `<?= base_url('users/export-csv') ?>?role=${selectedRole}`;
        }
    });
</script>

<?= $this->endSection() ?>
