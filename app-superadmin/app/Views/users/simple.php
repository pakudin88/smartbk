<?= $this->extend('layouts/simple') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-users me-2 text-primary"></i>Manajemen Pengguna
                </h2>
                <p class="text-muted mb-0">Kelola semua pengguna sistem</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" onclick="exportUsers()">
                    <i class="fas fa-download me-2"></i>Export
                </button>
                <a href="<?= base_url('users/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Pengguna
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengguna</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($users) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pengguna Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($users, function($user) { return ($user['is_active'] ?? 0); })) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Super Admin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($users, function($user) { return ($user['role_name'] ?? '') === 'Super Admin'; })) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-shield fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pengguna Nonaktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($users, function($user) { return !($user['is_active'] ?? 0); })) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-times fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-0 bg-light" 
                           placeholder="Cari pengguna berdasarkan nama, email, atau role..." 
                           id="searchInput">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select border-0 bg-light" id="roleFilter">
                    <option value="">Semua Role</option>
                    <option value="Super Admin">Super Admin</option>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" 
                        data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="selectAll()">
                        <i class="fas fa-check-square me-2"></i>Pilih Semua
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="deselectAll()">
                        <i class="fas fa-square me-2"></i>Batal Pilih
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#" onclick="bulkDelete()">
                        <i class="fas fa-trash me-2"></i>Hapus Terpilih
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($users)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="usersTable">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 ps-3" width="40">
                                <input type="checkbox" class="form-check-input" id="checkAll">
                            </th>
                            <th class="border-0">Pengguna</th>
                            <th class="border-0">Role</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Terakhir Login</th>
                            <th class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="user-row">
                                <td class="ps-3">
                                    <input type="checkbox" class="form-check-input user-checkbox" 
                                           value="<?= $user['id'] ?>">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <div class="avatar-initial rounded-circle bg-primary text-white">
                                                <?= strtoupper(substr($user['full_name'] ?? $user['username'], 0, 1)) ?>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-gray-800"><?= esc($user['full_name'] ?? $user['username']) ?></div>
                                            <div class="text-muted small">
                                                <i class="fas fa-envelope me-1"></i><?= esc($user['email']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-gradient-primary px-3 py-2">
                                        <i class="fas fa-user-tag me-1"></i><?= esc($user['role_name'] ?? 'No Role') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= ($user['is_active'] ?? 0) ? 'bg-success' : 'bg-danger' ?> px-3 py-2">
                                        <i class="fas <?= ($user['is_active'] ?? 0) ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                                        <?= ($user['is_active'] ?? 0) ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </td>
                                <td class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    <?= esc($user['last_login'] ?? 'Belum pernah login') ?>
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
                                        <button class="btn btn-outline-<?= ($user['is_active'] ?? 0) ? 'secondary' : 'success' ?> btn-sm" 
                                                onclick="toggleStatus(<?= $user['id'] ?>)" 
                                                title="<?= ($user['is_active'] ?? 0) ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                            <i class="fas <?= ($user['is_active'] ?? 0) ? 'fa-user-slash' : 'fa-user-check' ?>"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" 
                                                onclick="deleteUser(<?= $user['id'] ?>, '<?= esc($user['full_name'] ?? $user['username']) ?>')" 
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada pengguna</h5>
                <p class="text-muted">Mulai dengan menambahkan pengguna pertama</p>
                <a href="<?= base_url('users/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Pengguna
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.avatar {
    width: 40px;
    height: 40px;
}
.avatar-initial {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
.btn-group .btn {
    border-radius: 4px !important;
    margin-right: 2px;
}
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
}
</style>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Role filter
document.getElementById('roleFilter').addEventListener('change', function() {
    const selectedRole = this.value;
    const rows = document.querySelectorAll('#usersTable tbody tr');
    
    rows.forEach(row => {
        if (selectedRole === '') {
            row.style.display = '';
        } else {
            const roleText = row.querySelector('td:nth-child(3)').textContent;
            row.style.display = roleText.includes(selectedRole) ? '' : 'none';
        }
    });
});

// Check all functionality
document.getElementById('checkAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Select/Deselect all
function selectAll() {
    document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = true);
}

function deselectAll() {
    document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = false);
}

// Delete user with confirmation
function deleteUser(userId, userName) {
    if (confirm(`Apakah Anda yakin ingin menghapus pengguna "${userName}"?`)) {
        // Add your delete logic here
        window.location.href = `<?= base_url('users/delete/') ?>${userId}`;
    }
}

// Toggle user status
function toggleStatus(userId) {
    if (confirm('Apakah Anda yakin ingin mengubah status pengguna ini?')) {
        // Add your toggle status logic here
        fetch(`<?= base_url('users/toggle-status/') ?>${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}

// Bulk delete
function bulkDelete() {
    const selected = document.querySelectorAll('.user-checkbox:checked');
    if (selected.length === 0) {
        alert('Pilih setidaknya satu pengguna untuk dihapus');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin menghapus ${selected.length} pengguna yang dipilih?`)) {
        // Add your bulk delete logic here
        const userIds = Array.from(selected).map(cb => cb.value);
        console.log('Delete users:', userIds);
    }
}

// Export users
function exportUsers() {
    window.location.href = '<?= base_url('users/export') ?>';
}
</script>

<?= $this->endSection() ?>
