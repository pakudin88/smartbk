<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('assets/css/profile.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 animate-card">
            <i class="fas fa-user-circle text-primary me-2"></i> 
            Profil Pengguna
        </h1>
        <nav aria-label="breadcrumb" class="animate-card">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil</li>
            </ol>
        </nav>
    </div>

    <!-- Profile Header Card -->
    <div class="card info-card shadow-lg mb-4 animate-card">
        <div class="card-body p-0">
            <!-- Cover/Header Section -->
            <div class="position-relative">
                <div class="profile-cover rounded-top">
                    <div class="position-absolute" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
                        <i class="fas fa-user-shield text-white" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                </div>
                
                <!-- Profile Picture -->
                <div class="position-absolute" style="bottom: -50px; left: 50%; transform: translateX(-50%);">
                    <div class="profile-picture-wrapper">
                        <div class="bg-white rounded-circle p-1 shadow-lg">
                            <?php 
                            $profileImageUrl = base_url('assets/img/undraw_profile.svg'); // default image
                            if (!empty($user['profile_picture'])) {
                                $profilePath = base_url('uploads/profile_pictures/' . $user['profile_picture']);
                                // Check if file exists or use default
                                $profileImageUrl = $profilePath;
                            }
                            ?>
                            <img class="rounded-circle" src="<?= $profileImageUrl ?>" alt="Profile Picture" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <label for="profileImageUpload" class="position-absolute bottom-0 end-0 profile-edit-btn" title="Klik untuk mengubah foto profil">
                            <i class="fas fa-camera fa-sm"></i>
                        </label>
                        <input type="file" id="profileImageUpload" class="d-none" accept="image/*">
                    </div>
                </div>
            </div>
            
            <!-- Profile Info Section -->
            <div class="text-center pt-5 pb-4">
                <h2 class="h4 font-weight-bold text-gray-900 mb-1">
                    <?= esc($user['full_name'] ?? $user['username'] ?? 'Pengguna') ?>
                </h2>
                <p class="text-muted mb-2">
                    <i class="fas fa-crown text-warning me-1"></i>
                    <?= esc($user['role_name'] ?? 'Role') ?>
                </p>
                <div class="mt-3">
                    <span class="badge bg-success px-3 py-2 rounded-pill">
                        <i class="fas fa-circle fa-xs me-1"></i>
                        Status: Aktif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Details Grid -->
    <div class="row">
        <!-- Personal Information -->
        <div class="col-lg-8">
            <div class="card info-card shadow mb-4 animate-card">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Pribadi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0 text-gray-600">
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    Username
                                </h6>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-muted font-weight-500">
                                    <?= esc($user['username'] ?? 'N/A') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0 text-gray-600">
                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                    Email
                                </h6>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-muted font-weight-500">
                                    <?= esc($user['email'] ?? 'N/A') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0 text-gray-600">
                                    <i class="fas fa-id-card me-2 text-primary"></i>
                                    Nama Lengkap
                                </h6>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-muted font-weight-500">
                                    <?= esc($user['full_name'] ?? 'N/A') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0 text-gray-600">
                                    <i class="fas fa-shield-alt me-2 text-primary"></i>
                                    Role
                                </h6>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge-custom">
                                    <i class="fas fa-crown me-1"></i>
                                    <?= esc($user['role_name'] ?? 'Role') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0 text-gray-600">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                    Terdaftar
                                </h6>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-muted font-weight-500">
                                    <?= esc($user['created_at'] ? date('d F Y, H:i', strtotime($user['created_at'])) : 'N/A') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0 text-gray-600">
                                    <i class="fas fa-clock me-2 text-primary"></i>
                                    Terakhir Login
                                </h6>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-muted font-weight-500">
                                    <?= esc($user['last_login'] ? date('d F Y, H:i', strtotime($user['last_login'])) : 'Belum pernah login') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card info-card shadow mb-4 animate-card">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i>
                        Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <button type="button" class="btn btn-primary action-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-2"></i>
                            Edit Profile
                        </button>
                        <button type="button" class="btn btn-warning action-btn text-white" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-2"></i>
                            Ubah Password
                        </button>
                        <a href="<?= base_url('settings') ?>" class="btn btn-info action-btn">
                            <i class="fas fa-cog me-2"></i>
                            Pengaturan
                        </a>
                        <button type="button" class="btn btn-secondary action-btn" onclick="downloadProfileData()">
                            <i class="fas fa-download me-2"></i>
                            Download Data
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card info-card shadow mb-4 animate-card">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line me-2"></i>
                        Statistik Akun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stats-card border-end">
                                <div class="h4 font-weight-bold text-primary mb-1">
                                    <?= date('d') ?>
                                </div>
                                <div class="text-muted small">
                                    Hari Aktif
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card">
                                <div class="h4 font-weight-bold text-success mb-1">
                                    100%
                                </div>
                                <div class="text-muted small">
                                    Uptime
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="row text-center">
                        <div class="col-12">
                            <div class="stats-card">
                                <div class="h5 font-weight-bold text-info mb-1">
                                    ID: <?= esc($user['id'] ?? 'N/A') ?>
                                </div>
                                <div class="text-muted small">
                                    User ID
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    Edit Profile
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProfileForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editUsername" class="form-label">
                                    <i class="fas fa-user me-2"></i>Username
                                </label>
                                <input type="text" class="form-control" id="editUsername" name="username" value="<?= esc($user['username'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                <input type="email" class="form-control" id="editEmail" name="email" value="<?= esc($user['email'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editFullName" class="form-label">
                            <i class="fas fa-id-card me-2"></i>Nama Lengkap
                        </label>
                        <input type="text" class="form-control" id="editFullName" name="full_name" value="<?= esc($user['full_name'] ?? '') ?>" required>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong> Perubahan akan disimpan secara otomatis setelah Anda klik "Simpan Perubahan".
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="changePasswordModalLabel">
                    <i class="fas fa-key me-2"></i>
                    Ubah Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changePasswordForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password Lama
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('currentPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">
                            <i class="fas fa-key me-2"></i>Password Baru
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" name="new_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('newPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="password-strength-bar"></div>
                        </div>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Password minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">
                            <i class="fas fa-check-circle me-2"></i>Konfirmasi Password Baru
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirmPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Setelah mengubah password, Anda akan diminta untuk login kembali.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning text-white">
                        <i class="fas fa-save me-2"></i>Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Enhanced profile image preview with auto-save functionality
document.getElementById('profileImageUpload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            showToast('Tipe file tidak didukung. Pilih file JPG, PNG, GIF, atau WebP.', 'error');
            return;
        }
        
        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            showToast('Ukuran file terlalu besar. Maksimal 5MB.', 'error');
            return;
        }
        
        // Show loading state
        const imgElement = document.querySelector('.profile-picture-wrapper img');
        const originalSrc = imgElement.src;
        
        // Add loading overlay
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
        loadingOverlay.style.cssText = 'background: rgba(255,255,255,0.8); border-radius: 50%; z-index: 10;';
        loadingOverlay.innerHTML = '<i class="fas fa-spinner fa-spin text-primary"></i>';
        imgElement.parentElement.appendChild(loadingOverlay);
        
        // Create FormData for AJAX upload
        const formData = new FormData();
        formData.append('profile_picture', file);
        
        // Send AJAX request to upload and save
        fetch('<?= base_url('users/update-profile-picture') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update image source with new uploaded image
                imgElement.src = data.file_url;
                imgElement.parentElement.removeChild(loadingOverlay);
                
                // Add success animation
                imgElement.classList.add('profile-picture-success');
                setTimeout(() => {
                    imgElement.classList.remove('profile-picture-success');
                }, 600);
                
                showToast('Foto profil berhasil diperbarui dan disimpan!', 'success');
                
                // Update any other profile pictures on the page
                document.querySelectorAll('img[src*="undraw_profile"]').forEach(img => {
                    if (img !== imgElement) {
                        img.src = data.file_url;
                    }
                });
                
                // Update topbar avatar
                const topbarAvatar = document.querySelector('.user-avatar');
                if (topbarAvatar) {
                    // Remove existing content
                    topbarAvatar.innerHTML = '';
                    
                    // Add new profile image
                    const avatarImg = document.createElement('img');
                    avatarImg.src = data.file_url;
                    avatarImg.alt = 'Profile Picture';
                    avatarImg.loading = 'lazy';
                    topbarAvatar.appendChild(avatarImg);
                }
            } else {
                // Revert to original image on error
                imgElement.src = originalSrc;
                imgElement.parentElement.removeChild(loadingOverlay);
                showToast(data.message || 'Gagal mengupload foto profil', 'error');
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
            imgElement.src = originalSrc;
            imgElement.parentElement.removeChild(loadingOverlay);
            showToast('Terjadi kesalahan saat mengupload foto profil', 'error');
        });
    }
});

