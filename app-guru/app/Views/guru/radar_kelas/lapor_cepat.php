<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header-modern">
    <div class="page-header-icon">
        <i class="fas fa-bolt"></i>
    </div>
    <div class="page-header-title">
        <h1 class="page-title">Lapor Cepat & Senyap</h1>
        <p class="page-subtitle">Laporkan kekhawatiran tentang siswa dengan cepat dan aman.</p>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('/radar-kelas') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>
</div>

<div class="container-fluid">
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading"><i class="fas fa-ban me-2"></i>Validasi Gagal</h6>
            <ul class="mb-0 ps-4">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Main Form Column -->
        <div class="col-lg-8">
            <div class="content-card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-file-alt me-2"></i>Formulir Laporan</h5>
                    <small class="card-subtitle">Isi semua field yang ditandai dengan <span class="text-danger">*</span></small>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/radar-kelas/simpan-laporan') ?>" method="POST" id="laporanForm">
                        <?= csrf_field() ?>
                        
                        <!-- Filter Kelas -->
                        <div class="mb-3 form-floating">
                            <select class="form-select" id="filter_kelas">
                                <option value="">-- Tampilkan Semua Kelas --</option>
                                <?php foreach ($daftarKelas as $kelas): ?>
                                    <option value="<?= esc($kelas->class_name) ?>"><?= esc($kelas->class_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="filter_kelas"><i class="fas fa-chalkboard-teacher me-2"></i>Filter Berdasarkan Kelas</label>
                        </div>

                        <!-- Pilih Siswa -->
                        <div class="mb-4 form-floating">
                            <select class="form-select" id="siswa_id" name="siswa_id" required>
                                <option value="">-- Pilih Siswa --</option>
                                <?php foreach ($daftarSiswa as $siswa): ?>
                                    <option value="<?= $siswa->id ?>" data-kelas="<?= esc($siswa->class_name) ?>" <?= (old('siswa_id') == $siswa->id) ? 'selected' : '' ?>>
                                        <?= esc($siswa->full_name) ?> (NIS: <?= esc($siswa->username) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label for="siswa_id"><i class="fas fa-user-graduate me-2"></i>Siswa yang Dilaporkan <span class="text-danger">*</span></label>
                        </div>

                        <!-- Kategori Masalah -->
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-tags me-2"></i>Kategori Masalah <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                <?php 
                                $kategori_options = [
                                    'Akademik' => ['icon' => 'fa-book-open', 'desc' => 'Kesulitan belajar, nilai turun, dll.'],
                                    'Sosial' => ['icon' => 'fa-users', 'desc' => 'Masalah pertemanan, penarikan diri.'],
                                    'Perilaku' => ['icon' => 'fa-user-shield', 'desc' => 'Perilaku disruptif, tidak disiplin.']
                                ];
                                foreach ($kategori_options as $key => $val):
                                ?>
                                <div class="col-md-4">
                                    <div class="category-card-radio">
                                        <input type="radio" name="kategori" value="<?= $key ?>" id="cat_<?= strtolower($key) ?>" <?= (old('kategori') == $key) ? 'checked' : '' ?> required>
                                        <label for="cat_<?= strtolower($key) ?>" class="category-label">
                                            <div class="category-icon"><i class="fas <?= $val['icon'] ?>"></i></div>
                                            <div class="category-text">
                                                <strong><?= $key ?></strong>
                                                <small><?= $val['desc'] ?></small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Tingkat Prioritas -->
                        <div class="mb-4 form-floating">
                            <select class="form-select" id="tingkat_prioritas" name="tingkat_prioritas" required>
                                <option value="">-- Pilih Tingkat Prioritas --</option>
                                <option value="Rendah" data-icon="fas fa-circle text-success" <?= (old('tingkat_prioritas') == 'Rendah') ? 'selected' : '' ?>>Rendah - Perlu pemantauan</option>
                                <option value="Sedang" data-icon="fas fa-circle text-warning" <?= (old('tingkat_prioritas') == 'Sedang') ? 'selected' : '' ?>>Sedang - Perlu perhatian</option>
                                <option value="Tinggi" data-icon="fas fa-circle text-danger" <?= (old('tingkat_prioritas') == 'Tinggi') ? 'selected' : '' ?>>Tinggi - Perlu tindakan segera</option>
                            </select>
                            <label for="tingkat_prioritas"><i class="fas fa-flag me-2"></i>Tingkat Prioritas <span class="text-danger">*</span></label>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label"><i class="fas fa-edit me-2"></i>Deskripsi Rinci <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="6" placeholder="Jelaskan secara objektif perilaku atau kejadian yang Anda amati. Sertakan waktu, tempat, dan pihak lain yang terlibat jika relevan." required minlength="20" maxlength="1000"><?= old('deskripsi') ?></textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="form-text text-muted">Minimal 20 karakter.</small>
                                <small class="form-text text-muted"><span id="charCount">0</span>/1000</small>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="<?= base_url('/radar-kelas') ?>" class="btn btn-outline-secondary me-3">Batal</a>
                            <button type="submit" class="btn btn-danger btn-lg" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Laporan Rahasia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <div class="content-card sticky-top" style="top: 90px;">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-shield-alt me-2"></i>Kerahasiaan Terjamin</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        Laporan ini bersifat <strong>rahasia</strong>. Identitas Anda sebagai pelapor hanya akan diketahui oleh pihak yang berwenang (Wali Kelas & Guru BK) untuk proses tindak lanjut. 
                        Sistem memastikan keamanan data Anda.
                    </p>
                    <hr>
                    <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Panduan Singkat</h6>
                    <ul class="list-unstyled guide-list">
                        <li><i class="fas fa-check-circle text-success"></i><span><strong>Objektif:</strong> Laporkan fakta, bukan opini.</span></li>
                        <li><i class="fas fa-check-circle text-success"></i><span><strong>Spesifik:</strong> Berikan contoh perilaku yang jelas.</span></li>
                        <li><i class="fas fa-check-circle text-success"></i><span><strong>Lengkap:</strong> Isi semua informasi yang dibutuhkan.</span></li>
                        <li><i class="fas fa-check-circle text-success"></i><span><strong>Tepat Waktu:</strong> Laporkan sesegera mungkin.</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .page-header-modern {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        background-color: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        margin-bottom: 2rem;
    }
    .page-header-icon {
        font-size: 2rem;
        color: var(--primary-blue);
        margin-right: 1.5rem;
    }
    .page-header-title .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }
    .page-header-title .page-subtitle {
        font-size: 1rem;
        color: var(--text-secondary);
        margin: 0;
    }

    .content-card {
        background-color: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }
    .content-card .card-header {
        background-color: var(--gray-50);
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }
    .content-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }
    .content-card .card-subtitle {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin: 0;
    }
    .content-card .card-body {
        padding: 1.5rem;
    }

    /* Category Radio Cards */
    .category-card-radio {
        position: relative;
    }
    .category-card-radio input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .category-card-radio .category-label {
        display: flex;
        align-items: center;
        padding: 1rem;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .category-card-radio .category-icon {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 1rem;
        color: var(--white);
        background: var(--primary-gradient);
    }
    .category-card-radio .category-text strong {
        display: block;
        font-weight: 600;
        color: var(--text-primary);
    }
    .category-card-radio .category-text small {
        color: var(--text-secondary);
    }
    .category-card-radio input[type="radio"]:checked + .category-label {
        border-color: var(--primary-blue);
        background-color: var(--light-blue);
        box-shadow: 0 0 0 3px var(--primary-blue-light);
    }
    .category-card-radio input[type="radio"]:hover + .category-label {
        border-color: var(--primary-blue-light);
    }

    /* Select2 Customization */
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 58px; /* Match floating label height */
        padding-top: 1.625rem;
        padding-bottom: 0.625rem;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        padding-left: 0.5rem;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 50%;
        transform: translateY(-50%);
    }

    /* Guide List */
    .guide-list li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }
    .guide-list i {
        margin-top: 4px;
        margin-right: 10px;
    }

    @media (max-width: 991.98px) {
        .page-header-modern {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Store original options
    const siswaSelect = document.getElementById('siswa_id');
    const originalSiswaOptions = Array.from(siswaSelect.options);

    // Initialize Select2
    const siswaSelect2 = $('#siswa_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Ketik untuk mencari nama atau NIS siswa...',
        width: '100%',
    });

    // Filter logic
    const filterKelas = document.getElementById('filter_kelas');
    filterKelas.addEventListener('change', function() {
        const selectedKelas = this.value;
        
        // Clear current options
        siswaSelect.innerHTML = '';

        // Filter and add options
        originalSiswaOptions.forEach(option => {
            if (option.value === "" || !selectedKelas || option.dataset.kelas === selectedKelas) {
                siswaSelect.add(option.cloneNode(true));
            }
        });

        // Reset Select2 value
        siswaSelect2.val(null).trigger('change');
    });

    // Character counter for textarea
    const textarea = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');
    const minLength = 20;
    const maxLength = 1000;

    function updateCharCount() {
        const currentLength = textarea.value.length;
        charCount.textContent = currentLength;
        if (currentLength < minLength) {
            charCount.parentElement.classList.add('text-danger');
        } else {
            charCount.parentElement.classList.remove('text-danger');
        }
    }
    textarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Initial call

    // Form submission confirmation
    const form = document.getElementById('laporanForm');
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        if (!confirm('Apakah Anda yakin ingin mengirim laporan ini? Pastikan semua informasi sudah benar. Laporan akan dikirim secara rahasia.')) {
            e.preventDefault();
        }
    });
});
</script>
<?= $this->endSection() ?>