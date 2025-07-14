<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Kelola Pengguna Murid
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-graduation-cap"></i> Kelola Pengguna Murid
                            </h4>
                            <p class="card-text mb-0">Manajemen data murid/siswa</p>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modalTambahMurid">
                                    <i class="fas fa-plus"></i> Tambah Murid
                                </button>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImportExcelMurid">
                                    <i class="fas fa-file-excel"></i> Import Excel
                                </button>
                                <a href="<?= base_url('pengguna-murid/download-template') ?>" class="btn btn-info">
                                    <i class="fas fa-download"></i> Download Template
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <div class="card bg-success text-white">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title mb-1">Total Murid</h6>
                                            <h4 class="mb-0"><?= $stats['total'] ?? 0 ?></h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-users fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-primary text-white">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title mb-1">Sudah Kelas</h6>
                                            <h4 class="mb-0"><?= $stats['sudah_kelas'] ?? 0 ?></h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-chalkboard fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-warning text-white">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title mb-1">Belum Kelas</h6>
                                            <h4 class="mb-0"><?= $stats['belum_kelas'] ?? 0 ?></h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-clock fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-info text-white">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title mb-1">Laki-laki</h6>
                                            <h4 class="mb-0"><?= $stats['laki_laki'] ?? 0 ?></h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-mars fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-danger text-white">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title mb-1">Perempuan</h6>
                                            <h4 class="mb-0"><?= $stats['perempuan'] ?? 0 ?></h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-venus fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-secondary text-white">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title mb-1">Tahun Ajaran</h6>
                                            <small class="mb-0">2025/2026</small>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-calendar fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter dan Search -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari berdasarkan nama, NISN, atau NIS...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterKelas">
                                <option value="">Semua Kelas</option>
                                <?php if (isset($kelas) && !empty($kelas)): ?>
                                    <?php foreach ($kelas as $k): ?>
                                        <option value="<?= $k['id'] ?>">
                                            <?= esc($k['nama_kelas'] ?? $k['nama'] ?? 'Unknown') ?>
                                            <?php if (!empty($k['jumlah_murid'])): ?> (<?= $k['jumlah_murid'] ?>)<?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterJenisKelamin">
                                <option value="">Semua Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tabel Data -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="muridTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th>Kelas</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                    <th>Orang Tua</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="muridTableBody">
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <div class="mt-2">Memuat data...</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="dataTables_info" id="muridTable_info">
                                Menampilkan <span id="start_entry">0</span> sampai <span id="end_entry">0</span> dari <span id="total_entries">0</span> data
                            </div>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-end" id="pagination">
                                    <!-- Pagination will be populated by JavaScript -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Murid -->
<div class="modal fade" id="modalTambahMurid" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Murid Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahMurid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nisn" name="nisn" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nis" class="form-label">NIS</label>
                                <input type="text" class="form-control" id="nis" name="nis">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
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
                                <label class="form-label">Kelas</label>
                                <div class="alert alert-warning py-2 mb-0">
                                    <small>
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Kelas tidak dapat dipilih di sini.</strong><br>
                                        Setelah murid dibuat, silakan gunakan menu <strong>Pengelolaan Kelas</strong> untuk memasukkan murid ke kelas yang sesuai.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="simpanMurid()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Excel Murid -->
<div class="modal fade" id="modalImportExcelMurid" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Murid dari Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> Panduan Import:</h6>
                    <ul class="mb-0">
                        <li>Download template Excel terlebih dahulu</li>
                        <li>Isi data sesuai format yang disediakan</li>
                        <li>Kolom yang wajib diisi: NISN, Username, Password, Nama Lengkap</li>
                        <li>Jenis kelamin: L (Laki-laki) atau P (Perempuan)</li>
                        <li>Format tanggal: YYYY-MM-DD (contoh: 2010-01-15)</li>
                        <li>File maksimal 2MB dengan format .xlsx atau .xls</li>
                    </ul>
                </div>
                
                <form id="formImportExcelMurid" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="excel_file_murid" class="form-label">Pilih File Excel <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="excel_file_murid" name="excel_file" accept=".xlsx,.xls" required>
                        <div class="form-text">Format yang didukung: .xlsx, .xls (Maksimal 2MB)</div>
                    </div>
                </form>
                
                <div id="importProgressMurid" style="display: none;">
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                    </div>
                    <p class="text-center">Sedang memproses file Excel...</p>
                </div>
                
                <div id="importResultMurid" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="importExcelMurid()">
                    <i class="fas fa-file-import"></i> Import Data
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function simpanMurid() {
    const form = document.getElementById('formTambahMurid');
    const formData = new FormData(form);
    
    fetch('<?= base_url('pengguna-murid/store') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Murid berhasil disimpan');
            loadMuridData(1);
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalTambahMurid'));
            if (modal) modal.hide();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}

