<?= $this->extend('layouts/simple_layout') ?>

<?= $this->section('title') ?>
Safe Space Dashboard - Ruang Aman
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    /* Elegant Modern Card Grid - Safe Space */
    .page-container {
        background: linear-gradient(135deg, 
            #f8fafc 0%, 
            #f1f5f9 25%, 
            #e2e8f0 50%, 
            #f1f5f9 75%, 
            #f8fafc 100%
        );
        min-height: 100vh;
        padding: 2rem 1rem;
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 4rem;
        animation: fadeInDown 0.8s ease-out;
    }
    
    .page-title {
        font-size: 2.8rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(30, 41, 59, 0.1);
    }
    
    .page-subtitle {
        font-size: 1.2rem;
        color: #64748b;
        font-weight: 400;
        margin-bottom: 0;
    }
    
    /* Main Card Grid Layout */
    .main-card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        max-width: 800px;
        margin: 0 auto;
        animation: fadeInUp 1s ease-out 0.3s both;
    }
    
    /* Feature Cards */
    .feature-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 2.5rem 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        overflow: hidden;
        min-height: 200px;
        backdrop-filter: blur(10px);
    }
    
    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 24px;
        z-index: 1;
    }
    
    .feature-card:hover::before {
        opacity: 1;
    }
    
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
    
    /* Card Icons */
    .card-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
    }
    
    .card-icon i {
        font-size: 2.2rem;
        color: #ffffff;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }
    
    .feature-card:hover .card-icon {
        transform: scale(1.1);
    }
    
    /* Card Content */
    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.75rem;
        position: relative;
        z-index: 2;
    }
    
    .card-description {
        font-size: 0.95rem;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
        position: relative;
        z-index: 2;
    }
    
    /* Individual Card Colors */
    .card-konsul {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    }
    
    .card-konsul::before {
        background: linear-gradient(135deg, rgba(156, 163, 175, 0.05) 0%, rgba(156, 163, 175, 0.1) 100%);
    }
    
    .card-konsul .card-icon {
        background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
    }
    
    .card-jadwal {
        background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
    }
    
    .card-jadwal::before {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(59, 130, 246, 0.1) 100%);
    }
    
    .card-jadwal .card-icon {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }
    
    .card-jurnal {
        background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
    }
    
    .card-jurnal::before {
        background: linear-gradient(135deg, rgba(251, 146, 60, 0.05) 0%, rgba(251, 146, 60, 0.1) 100%);
    }
    
    .card-jurnal .card-icon {
        background: linear-gradient(135deg, #fb923c 0%, #ea580c 100%);
    }
    
    .card-informasi {
        background: linear-gradient(135deg, #faf5ff 0%, #ffffff 100%);
    }
    
    .card-informasi::before {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.05) 0%, rgba(147, 51, 234, 0.1) 100%);
    }
    
    .card-informasi .card-icon {
        background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%);
    }
    
    /* Welcome Section */
    .welcome-section {
        background: #ffffff;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 3rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        text-align: center;
        animation: fadeInUp 1s ease-out 0.1s both;
    }
    
    .welcome-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    
    .welcome-text {
        color: #64748b;
        font-size: 1rem;
        margin: 0;
    }
    
    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .page-container {
            padding: 1.5rem 1rem;
        }
        
        .page-title {
            font-size: 2.2rem;
        }
        
        .page-subtitle {
            font-size: 1.1rem;
        }
        
        .main-card-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            max-width: 400px;
        }
        
        .feature-card {
            padding: 2rem 1.5rem;
            min-height: 180px;
        }
        
        .card-icon {
            width: 70px;
            height: 70px;
            margin-bottom: 1.25rem;
        }
        
        .card-icon i {
            font-size: 2rem;
        }
        
        .card-title {
            font-size: 1.2rem;
        }
        
        .card-description {
            font-size: 0.9rem;
        }
        
        .welcome-section {
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .welcome-title {
            font-size: 1.3rem;
        }
    }
    
    @media (max-width: 480px) {
        .page-container {
            padding: 1rem 0.75rem;
        }
        
        .page-title {
            font-size: 1.9rem;
        }
        
        .page-subtitle {
            font-size: 1rem;
        }
        
        .feature-card {
            padding: 1.75rem 1.25rem;
            min-height: 160px;
        }
        
        .card-icon {
            width: 65px;
            height: 65px;
        }
        
        .card-icon i {
            font-size: 1.8rem;
        }
        
        .card-title {
            font-size: 1.1rem;
        }
        
        .card-description {
            font-size: 0.85rem;
        }
    }
    }
    
    /* Main Feature Cards */
    .feature-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 2rem 1.5rem;
        box-shadow: 0 4px 20px rgba(100, 116, 139, 0.1);
        border: 1px solid rgba(203, 213, 225, 0.6);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        min-height: 200px;
        justify-content: center;
    }
    
    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .feature-card:hover::before {
        transform: scaleX(1);
    }
    
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(100, 116, 139, 0.2);
        border-color: rgba(37, 99, 235, 0.3);
    }
    
    .feature-card:active {
        transform: translateY(-4px);
    }
    
    /* Card Icons */
    .card-icon {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .card-icon i {
        font-size: 2rem;
        color: #ffffff;
        transition: all 0.3s ease;
    }
    
    .feature-card:hover .card-icon {
        transform: scale(1.1);
    }
    
    .feature-card:hover .card-icon i {
        transform: rotate(5deg);
    }
    
    /* Icon Colors - Safe Space BK Features */
    .card-konsul .card-icon {
        background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
    }
    
    .card-jadwal .card-icon {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }
    
    .card-jurnal .card-icon {
        background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
    }
    
    .card-informasi .card-icon {
        background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%);
    }
    
    /* Card Text */
    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }
    
    .card-description {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.5;
        margin: 0;
    }
    
    /* Action Cards */
    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-top: 2rem;
        animation: fadeInUp 1s ease-out 0.6s both;
    }
    
    .action-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(100, 116, 139, 0.08);
        border: 1px solid rgba(203, 213, 225, 0.6);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .action-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(100, 116, 139, 0.15);
        border-color: rgba(37, 99, 235, 0.3);
    }
    
    .action-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .action-icon i {
        font-size: 1.25rem;
        color: #2563eb;
    }
    
    .action-content h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #334155;
        margin: 0 0 0.25rem 0;
    }
    
    .action-content p {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0;
        line-height: 1.4;
    }
    
    /* Status Badge */
    .status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }
    
    .status-badge.offline {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border-color: rgba(239, 68, 68, 0.2);
    }
    
    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .page-container {
            padding: 1.5rem 1rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .page-subtitle {
            font-size: 1rem;
        }
        
        .card-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .feature-card {
            padding: 1.5rem 1rem;
            min-height: 180px;
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
        }
        
        .card-icon i {
            font-size: 1.75rem;
        }
        
        .card-title {
            font-size: 1.1rem;
        }
        
        .card-description {
            font-size: 0.85rem;
        }
        
        .action-grid {
            grid-template-columns: 1fr;
        }
        
        .action-card {
            padding: 1.25rem;
        }
    }
    
    @media (max-width: 480px) {
        .page-container {
            padding: 1rem 0.75rem;
        }
        
        .page-title {
            font-size: 1.75rem;
        }
        
        .card-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        
        .feature-card {
            padding: 1.25rem 1rem;
            min-height: 160px;
        }
        
        .card-icon {
            width: 55px;
            height: 55px;
        }
        
        .card-icon i {
            font-size: 1.5rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Safe Space</h1>
        <p class="page-subtitle">Ruang Aman untuk Kesehatan Mental dan Pembelajaran</p>
    </div>
    
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h3 class="welcome-title">Selamat Datang di Safe Space</h3>
        <p class="welcome-text">Pilih layanan yang Anda butuhkan untuk mendapatkan dukungan dan bantuan terbaik</p>
    </div>
    
    <!-- Main Feature Cards -->
    <div class="main-card-grid">
        <!-- Konsul Cepat & Anonim -->
        <a href="<?= base_url('safe-space/konsul-cepat') ?>" class="feature-card card-konsul">
            <div class="card-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h3 class="card-title">Konsul Cepat & Anonim</h3>
            <p class="card-description">Chat langsung dengan Guru BK<br>Bisa anonim untuk kenyamanan siswa</p>
        </a>
        
        <!-- Jadwalkan Sesi Konseling -->
        <a href="<?= base_url('safe-space/jadwal-konseling') ?>" class="feature-card card-jadwal">
            <div class="card-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <h3 class="card-title">Jadwalkan Sesi Konseling</h3>
            <p class="card-description">Buat jadwal konseling tatap muka atau online<br>Sistem booking yang mudah</p>
        </a>
        
        <!-- Jurnal Digital & Pelacak Emosi -->
        <a href="<?= base_url('safe-space/jurnal-digital') ?>" class="feature-card card-jurnal">
            <div class="card-icon">
                <i class="fas fa-journal-whills"></i>
            </div>
            <h3 class="card-title">Jurnal Digital & Pelacak Emosi</h3>
            <p class="card-description">Catat harian dan lacak mood setiap hari<br>Fitur mood tracker terintegrasi</p>
        </a>
        
        <!-- Pusat Informasi & Bantuan -->
        <a href="<?= base_url('safe-space/pusat-informasi') ?>" class="feature-card card-informasi">
            <div class="card-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <h3 class="card-title">Pusat Informasi & Bantuan</h3>
            <p class="card-description">Artikel, video, tips untuk kesehatan mental<br>Resource pembelajaran dan bantuan</p>
        </a>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Enhanced interactive animations for Safe Space
    document.addEventListener('DOMContentLoaded', function() {
        // Stagger card animations with better timing
        const cards = document.querySelectorAll('.feature-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${0.4 + (index * 0.15)}s`;
        });
        
        // Add enhanced hover effects
        cards.forEach((card, index) => {
            card.addEventListener('mouseenter', function() {
                // Add scale effect to icon
                const icon = this.querySelector('.card-icon');
                if (icon) {
                    icon.style.transform = 'scale(1.15) rotate(5deg)';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                // Reset icon transform
                const icon = this.querySelector('.card-icon');
                if (icon) {
                    icon.style.transform = 'scale(1) rotate(0deg)';
                }
            });
            
            // Add click feedback with ripple effect
            card.addEventListener('click', function(e) {
                // Create ripple effect
                const ripple = document.createElement('div');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.4);
                    transform: scale(0);
                    animation: ripple 0.6s ease-out;
                    pointer-events: none;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${e.clientX - rect.left - size / 2}px;
                    top: ${e.clientY - rect.top - size / 2}px;
                    z-index: 10;
                `;
                
                this.appendChild(ripple);
                
                // Remove ripple after animation
                setTimeout(() => {
                    if (ripple.parentNode) {
                        ripple.remove();
                    }
                }, 600);
                
                // Add feedback animation to the card
                this.style.transform = 'translateY(-8px) scale(0.98)';
                setTimeout(() => {
                    this.style.transform = 'translateY(-8px) scale(1)';
                }, 150);
            });
        });
        
        // Add floating animation to welcome section
        const welcomeSection = document.querySelector('.welcome-section');
        if (welcomeSection) {
            let floatDirection = 1;
            setInterval(() => {
                welcomeSection.style.transform = `translateY(${floatDirection * 2}px)`;
                floatDirection *= -1;
            }, 3000);
        }
        
        // Add parallax effect on scroll
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.feature-card');
            
            parallaxElements.forEach((element, index) => {
                const speed = 0.1 + (index * 0.02);
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });
    });
    
    // Enhanced CSS animations
    const enhancedStyles = document.createElement('style');
    enhancedStyles.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .feature-card {
            position: relative;
            overflow: hidden;
        }
        
        .welcome-section {
            animation: float 6s ease-in-out infinite;
        }
        
        .card-icon {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Smooth gradient transitions */
        .card-konsul:hover {
            background: linear-gradient(135deg, #f3f4f6 0%, #ffffff 100%);
        }
        
        .card-jadwal:hover {
            background: linear-gradient(135deg, #dbeafe 0%, #ffffff 100%);
        }
        
        .card-jurnal:hover {
            background: linear-gradient(135deg, #fed7aa 0%, #ffffff 100%);
        }
        
        .card-informasi:hover {
            background: linear-gradient(135deg, #e9d5ff 0%, #ffffff 100%);
        }
        
        /* Loading shimmer effect */
        @keyframes shimmer {
            0% { background-position: -200px 0; }
            100% { background-position: calc(200px + 100%) 0; }
        }
        
        .feature-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.4),
                transparent
            );
            background-size: 200px 100%;
            animation: shimmer 2s infinite;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .feature-card:hover::after {
            opacity: 1;
        }
    `;
    document.head.appendChild(enhancedStyles);
</script>
<?= $this->endSection() ?>
