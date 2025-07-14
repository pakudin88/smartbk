<?= $this->extend('layouts/modern_layout') ?>

<?= $this->section('title') ?>Smart BookKeeping - Profil Anak<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Student Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="student-profile-header">
                <div class="profile-cover">
                    <div class="cover-gradient"></div>
                    <div class="profile-content">
                        <div class="row align-items-end">
                            <div class="col-lg-3 col-md-4">
                                <div class="profile-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Ahmad+Rizki&size=150&background=667eea&color=ffffff&font-size=0.6" 
                                         alt="Student Photo" class="avatar-img">
                                    <div class="avatar-status online"></div>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8">
                                <div class="profile-info">
                                    <h2 class="student-name">Ahmad Rizki Pratama</h2>
                                    <p class="student-details">
                                        <span class="detail-item">
                                            <i class="fas fa-id-card me-2"></i>
                                            NIS: 2024001234
                                        </span>
                                        <span class="detail-item">
                                            <i class="fas fa-graduation-cap me-2"></i>
                                            Kelas VII A
                                        </span>
                                        <span class="detail-item">
                                            <i class="fas fa-calendar me-2"></i>
                                            Tahun Ajaran 2024/2025
                                        </span>
                                    </p>
                                    <div class="student-stats">
                                        <div class="stat-item">
                                            <span class="stat-number">87.5</span>
                                            <span class="stat-label">Rata-rata Nilai</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-number">95%</span>
                                            <span class="stat-label">Kehadiran</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-number">3</span>
                                            <span class="stat-label">Prestasi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills profile-tabs" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button" role="tab">
                        <i class="fas fa-chart-line me-2"></i>Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="academic-tab" data-bs-toggle="pill" data-bs-target="#academic" type="button" role="tab">
                        <i class="fas fa-book me-2"></i>Akademik
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="attendance-tab" data-bs-toggle="pill" data-bs-target="#attendance" type="button" role="tab">
                        <i class="fas fa-calendar-check me-2"></i>Kehadiran
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="achievements-tab" data-bs-toggle="pill" data-bs-target="#achievements" type="button" role="tab">
                        <i class="fas fa-trophy me-2"></i>Prestasi
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="behavior-tab" data-bs-toggle="pill" data-bs-target="#behavior" type="button" role="tab">
                        <i class="fas fa-star me-2"></i>Perilaku
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="profileTabsContent">
        <!-- Overview Tab -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
            <div class="row">
                <!-- Quick Stats -->
                <div class="col-lg-8 mb-4">
                    <div class="card modern-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-area me-2 text-primary"></i>
                                Perkembangan Akademik
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="academicChart" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card modern-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar-alt me-2 text-success"></i>
                                Kehadiran Bulan Ini
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="attendance-circle">
                                <canvas id="attendanceChart" width="150" height="150"></canvas>
                                <div class="attendance-percentage">
                                    <span class="percentage-number">95%</span>
                                    <span class="percentage-label">Hadir</span>
                                </div>
                            </div>
                            <div class="attendance-details mt-3">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <span class="detail-number text-success">19</span>
                                        <span class="detail-label">Hadir</span>
                                    </div>
                                    <div class="col-4">
                                        <span class="detail-number text-warning">1</span>
                                        <span class="detail-label">Izin</span>
                                    </div>
                                    <div class="col-4">
                                        <span class="detail-number text-danger">0</span>
                                        <span class="detail-label">Alpha</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="col-12 mb-4">
                    <div class="card modern-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clock me-2 text-info"></i>
                                Aktivitas Terbaru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Juara 1 Kompetisi Matematika</h6>
                                        <p class="timeline-description">Meraih prestasi terbaik dalam olimpiade matematika tingkat sekolah</p>
                                        <span class="timeline-time">2 hari yang lalu</span>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Tugas IPA Dikumpulkan</h6>
                                        <p class="timeline-description">Mengumpulkan tugas penelitian tentang ekosistem dengan nilai A</p>
                                        <span class="timeline-time">3 hari yang lalu</span>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Terlambat Masuk Kelas</h6>
                                        <p class="timeline-description">Terlambat 15 menit karena macet, sudah dikonfirmasi oleh wali kelas</p>
                                        <span class="timeline-time">1 minggu yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Tab -->
        <div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="academic-tab">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card modern-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-bar me-2 text-primary"></i>
                                Nilai Per Mata Pelajaran
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="subjects-grid">
                                <div class="subject-card">
                                    <div class="subject-icon">
                                        <i class="fas fa-calculator text-primary"></i>
                                    </div>
                                    <div class="subject-info">
                                        <h6 class="subject-name">Matematika</h6>
                                        <div class="subject-score">
                                            <span class="score-number">92</span>
                                            <span class="score-grade">A</span>
                                        </div>
                                        <div class="progress subject-progress">
                                            <div class="progress-bar bg-primary" style="width: 92%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="subject-card">
                                    <div class="subject-icon">
                                        <i class="fas fa-flask text-success"></i>
                                    </div>
                                    <div class="subject-info">
                                        <h6 class="subject-name">IPA</h6>
                                        <div class="subject-score">
                                            <span class="score-number">88</span>
                                            <span class="score-grade">A-</span>
                                        </div>
                                        <div class="progress subject-progress">
                                            <div class="progress-bar bg-success" style="width: 88%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="subject-card">
                                    <div class="subject-icon">
                                        <i class="fas fa-book text-info"></i>
                                    </div>
                                    <div class="subject-info">
                                        <h6 class="subject-name">Bahasa Indonesia</h6>
                                        <div class="subject-score">
                                            <span class="score-number">85</span>
                                            <span class="score-grade">B+</span>
                                        </div>
                                        <div class="progress subject-progress">
                                            <div class="progress-bar bg-info" style="width: 85%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="subject-card">
                                    <div class="subject-icon">
                                        <i class="fas fa-globe text-warning"></i>
                                    </div>
                                    <div class="subject-info">
                                        <h6 class="subject-name">Bahasa Inggris</h6>
                                        <div class="subject-score">
                                            <span class="score-number">90</span>
                                            <span class="score-grade">A</span>
                                        </div>
                                        <div class="progress subject-progress">
                                            <div class="progress-bar bg-warning" style="width: 90%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="subject-card">
                                    <div class="subject-icon">
                                        <i class="fas fa-map text-danger"></i>
                                    </div>
                                    <div class="subject-info">
                                        <h6 class="subject-name">IPS</h6>
                                        <div class="subject-score">
                                            <span class="score-number">83</span>
                                            <span class="score-grade">B+</span>
                                        </div>
                                        <div class="progress subject-progress">
                                            <div class="progress-bar bg-danger" style="width: 83%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="subject-card">
                                    <div class="subject-icon">
                                        <i class="fas fa-pray text-secondary"></i>
                                    </div>
                                    <div class="subject-info">
                                        <h6 class="subject-name">PAI</h6>
                                        <div class="subject-score">
                                            <span class="score-number">94</span>
                                            <span class="score-grade">A</span>
                                        </div>
                                        <div class="progress subject-progress">
                                            <div class="progress-bar bg-secondary" style="width: 94%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Tab -->
        <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card modern-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar me-2 text-success"></i>
                                Kalender Kehadiran
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="attendanceCalendar" class="attendance-calendar"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card modern-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-pie me-2 text-info"></i>
                                Statistik Kehadiran
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="attendance-stats">
                                <div class="stat-row">
                                    <span class="stat-icon bg-success">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <div class="stat-info">
                                        <span class="stat-label">Hadir</span>
                                        <span class="stat-value">95 hari</span>
                                    </div>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-icon bg-warning">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                    <div class="stat-info">
                                        <span class="stat-label">Terlambat</span>
                                        <span class="stat-value">2 kali</span>
                                    </div>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-icon bg-info">
                                        <i class="fas fa-file-medical"></i>
                                    </span>
                                    <div class="stat-info">
                                        <span class="stat-label">Izin/Sakit</span>
                                        <span class="stat-value">3 hari</span>
                                    </div>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-icon bg-danger">
                                        <i class="fas fa-times"></i>
                                    </span>
                                    <div class="stat-info">
                                        <span class="stat-label">Alpha</span>
                                        <span class="stat-value">0 hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievements Tab -->
        <div class="tab-pane fade" id="achievements" role="tabpanel" aria-labelledby="achievements-tab">
            <div class="row">
                <div class="col-12">
                    <div class="achievements-grid">
                        <div class="achievement-card gold">
                            <div class="achievement-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="achievement-content">
                                <h6 class="achievement-title">Juara 1 Olimpiade Matematika</h6>
                                <p class="achievement-description">Tingkat Sekolah - Januari 2025</p>
                                <span class="achievement-date">2 hari yang lalu</span>
                            </div>
                            <div class="achievement-badge">
                                <span class="badge bg-warning">Emas</span>
                            </div>
                        </div>

                        <div class="achievement-card silver">
                            <div class="achievement-icon">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div class="achievement-content">
                                <h6 class="achievement-title">Juara 2 Lomba Karya Tulis</h6>
                                <p class="achievement-description">Tingkat Kecamatan - Desember 2024</p>
                                <span class="achievement-date">1 bulan yang lalu</span>
                            </div>
                            <div class="achievement-badge">
                                <span class="badge bg-secondary">Perak</span>
                            </div>
                        </div>

                        <div class="achievement-card bronze">
                            <div class="achievement-icon">
                                <i class="fas fa-award"></i>
                            </div>
                            <div class="achievement-content">
                                <h6 class="achievement-title">Juara 3 Lomba Pidato</h6>
                                <p class="achievement-description">Tingkat Sekolah - November 2024</p>
                                <span class="achievement-date">2 bulan yang lalu</span>
                            </div>
                            <div class="achievement-badge">
                                <span class="badge bg-warning">Perunggu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Behavior Tab -->
        <div class="tab-pane fade" id="behavior" role="tabpanel" aria-labelledby="behavior-tab">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card modern-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-star me-2 text-warning"></i>
                                Penilaian Karakter
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="behavior-scores">
                                <div class="behavior-item">
                                    <span class="behavior-label">Kedisiplinan</span>
                                    <div class="behavior-rating">
                                        <div class="stars">
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-text">Baik</span>
                                    </div>
                                </div>

                                <div class="behavior-item">
                                    <span class="behavior-label">Kerjasama</span>
                                    <div class="behavior-rating">
                                        <div class="stars">
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                        </div>
                                        <span class="rating-text">Sangat Baik</span>
                                    </div>
                                </div>

                                <div class="behavior-item">
                                    <span class="behavior-label">Tanggung Jawab</span>
                                    <div class="behavior-rating">
                                        <div class="stars">
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-text">Baik</span>
                                    </div>
                                </div>

                                <div class="behavior-item">
                                    <span class="behavior-label">Kejujuran</span>
                                    <div class="behavior-rating">
                                        <div class="stars">
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                            <i class="fas fa-star active"></i>
                                        </div>
                                        <span class="rating-text">Sangat Baik</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card modern-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-comments me-2 text-primary"></i>
                                Catatan Guru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="teacher-notes">
                                <div class="note-item">
                                    <div class="note-header">
                                        <span class="note-teacher">Ibu Sarah (Wali Kelas)</span>
                                        <span class="note-date">15 Jan 2025</span>
                                    </div>
                                    <p class="note-content">Ahmad menunjukkan peningkatan yang signifikan dalam matematika. Sangat aktif bertanya dan membantu teman yang kesulitan.</p>
                                </div>

                                <div class="note-item">
                                    <div class="note-header">
                                        <span class="note-teacher">Pak Budi (Guru IPA)</span>
                                        <span class="note-date">10 Jan 2025</span>
                                    </div>
                                    <p class="note-content">Eksperimen yang dilakukan Ahmad sangat kreatif dan menunjukkan pemahaman konsep yang baik.</p>
                                </div>

                                <div class="note-item">
                                    <div class="note-header">
                                        <span class="note-teacher">Ibu Sari (Guru B.Inggris)</span>
                                        <span class="note-date">8 Jan 2025</span>
                                    </div>
                                    <p class="note-content">Speaking skill Ahmad sudah bagus, perlu ditingkatkan lagi untuk grammar dan writing.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Profile Header Styles */
