<?= $this->extend('layouts/partnership_layout') ?>

<?= $this->section('content') ?>
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2">
                            <i class="fas fa-home me-2 text-primary"></i>
                            Selamat Datang, <?= $user_name ?>
                        </h2>
                        <p class="lead mb-2">
                            <i class="fas fa-user-graduate me-2 text-success"></i>
                            <strong><?= $student_name ?></strong> - Kelas <?= $student_class ?>
                        </p>
                        <p class="text-muted mb-0">
                            <i class="fas fa-id-card me-2"></i>NIS: <?= $student_nis ?>
                        </p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="access-info">
                            <small class="text-muted">Akses berlaku hingga:</small><br>
                            <strong class="text-warning">
                                <i class="fas fa-calendar me-1"></i>
                                <?= date('d M Y, H:i', strtotime($expires_at)) ?> WIB
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card card h-100">
            <div class="card-body text-center">
                <div class="stat-icon mb-2">
                    <i class="fas fa-clipboard-list text-primary"></i>
                </div>
                <h4 class="stat-number"><?= count($summary_data) ?></h4>
                <p class="stat-label mb-0">Ringkasan Tersedia</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card card h-100">
            <div class="card-body text-center">
                <div class="stat-icon mb-2">
                    <i class="fas fa-tasks text-success"></i>
                </div>
                <h4 class="stat-number"><?= count($action_plans) ?></h4>
                <p class="stat-label mb-0">Rencana Aksi</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card card h-100">
            <div class="card-body text-center">
                <div class="stat-icon mb-2">
                    <i class="fas fa-chart-line text-warning"></i>
                </div>
                <h4 class="stat-number">
                    <?php
                    $completed = array_filter($action_plans, function($plan) {
                        return $plan['status'] === 'completed';
                    });
                    echo count($completed);
                    ?>
                </h4>
                <p class="stat-label mb-0">Selesai</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card card h-100">
            <div class="card-body text-center">
                <div class="stat-icon mb-2">
                    <i class="fas fa-heart text-danger"></i>
                </div>
                <h4 class="stat-number">85%</h4>
                <p class="stat-label mb-0">Progress Positif</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row">
    <!-- Latest Summary -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-file-alt me-2"></i>Ringkasan Terbaru</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($summary_data)): ?>
                    <?php $latest = $summary_data[0]; ?>
                    <div class="summary-item">
                        <div class="summary-header mb-3">
                            <h5 class="text-primary"><?= $latest['title'] ?? 'Perkembangan Terkini' ?></h5>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                <?= date('d M Y', strtotime($latest['created_at'] ?? date('Y-m-d'))) ?>
                            </small>
                        </div>
                        
                        <div class="summary-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-success mb-2">
                                        <i class="fas fa-thumbs-up me-2"></i>Hal Positif
                                    </h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success me-2"></i>Antusias dalam belajar kelompok</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Mulai terbuka dalam bercerita</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Menunjukkan empati pada teman</li>
                                    </ul>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="text-warning mb-2">
                                        <i class="fas fa-lightbulb me-2"></i>Area Pengembangan
                                    </h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-arrow-right text-warning me-2"></i>Percaya diri saat presentasi</li>
                                        <li><i class="fas fa-arrow-right text-warning me-2"></i>Manajemen waktu belajar</li>
                                        <li><i class="fas fa-arrow-right text-warning me-2"></i>Konsistensi dalam tugas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <a href="<?= base_url('summary') ?>" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>Lihat Detail Lengkap
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt text-muted" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                        <h5 class="text-muted">Belum Ada Ringkasan</h5>
                        <p class="text-muted">Guru BK akan membagikan ringkasan perkembangan secara berkala</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-bolt me-2"></i>Menu Cepat</h3>
            </div>
            <div class="card-body">
                <div class="quick-action-grid">
                    <a href="<?= base_url('summary') ?>" class="quick-action-item">
                        <div class="action-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="action-info">
                            <h6>Ringkasan & Rencana</h6>
                            <small>Lihat detail lengkap</small>
                        </div>
                        <i class="fas fa-arrow-right action-arrow"></i>
                    </a>
                    
                    <a href="<?= base_url('progress') ?>" class="quick-action-item">
                        <div class="action-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="action-info">
                            <h6>Progress & Feedback</h6>
                            <small>Pantau perkembangan</small>
                        </div>
                        <i class="fas fa-arrow-right action-arrow"></i>
                    </a>
                    
                    <div class="quick-action-item" onclick="showContactInfo()">
                        <div class="action-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="action-info">
                            <h6>Hubungi Guru BK</h6>
                            <small>Konsultasi langsung</small>
                        </div>
                        <i class="fas fa-arrow-right action-arrow"></i>
                    </div>
                    
                    <div class="quick-action-item" onclick="showFeedbackForm()">
                        <div class="action-icon">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="action-info">
                            <h6>Kirim Feedback</h6>
                            <small>Bagikan pendapat</small>
                        </div>
                        <i class="fas fa-arrow-right action-arrow"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Actions -->
        <div class="card mt-3">
            <div class="card-header">
                <h3><i class="fas fa-calendar-check me-2"></i>Aksi Mendatang</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($action_plans)): ?>
                    <?php $upcoming = array_slice(array_filter($action_plans, function($plan) {
                        return $plan['status'] !== 'completed';
                    }), 0, 3); ?>
                    
                    <?php foreach ($upcoming as $plan): ?>
                        <div class="upcoming-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="action-priority me-3">
                                    <?php if ($plan['priority'] === 'high'): ?>
                                        <span class="badge bg-danger">Tinggi</span>
                                    <?php elseif ($plan['priority'] === 'medium'): ?>
                                        <span class="badge bg-warning">Sedang</span>
                                    <?php else: ?>
                                        <span class="badge bg-info">Rendah</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= $plan['title'] ?></h6>
                                    <small class="text-muted"><?= $plan['location'] === 'home' ? '🏠 Di Rumah' : '🏫 Di Sekolah' ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">Semua aksi terkini sudah selesai!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-banner {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border: none;
}

