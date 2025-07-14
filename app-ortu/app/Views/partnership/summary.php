<?= $this->extend('layouts/partnership_layout') ?>

<?= $this->section('content') ?>
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Ringkasan & Rencana Aksi</li>
    </ol>
</nav>

<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="page-header card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2">
                            <i class="fas fa-clipboard-list me-2 text-primary"></i>
                            Ringkasan & Rencana Aksi
                        </h2>
                        <p class="text-muted mb-0">
                            Informasi yang telah dikurasi dengan bijak oleh Guru BK untuk kemitraan yang konstruktif
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="student-info">
                            <h6 class="mb-1"><?= $student_name ?></h6>
                            <small class="text-muted">Kelas <?= session('student_class') ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-file-alt me-2"></i>Ringkasan Perkembangan</h3>
                <small class="text-muted">Disusun dengan pendekatan positif dan solutif</small>
            </div>
            <div class="card-body">
                <?php if (!empty($summary_data)): ?>
                    <?php foreach ($summary_data as $index => $summary): ?>
                        <div class="summary-card mb-4 <?= $index > 0 ? 'collapsed' : '' ?>" data-summary-index="<?= $index ?>">
                            <div class="summary-header" onclick="toggleSummary(<?= $index ?>)">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">
                                            <i class="fas fa-chevron-right toggle-icon me-2"></i>
                                            <?= $summary['title'] ?? 'Laporan Perkembangan #' . ($index + 1) ?>
                                        </h5>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?= date('d M Y, H:i', strtotime($summary['created_at'] ?? date('Y-m-d'))) ?> WIB
                                        </small>
                                    </div>
                                    <span class="badge bg-primary">Terbaru</span>
                                </div>
                            </div>
                            
                            <div class="summary-content" style="<?= $index > 0 ? 'display: none;' : '' ?>">
                                <div class="row mt-3">
                                    <!-- Aspek Positif -->
                                    <div class="col-lg-6 mb-4">
                                        <div class="aspect-card positive">
                                            <div class="aspect-header">
                                                <h6><i class="fas fa-star text-warning me-2"></i>Kekuatan & Pencapaian</h6>
                                            </div>
                                            <div class="aspect-content">
                                                <ul class="list-unstyled">
                                                    <li><i class="fas fa-check-circle text-success me-2"></i>Menunjukkan antusiasme tinggi dalam diskusi kelompok</li>
                                                    <li><i class="fas fa-check-circle text-success me-2"></i>Mulai berani menyampaikan pendapat di kelas</li>
                                                    <li><i class="fas fa-check-circle text-success me-2"></i>Memiliki empati yang baik terhadap teman</li>
                                                    <li><i class="fas fa-check-circle text-success me-2"></i>Rajin membantu teman yang kesulitan</li>
                                                    <li><i class="fas fa-check-circle text-success me-2"></i>Konsisten mengumpulkan tugas tepat waktu</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Area Pengembangan -->
                                    <div class="col-lg-6 mb-4">
                                        <div class="aspect-card development">
                                            <div class="aspect-header">
                                                <h6><i class="fas fa-seedling text-success me-2"></i>Area Pengembangan</h6>
                                            </div>
                                            <div class="aspect-content">
                                                <ul class="list-unstyled">
                                                    <li><i class="fas fa-arrow-up text-info me-2"></i>Meningkatkan kepercayaan diri saat presentasi</li>
                                                    <li><i class="fas fa-arrow-up text-info me-2"></i>Mengembangkan keterampilan manajemen waktu</li>
                                                    <li><i class="fas fa-arrow-up text-info me-2"></i>Memperkuat fokus dalam pembelajaran individu</li>
                                                    <li><i class="fas fa-arrow-up text-info me-2"></i>Melatih keberanian dalam bertanya</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Catatan Guru BK -->
                                <div class="teacher-note">
                                    <div class="note-header">
                                        <h6><i class="fas fa-user-tie me-2"></i>Catatan Guru BK</h6>
                                    </div>
                                    <div class="note-content">
                                        <p class="mb-2">
                                            "<?= $student_name ?> menunjukkan perkembangan yang sangat positif dalam aspek sosial dan akademik. 
                                            Kemampuan berempatinya yang tinggi menjadi modal kuat untuk pengembangan kepemimpinan. 
                                            Dengan dukungan yang tepat dari rumah dan sekolah, potensi dirinya akan semakin berkembang optimal."
                                        </p>
                                        <div class="teacher-signature">
                                            <small class="text-muted">
                                                <i class="fas fa-pen me-1"></i>Ibu Sarah Wijaya, S.Pd - Guru BK
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt text-muted" style="font-size: 4rem; margin-bottom: 1rem;"></i>
                        <h5 class="text-muted">Belum Ada Ringkasan</h5>
                        <p class="text-muted">Guru BK akan menyusun ringkasan perkembangan secara berkala</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Action Plans Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-tasks me-2"></i>Rencana Aksi Kemitraan</h3>
                <small class="text-muted">Langkah konkret untuk kemitraan rumah dan sekolah</small>
            </div>
            <div class="card-body">
                <?php if (!empty($action_plans)): ?>
                    <div class="row">
                        <!-- Aksi untuk Rumah -->
                        <div class="col-lg-6 mb-4">
                            <div class="action-section">
                                <div class="section-header">
                                    <h5><i class="fas fa-home text-primary me-2"></i>Aksi di Rumah</h5>
                                    <p class="text-muted">Yang dapat dilakukan oleh keluarga</p>
                                </div>
                                
                                <?php 
                                $homeActions = array_filter($action_plans, function($plan) {
                                    return $plan['location'] === 'home';
                                });
                                ?>
                                
                                <?php if (!empty($homeActions)): ?>
                                    <?php foreach ($homeActions as $plan): ?>
                                        <div class="action-item">
                                            <div class="action-header">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h6 class="action-title"><?= $plan['title'] ?></h6>
                                                    <span class="badge bg-<?= $plan['priority'] === 'high' ? 'danger' : ($plan['priority'] === 'medium' ? 'warning' : 'info') ?>">
                                                        <?= $plan['priority'] === 'high' ? 'Prioritas Tinggi' : ($plan['priority'] === 'medium' ? 'Prioritas Sedang' : 'Prioritas Rendah') ?>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="action-description">
                                                <p><?= $plan['description'] ?></p>
                                            </div>
                                            
                                            <div class="action-steps">
                                                <h6><i class="fas fa-list-ol me-2"></i>Langkah-langkah:</h6>
                                                <ol class="step-list">
                                                    <li>Luangkan waktu 15-20 menit setiap hari untuk mendengarkan cerita anak</li>
                                                    <li>Berikan pujian spesifik untuk usaha yang dilakukan, bukan hanya hasil</li>
                                                    <li>Dampingi saat mengerjakan tugas tanpa memberikan jawaban langsung</li>
                                                    <li>Ciptakan lingkungan belajar yang nyaman dan bebas distraksi</li>
                                                </ol>
                                            </div>
                                            
                                            <div class="action-status">
                                                <div class="progress mb-2">
                                                    <div class="progress-bar bg-<?= $plan['status'] === 'completed' ? 'success' : ($plan['status'] === 'in_progress' ? 'warning' : 'info') ?>" 
                                                         style="width: <?= $plan['status'] === 'completed' ? '100' : ($plan['status'] === 'in_progress' ? '60' : '0') ?>%">
                                                    </div>
                                                </div>
                                                <small class="text-muted">
                                                    Status: 
                                                    <span class="fw-bold text-<?= $plan['status'] === 'completed' ? 'success' : ($plan['status'] === 'in_progress' ? 'warning' : 'info') ?>">
                                                        <?= $plan['status'] === 'completed' ? 'Selesai' : ($plan['status'] === 'in_progress' ? 'Sedang Berjalan' : 'Belum Dimulai') ?>
                                                    </span>
                                                </small>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-3">
                                        <i class="fas fa-home text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted mt-2">Belum ada aksi khusus untuk rumah</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Aksi untuk Sekolah -->
                        <div class="col-lg-6 mb-4">
                            <div class="action-section">
                                <div class="section-header">
                                    <h5><i class="fas fa-school text-success me-2"></i>Aksi di Sekolah</h5>
                                    <p class="text-muted">Yang dilakukan oleh pihak sekolah</p>
                                </div>
                                
                                <?php 
                                $schoolActions = array_filter($action_plans, function($plan) {
                                    return $plan['location'] === 'school';
                                });
                                ?>
                                
                                <?php if (!empty($schoolActions)): ?>
                                    <?php foreach ($schoolActions as $plan): ?>
                                        <div class="action-item">
                                            <div class="action-header">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h6 class="action-title"><?= $plan['title'] ?></h6>
                                                    <span class="badge bg-success">Sekolah</span>
                                                </div>
                                            </div>
                                            
                                            <div class="action-description">
                                                <p><?= $plan['description'] ?></p>
                                            </div>
                                            
                                            <div class="action-steps">
                                                <h6><i class="fas fa-chalkboard-teacher me-2"></i>Program:</h6>
                                                <ul class="program-list">
                                                    <li>Sesi konseling individu mingguan dengan Guru BK</li>
                                                    <li>Pelatihan public speaking dalam kelompok kecil</li>
                                                    <li>Mentoring dari kakak kelas yang berprestasi</li>
                                                    <li>Partisipasi dalam proyek kolaboratif kelas</li>
                                                </ul>
                                            </div>
                                            
                                            <div class="action-status">
                                                <div class="progress mb-2">
                                                    <div class="progress-bar bg-success" style="width: 80%"></div>
                                                </div>
                                                <small class="text-muted">
                                                    Status: <span class="fw-bold text-success">Sedang Berjalan</span>
                                                </small>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-3">
                                        <i class="fas fa-school text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted mt-2">Program sekolah akan segera diperbarui</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-tasks text-muted" style="font-size: 4rem; margin-bottom: 1rem;"></i>
                        <h5 class="text-muted">Rencana Aksi Akan Segera Tersedia</h5>
                        <p class="text-muted">Guru BK sedang menyusun rencana aksi yang sesuai</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border: none;
}

