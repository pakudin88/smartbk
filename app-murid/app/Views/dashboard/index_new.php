<?= $this->extend('layouts/simple_layout') ?>

<?= $this->section('title') ?>
<?= $title ?? 'Dashboard - Aplikasi Murid' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <?php if (!empty($user['foto'])): ?>
                                <img src="<?= base_url('uploads/profiles/' . $user['foto']) ?>" 
                                     alt="Profile" 
                                     class="rounded-circle" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-user fs-4"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="mb-1">Selamat datang, <?= $user['name'] ?? 'Siswa' ?>!</h4>
                            <p class="mb-0 opacity-75">
                                <?php if (!empty($user['kelas'])): ?>
                                    Kelas <?= $user['kelas'] ?> • <?= $user['tahun_ajaran'] ?? 'Tahun Ajaran' ?>
                                <?php else: ?>
                                    Aplikasi Murid - Safe Space
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="text-end">
                            <small class="opacity-75">
                                <?= date('l, d F Y') ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-primary mb-2">
                        <i class="fas fa-book fs-2"></i>
                    </div>
                    <h5 class="card-title">Mata Pelajaran</h5>
                    <h3 class="text-primary mb-0">12</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-success mb-2">
                        <i class="fas fa-tasks fs-2"></i>
                    </div>
                    <h5 class="card-title">Tugas Selesai</h5>
                    <h3 class="text-success mb-0">8</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-warning mb-2">
                        <i class="fas fa-clock fs-2"></i>
                    </div>
                    <h5 class="card-title">Tugas Pending</h5>
                    <h3 class="text-warning mb-0">3</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-info mb-2">
                        <i class="fas fa-chart-line fs-2"></i>
                    </div>
                    <h5 class="card-title">Rata-rata Nilai</h5>
                    <h3 class="text-info mb-0">85</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Applications -->
    <div class="row">
        <div class="col-12">
            <h5 class="mb-3">
                <i class="fas fa-apps me-2"></i>
                Aplikasi Utama
            </h5>
        </div>
    </div>

    <div class="row">
        <!-- Jurnal Digital -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 app-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-journal-whills text-primary fs-2"></i>
                        </div>
                    </div>
                    <h5 class="card-title">Jurnal Digital</h5>
                    <p class="card-text text-muted">
                        Tulis perasaan dan pemikiran Anda dalam jurnal digital yang aman dan private.
                    </p>
                    <a href="<?= base_url('jurnal-digital') ?>" class="btn btn-primary">
                        <i class="fas fa-pen me-2"></i>Buka Jurnal
                    </a>
                </div>
            </div>
        </div>

        <!-- Konseling BK -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 app-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-comments text-success fs-2"></i>
                        </div>
                    </div>
                    <h5 class="card-title">Konseling BK</h5>
                    <p class="card-text text-muted">
                        Konsultasi dengan guru BK untuk mendapatkan bimbingan dan dukungan.
                    </p>
                    <a href="<?= base_url('konseling') ?>" class="btn btn-success">
                        <i class="fas fa-user-friends me-2"></i>Mulai Konseling
                    </a>
                </div>
            </div>
        </div>

        <!-- Tugas & Nilai -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 app-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-clipboard-list text-warning fs-2"></i>
                        </div>
                    </div>
                    <h5 class="card-title">Tugas & Nilai</h5>
                    <p class="card-text text-muted">
                        Lihat tugas yang diberikan guru dan pantau perkembangan nilai Anda.
                    </p>
                    <a href="<?= base_url('tugas') ?>" class="btn btn-warning">
                        <i class="fas fa-tasks me-2"></i>Lihat Tugas
                    </a>
                </div>
            </div>
        </div>

        <!-- Jadwal Pelajaran -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 app-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar-alt text-info fs-2"></i>
                        </div>
                    </div>
                    <h5 class="card-title">Jadwal Pelajaran</h5>
                    <p class="card-text text-muted">
                        Lihat jadwal mata pelajaran dan kegiatan sekolah hari ini dan minggu ini.
                    </p>
                    <a href="<?= base_url('jadwal') ?>" class="btn btn-info">
                        <i class="fas fa-clock me-2"></i>Lihat Jadwal
                    </a>
                </div>
            </div>
        </div>

        <!-- Profil -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 app-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-user-cog text-secondary fs-2"></i>
                        </div>
                    </div>
                    <h5 class="card-title">Profil Saya</h5>
                    <p class="card-text text-muted">
                        Kelola informasi profil, ubah password, dan pengaturan akun Anda.
                    </p>
                    <a href="<?= base_url('profil') ?>" class="btn btn-secondary">
                        <i class="fas fa-user me-2"></i>Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <!-- Pengumuman -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 app-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-bullhorn text-danger fs-2"></i>
                        </div>
                    </div>
                    <h5 class="card-title">Pengumuman</h5>
                    <p class="card-text text-muted">
                        Baca pengumuman terbaru dari sekolah dan guru mata pelajaran.
                    </p>
                    <a href="<?= base_url('pengumuman') ?>" class="btn btn-danger">
                        <i class="fas fa-megaphone me-2"></i>Lihat Pengumuman
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <div class="col-12">
            <h5 class="mb-3">
                <i class="fas fa-history me-2"></i>
                Aktivitas Terbaru
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h6 class="mb-0">
                        <i class="fas fa-tasks text-primary me-2"></i>
                        Tugas Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                            <i class="fas fa-book text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Matematika - Latihan Soal BAB 5</h6>
                            <small class="text-muted">Deadline: 15 Juli 2025</small>
                        </div>
                        <span class="badge bg-warning">Pending</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                            <i class="fas fa-flask text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Fisika - Laporan Praktikum</h6>
                            <small class="text-muted">Deadline: 20 Juli 2025</small>
                        </div>
                        <span class="badge bg-success">Selesai</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                            <i class="fas fa-language text-info"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Bahasa Indonesia - Essay</h6>
                            <small class="text-muted">Deadline: 18 Juli 2025</small>
                        </div>
                        <span class="badge bg-primary">Dikerjakan</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h6 class="mb-0">
                        <i class="fas fa-calendar text-success me-2"></i>
                        Jadwal Hari Ini
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="text-center me-3" style="width: 50px;">
                            <div class="fw-bold text-primary">07:00</div>
                            <small class="text-muted">08:30</small>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Matematika</h6>
                            <small class="text-muted">Ruang 12A • Pak Budi</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="text-center me-3" style="width: 50px;">
                            <div class="fw-bold text-success">08:30</div>
                            <small class="text-muted">10:00</small>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Fisika</h6>
                            <small class="text-muted">Lab Fisika • Bu Sari</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="text-center me-3" style="width: 50px;">
                            <div class="fw-bold text-info">10:15</div>
                            <small class="text-muted">11:45</small>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Bahasa Indonesia</h6>
                            <small class="text-muted">Ruang 12A • Bu Rina</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.app-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.app-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.app-card .btn {
    transition: all 0.3s ease;
}

.app-card:hover .btn {
    transform: scale(1.05);
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.app-card.slide-up {
    animation: slideUp 0.6s ease-out forwards;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate app cards on load
    const appCards = document.querySelectorAll('.app-card');
    
    appCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('slide-up');
        }, index * 100);
    });
});
</script>
<?= $this->endSection() ?>
