<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Kelola Pengguna Orang Tua
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-users"></i> Kelola Pengguna Orang Tua
                            </h4>
                            <p class="card-text mb-0">Manajemen data orang tua/wali murid (dapat memiliki lebih dari 1 murid)</p>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modalTambahOrangTua">
                                    <i class="fas fa-plus"></i> Tambah Orang Tua
                                </button>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImportExcelOrangTua">
                                    <i class="fas fa-file-excel"></i> Import Excel
                                </button>
                                <a href="<?= base_url('pengguna-orang-tua/download-template') ?>" class="btn btn-info">
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
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Total Orang Tua</h5>
                                            <h3 class="mb-0"><?= $stats['total'] ?? 0 ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-users fa-2x"></i>
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
                                            <h5 class="card-title">Aktif</h5>
                                            <h3 class="mb-0"><?= $stats['aktif'] ?? 0 ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-user-check fa-2x"></i>
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
                                            <h5 class="card-title">Ayah</h5>
                                            <h3 class="mb-0"><?= $stats['ayah'] ?? 0 ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-male fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Ibu</h5>
                                            <h3 class="mb-0"><?= $stats['ibu'] ?? 0 ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-female fa-2x"></i>
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
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari berdasarkan nama, email, atau username...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterHubungan">
                                <option value="">Semua Hubungan</option>
                                <option value="Ayah">Ayah</option>
                                <option value="Ibu">Ibu</option>
                                <option value="Wali">Wali</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-primary w-100" onclick="exportData()">
                                <i class="fas fa-download"></i> Export
                            </button>
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
                                    <th>Hubungan</th>
                                    <th>Jumlah Anak</th>
                                    <th>Status</th>
                                    <th>Terakhir Login</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($orangTua)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada data orang tua</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; foreach ($orangTua as $row): ?>
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
                                                <?php 
                                                $badgeClass = '';
                                                switch($row['hubungan_keluarga']) {
                                                    case 'Ayah': $badgeClass = 'bg-primary'; break;
                                                    case 'Ibu': $badgeClass = 'bg-pink'; break;
                                                    case 'Wali': $badgeClass = 'bg-secondary'; break;
                                                    default: $badgeClass = 'bg-secondary';
                                                }
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><?= esc($row['hubungan_keluarga']) ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= $row['jumlah_anak'] ?? 0 ?> anak
                                                </span>
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
                                                            onclick="viewOrangTua(<?= $row['id'] ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-info" 
                                                            onclick="kelolaMurid(<?= $row['id'] ?>)">
                                                        <i class="fas fa-child"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                                            onclick="editOrangTua(<?= $row['id'] ?>)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="deleteOrangTua(<?= $row['id'] ?>)">
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

<!-- Modal Tambah Orang Tua -->
<div class="modal fade" id="modalTambahOrangTua" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Orang Tua Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahOrangTua">
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
                                <label for="hubungan_keluarga" class="form-label">Hubungan Keluarga <span class="text-danger">*</span></label>
                                <select class="form-select" id="hubungan_keluarga" name="hubungan_keluarga" required>
                                    <option value="">Pilih Hubungan</option>
                                    <option value="Ayah">Ayah</option>
                                    <option value="Ibu">Ibu</option>
                                    <option value="Wali">Wali</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_telepon" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pendidikan" class="form-label">Pendidikan</label>
                                <input type="text" class="form-control" id="pendidikan" name="pendidikan">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="penghasilan" class="form-label">Penghasilan</label>
                                <select class="form-select" id="penghasilan" name="penghasilan">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< 1 Juta">< 1 Juta</option>
                                    <option value="1-2 Juta">1-2 Juta</option>
                                    <option value="2-5 Juta">2-5 Juta</option>
                                    <option value="5-10 Juta">5-10 Juta</option>
                                    <option value="> 10 Juta">> 10 Juta</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <h6>Hubungkan dengan Anak (Murid)</h6>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Cari dan Pilih Murid:</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="searchMurid" placeholder="Ketik nama atau NISN murid untuk mencari...">
                                    <button type="button" class="btn btn-outline-primary" onclick="cariMurid()">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                                <div id="hasilCariMurid" style="display: none;">
                                    <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                                        <!-- Hasil pencarian akan muncul di sini -->
                                    </div>
                                </div>
                                <div id="muridTerpilih" class="mt-3">
                                    <label class="form-label text-success">Murid yang dipilih:</label>
                                    <div id="daftarMuridTerpilih" class="border rounded p-2 bg-light" style="min-height: 50px;">
                                        <p class="text-muted mb-0">Belum ada murid yang dipilih</p>
                                    </div>
                                </div>
                                <input type="hidden" id="selectedMuridIds" name="murid_ids" value="">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" onclick="simpanOrangTua()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Excel Orang Tua -->