// Toast notification function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white border-0 position-fixed toast-custom`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 1055; min-width: 300px;';
    toast.setAttribute('role', 'alert');
    
    let bgClass = 'bg-info';
    let icon = 'fas fa-info-circle';
    
    switch(type) {
        case 'success':
            bgClass = 'bg-success';
            icon = 'fas fa-check-circle';
            break;
        case 'error':
            bgClass = 'bg-danger';
            icon = 'fas fa-exclamation-circle';
            break;
        case 'warning':
            bgClass = 'bg-warning';
            icon = 'fas fa-exclamation-triangle';
            break;
    }
    
    toast.classList.add(bgClass);
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="${icon} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Initialize and show toast
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 4000
    });
    bsToast.show();
    
    // Remove toast after hiding
    toast.addEventListener('hidden.bs.toast', function() {
        if (document.body.contains(toast)) {
            document.body.removeChild(toast);
        }
    });
}

// Toggle password visibility
function togglePasswordVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    const button = field.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Download profile data
function downloadProfileData() {
    const profileData = {
        id: <?= json_encode($user['id'] ?? '') ?>,
        username: <?= json_encode($user['username'] ?? '') ?>,
        email: <?= json_encode($user['email'] ?? '') ?>,
        full_name: <?= json_encode($user['full_name'] ?? '') ?>,
        role: <?= json_encode($user['role_name'] ?? '') ?>,
        created_at: <?= json_encode($user['created_at'] ?? '') ?>,
        last_login: <?= json_encode($user['last_login'] ?? '') ?>
    };
    
    const dataStr = JSON.stringify(profileData, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });
    const url = URL.createObjectURL(dataBlob);
    
    const link = document.createElement('a');
    link.href = url;
    link.download = `profile_data_${profileData.username}_${new Date().toISOString().split('T')[0]}.json`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    
    showToast('Data profil berhasil diunduh!', 'success');
}

