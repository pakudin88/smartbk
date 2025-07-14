<?= $this->extend('layouts/minimal_layout') ?>

<?= $this->section('content') ?>
<style>
/* Mobile-First Dashboard Design - Safe Space Style */
.dashboard-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #e8f4f8 0%, #f3e5f5 50%, #fff3e0 100%);
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
}

.mobile-header {
    background: linear-gradient(135deg, #4a90e2 0%, #7b68ee 100%);
    color: white;
    padding: 1rem 0;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.time-display {
    font-size: 2rem;
    font-weight: 300;
    margin-bottom: 0.5rem;
}

.date-display {
    font-size: 0.9rem;
    opacity: 0.9;
}

.app-title {
    background: white;
    padding: 1rem;
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
    color: #4a5568;
    text-align: center;
    border-bottom: 1px solid #e2e8f0;
}

.apps-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    padding: 2rem 1.5rem;
    max-width: 500px;
    margin: 0 auto;
}

.app-card {
    background: white;
    border-radius: 20px;
    padding: 2rem 1.5rem;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    cursor: pointer;
    border: 1px solid rgba(0,0,0,0.05);
    text-decoration: none;
    color: inherit;
}

.app-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    color: inherit;
    text-decoration: none;
}

.app-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.8rem;
    color: white;
}

.app-icon.konsul { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); }
.app-icon.jadwal { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.app-icon.jurnal { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
.app-icon.informasi { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }

.app-title-text {
    font-size: 1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.app-description {
    font-size: 0.8rem;
    color: #718096;
    line-height: 1.4;
    margin: 0;
}

.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    border-radius: 25px 25px 0 0;
    box-shadow: 0 -2px 20px rgba(0,0,0,0.1);
    padding: 1rem 2rem;
    display: flex;
    gap: 2rem;
    align-items: center;
    min-width: 300px;
    justify-content: center;
}

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: #a0aec0;
    transition: color 0.3s ease;
    padding: 0.5rem;
}

.nav-item.active,
.nav-item:hover {
    color: #4a90e2;
}

.nav-item i {
    font-size: 1.2rem;
    margin-bottom: 0.25rem;
}

.nav-item span {
    font-size: 0.7rem;
    font-weight: 500;
}

/* Welcome Message */
.welcome-message {
    background: white;
    margin: 0 1.5rem 1rem;
    padding: 1rem;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    text-align: center;
}

.welcome-text {
    font-size: 1rem;
    color: #4a5568;
    margin: 0;
}

.user-name {
    font-weight: 600;
    color: #2d3748;
}

/* Responsive adjustments */
@media (max-width: 480px) {
    .apps-grid {
        padding: 1.5rem 1rem;
        gap: 1rem;
    }
    
    .app-card {
        padding: 1.5rem 1rem;
    }
    
    .bottom-nav {
        min-width: 100%;
        border-radius: 0;
        padding: 1rem;
    }
    
    .welcome-message {
        margin: 0 1rem 1rem;
    }
}

/* Remove default container margins */
.container-fluid {
    padding: 0 !important;
}

.navbar {
    display: none !important;
}
</style>

<div class="dashboard-container">
    <!-- Mobile Header -->
    <div class="mobile-header">
        <div class="time-display"><?= date('H:i') ?></div>
        <div class="date-display">
            JUMAT
            <br><?= date('d') ?> Juli <?= date('Y') ?>
        </div>
    </div>
    
    <!-- App Title -->
    <div class="app-title">RUANG AMAN</div>
    
    <!-- Welcome Message -->
    <div class="welcome-message">
        <p class="welcome-text">
            Selamat datang, <span class="user-name"><?= $user['name'] ?? 'Siswa' ?></span>!
        </p>
    </div>
    
    <!-- Apps Grid -->
    <div class="apps-grid">
        <a href="<?= base_url('safe-space/konsul-cepat') ?>" class="app-card">
            <div class="app-icon konsul">
                <i class="fas fa-comments"></i>
            </div>
            <div class="app-title-text">Konsul Cepat & Anonim</div>
            <p class="app-description">Chat langsung dengan Guru BK, bisa anonim</p>
        </a>
        
        <a href="<?= base_url('safe-space/jadwal-konseling') ?>" class="app-card">
            <div class="app-icon jadwal">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="app-title-text">Jadwalkan Sesi Konseling</div>
            <p class="app-description">Atur jadwal konseling tatap muka atau online</p>
        </a>
        
        <a href="<?= base_url('jurnal-digital') ?>" class="app-card">
            <div class="app-icon jurnal">
                <i class="fas fa-journal-whills"></i>
            </div>
            <div class="app-title-text">Jurnal Digital & Pelacak Emosi</div>
            <p class="app-description">Catat perasaan dan lacak mood setiap hari</p>
        </a>
        
        <a href="<?= base_url('safe-space/pusat-informasi') ?>" class="app-card">
            <div class="app-icon informasi">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="app-title-text">Pusat Informasi & Bantuan</div>
            <p class="app-description">Artikel, video, tips untuk kesehatan mental</p>
        </a>
    </div>
</div>

<!-- Bottom Navigation -->
<div class="bottom-nav">
    <a href="<?= base_url('dashboard') ?>" class="nav-item active">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="<?= base_url('safe-space/konsul-cepat') ?>" class="nav-item">
        <i class="fas fa-comments"></i>
        <span>Chat</span>
    </a>
    <a href="<?= base_url('jurnal-digital') ?>" class="nav-item">
        <i class="fas fa-heart"></i>
        <span>Jurnal</span>
    </a>
    <a href="<?= base_url('logout') ?>" class="nav-item">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>
</div>
<?= $this->endSection() ?>
