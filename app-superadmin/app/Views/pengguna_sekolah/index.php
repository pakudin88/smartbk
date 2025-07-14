<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Kelola Pengguna Sekolah
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-users-cog"></i> Kelola Pengguna Sekolah
                            </h4>
                            <p class="card-text mb-0">Manajemen pengguna untuk Super Admin, Kepala Sekolah, Guru, dan Staff</p>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modalTambahPetugas">
                                    <i class="fas fa-plus"></i> Tambah Petugas
                                </button>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
                                    <i class="fas fa-file-excel"></i> Import Excel
                                </button>
                                <a href="<?= base_url('pengguna-sekolah/download-template') ?>" class="btn btn-info">
                                    <i class="fas fa-download"></i> Download Template
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Super Admin</h5>
                                            <h3 class="mb-0"><?= $stats['super_admin'] ?? 0 ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-crown fa-2x"></i>
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
                                            <h5 class="card-title">Kepala Sekolah</h5>
                                            <h3 class="mb-0"><?= $stats['kepala_sekolah'] ?? 0 ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-user-tie fa-2x"></i>
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
                                            <h5 class="card-title">Guru</h5>
                                            <h3 class="mb-0"><?= $stats['guru'] ?? 0 ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-secondary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Staff</h5>
                                            <h3 class="mb-0"><?= $stats['staff'] ?? 0 ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-user-cog fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter dan Search -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari berdasarkan nama, email, atau username...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterRole">
                                <option value="">Semua Role</option>
                                <?php if (isset($roles) && !empty($roles)): ?>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role['id'] ?>"><?= esc($role['role_name']) ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">Super Admin</option>
                                    <option value="7">Kepala Sekolah</option>
                                    <option value="2">Guru Mapel</option>
                                    <option value="3">Wali Kelas</option>
                                    <option value="16">Guru</option>
                                    <option value="6">Staff Administrasi</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tabel Data -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Terakhir Login</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($petugas)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data petugas</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; foreach ($petugas as $row): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <img src="<?= base_url('uploads/profiles/' . ($row['profile_picture'] ?? 'default.png')) ?>" 
                                                     alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            </td>
                                            <td><?= esc($row['nama_lengkap']) ?></td>
                                            <td><?= esc($row['username']) ?></td>
                                            <td><?= esc($row['email']) ?></td>
                                            <td>
                                                <span class="badge bg-primary"><?= esc($row['role_name']) ?></span>
                                            </td>
                                            <td>
                                                <?php if ($row['is_active']): ?>
                                                    <span class="badge bg-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Nonaktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($row['last_login']): ?>
                                                    <small class="text-muted">
                                                        <?= date('d/m/Y H:i', strtotime($row['last_login'])) ?>
                                                    </small>
                                                <?php else: ?>
                                                    <small class="text-muted">Belum pernah login</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            onclick="viewPetugas(<?= $row['id'] ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                                            onclick="editPetugas(<?= $row['id'] ?>)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="deletePetugas(<?= $row['id'] ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if (isset($pager)): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted">
                                    Menampilkan <?= $pager->getPerPage() ?> dari <?= $pager->getTotal() ?> data
                                </p>
                            </div>
                            <div class="col-md-6">
                                <?= $pager->links() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Petugas -->
