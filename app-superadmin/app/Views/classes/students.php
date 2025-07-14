<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Siswa di Kelas <?= esc($class['nama_kelas']) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('classes') ?>">Data Kelas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Siswa</li>
            </ol>
        </nav>
    </div>
    <a href="<?= base_url('classes') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Class Info Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Kelas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Nama Kelas:</strong><br>
                        <?= esc($class['nama_kelas']) ?>
                    </div>
                    <div class="col-md-3">
                        <strong>Sekolah:</strong><br>
                        <?= esc($class['nama_sekolah']) ?>
                    </div>
                    <div class="col-md-2">
                        <strong>Tingkat:</strong><br>
                        <?= esc($class['tingkat']) ?>
                    </div>
                    <div class="col-md-2">
                        <strong>Jurusan:</strong><br>
                        <?= esc($class['jurusan']) ?: '-' ?>
                    </div>
                    <div class="col-md-2">
                        <strong>Kapasitas:</strong><br>
                        <div class="progress mt-1" style="height: 20px;">
                            <div class="progress-bar bg-info" role="progressbar" 
                                 style="width: <?= $capacityInfo['persentase'] ?>%"
                                 aria-valuenow="<?= $capacityInfo['terisi'] ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="<?= $capacityInfo['kapasitas'] ?>">
                                <?= $capacityInfo['terisi'] ?>/<?= $capacityInfo['kapasitas'] ?>
                            </div>
                        </div>
                        <small class="text-muted">
                            <?= $capacityInfo['persentase'] ?>% terisi
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Students List -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Siswa</h5>
        <div>
            <span class="badge bg-primary me-2">
                Total: <?= count($students) ?> siswa
            </span>
            <?php if ($capacityInfo['tersisa'] > 0): ?>
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    <i class="fas fa-plus me-1"></i>Tambah Siswa
                </button>
            <?php else: ?>
                <span class="badge bg-warning">Kelas Penuh</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN/Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $index => $student): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($student['username'] ?? $student['email'] ?? 'N/A') ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <?php if (!empty($student['profile_picture'])): ?>
                                                <img src="<?= base_url('uploads/profile_pictures/' . $student['profile_picture']) ?>" 
                                                     class="rounded-circle" width="32" height="32" alt="Avatar">
                                            <?php else: ?>
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 32px; height: 32px; font-size: 14px;">
                                                    <?= strtoupper(substr($student['nama_lengkap'] ?? $student['full_name'] ?? $student['nama'] ?? 'N', 0, 1)) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?= esc($student['nama_lengkap'] ?? $student['full_name'] ?? $student['nama'] ?? 'Tidak ada nama') ?>
                                    </div>
                                </td>
                                <td><?= esc($student['email'] ?? '') ?></td>
                                <td>
                                    <?php if ($student['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($student['created_at'])) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('users/view/' . $student['id']) ?>" 
                                           class="btn btn-sm btn-info" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('classes/remove-student/' . $class['id'] . '/' . $student['id']) ?>" 
                                           class="btn btn-sm btn-danger"
                                           title="Keluarkan dari Kelas"
                                           onclick="return confirm('Apakah Anda yakin ingin mengeluarkan siswa ini dari kelas?')">
                                            <i class="fas fa-user-minus"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="py-4">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada siswa di kelas ini</h5>
                                    <p class="text-muted">Klik tombol "Tambah Siswa" untuk mulai menambahkan siswa ke kelas ini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Tambah Siswa ke Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addStudentForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Pilih Siswa</label>
                        <select class="form-select" id="student_id" name="student_id" required>
                            <option value="">-- Pilih Siswa --</option>
                            <!-- Options will be loaded via AJAX -->
                        </select>
                        <div class="form-text">Hanya siswa yang belum memiliki kelas yang ditampilkan.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah ke Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Load available students when modal is opened
document.getElementById('addStudentModal').addEventListener('show.bs.modal', function() {
    // Add a cache-busting parameter to prevent browser caching
    const url = `<?= base_url('api/studentsWithoutClass') ?>?_=${new Date().getTime()}`;
    
    const select = document.getElementById('student_id');
    select.innerHTML = '<option value="">Memuat data siswa...</option>';
    select.disabled = true;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            select.innerHTML = '<option value="">-- Pilih Siswa --</option>';
            
            console.log('API Response (Students without class):', data); // For debugging

            if (data.success && data.students.length > 0) {
                data.students.forEach(student => {
                    const option = document.createElement('option');
                    option.value = student.id;
                    const studentName = student.full_name || student.nama_lengkap || student.nama || 'Nama Tidak Diketahui';
                    const studentIdentifier = student.username || student.email || student.nisn || `ID: ${student.id}`;
                    option.textContent = `${studentName} (${studentIdentifier})`;
                    select.appendChild(option);
                });
                select.disabled = false;
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = data.message || 'Tidak ada siswa yang tersedia';
                option.disabled = true;
                select.appendChild(option);
            }
        })
        .catch(error => {
            console.error('Error loading students:', error);
            select.innerHTML = '<option value="">Gagal memuat data siswa</option>';
            select.disabled = true;
        });
});

// Handle form submission
document.getElementById('addStudentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const studentId = formData.get('student_id');
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;

    if (!studentId) {
        alert('Silakan pilih siswa terlebih dahulu.');
        return;
    }
    
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menambahkan...';
    submitButton.disabled = true;
    
    fetch('<?= base_url('classes/assign-student/' . $class['id']) ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Assign student response:', data); // For debugging

        // Show the specific message from the server
        alert(data.message || 'Sebuah kesalahan terjadi.'); 

        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('addStudentModal'));
            if (modal) {
                modal.hide();
            }
            // Give a moment for the modal to close before reloading
            setTimeout(() => {
                location.reload();
            }, 300);
        }
    })
    .catch(error => {
        console.error('Error assigning student:', error);
        alert('Terjadi kesalahan teknis. Silakan cek konsol browser untuk detail.');
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
});
</script>
<?= $this->endSection() ?>