// Handle edit profile form submission
document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const loadingBtn = this.querySelector('button[type="submit"]');
    const originalText = loadingBtn.innerHTML;
    
    loadingBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    loadingBtn.disabled = true;
    
    fetch('<?= base_url("users/update-profile") ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_token() ?>'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            
            // Update displayed data dengan data yang berubah
            const changes = data.changes || {};
            
            if (changes.username) {
                const usernameElement = document.querySelector('.info-row:nth-child(1) .text-muted');
                if (usernameElement) usernameElement.textContent = changes.username;
                // Update global data
                currentUserData.username = changes.username;
            }
            
            if (changes.email) {
                const emailElement = document.querySelector('.info-row:nth-child(2) .text-muted');
                if (emailElement) emailElement.textContent = changes.email;
                // Update global data
                currentUserData.email = changes.email;
            }
            
            if (changes.full_name) {
                const fullNameElement = document.querySelector('.info-row:nth-child(3) .text-muted');
                if (fullNameElement) fullNameElement.textContent = changes.full_name;
                
                // Update nama di header profil
                const headerNameElement = document.querySelector('.h4.font-weight-bold');
                if (headerNameElement) {
                    headerNameElement.textContent = changes.full_name;
                }
                
                // Update nama di dropdown header topbar
                const dropdownHeaderElement = document.querySelector('.dropdown-header');
                if (dropdownHeaderElement) {
                    dropdownHeaderElement.textContent = changes.full_name;
                }
                
                // Update global data
                currentUserData.full_name = changes.full_name;
            }
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
            
            // Update form dengan data terbaru untuk edit selanjutnya
            // Tidak perlu reset form, langsung update dengan data terbaru
            if (data.data) {
                // Update global data dengan semua data terbaru
                currentUserData = {
                    username: data.data.username || currentUserData.username,
                    email: data.data.email || currentUserData.email,
                    full_name: data.data.full_name || currentUserData.full_name
                };
                
                console.log('Updated currentUserData:', currentUserData);
            }
        } else {
            // Tampilkan pesan error yang detail
            showToast(data.message || 'Gagal memperbarui profil!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan jaringan: ' + error.message, 'error');
    })
    .finally(() => {
        loadingBtn.innerHTML = originalText;
        loadingBtn.disabled = false;
    });
});

// Handle change password form submission
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    // Validate password match
    if (newPassword !== confirmPassword) {
        showToast('Konfirmasi password tidak cocok!', 'error');
        return;
    }
    
    // Validate password strength
    if (newPassword.length < 8) {
        showToast('Password minimal 8 karakter!', 'error');
        return;
    }
    
    const formData = new FormData(this);
    const loadingBtn = this.querySelector('button[type="submit"]');
    const originalText = loadingBtn.innerHTML;
    
    loadingBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengubah...';
    loadingBtn.disabled = true;
    
    fetch('<?= base_url("users/change-password") ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_token() ?>'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Password berhasil diubah! Silakan login kembali.', 'success');
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('changePasswordModal')).hide();
            
            // Redirect to login after delay
            setTimeout(() => {
                window.location.href = '<?= base_url("auth/logout") ?>';
            }, 2000);
        } else {
            showToast(data.message || 'Gagal mengubah password!', 'error');
        }
    })
    .catch(error => {
        showToast('Terjadi kesalahan: ' + error.message, 'error');
    })
    .finally(() => {
        loadingBtn.innerHTML = originalText;
        loadingBtn.disabled = false;
    });
});