<div class="modal fade" id="modalTambahPetugas" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Petugas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPetugas">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select" id="role_id" name="role_id" required>
                                    <option value="">Pilih Role</option>
                                    <?php if (isset($roles) && !empty($roles)): ?>
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?= $role['id'] ?>"><?= esc($role['role_name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">Super Admin</option>
                                        <option value="7">Kepala Sekolah</option>
                                        <option value="2">Guru Mapel</option>
                                        <option value="3">Wali Kelas</option>
                                        <option value="16">Guru</option>
                                        <option value="6">Staff Administrasi</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="departemen" class="form-label">Departemen</label>
                                <input type="text" class="form-control" id="departemen" name="departemen">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpanPetugas()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="modalImportExcel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Pengguna Sekolah dari Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> Panduan Import:</h6>
                    <ul class="mb-0">
                        <li>Download template Excel terlebih dahulu</li>
                        <li>Isi data sesuai format yang disediakan</li>
                        <li>Kolom yang wajib diisi: Username, Email, Password, Nama Lengkap, Role</li>
                        <li>Role yang tersedia: Super Admin, Kepala Sekolah, Guru, Staff Administrasi, dll</li>
                        <li>Jenis kelamin: L (Laki-laki) atau P (Perempuan)</li>
                        <li>File maksimal 2MB dengan format .xlsx atau .xls</li>
                    </ul>
                </div>
                
                <form id="formImportExcel" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">Pilih File Excel <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".xlsx,.xls" required>
                        <div class="form-text">Format yang didukung: .xlsx, .xls (Maksimal 2MB)</div>
                    </div>
                </form>
                
                <div id="importProgress" style="display: none;">
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                    </div>
                    <p class="text-center">Sedang memproses file Excel...</p>
                </div>
                
                <div id="importResult" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="importExcel()">
                    <i class="fas fa-file-import"></i> Import Data
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function simpanPetugas() {
    const form = document.getElementById('formTambahPetugas');
    const formData = new FormData(form);
    
    // Disable submit button
    const submitBtn = document.querySelector('#modalTambahPetugas .btn-primary');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    
    fetch('<?= base_url('pengguna-sekolah/store') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Petugas berhasil ditambahkan');
            location.reload();
        } else {
            let errorMsg = 'Error: ' + (data.message || 'Unknown error');
            if (data.errors) {
                errorMsg += '\nDetail errors:\n';
                Object.keys(data.errors).forEach(key => {
                    errorMsg += '- ' + data.errors[key] + '\n';
                });
            }
            alert(errorMsg);
            
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
        
        // Re-enable submit button
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Simpan';
    });
}

function viewPetugas(id) {
    if (!id) {
        alert('ID petugas tidak valid');
        return;
    }
    window.location.href = '<?= base_url('pengguna-sekolah/view/') ?>' + id;
}

function editPetugas(id) {
    if (!id) {
        alert('ID petugas tidak valid');
        return;
    }
    window.location.href = '<?= base_url('pengguna-sekolah/edit/') ?>' + id;
}

function importExcel() {
    const form = document.getElementById('formImportExcel');
    const fileInput = document.getElementById('excel_file');
    const importProgress = document.getElementById('importProgress');
    const importResult = document.getElementById('importResult');
    const submitBtn = document.querySelector('#modalImportExcel .btn-success');
    
    if (!fileInput.files[0]) {
        alert('Silakan pilih file Excel terlebih dahulu');
        return;
    }
    
    // Validate file type
    const fileName = fileInput.files[0].name;
    const fileExtension = fileName.split('.').pop().toLowerCase();
    if (!['xlsx', 'xls'].includes(fileExtension)) {
        alert('File harus berformat Excel (.xlsx atau .xls)');
        return;
    }
    
    // Validate file size (2MB)
    if (fileInput.files[0].size > 2 * 1024 * 1024) {
        alert('Ukuran file maksimal 2MB');
        return;
    }
    
    const formData = new FormData(form);
    
    // Show progress
    importProgress.style.display = 'block';
    importResult.style.display = 'none';
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    
    fetch('<?= base_url('pengguna-sekolah/import-excel') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        importProgress.style.display = 'none';
        importResult.style.display = 'block';
        
        if (data.success) {
            let resultHtml = `
                <div class="alert alert-success">
                    <h6><i class="fas fa-check-circle"></i> Import Berhasil!</h6>
                    <p class="mb-0">${data.message}</p>
                    <p class="mb-0"><strong>${data.imported}</strong> data berhasil diimport.</p>
                </div>
            `;
            
            if (data.errors && data.errors.length > 0) {
                resultHtml += `
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle"></i> Ada ${data.errors.length} error:</h6>
                        <ul class="mb-0">
                `;
                data.errors.forEach(error => {
                    resultHtml += `<li>${error}</li>`;
                });
                resultHtml += `
                        </ul>
                    </div>
                `;
            }
            
            importResult.innerHTML = resultHtml;
            
            // Auto close modal and reload after 3 seconds if all success
            if (!data.errors || data.errors.length === 0) {
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }
            
        } else {
            let errorHtml = `
                <div class="alert alert-danger">
                    <h6><i class="fas fa-times-circle"></i> Import Gagal!</h6>
                    <p class="mb-0">${data.message}</p>
                </div>
            `;
            
            if (data.errors) {
                errorHtml += `
                    <div class="alert alert-warning">
                        <h6>Detail Error:</h6>
                        <ul class="mb-0">
                `;
                if (typeof data.errors === 'object') {
                    Object.keys(data.errors).forEach(key => {
                        errorHtml += `<li><strong>${key}:</strong> ${data.errors[key]}</li>`;
                    });
                } else if (Array.isArray(data.errors)) {
                    data.errors.forEach(error => {
                        errorHtml += `<li>${error}</li>`;
                    });
                }
                errorHtml += `
                        </ul>
                    </div>
                `;
            }
            
            importResult.innerHTML = errorHtml;
        }
        
        // Re-enable submit button
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-file-import"></i> Import Data';
    })
    .catch(error => {
        console.error('Error:', error);
        importProgress.style.display = 'none';
        importResult.style.display = 'block';
        importResult.innerHTML = `
            <div class="alert alert-danger">
                <h6><i class="fas fa-times-circle"></i> Error!</h6>
                <p class="mb-0">Terjadi kesalahan: ${error.message}</p>
            </div>
        `;
        
        // Re-enable submit button
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-file-import"></i> Import Data';
    });
}

