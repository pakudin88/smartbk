<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-exclamation-triangle me-3"></i>Lapor Cepat & Senyap
        </h1>
        <p class="page-subtitle">Laporkan kekhawatiran tentang siswa dengan cepat dan aman</p>
    </div>
    <div>
        <a href="<?= base_url('/radar-kelas') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <h6><i class="fas fa-exclamation-triangle me-2"></i>Periksa input Anda:</h6>
        <ul class="mb-0 ps-3">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="dashboard-card">
            <div class="card-body p-4">
                <div class="alert alert-warning">
                    <i class="fas fa-shield-alt me-2"></i>
                    <strong>Laporan Rahasia & Aman</strong><br>
                    Laporan ini akan dikirim secara otomatis dan rahasia hanya kepada Wali Kelas dan Guru BK. 
                    Identitas Anda sebagai pelapor akan dijaga kerahasiaannya.
                </div>

                <form action="<?= base_url('/radar-kelas/simpan-laporan') ?>" method="POST" id="laporanForm">
                    <?= csrf_field() ?>
                    
                    <!-- Pilih Siswa -->
                    <div class="mb-4">
                        <label for="siswa_id" class="form-label">
                            <i class="fas fa-user me-2"></i>Pilih Siswa <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="siswa_id" name="siswa_id" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php foreach ($daftarSiswa as $siswa): ?>
                                <option value="<?= $siswa->id ?>" <?= (old('siswa_id') == $siswa->id) ? 'selected' : '' ?>>
                                    <?= esc($siswa->full_name) ?> (<?= esc($siswa->username) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Kategori Masalah -->
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-tags me-2"></i>Kategori Masalah <span class="text-danger">*</span>
                        </label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="category-card <?= (old('kategori') == 'Akademik') ? 'selected' : '' ?>" data-category="Akademik">
                                    <input type="radio" name="kategori" value="Akademik" id="akademik" <?= (old('kategori') == 'Akademik') ? 'checked' : '' ?> required>
                                    <label for="akademik" class="category-label">
                                        <div class="category-icon academic">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <h6>Akademik</h6>
                                        <small>Kesulitan belajar, nilai turun, tidak mengerjakan tugas</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="category-card <?= (old('kategori') == 'Sosial') ? 'selected' : '' ?>" data-category="Sosial">
                                    <input type="radio" name="kategori" value="Sosial" id="sosial" <?= (old('kategori') == 'Sosial') ? 'checked' : '' ?> required>
                                    <label for="sosial" class="category-label">
                                        <div class="category-icon social">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h6>Sosial</h6>
                                        <small>Masalah dengan teman, menarik diri, konflik sosial</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="category-card <?= (old('kategori') == 'Perilaku') ? 'selected' : '' ?>" data-category="Perilaku">
                                    <input type="radio" name="kategori" value="Perilaku" id="perilaku" <?= (old('kategori') == 'Perilaku') ? 'checked' : '' ?> required>
                                    <label for="perilaku" class="category-label">
                                        <div class="category-icon behavior">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                        <h6>Perilaku</h6>
                                        <small>Perilaku disruptif, melanggar aturan, agresif</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tingkat Prioritas -->
                    <div class="mb-4">
                        <label for="tingkat_prioritas" class="form-label">
                            <i class="fas fa-flag me-2"></i>Tingkat Prioritas <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="tingkat_prioritas" name="tingkat_prioritas" required>
                            <option value="">-- Pilih Tingkat Prioritas --</option>
                            <option value="Rendah" <?= (old('tingkat_prioritas') == 'Rendah') ? 'selected' : '' ?>>
                                🟢 Rendah - Perlu pemantauan rutin
                            </option>
                            <option value="Sedang" <?= (old('tingkat_prioritas') == 'Sedang') ? 'selected' : '' ?>>
                                🟡 Sedang - Perlu perhatian dalam beberapa hari
                            </option>
                            <option value="Tinggi" <?= (old('tingkat_prioritas') == 'Tinggi') ? 'selected' : '' ?>>
                                🔴 Tinggi - Perlu tindakan segera
                            </option>
                        </select>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="deskripsi" class="form-label">
                            <i class="fas fa-edit me-2"></i>Deskripsi Masalah <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" 
                                  placeholder="Jelaskan secara singkat masalah yang diamati pada siswa..." 
                                  required maxlength="500"><?= old('deskripsi') ?></textarea>
                        <div class="form-text">
                            <span id="charCount">0</span>/500 karakter
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= base_url('/radar-kelas') ?>" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-danger" id="submitBtn">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Laporan Rahasia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-body p-4">
                <h6 class="mb-3">
                    <i class="fas fa-info-circle me-2"></i>Panduan Pelaporan
                </h6>
                
                <div class="guide-item">
                    <div class="guide-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="guide-content">
                        <strong>Observasi</strong>
                        <p>Pastikan Anda telah mengamati masalah secara objektif dan konsisten.</p>
                    </div>
                </div>
                
                <div class="guide-item">
                    <div class="guide-icon">
                        <i class="fas fa-pen"></i>
                    </div>
                    <div class="guide-content">
                        <strong>Deskripsi Jelas</strong>
                        <p>Gunakan bahasa yang jelas, objektif, dan hindari penilaian subjektif.</p>
                    </div>
                </div>
                
                <div class="guide-item">
                    <div class="guide-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="guide-content">
                        <strong>Tepat Waktu</strong>
                        <p>Laporkan sesegera mungkin setelah mengamati masalah.</p>
                    </div>
                </div>
                
                <div class="guide-item">
                    <div class="guide-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="guide-content">
                        <strong>Kerahasiaan</strong>
                        <p>Laporan Anda dijamin rahasia dan hanya diakses oleh yang berwenang.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-body p-4">
                <h6 class="mb-3">
                    <i class="fas fa-route me-2"></i>Alur Pelaporan
                </h6>
                
                <div class="flow-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <strong>Guru Mapel</strong>
                        <small>Mengirim laporan</small>
                    </div>
                </div>
                
                <div class="flow-arrow">
                    <i class="fas fa-arrow-down"></i>
                </div>
                
                <div class="flow-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <strong>Wali Kelas</strong>
                        <small>Menerima & menilai</small>
                    </div>
                </div>
                
                <div class="flow-arrow">
                    <i class="fas fa-arrow-down"></i>
                </div>
                
                <div class="flow-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <strong>Guru BK</strong>
                        <small>Menindaklanjuti</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
.category-card {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    background: white;
}

.category-card:hover {
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

.category-card.selected {
    border-color: #667eea;
    background: #f7fafc;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.category-card input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.category-label {
    cursor: pointer;
    display: block;
    width: 100%;
}

.category-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    color: white;
    font-size: 1.5rem;
}

.category-icon.academic {
    background: linear-gradient(135deg, #3182ce, #2c5282);
}

.category-icon.social {
    background: linear-gradient(135deg, #38a169, #2f855a);
}

.category-icon.behavior {
    background: linear-gradient(135deg, #ed8936, #dd6b20);
}

.guide-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f1f5f9;
}

.guide-icon {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 15px;
    flex-shrink: 0;
}

.guide-content {
    flex: 1;
}

.guide-content p {
    margin-bottom: 0;
    font-size: 0.9rem;
    color: #718096;
}

.flow-step {
    display: flex;
    align-items: center;
    padding: 10px;
    background: #f8fafc;
    border-radius: 8px;
    margin-bottom: 10px;
}

.step-number {
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    font-weight: bold;
    font-size: 0.9rem;
}

.flow-arrow {
    text-align: center;
    color: #cbd5e0;
    margin: 5px 0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter
    const textarea = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');
    
    textarea.addEventListener('input', function() {
        const currentLength = this.value.length;
        charCount.textContent = currentLength;
        
        if (currentLength > 450) {
            charCount.style.color = '#e53e3e';
        } else if (currentLength > 400) {
            charCount.style.color = '#ed8936';
        } else {
            charCount.style.color = '#718096';
        }
    });
    
    // Category selection
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove selected class from all cards
            categoryCards.forEach(c => c.classList.remove('selected'));
            
            // Add selected class to clicked card
            this.classList.add('selected');
            
            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
        });
    });
    
    // Form validation
    const form = document.getElementById('laporanForm');
    form.addEventListener('submit', function(e) {
        const siswaId = document.getElementById('siswa_id').value;
        const kategori = document.querySelector('input[name="kategori"]:checked');
        const prioritas = document.getElementById('tingkat_prioritas').value;
        const deskripsi = document.getElementById('deskripsi').value;
        
        if (!siswaId || !kategori || !prioritas || !deskripsi.trim()) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
            return;
        }
        
        if (deskripsi.trim().length < 10) {
            e.preventDefault();
            alert('Deskripsi minimal 10 karakter.');
            return;
        }
        
        // Confirm submission
        if (!confirm('Apakah Anda yakin ingin mengirim laporan ini? Laporan akan dikirim secara rahasia ke Wali Kelas dan Guru BK.')) {
            e.preventDefault();
        }
    });
});
</script>
<?= $this->endSection() ?>