.student-profile-header {
    margin-bottom: 2rem;
}

.profile-cover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    min-height: 200px;
}

.cover-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.profile-content {
    position: relative;
    z-index: 2;
}

.profile-avatar {
    position: relative;
    margin-bottom: 1rem;
}

.avatar-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.3);
    object-fit: cover;
}

.avatar-status {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 3px solid white;
}

.avatar-status.online {
    background: #28a745;
}

.student-name {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 2rem;
}

.student-details {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 1rem;
}

.detail-item {
    display: inline-block;
    margin-right: 2rem;
    margin-bottom: 0.5rem;
}

.student-stats {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
    color: white;
}

.stat-number {
    display: block;
    font-size: 1.8rem;
    font-weight: 700;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

/* Profile Tabs */
.profile-tabs .nav-link {
    border-radius: 25px;
    margin-right: 10px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #666;
    transition: all 0.3s ease;
    font-weight: 500;
}

.profile-tabs .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* Cards */
.modern-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.modern-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

/* Attendance Circle */
.attendance-circle {
    position: relative;
    display: inline-block;
}

.attendance-percentage {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.percentage-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: #28a745;
}

.percentage-label {
    font-size: 0.9rem;
    color: #666;
}

.detail-number {
    display: block;
    font-size: 1.2rem;
    font-weight: 600;
}

.detail-label {
    font-size: 0.8rem;
    color: #666;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #667eea, #764ba2);
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-marker {
    position: absolute;
    left: -2rem;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.8rem;
}

.timeline-content {
    background: rgba(255, 255, 255, 0.7);
    padding: 1rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.timeline-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.timeline-description {
    color: #666;
    margin-bottom: 0.5rem;
}

.timeline-time {
    font-size: 0.8rem;
    color: #999;
}

/* Subjects Grid */
.subjects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
}

.subject-card {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.subject-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.subject-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.8);
    font-size: 1.2rem;
}

.subject-info {
    flex: 1;
}

.subject-name {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.subject-score {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.score-number {
    font-size: 1.5rem;
    font-weight: 700;
}

.score-grade {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.2rem 0.5rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
}

.subject-progress {
    height: 6px;
    border-radius: 3px;
    background: rgba(0, 0, 0, 0.1);
}

/* Achievements */
.achievements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
}

.achievement-card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.achievement-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0.1;
    transition: opacity 0.3s ease;
}

.achievement-card.gold::before {
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
}

.achievement-card.silver::before {
    background: linear-gradient(135deg, #c0c0c0 0%, #dcdcdc 100%);
}

.achievement-card.bronze::before {
    background: linear-gradient(135deg, #cd7f32 0%, #daa520 100%);
}

.achievement-card:hover::before {
    opacity: 0.2;
}

.achievement-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.achievement-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    position: relative;
    z-index: 2;
}

.achievement-card.gold .achievement-icon {
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
}

.achievement-card.silver .achievement-icon {
    background: linear-gradient(135deg, #c0c0c0 0%, #dcdcdc 100%);
}

.achievement-card.bronze .achievement-icon {
    background: linear-gradient(135deg, #cd7f32 0%, #daa520 100%);
}

.achievement-content {
    flex: 1;
    position: relative;
    z-index: 2;
}

.achievement-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.achievement-description {
    color: #666;
    margin-bottom: 0.5rem;
}

.achievement-date {
    font-size: 0.8rem;
    color: #999;
}

.achievement-badge {
    position: relative;
    z-index: 2;
}

/* Behavior Scores */
.behavior-scores {
    space-y: 1rem;
}

.behavior-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.behavior-label {
    font-weight: 500;
}

.behavior-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.stars {
    display: flex;
    gap: 0.2rem;
}

.stars i {
    color: #ddd;
    transition: color 0.2s ease;
}

.stars i.active {
    color: #ffd700;
}

.rating-text {
    font-size: 0.9rem;
    color: #666;
    min-width: 80px;
}

/* Attendance Stats */
.attendance-stats {
    space-y: 1rem;
}

.stat-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 0;
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
}

.stat-info {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-label {
    font-weight: 500;
}

.stat-value {
    font-weight: 600;
    color: #333;
}

/* Teacher Notes */
.teacher-notes {
    space-y: 1rem;
}

.note-item {
    background: rgba(255, 255, 255, 0.6);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.note-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.note-teacher {
    font-weight: 600;
    color: #333;
}

.note-date {
    font-size: 0.8rem;
    color: #999;
}

.note-content {
    color: #666;
    line-height: 1.5;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .student-name {
        font-size: 1.5rem;
    }
    
    .student-stats {
        justify-content: center;
    }
    
    .detail-item {
        display: block;
        margin-right: 0;
    }
    
    .subjects-grid {
        grid-template-columns: 1fr;
    }
    
    .achievements-grid {
        grid-template-columns: 1fr;
    }
    
    .behavior-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .note-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Academic Progress Chart
    const academicCtx = document.getElementById('academicChart').getContext('2d');
    new Chart(academicCtx, {
        type: 'line',
        data: {
            labels: ['Sep', 'Okt', 'Nov', 'Des', 'Jan'],
            datasets: [{
                label: 'Rata-rata Nilai',
                data: [82, 85, 83, 87, 87.5],
                borderColor: 'rgb(102, 126, 234)',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: 70,
                    max: 100
                }
            }
        }
    });

    // Attendance Doughnut Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Izin', 'Alpha'],
            datasets: [{
                data: [95, 5, 0],
                backgroundColor: [
                    '#28a745',
                    '#ffc107',
                    '#dc3545'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '75%'
        }
    });

    // Tab switching animations
    document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(e) {
            const targetPane = document.querySelector(e.target.getAttribute('data-bs-target'));
            targetPane.style.opacity = '0';
            targetPane.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                targetPane.style.transition = 'all 0.3s ease';
                targetPane.style.opacity = '1';
                targetPane.style.transform = 'translateY(0)';
            }, 50);
        });
    });

    // Animate stats on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = '0.1s';
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.subject-card, .achievement-card, .timeline-item').forEach(el => {
        observer.observe(el);
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-in {
        animation: slideInUp 0.6s ease-out forwards;
    }
`;
document.head.appendChild(style);
</script>
<?= $this->endSection() ?>