function deletePetugas(id) {
    if (!id) {
        alert('ID petugas tidak valid');
        return;
    }
    
    if (confirm('Apakah Anda yakin ingin menghapus petugas ini?')) {
        // Show loading
        const deleteBtn = document.querySelector(`button[onclick="deletePetugas(${id})"]`);
        const originalContent = deleteBtn.innerHTML;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        deleteBtn.disabled = true;
        
        fetch('<?= base_url('pengguna-sekolah/delete/') ?>' + id, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Petugas berhasil dihapus');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Gagal menghapus petugas'));
                // Restore button
                deleteBtn.innerHTML = originalContent;
                deleteBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
            // Restore button
            deleteBtn.innerHTML = originalContent;
            deleteBtn.disabled = false;
        });
    }
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterRole = document.getElementById('filterRole');
    const filterStatus = document.getElementById('filterStatus');
    
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            filterTable();
        });
    }
    
    if (filterRole) {
        filterRole.addEventListener('change', function() {
            filterTable();
        });
    }
    
    if (filterStatus) {
        filterStatus.addEventListener('change', function() {
            filterTable();
        });
    }
});

function filterTable() {
    const searchFilter = document.getElementById('searchInput').value.toLowerCase();
    const roleFilter = document.getElementById('filterRole').value;
    const statusFilter = document.getElementById('filterStatus').value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        if (row.cells.length < 2) return; // Skip empty rows
        
        const text = row.textContent.toLowerCase();
        const roleCell = row.cells[5]; // Role column
        const statusCell = row.cells[6]; // Status column
        
        let showRow = true;
        
        // Search filter
        if (searchFilter && !text.includes(searchFilter)) {
            showRow = false;
        }
        
        // Role filter
        if (roleFilter && roleCell) {
            const roleBadge = roleCell.querySelector('.badge');
            if (roleBadge) {
                const roleText = roleBadge.textContent.toLowerCase();
                const filterText = document.getElementById('filterRole').selectedOptions[0].textContent.toLowerCase();
                if (!roleText.includes(filterText.replace(/\s+/g, ' ').trim())) {
                    showRow = false;
                }
            }
        }
        
        // Status filter
        if (statusFilter && statusCell) {
            const statusBadge = statusCell.querySelector('.badge');
            if (statusBadge) {
                const isActive = statusBadge.textContent.includes('Aktif');
                if ((statusFilter === '1' && !isActive) || (statusFilter === '0' && isActive)) {
                    showRow = false;
                }
            }
        }
        
        row.style.display = showRow ? '' : 'none';
    });
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formTambahPetugas');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            simpanPetugas();
        });
    }
});
</script>
<?= $this->endSection() ?>
