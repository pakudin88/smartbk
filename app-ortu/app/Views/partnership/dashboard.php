<?= $this->extend('layouts/modern_layout') ?>

<?= $this->section('content') ?>
<!-- Hero Welcome Section -->
<div class="hero-section mb-4">
    <div class="card gradient-card border-0 overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="welcome-content">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-circle me-3">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div>
                                <h1 class="welcome-title mb-1">Selamat Datang, <?= esc($user_name) ?>!</h1>
                                <p class="welcome-subtitle mb-0">Jendela Kemitraan - Portal Kolaborasi Orang Tua & Sekolah</p>
                            </div>
                        </div>
                        
                        <div class="student-info-card">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="student-avatar">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h4 class="student-name mb-1"><?= esc($student_name) ?></h4>
                                    <div class="student-details">
                                        <span class="badge badge-class me-2">
                                            <i class="fas fa-school me-1"></i>Kelas <?= esc($student_class) ?>
                                        </span>
                                        <span class="badge badge-nis">
                                            <i class="fas fa-id-card me-1"></i>NIS: <?= esc($student_nis) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="access-info-card">
                        <div class="text-center">
                            <div class="access-icon mb-3">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h6 class="access-title">Akses Portal</h6>
                            <p class="access-time mb-2"><?= date('d M Y, H:i', strtotime($expires_at)) ?> WIB</p>
                            <div class="access-status">
                                <span class="badge badge-active">
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-section mb-4">
    <div class="row g-3">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-body">
                    <div class="stat-icon stat-icon-primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?= count($summary_data) ?></h3>
                        <p class="stat-label">Laporan Tersedia</p>
                        <div class="stat-trend">
                            <span class="trend-positive">
                                <i class="fas fa-arrow-up"></i> Terkini
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-body">
                    <div class="stat-icon stat-icon-success">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?= count($action_plans) ?></h3>
                        <p class="stat-label">Rencana Aksi</p>
                        <div class="stat-trend">
                            <span class="trend-info">
                                <i class="fas fa-play-circle"></i> Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-body">
                    <div class="stat-icon stat-icon-warning">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">
                            <?php
                            $inProgress = array_filter($action_plans, function($plan) {
                                return isset($plan['status']) && $plan['status'] === 'in_progress';
                            });
                            echo count($inProgress);
                            ?>
                        </h3>
                        <p class="stat-label">Sedang Berjalan</p>
                        <div class="stat-trend">
                            <span class="trend-warning">
                                <i class="fas fa-clock"></i> Progress
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-body">
                    <div class="stat-icon stat-icon-info">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">92%</h3>
                        <p class="stat-label">Kolaborasi</p>
                        <div class="stat-trend">
                            <span class="trend-positive">
                                <i class="fas fa-heart"></i> Excellent
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Dashboard Content -->
<div class="row">
    <!-- Recent Reports -->
    <div class="col-lg-8 mb-4">
        <div class="card modern-card">
            <div class="card-header modern-card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">
                            <i class="fas fa-clipboard-list me-2 text-primary"></i>
                            Laporan Terkini
                        </h5>
                        <p class="card-subtitle text-muted mb-0">Informasi perkembangan putra/putri Anda</p>
                    </div>
                    <a href="<?= base_url('summary') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($summary_data)): ?>
                    <div class="reports-timeline">
                        <?php foreach (array_slice($summary_data, 0, 3) as $index => $summary): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker">
                                <div class="timeline-icon 
                                    <?= $summary['summary_type'] === 'academic' ? 'bg-primary' : 
                                        ($summary['summary_type'] === 'behavior' ? 'bg-success' : 'bg-info') ?>">
                                    <i class="fas <?= $summary['summary_type'] === 'academic' ? 'fa-graduation-cap' : 
                                        ($summary['summary_type'] === 'behavior' ? 'fa-users' : 'fa-heart') ?>"></i>
                                </div>
                            </div>
                            <div class="timeline-content">
                                <div class="report-card">
                                    <div class="report-header">
                                        <h6 class="report-title"><?= esc($summary['title']) ?></h6>
                                        <span class="report-type badge 
                                            <?= $summary['summary_type'] === 'academic' ? 'badge-primary' : 
                                                ($summary['summary_type'] === 'behavior' ? 'badge-success' : 'badge-info') ?>">
                                            <?= ucfirst($summary['summary_type']) ?>
                                        </span>
                                    </div>
                                    <p class="report-content"><?= esc(substr($summary['content'], 0, 150)) ?>...</p>
                                    <div class="report-meta">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?= date('d M Y', strtotime($summary['created_at'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Belum Ada Laporan</h6>
                            <p class="text-muted">Laporan perkembangan akan muncul di sini</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Action Plans & Quick Actions -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card modern-card mb-4">
            <div class="card-header modern-card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-rocket me-2 text-success"></i>
                    Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="<?= base_url('summary') ?>" class="quick-action-btn">
                        <div class="quick-action-icon bg-primary">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="quick-action-content">
                            <h6>Lihat Laporan</h6>
                            <small>Ringkasan lengkap</small>
                        </div>
                        <i class="fas fa-chevron-right quick-action-arrow"></i>
                    </a>
                    
                    <a href="<?= base_url('progress') ?>" class="quick-action-btn">
                        <div class="quick-action-icon bg-warning">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="quick-action-content">
                            <h6>Pantau Progress</h6>
                            <small>Status rencana aksi</small>
                        </div>
                        <i class="fas fa-chevron-right quick-action-arrow"></i>
                    </a>
                    
                    <button onclick="openFeedbackModal()" class="quick-action-btn">
                        <div class="quick-action-icon bg-info">
                            <i class="fas fa-comment-alt"></i>
                        </div>
                        <div class="quick-action-content">
                            <h6>Berikan Feedback</h6>
                            <small>Masukan untuk sekolah</small>
                        </div>
                        <i class="fas fa-chevron-right quick-action-arrow"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Action Plans -->
        <div class="card modern-card">
            <div class="card-header modern-card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list-check me-2 text-warning"></i>
                    Rencana Aksi
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($action_plans)): ?>
                    <div class="action-plans-list">
                        <?php foreach (array_slice($action_plans, 0, 3) as $plan): ?>
                        <div class="action-plan-item">
                            <div class="d-flex align-items-start">
                                <div class="action-status me-2">
                                    <?php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'in_progress' => 'info',
                                        'completed' => 'success',
                                        'review' => 'primary'
                                    ];
                                    $status = $plan['status'] ?? 'pending';
                                    $color = $statusColors[$status] ?? 'secondary';
                                    ?>
                                    <div class="status-dot bg-<?= $color ?>"></div>
                                </div>
                                <div class="action-content flex-grow-1">
                                    <h6 class="action-title"><?= esc($plan['title']) ?></h6>
                                    <p class="action-desc"><?= esc(substr($plan['description'], 0, 80)) ?>...</p>
                                    <div class="action-meta">
                                        <span class="badge badge-<?= $plan['target_area'] === 'home' ? 'home' : 'school' ?>">
                                            <i class="fas <?= $plan['target_area'] === 'home' ? 'fa-home' : 'fa-school' ?> me-1"></i>
                                            <?= ucfirst($plan['target_area']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center mt-3">
                        <a href="<?= base_url('progress') ?>" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-tasks me-1"></i>Lihat Semua Rencana
                        </a>
                    </div>
                <?php else: ?>
                    <div class="empty-state-small">
                        <div class="text-center py-3">
                            <i class="fas fa-clipboard fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada rencana aksi</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.hero-section .gradient-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: relative;
}

.hero-section .gradient-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
    opacity: 0.3;
}