.summary-card {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(102, 126, 234, 0.2);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.summary-card.collapsed {
    opacity: 0.7;
}

.summary-header {
    background: rgba(102, 126, 234, 0.05);
    padding: 1.5rem;
    cursor: pointer;
    transition: background 0.3s ease;
}

.summary-header:hover {
    background: rgba(102, 126, 234, 0.1);
}

.toggle-icon {
    transition: transform 0.3s ease;
}

.summary-card:not(.collapsed) .toggle-icon {
    transform: rotate(90deg);
}

.aspect-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    height: 100%;
}

.aspect-card.positive {
    border-left: 5px solid #10b981;
}

.aspect-card.development {
    border-left: 5px solid #3b82f6;
}

.aspect-header h6 {
    color: #374151;
    font-weight: 600;
    margin-bottom: 1rem;
}

.teacher-note {
    background: rgba(102, 126, 234, 0.05);
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 1rem;
    border-left: 4px solid #667eea;
}

.action-section {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 1.5rem;
    height: 100%;
    border: 1px solid rgba(0,0,0,0.1);
}

.action-item {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border-left: 4px solid #667eea;
}

.action-title {
    color: #374151;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.step-list {
    padding-left: 1rem;
}

.step-list li {
    margin-bottom: 0.5rem;
    color: #6b7280;
}

.program-list {
    list-style: none;
    padding-left: 0;
}

.program-list li {
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
    color: #6b7280;
}

.program-list li:last-child {
    border-bottom: none;
}

.program-list li:before {
    content: "✓";
    color: #10b981;
    font-weight: bold;
    margin-right: 0.5rem;
}
</style>

<script>
function toggleSummary(index) {
    const summaryCard = document.querySelector(`[data-summary-index="${index}"]`);
    const content = summaryCard.querySelector('.summary-content');
    const isCollapsed = summaryCard.classList.contains('collapsed');
    
    if (isCollapsed) {
        summaryCard.classList.remove('collapsed');
        content.style.display = 'block';
    } else {
        summaryCard.classList.add('collapsed');
        content.style.display = 'none';
    }
}
</script>
<?= $this->endSection() ?>