<div class="modal fade" id="modalImportExcelOrangTua" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Orang Tua dari Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> Panduan Import:</h6>
                    <ul class="mb-0">
                        <li>Download template Excel terlebih dahulu</li>
                        <li>Isi data sesuai format yang disediakan</li>
                        <li>Kolom yang wajib diisi: Username, Password, Nama Lengkap, Hubungan Keluarga</li>
                        <li>Hubungan Keluarga: Ayah, Ibu, atau Wali</li>
                        <li>Jenis kelamin: L (Laki-laki) atau P (Perempuan)</li>
                        <li>File maksimal 2MB dengan format .xlsx atau .xls</li>
                        <li>Data anak (murid) dapat dikosongkan dulu, hubungkan nanti secara manual</li>
                    </ul>
                </div>
                
                <form id="formImportExcelOrangTua" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="excel_file_ortu" class="form-label">Pilih File Excel <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="excel_file_ortu" name="excel_file" accept=".xlsx,.xls" required>
                        <div class="form-text">Format yang didukung: .xlsx, .xls (Maksimal 2MB)</div>
                    </div>
                </form>
                
                <div id="importProgressOrangTua" style="display: none;">
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                    </div>
                    <p class="text-center">Sedang memproses file Excel...</p>
                </div>
                
                <div id="importResultOrangTua" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="importExcelOrangTua()">
                    <i class="fas fa-file-import"></i> Import Data
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function simpanOrangTua() {
    const form = document.getElementById('formTambahOrangTua');
    const formData = new FormData(form);
    
    fetch('<?= base_url('pengguna-orang-tua/store') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Orang tua berhasil ditambahkan');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}