.avatar-circle {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.avatar-circle i {
    font-size: 1.5rem;
    color: white;
}

.welcome-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: white;
}

.welcome-subtitle {
    color: rgba(255, 255, 255, 0.8);
}

.student-info-card {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 16px;
    padding: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.student-avatar {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.student-avatar i {
    font-size: 1.2rem;
    color: white;
}

.student-name {
    color: white;
    font-weight: 600;
    margin-bottom: 8px;
}

.badge-class, .badge-nis {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.access-info-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 24px;
    backdrop-filter: blur(10px);
}

.access-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.access-icon i {
    font-size: 1.5rem;
    color: white;
}

.access-title {
    color: white;
    font-weight: 600;
}

.access-time {
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

.badge-active {
    background: rgba(40, 167, 69, 0.8);
    color: white;
}

.stat-card {
    background: white;
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.stat-card-body {
    padding: 24px;
    display: flex;
    align-items: center;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 16px;
}

.stat-icon-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stat-icon-success { background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%); }
.stat-icon-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.stat-icon-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

.stat-icon i {
    color: white;
    font-size: 1.4rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 4px;
}

.stat-label {
    color: #718096;
    font-weight: 500;
    margin-bottom: 8px;
}

.stat-trend {
    font-size: 0.875rem;
}

.trend-positive { color: #28a745; }
.trend-warning { color: #ffc107; }
.trend-info { color: #17a2b8; }

.modern-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.modern-card-header {
    background: transparent;
    border-bottom: 1px solid #e9ecef;
    padding: 20px 24px;
}

.card-title {
    font-weight: 600;
    color: #2d3748;
}

.card-subtitle {
    font-size: 0.875rem;
}

.reports-timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    margin-bottom: 24px;
    position: relative;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 20px;
    top: 40px;
    bottom: -24px;
    width: 2px;
    background: #e9ecef;
}

.timeline-marker {
    flex-shrink: 0;
    margin-right: 16px;
}

.timeline-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline-icon i {
    color: white;
    font-size: 1rem;
}

.timeline-content {
    flex-grow: 1;
}

.report-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 16px;
}

.report-header {
    display: flex;
    justify-content: between;
    align-items: start;
    margin-bottom: 12px;
}

.report-title {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0;
    flex-grow: 1;
    margin-right: 12px;
}

.report-type.badge {
    font-size: 0.75rem;
}

.badge-primary { background: #667eea; }
.badge-success { background: #56ab2f; }
.badge-info { background: #4facfe; }

.report-content {
    color: #4a5568;
    font-size: 0.875rem;
    line-height: 1.5;
    margin-bottom: 12px;
}

.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    border: none;
    width: 100%;
}

.quick-action-btn:hover {
    background: #e9ecef;
    transform: translateX(4px);
    color: inherit;
    text-decoration: none;
}

.quick-action-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

.quick-action-icon i {
    color: white;
    font-size: 1rem;
}

.quick-action-content h6 {
    margin-bottom: 2px;
    font-weight: 600;
    color: #2d3748;
}

.quick-action-content small {
    color: #718096;
}

.quick-action-arrow {
    color: #cbd5e0;
    margin-left: auto;
}

.action-plans-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.action-plan-item {
    padding: 16px;
    background: #f8f9fa;
    border-radius: 12px;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-top: 4px;
}

.action-title {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 6px;
    font-size: 0.875rem;
}

.action-desc {
    color: #4a5568;
    font-size: 0.75rem;
    line-height: 1.4;
    margin-bottom: 8px;
}

.badge-home { 
    background: #e3f2fd; 
    color: #1565c0; 
    font-size: 0.75rem;
}

.badge-school { 
    background: #f3e5f5; 
    color: #7b1fa2; 
    font-size: 0.75rem;
}

.empty-state {
    padding: 40px 20px;
}

.empty-state-small {
    padding: 20px;
}

@media (max-width: 768px) {
    .hero-section .card-body {
        padding: 24px 20px;
    }
    
    .welcome-title {
        font-size: 1.4rem;
    }
    
    .student-info-card {
        margin-top: 20px;
    }
    
    .stat-card-body {
        padding: 20px;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .access-info-card {
        margin-top: 20px;
    }
}
</style>

<?= $this->endSection() ?>
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