// Import Excel function
function importExcelMurid() {
    const form = document.getElementById('formImportExcelMurid');
    const fileInput = document.getElementById('excel_file_murid');
    const importProgress = document.getElementById('importProgressMurid');
    const importResult = document.getElementById('importResultMurid');
    const submitBtn = document.querySelector('#modalImportExcelMurid .btn-success');
    
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
    
    fetch('<?= base_url('pengguna-murid/import-excel') ?>', {
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
                    <p class="mb-0"><strong>${data.imported}</strong> data murid berhasil diimport.</p>
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
            
            // Auto reload data and close modal after 3 seconds if all success
            if (!data.errors || data.errors.length === 0) {
                setTimeout(() => {
                    loadMuridData();
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalImportExcelMurid'));
                    if (modal) modal.hide();
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

// Global variables
let currentPage = 1;
let currentLimit = 10;
let currentFilters = {};

// Load data when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadMuridData();
    
    // Bind event listeners
    document.getElementById('searchInput').addEventListener('keyup', debounce(loadMuridData, 500));
    document.getElementById('filterKelas').addEventListener('change', loadMuridData);
    document.getElementById('filterJenisKelamin').addEventListener('change', loadMuridData);
    document.getElementById('filterStatus').addEventListener('change', loadMuridData);
});

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Load murid data via AJAX
function loadMuridData(page = 1) {
    currentPage = page;
    
    // Show loading
    const tbody = document.getElementById('muridTableBody');
    tbody.innerHTML = `
        <tr>
            <td colspan="9" class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2">Memuat data...</div>
            </td>
        </tr>
    `;
    
    // Collect filters safely
    const searchInput = document.getElementById('searchInput');
    const filterKelas = document.getElementById('filterKelas');
    const filterJenisKelamin = document.getElementById('filterJenisKelamin');
    const filterStatus = document.getElementById('filterStatus');
    
    const params = new URLSearchParams({
        page: currentPage,
        limit: currentLimit,
        search: searchInput ? searchInput.value : '',
        kelas_id: filterKelas ? filterKelas.value : '',
        jenis_kelamin: filterJenisKelamin ? filterJenisKelamin.value : '',
        status: filterStatus ? filterStatus.value : ''
    });
    
    // Fetch data using DataTables format
    const requestData = {
        draw: 1,
        start: (currentPage - 1) * currentLimit,
        length: currentLimit,
        search: { value: searchInput ? searchInput.value : '' },
        kelas_filter: filterKelas ? filterKelas.value : '',
        jenis_kelamin_filter: filterJenisKelamin ? filterJenisKelamin.value : '',
        status_filter: filterStatus ? filterStatus.value : ''
    };
    
    console.log('Making request to:', '<?= base_url('pengguna-murid/getData') ?>');
    console.log('Request data:', requestData);
    
    fetch('<?= base_url('pengguna-murid/getData') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(requestData)
    })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data); // Debug log
            if (data.data && Array.isArray(data.data)) {
                console.log('Data array length:', data.data.length);
                renderMuridTable(data.data, currentPage, currentLimit);
                const totalPages = Math.ceil(data.recordsTotal / currentLimit);
                renderPagination(data.recordsTotal, currentPage, currentLimit, totalPages);
                updateInfoText(data.recordsTotal, currentPage, currentLimit);
            } else {
                console.log('No data found or data is not array');
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center text-warning">
                            <i class="fas fa-info-circle"></i> Tidak ada data murid yang ditemukan
                            <br><small>Debug: ${JSON.stringify(data.debug || {})}</small>
                            <br><small>Error: ${data.error || 'No error message'}</small>
                        </td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading data:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center text-danger">
                        <i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan saat memuat data
                        <br><small>Error: ${error.message}</small>
                    </td>
                </tr>
            `;
        });
}

// Render table data
function renderMuridTable(data, page, limit) {
    const tbody = document.getElementById('muridTableBody');
    
    if (data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="9" class="text-center text-muted">
                    <i class="fas fa-search"></i> Tidak ada data murid yang ditemukan
                </td>
            </tr>
        `;
        return;
    }
    
    let html = '';
    const startNumber = (page - 1) * limit + 1;
    
    data.forEach((row, index) => {
        const number = startNumber + index;
        
        // Handle kelas display
        let kelasDisplay = '';
        if (row.nama_kelas && row.tingkat) {
            kelasDisplay = `<span class="badge bg-success">${row.nama_kelas} (${row.tingkat})</span>`;
        } else {
            kelasDisplay = `<span class="text-muted"><i class="fas fa-info-circle me-1"></i>Belum ada kelas</span>`;
        }
        
        // Handle gender display
        let genderDisplay = '';
        if (row.jenis_kelamin === 'L') {
            genderDisplay = `<span class="badge bg-primary">Laki-laki</span>`;
        } else if (row.jenis_kelamin === 'P') {
            genderDisplay = `<span class="badge bg-danger">Perempuan</span>`;
        } else {
            genderDisplay = `<span class="text-muted">-</span>`;
        }
        
        // Handle status display
        let statusDisplay = '';
        if (row.is_active == 1 || row.status_murid === 'aktif') {
            statusDisplay = `<span class="badge bg-success">Aktif</span>`;
        } else {
            statusDisplay = `<span class="badge bg-danger">Nonaktif</span>`;
        }
        
        html += `
            <tr>
                <td>${number}</td>
                <td>
                    <img src="<?= base_url('uploads/profiles/') ?>default.png" 
                         alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                </td>
                <td>${row.nis || '-'}</td>
                <td><strong>${row.nama_lengkap || row.nama || 'N/A'}</strong></td>
                <td>${kelasDisplay}</td>
                <td>${genderDisplay}</td>
                <td>${statusDisplay}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-info" onclick="showOrangTua(${row.id})">
                        <i class="fas fa-users"></i> Lihat
                    </button>
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewMurid(${row.id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="editMurid(${row.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteMurid(${row.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

// Render pagination
function renderPagination(total, page, limit, totalPages) {
    const pagination = document.getElementById('pagination');
    
    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }
    
    let html = '';
    
    // Previous button
    html += `
        <li class="page-item ${page <= 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadMuridData(${page - 1}); return false;">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
    `;
    
    // Page numbers
    const maxVisiblePages = 5;
    let startPage = Math.max(1, page - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
    
    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        html += `
            <li class="page-item ${i === page ? 'active' : ''}">
                <a class="page-link" href="#" onclick="loadMuridData(${i}); return false;">${i}</a>
            </li>
        `;
    }
    
    // Next button
    html += `
        <li class="page-item ${page >= totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadMuridData(${page + 1}); return false;">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
    `;
    
    pagination.innerHTML = html;
}

// Update info text
function updateInfoText(total, page, limit) {
    const start = (page - 1) * limit + 1;
    const end = Math.min(page * limit, total);
    
    document.getElementById('start_entry').textContent = start;
    document.getElementById('end_entry').textContent = end;
    document.getElementById('total_entries').textContent = total;
}

// Action functions
function viewMurid(id) {
    window.location.href = '<?= base_url('pengguna-murid/view/') ?>' + id;
}

function editMurid(id) {
    window.location.href = '<?= base_url('pengguna-murid/edit/') ?>' + id;
}

function deleteMurid(id) {
    if (confirm('Apakah Anda yakin ingin menghapus murid ini?')) {
        fetch('<?= base_url('pengguna-murid/ajax-delete/') ?>' + id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Murid berhasil dihapus');
                loadMuridData(currentPage); // Reload current page
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
}

function showOrangTua(id) {
    window.location.href = '<?= base_url('pengguna-murid/orang-tua/') ?>' + id;
}

// Form submission (if needed)
function submitForm() {
    // Implementation for form submission
    const formData = new FormData(document.getElementById('formTambahMurid'));
    
    fetch('<?= base_url('pengguna-murid/store') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Murid berhasil ditambahkan');
            loadMuridData(1); // Reload to first page
            // Close modal if using Bootstrap modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalTambahMurid'));
            if (modal) modal.hide();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}
</script>
<?= $this->endSection() ?>
