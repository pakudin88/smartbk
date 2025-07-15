<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>

<style>
    /* Enhanced Dashboard Styling */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #4A90E2 100%);
        border-radius: 20px;
        color: white;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -15%;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(10deg); }
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 20px;
        position: relative;
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .stat-icon.green {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        box-shadow: 0 8px 25px rgba(17, 153, 142, 0.4);
    }

    .stat-icon.orange {
        background: linear-gradient(135deg, #ff6b6b, #ffa500);
        color: white;
        box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
    }

    .stat-icon.purple {
        background: linear-gradient(135deg, #a8edea, #fed6e3);
        color: #6b46c1;
        box-shadow: 0 8px 25px rgba(168, 237, 234, 0.4);
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .btn-elegant {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-elegant:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
        color: white;
    }
</style>

<!-- Page Header -->
<div class="mb-4">
    <h1 class="page-title">
        <i class="fas fa-tachometer-alt me-3"></i>Dashboard SmartBK
    </h1>
    <p class="text-muted" style="font-size: 1.2rem;">Selamat datang di portal bimbingan konseling terdepan</p>
</div>

<!-- Hero Welcome Section -->
<div class="hero-section">
    <div class="welcome-content">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="mb-3" style="font-size: 2.2rem; font-weight: 700;">
                    <i class="fas fa-hand-wave me-2"></i>Halo, <?= esc($user_name) ?>!
                </h2>
                <p class="mb-4" style="font-size: 1.1rem; opacity: 0.95;">
                    Selamat datang kembali di SmartBK. Sistem bimbingan konseling yang membantu Anda memberikan pelayanan terbaik untuk siswa.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <span class="badge bg-white bg-opacity-25 px-3 py-2" style="font-size: 0.9rem;">
                        <i class="fas fa-user me-2"></i><?= esc($username) ?>
                    </span>
                    <span class="badge bg-white bg-opacity-25 px-3 py-2" style="font-size: 0.9rem;">
                        <i class="fas fa-shield-alt me-2"></i><?= session('role_name') ?? 'Guru' ?>
                    </span>
                </div>
                <button class="btn btn-elegant">
                    <i class="fas fa-rocket me-2"></i>Mulai Bekerja
                </button>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="fas fa-graduation-cap" style="font-size: 150px; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="quick-stats">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-users"></i>
        </div>
        <div style="font-size: 2.5rem; font-weight: 800; color: #2c3e50; margin-bottom: 8px;">1,247</div>
        <div style="font-size: 1rem; color: #6c757d; font-weight: 600; margin-bottom: 15px;">Total Siswa</div>
        <div style="color: #11998e; font-size: 0.85rem; font-weight: 600;">
            <i class="fas fa-arrow-up me-1"></i>+12% dari bulan lalu
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-user-md"></i>
        </div>
        <div style="font-size: 2.5rem; font-weight: 800; color: #2c3e50; margin-bottom: 8px;">89</div>
        <div style="font-size: 1rem; color: #6c757d; font-weight: 600; margin-bottom: 15px;">Sesi Konseling</div>
        <div style="color: #11998e; font-size: 0.85rem; font-weight: 600;">
            <i class="fas fa-arrow-up me-1"></i>+8% minggu ini
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div style="font-size: 2.5rem; font-weight: 800; color: #2c3e50; margin-bottom: 8px;">156</div>
        <div style="font-size: 1rem; color: #6c757d; font-weight: 600; margin-bottom: 15px;">Assessment Selesai</div>
        <div style="color: #11998e; font-size: 0.85rem; font-weight: 600;">
            <i class="fas fa-arrow-up me-1"></i>+15% bulan ini
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-chart-line"></i>
        </div>
        <div style="font-size: 2.5rem; font-weight: 800; color: #2c3e50; margin-bottom: 8px;">94%</div>
        <div style="font-size: 1rem; color: #6c757d; font-weight: 600; margin-bottom: 15px;">Tingkat Kepuasan</div>
        <div style="color: #11998e; font-size: 0.85rem; font-weight: 600;">
            <i class="fas fa-arrow-up me-1"></i>Excellent rating
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