function importExcelOrangTua() {
    const form = document.getElementById('formImportExcelOrangTua');
    const fileInput = document.getElementById('excel_file_ortu');
    const importProgress = document.getElementById('importProgressOrangTua');
    const importResult = document.getElementById('importResultOrangTua');
    const submitBtn = document.querySelector('#modalImportExcelOrangTua .btn-success');
    
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
    
    fetch('<?= base_url('pengguna-orang-tua/import-excel') ?>', {
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
                    <p class="mb-0"><strong>${data.imported}</strong> data orang tua berhasil diimport.</p>
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
            
            // Auto reload and close modal after 3 seconds if all success
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

// Global variables untuk mengelola murid yang dipilih
let selectedMurids = [];

function cariMurid() {
    const searchTerm = document.getElementById('searchMurid').value.trim();
    const hasilDiv = document.getElementById('hasilCariMurid');
    
    if (searchTerm.length < 2) {
        alert('Masukkan minimal 2 karakter untuk mencari');
        return;
    }
    
    // Show loading
    hasilDiv.style.display = 'block';
    hasilDiv.innerHTML = '<div class="text-center p-2"><i class="fas fa-spinner fa-spin"></i> Mencari...</div>';
    
    // Fetch data murid
    fetch(`<?= base_url('pengguna-orang-tua/search-murid') ?>?q=${encodeURIComponent(searchTerm)}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.murid && data.murid.length > 0) {
            let html = '';
            data.murid.forEach(murid => {
                const isSelected = selectedMurids.find(m => m.id == murid.id);
                const btnClass = isSelected ? 'btn-success' : 'btn-outline-primary';
                const btnText = isSelected ? 'Terpilih' : 'Pilih';
                const btnIcon = isSelected ? 'fas fa-check' : 'fas fa-plus';
                
                html += `
                    <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                        <div>
                            <strong>${murid.nama_lengkap}</strong><br>
                            <small class="text-muted">NISN: ${murid.nisn || '-'}</small>
                            ${murid.nama_kelas ? `<br><small class="text-info">Kelas: ${murid.nama_kelas}</small>` : ''}
                        </div>
                        <button type="button" class="btn btn-sm ${btnClass}" 
                                onclick="togglePilihMurid(${murid.id}, '${murid.nama_lengkap}', '${murid.nisn || ''}', '${murid.nama_kelas || ''}')"
                                ${isSelected ? 'disabled' : ''}>
                            <i class="${btnIcon}"></i> ${btnText}
                        </button>
                    </div>
                `;
            });
            hasilDiv.innerHTML = html;
        } else {
            hasilDiv.innerHTML = '<div class="text-center p-2 text-muted">Tidak ada murid yang ditemukan</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        hasilDiv.innerHTML = '<div class="text-center p-2 text-danger">Error saat mencari murid</div>';
    });
}

function togglePilihMurid(id, nama, nisn, kelas) {
    const existingIndex = selectedMurids.findIndex(m => m.id == id);
    
    if (existingIndex === -1) {
        // Tambah murid ke daftar pilihan
        selectedMurids.push({
            id: id,
            nama: nama,
            nisn: nisn,
            kelas: kelas
        });
    } else {
        // Hapus murid dari daftar pilihan
        selectedMurids.splice(existingIndex, 1);
    }
    
    updateDaftarMuridTerpilih();
    updateSelectedMuridIds();
}

function hapusMuridTerpilih(id) {
    const index = selectedMurids.findIndex(m => m.id == id);
    if (index !== -1) {
        selectedMurids.splice(index, 1);
        updateDaftarMuridTerpilih();
        updateSelectedMuridIds();
        
        // Update tombol di hasil pencarian jika masih ada
        const searchBtn = document.querySelector(`button[onclick*="togglePilihMurid(${id}"]`);
        if (searchBtn) {
            searchBtn.className = 'btn btn-sm btn-outline-primary';
            searchBtn.innerHTML = '<i class="fas fa-plus"></i> Pilih';
            searchBtn.disabled = false;
        }
    }
}

function updateDaftarMuridTerpilih() {
    const daftarDiv = document.getElementById('daftarMuridTerpilih');
    
    if (selectedMurids.length === 0) {
        daftarDiv.innerHTML = '<p class="text-muted mb-0">Belum ada murid yang dipilih</p>';
    } else {
        let html = '';
        selectedMurids.forEach(murid => {
            html += `
                <div class="d-flex justify-content-between align-items-center p-2 border rounded mb-2 bg-white">
                    <div>
                        <strong>${murid.nama}</strong><br>
                        <small class="text-muted">NISN: ${murid.nisn || '-'}</small>
                        ${murid.kelas ? `<br><small class="text-info">Kelas: ${murid.kelas}</small>` : ''}
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusMuridTerpilih(${murid.id})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        });
        daftarDiv.innerHTML = html;
    }
}

function updateSelectedMuridIds() {
    const ids = selectedMurids.map(m => m.id).join(',');
    document.getElementById('selectedMuridIds').value = ids;
}

// Event listener untuk pencarian dengan Enter
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchMurid');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                cariMurid();
            }
        });
    }
});

function viewOrangTua(id) {
    window.location.href = '<?= base_url('pengguna-orang-tua/view/') ?>' + id;
}

function editOrangTua(id) {
    window.location.href = '<?= base_url('pengguna-orang-tua/edit/') ?>' + id;
}

function deleteOrangTua(id) {
    if (confirm('Apakah Anda yakin ingin menghapus orang tua ini?')) {
        fetch('<?= base_url('pengguna-orang-tua/delete/') ?>' + id, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Orang tua berhasil dihapus');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function kelolaMurid(id) {
    window.location.href = '<?= base_url('pengguna-orang-tua/kelola-murid/') ?>' + id;
}

function exportData() {
    window.location.href = '<?= base_url('pengguna-orang-tua/export') ?>';
}

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>
<?= $this->endSection() ?>