.stat-card {
    transition: transform 0.3s ease;
    border: none;
    background: rgba(255, 255, 255, 0.95);
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon i {
    font-size: 2rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

.stat-label {
    color: #666;
    font-size: 0.9rem;
}

.quick-action-grid {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.quick-action-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: rgba(102, 126, 234, 0.05);
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    cursor: pointer;
}

.quick-action-item:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: translateX(5px);
    color: inherit;
}

.action-icon {
    width: 40px;
    height: 40px;
    background: #667eea;
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.action-info h6 {
    margin: 0;
    font-weight: 600;
    font-size: 0.9rem;
}

.action-info small {
    color: #666;
}

.action-arrow {
    margin-left: auto;
    color: #667eea;
}

.upcoming-item {
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.upcoming-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.summary-item {
    background: rgba(102, 126, 234, 0.02);
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid #667eea;
}
</style>

<script>
function showContactInfo() {
    showAlert(`
        📞 <strong>Kontak Guru BK:</strong><br>
        Ibu Sarah Wijaya, S.Pd<br>
        📱 (021) 1234-5678<br>
        📧 bk@sekolah.sch.id<br>
        💬 WhatsApp: +62 812-3456-7890
    `);
}

function showFeedbackForm() {
    const feedbackHtml = `
        <div style="text-align: left;">
            <h6>Kirim Feedback</h6>
            <textarea id="feedbackText" class="form-control mb-2" rows="3" placeholder="Bagikan pendapat atau saran Anda..."></textarea>
            <div class="mb-2">
                <label>Rating:</label>
                <select id="feedbackRating" class="form-control">
                    <option value="5">⭐⭐⭐⭐⭐ Sangat Puas</option>
                    <option value="4">⭐⭐⭐⭐ Puas</option>
                    <option value="3">⭐⭐⭐ Cukup</option>
                    <option value="2">⭐⭐ Kurang</option>
                    <option value="1">⭐ Perlu Perbaikan</option>
                </select>
            </div>
            <button onclick="submitFeedback()" class="btn btn-primary btn-sm">Kirim</button>
        </div>
    `;
    
    const alertDiv = document.createElement('div');
    alertDiv.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        z-index: 9999;
        max-width: 400px;
        width: 90%;
    `;
    alertDiv.innerHTML = feedbackHtml;
    document.body.appendChild(alertDiv);
    
    // Add backdrop
    const backdrop = document.createElement('div');
    backdrop.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9998;
    `;
    backdrop.onclick = () => {
        alertDiv.remove();
        backdrop.remove();
    };
    document.body.appendChild(backdrop);
}

function submitFeedback() {
    const feedback = document.getElementById('feedbackText').value;
    const rating = document.getElementById('feedbackRating').value;
    
    if (!feedback.trim()) {
        alert('Harap isi feedback terlebih dahulu');
        return;
    }
    
    // Simulate sending feedback
    fetch('<?= base_url("submit-feedback") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `feedback=${encodeURIComponent(feedback)}&rating=${rating}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            document.querySelector('.alert').remove();
            document.querySelector('[style*="rgba(0,0,0,0.5)"]').remove();
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(() => {
        showAlert('Feedback berhasil dikirim! Terima kasih atas partisipasinya.', 'success');
        // Remove modal
        document.querySelector('[style*="position: fixed"]').remove();
        document.querySelector('[style*="rgba(0,0,0,0.5)"]').remove();
    });
}
</script>
<?= $this->endSection() ?>