// Add smooth hover effects
document.querySelectorAll('.action-btn').forEach(btn => {
    btn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px) scale(1.02)';
    });
    
    btn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});

// Add parallax effect to cover
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const cover = document.querySelector('.profile-cover');
    if (cover) {
        cover.style.transform = `translateY(${scrolled * 0.3}px)`;
    }
});

// Add typing animation to user name
function typeWriterEffect(element, text, speed = 100) {
    element.textContent = '';
    let i = 0;
    const timer = setInterval(() => {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
        } else {
            clearInterval(timer);
        }
    }, speed);
}

// Initialize typing effect on page load
document.addEventListener('DOMContentLoaded', function() {
    const userName = document.querySelector('.h4.font-weight-bold');
    if (userName) {
        const originalText = userName.textContent;
        typeWriterEffect(userName, originalText, 50);
    }
});

// Add progressive loading animation
function animateElements() {
    const elements = document.querySelectorAll('.animate-card');
    elements.forEach((element, index) => {
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 200);
    });
}

// Global variable untuk menyimpan data user terbaru
let currentUserData = {
    username: <?= json_encode($user['username'] ?? '') ?>,
    email: <?= json_encode($user['email'] ?? '') ?>,
    full_name: <?= json_encode($user['full_name'] ?? '') ?>
};

// Initialize animations
document.addEventListener('DOMContentLoaded', function() {
    // Initially hide animated elements
    document.querySelectorAll('.animate-card').forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'all 0.6s ease-out';
    });
    
    // Animate elements after short delay
    setTimeout(animateElements, 200);
});

// Update form dengan data terbaru saat modal dibuka
document.getElementById('editProfileModal').addEventListener('show.bs.modal', function() {
    console.log('Modal opened, current data:', currentUserData);
    
    // Isi form dengan data terbaru
    document.getElementById('editUsername').value = currentUserData.username || '';
    document.getElementById('editEmail').value = currentUserData.email || '';
    document.getElementById('editFullName').value = currentUserData.full_name || '';
    
    // Visual feedback bahwa form telah diisi
    setTimeout(() => {
        const inputs = document.querySelectorAll('#editProfileForm .form-control');
        inputs.forEach(input => {
            if (input.value) {
                input.classList.add('is-valid');
            }
        });
    }, 100);
});

// Reset modal edit profile saat ditutup
document.getElementById('editProfileModal').addEventListener('hidden.bs.modal', function() {
    const form = document.getElementById('editProfileForm');
    
    // Reset validasi visual
    const inputs = form.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });
});

// Reset modal change password saat ditutup
document.getElementById('changePasswordModal').addEventListener('hidden.bs.modal', function() {
    const form = document.getElementById('changePasswordForm');
    form.reset();
    
    // Reset validasi visual
    const inputs = form.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });
});

// Validasi real-time untuk form edit profile
document.getElementById('editUsername').addEventListener('input', function() {
    const value = this.value.trim();
    if (value.length < 3) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else {
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
    }
});

document.getElementById('editEmail').addEventListener('input', function() {
    const value = this.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(value)) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else {
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
    }
});

document.getElementById('editFullName').addEventListener('input', function() {
    const value = this.value.trim();
    if (value.length < 2) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else {
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
    }
});

// Validasi real-time untuk form change password
document.getElementById('newPassword').addEventListener('input', function() {
    const value = this.value;
    const strengthBar = document.querySelector('.password-strength-bar');
    
    if (value.length === 0) {
        this.classList.remove('is-valid', 'is-invalid');
        if (strengthBar) strengthBar.style.width = '0%';
        return;
    }
    
    if (value.length < 8) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
        if (strengthBar) {
            strengthBar.className = 'password-strength-bar password-strength-weak';
            strengthBar.style.width = '33%';
        }
    } else {
        // Check password strength
        let strength = 0;
        if (/[a-z]/.test(value)) strength++;
        if (/[A-Z]/.test(value)) strength++;
        if (/[0-9]/.test(value)) strength++;
        if (/[^A-Za-z0-9]/.test(value)) strength++;
        
        if (strength >= 3) {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
            if (strengthBar) {
                strengthBar.className = 'password-strength-bar password-strength-strong';
                strengthBar.style.width = '100%';
            }
        } else if (strength >= 2) {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
            if (strengthBar) {
                strengthBar.className = 'password-strength-bar password-strength-medium';
                strengthBar.style.width = '66%';
            }
        } else {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
            if (strengthBar) {
                strengthBar.className = 'password-strength-bar password-strength-weak';
                strengthBar.style.width = '33%';
            }
        }
    }
});

document.getElementById('confirmPassword').addEventListener('input', function() {
    const newPassword = document.getElementById('newPassword').value;
    if (this.value !== newPassword || this.value.length === 0) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else {
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
    }
});
</script>
<?= $this->endSection() ?>
