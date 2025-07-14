<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Card -->
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-child"></i> Kelola Murid - <?= esc($orangTua['nama_lengkap']) ?>
                            </h4>
                            <p class="card-text mb-0">Mengelola hubungan orang tua dengan murid/anak</p>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('pengguna-orang-tua') ?>" class="btn btn-light">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Info Orang Tua -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Informasi Orang Tua</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="120"><strong>Nama</strong></td>
                                            <td>: <?= esc($orangTua['nama_lengkap']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Username</strong></td>
                                            <td>: <?= esc($orangTua['username']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td>: <?= esc($orangTua['email'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Hubungan</strong></td>
                                            <td>: 
                                                <?php 
                                                $badgeClass = '';
                                                switch($orangTua['hubungan_keluarga']) {
                                                    case 'Ayah': $badgeClass = 'bg-primary'; break;
                                                    case 'Ibu': $badgeClass = 'bg-pink'; break;
                                                    case 'Wali': $badgeClass = 'bg-secondary'; break;
                                                    default: $badgeClass = 'bg-secondary';
                                                }
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><?= esc($orangTua['hubungan_keluarga']) ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>No. Telepon</strong></td>
                                            <td>: <?= esc($orangTua['no_telepon'] ?? '-') ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h2 class="mb-2"><?= count($muridTerhubung) ?></h2>
                                    <h6 class="mb-0">Total Anak Terhubung</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tambah Murid -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-plus"></i> Tambah Murid</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="searchMuridKelola" 
                                               placeholder="Ketik nama atau NISN murid untuk mencari...">
                                        <button type="button" class="btn btn-outline-primary" onclick="cariMuridKelola()">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="hasilCariMuridKelola" style="display: none;" class="mt-3">
                                <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                                    <!-- Hasil pencarian akan muncul di sini -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Murid Terhubung -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-list"></i> Daftar Murid Terhubung</h6>
                        </div>
                        <div class="card-body">
                            <?php if (empty($muridTerhubung)): ?>
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-child fa-3x mb-3"></i>
                                    <p>Belum ada murid yang terhubung dengan orang tua ini</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Foto</th>
                                                <th>Nama Lengkap</th>
                                                <th>NISN</th>
                                                <th>Kelas</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach ($muridTerhubung as $murid): ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td>
                                                        <img src="<?= base_url('uploads/profiles/' . ($murid['profile_picture'] ?? 'default.png')) ?>" 
                                                             alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                    </td>
                                                    <td><?= esc($murid['nama_lengkap']) ?></td>
                                                    <td><?= esc($murid['nisn']) ?></td>
                                                    <td>
                                                        <?php if (isset($murid['nama_kelas']) && $murid['nama_kelas']): ?>
                                                            <span class="badge bg-info"><?= esc($murid['nama_kelas']) ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Belum ada kelas</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($murid['is_active']): ?>
                                                            <span class="badge bg-success">Aktif</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Nonaktif</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                                    onclick="viewMurid(<?= $murid['id'] ?>)">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                                    onclick="hapusHubunganMurid(<?= $murid['id'] ?>, '<?= esc($murid['nama_lengkap']) ?>')">
                                                                <i class="fas fa-unlink"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function cariMuridKelola() {
    const searchTerm = document.getElementById('searchMuridKelola').value.trim();
    const hasilDiv = document.getElementById('hasilCariMuridKelola');
    
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
                // Cek apakah murid sudah terhubung
                const sudahTerhubung = <?= json_encode(array_column($muridTerhubung, 'id')) ?>.includes(murid.id);
                const btnClass = sudahTerhubung ? 'btn-secondary' : 'btn-success';
                const btnText = sudahTerhubung ? 'Sudah Terhubung' : 'Tambah';
                const btnIcon = sudahTerhubung ? 'fas fa-check' : 'fas fa-plus';
                
                html += `
                    <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                        <div>
                            <strong>${murid.nama_lengkap}</strong><br>
                            <small class="text-muted">NISN: ${murid.nisn || '-'}</small>
                            ${murid.nama_kelas ? `<br><small class="text-info">Kelas: ${murid.nama_kelas}</small>` : ''}
                        </div>
                        <button type="button" class="btn btn-sm ${btnClass}" 
                                onclick="tambahMuridKeOrangTua(${murid.id}, '${murid.nama_lengkap}')"
                                ${sudahTerhubung ? 'disabled' : ''}>
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

function tambahMuridKeOrangTua(muridId, namaMurid) {
    if (confirm(`Apakah Anda yakin ingin menambahkan ${namaMurid} sebagai anak dari <?= esc($orangTua['nama_lengkap']) ?>?`)) {
        const formData = new FormData();
        formData.append('orang_tua_id', <?= $orangTua['id'] ?>);
        formData.append('murid_id', muridId);
        
        fetch('<?= base_url('pengguna-orang-tua/tambah-murid') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        });
    }
}

function hapusHubunganMurid(muridId, namaMurid) {
    if (confirm(`Apakah Anda yakin ingin menghapus hubungan ${namaMurid} dengan <?= esc($orangTua['nama_lengkap']) ?>?`)) {
        const formData = new FormData();
        formData.append('orang_tua_id', <?= $orangTua['id'] ?>);
        formData.append('murid_id', muridId);
        
        fetch('<?= base_url('pengguna-orang-tua/hapus-murid') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        });
    }
}

function viewMurid(id) {
    window.location.href = '<?= base_url('pengguna-murid/view/') ?>' + id;
}

// Event listener untuk pencarian dengan Enter
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchMuridKelola');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                cariMuridKelola();
            }
        });
    }
});
</script>
<?= $this->endSection() ?>
