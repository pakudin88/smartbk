<?= $this->extend('layouts/simple_layout') ?>

<?= $this->section('title') ?>
<?= $title ?? 'Dashboard - Aplikasi Murid' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
        /* Modern Safe Space Dashboard */
        .dashboard-container {
            min-height: 100vh;
            background: linear-gradient(135deg, 
                rgba(116, 144, 255, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 25%,
                rgba(139, 69, 255, 0.1) 50%,
                rgba(255, 255, 255, 0.05) 75%,
                rgba(67, 56, 202, 0.1) 100%
            );
            padding: 2rem 0;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { 
                background: linear-gradient(135deg, 
                    rgba(116, 144, 255, 0.1) 0%, 
                    rgba(255, 255, 255, 0.05) 25%,
                    rgba(139, 69, 255, 0.1) 50%,
                    rgba(255, 255, 255, 0.05) 75%,
                    rgba(67, 56, 202, 0.1) 100%
                );
            }
            50% { 
                background: linear-gradient(135deg, 
                    rgba(67, 56, 202, 0.1) 0%, 
                    rgba(255, 255, 255, 0.05) 25%,
                    rgba(116, 144, 255, 0.1) 50%,
                    rgba(255, 255, 255, 0.05) 75%,
                    rgba(139, 69, 255, 0.1) 100%
                );
            }
        }
        
        .welcome-section {
            text-align: center;
            margin-bottom: 3rem;
            animation: slideDown 0.8s ease-out;
        }
        
        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .welcome-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
            font-weight: 400;
            opacity: 0.9;
        }
        
        .app-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
            animation: fadeInUp 1s ease-out 0.3s both;
        }
        
        .app-card {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            border: var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            min-height: 160px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .app-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 50%, 
                rgba(255, 255, 255, 0) 100%
            );
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .app-card:hover::before {
            opacity: 1;
        }
        
        .app-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        .app-card:active {
            transform: translateY(-4px) scale(1.01);
        }
        
        .app-icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .app-icon-wrapper::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            padding: 2px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: xor;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .app-card:hover .app-icon-wrapper::before {
            opacity: 1;
        }
        
        .app-icon-wrapper i {
            font-size: 2rem;
            transition: all 0.3s ease;
        }
        
        .app-card:hover .app-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }
        
        .app-card:hover .app-icon-wrapper i {
            transform: scale(1.1);
        }
        
        /* Specific app card colors */
        .app-safe-space {
            background: linear-gradient(135deg, 
                rgba(239, 68, 68, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 100%
            );
        }
        
        .app-safe-space .app-icon-wrapper {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        
        .app-academic {
            background: linear-gradient(135deg, 
                rgba(34, 197, 94, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 100%
            );
        }
        
        .app-academic .app-icon-wrapper {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
        }
        
        .app-schedule {
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 100%
            );
        }
        
        .app-schedule .app-icon-wrapper {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }
        
        .app-profile {
            background: linear-gradient(135deg, 
                rgba(168, 85, 247, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 100%
            );
        }
        
        .app-profile .app-icon-wrapper {
            background: linear-gradient(135deg, #a855f7, #9333ea);
            color: white;
        }
        
        .app-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }
        
        .app-description {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.4;
            opacity: 0.8;
        }
        
        /* Statistics Section */
        .stats-section {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            border: var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            animation: fadeInUp 1s ease-out 0.6s both;
        }
        
        .stats-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1.5rem;
        }
        
        .stat-item {
            text-align: center;
            padding: 1rem;
            border-radius: var(--border-radius);
            background: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }
        
        .stat-item:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.7);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 500;
        }
        
        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        .slide-up {
            animation: slideUp 0.8s ease-out;
        }
        
        .slide-down {
            animation: slideDown 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideDown {
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
            .dashboard-container {
                padding: 1rem 0;
            }
            
            .welcome-title {
                font-size: 2rem;
            }
            
            .welcome-subtitle {
                font-size: 1rem;
            }
            
            .app-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
                margin-bottom: 2rem;
            }
            
            .app-card {
                padding: 1.5rem;
                min-height: 140px;
            }
            
            .app-icon-wrapper {
                width: 60px;
                height: 60px;
                margin-bottom: 0.75rem;
            }
            
            .app-icon-wrapper i {
                font-size: 1.75rem;
            }
            
            .app-title {
                font-size: 1.1rem;
            }
            
            .app-description {
                font-size: 0.85rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .welcome-section {
                margin-bottom: 2rem;
            }
            
            .welcome-title {
                font-size: 1.75rem;
            }
            
            .app-card {
                padding: 1.25rem;
                min-height: 120px;
            }
            
            .stats-section {
                padding: 1.5rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }
            
            .stat-item {
                padding: 0.75rem;
            }
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-container page-transition">
    <!-- Welcome Section -->
    <div class="welcome-section fade-in">
        <h1 class="welcome-title">Selamat Datang!</h1>
        <p class="welcome-subtitle">Halo, <?= esc($nama ?? 'Siswa') ?>! Selamat datang di Ruang Aman - Safe Space</p>
    </div>
    
    <!-- Main Apps Grid -->
    <div class="app-grid">
        <!-- Safe Space Dashboard -->
        <a href="<?= base_url('safe-space/dashboard') ?>" class="app-card app-safe-space slide-up">
            <div class="app-icon-wrapper">
                <i class="fas fa-heart"></i>
            </div>
            <div class="app-title">Safe Space</div>
            <div class="app-description">Ruang aman untuk berbagi cerita dan mendapat dukungan</div>
        </a>
        
        <!-- Academic Dashboard -->
        <a href="<?= base_url('academic/dashboard') ?>" class="app-card app-academic slide-up">
            <div class="app-icon-wrapper">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="app-title">Akademik</div>
            <div class="app-description">Pantau nilai, tugas, dan perkembangan akademik Anda</div>
        </a>
        
        <!-- Schedule -->
        <a href="<?= base_url('schedule/view') ?>" class="app-card app-schedule slide-up">
            <div class="app-icon-wrapper">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="app-title">Jadwal</div>
            <div class="app-description">Lihat jadwal pelajaran dan kegiatan sekolah</div>
        </a>
        
        <!-- Profile -->
        <a href="<?= base_url('profile/view') ?>" class="app-card app-profile slide-up">
            <div class="app-icon-wrapper">
                <i class="fas fa-user"></i>
            </div>
            <div class="app-title">Profil</div>
            <div class="app-description">Kelola informasi profil dan pengaturan akun</div>
        </a>
    </div>
    
    <!-- Statistics Section -->
    <div class="stats-section">
        <h3 class="stats-title">Statistik Aktivitas Anda</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">12</div>
                <div class="stat-label">Chat</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">5</div>
                <div class="stat-label">Jurnal</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">3</div>
                <div class="stat-label">Konseling</div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Set current URL for JavaScript
    window.phpCurrentUrl = '<?= $current_url ?? '' ?>';
    
    // Add haptic feedback simulation
    function addHapticFeedback() {
        const appCards = document.querySelectorAll('.app-card');
        
        appCards.forEach(card => {
            card.addEventListener('touchstart', function() {
                // Simulate haptic feedback with a small vibration
                if (navigator.vibrate) {
                    navigator.vibrate(10);
                }
                
                // Add visual feedback
                this.style.transform = 'translateY(-4px) scale(1.01)';
            });
            
            card.addEventListener('touchend', function() {
                // Remove visual feedback
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    }
    
    // Animate app icons on load
    function animateAppIcons() {
        const appCards = document.querySelectorAll('.app-card');
        
        appCards.forEach((card, index) => {
            // Stagger the animation
            setTimeout(() => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('slide-up');
            }, index * 100);
        });
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Small delay to ensure smooth loading
        setTimeout(() => {
            animateAppIcons();
            addHapticFeedback();
        }, 200);
    });
</script>
<?= $this->endSection() ?>
