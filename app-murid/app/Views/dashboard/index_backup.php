<?= $this->extend('layouts/simple_layout') ?>

<?= $this->section('title') ?>
<?= $title ?? 'Dashboard - Aplikasi Murid' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
        /* Modern Mobile-Inspired Dashboard */
        .dashboard-container {
            min-height: 100vh;
            background: linear-gradient(135deg, 
                #667eea 0%, 
                #764ba2 50%,
                #f093fb 100%
            );
            padding: 0;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Background Elements */
        .dashboard-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.08)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }
        
        /* Safe Area for mobile */
        .safe-area {
            padding-top: env(safe-area-inset-top, 20px);
            padding-bottom: env(safe-area-inset-bottom, 20px);
            padding-left: env(safe-area-inset-left, 20px);
            padding-right: env(safe-area-inset-right, 20px);
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }
        
        /* Main Apps Grid - iPhone Style */
        .app-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 40px 20px;
            max-width: 400px;
            margin: 0 auto;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* App Cards - iOS Style */
        .app-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 24px 16px;
            text-decoration: none;
            color: white;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            text-align: center;
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                0 4px 16px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transform-style: preserve-3d;
        }
        
        .app-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.2) 0%, 
                rgba(255, 255, 255, 0) 50%, 
                rgba(255, 255, 255, 0.1) 100%
            );
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 24px;
        }
        
        .app-card:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.2),
                0 8px 24px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }
        
        .app-card:hover::before {
            opacity: 1;
        }
        
        .app-card:active {
            transform: translateY(-4px) scale(1.02);
            transition-duration: 0.1s;
        }
        
        /* App Icons - Modern Style */
        .app-icon-wrapper {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            position: relative;
            box-shadow: 
                0 4px 12px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .app-icon-wrapper i {
            font-size: 24px;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        
        .app-card:hover .app-icon-wrapper {
            transform: scale(1.1) rotateY(5deg);
            box-shadow: 
                0 6px 16px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }
        
        .app-card:hover .app-icon-wrapper i {
            transform: scale(1.1);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
        }
        
        /* Individual Card Themes */
        .app-konsul {
            background: linear-gradient(135deg, 
                rgba(156, 163, 175, 0.3) 0%, 
                rgba(107, 114, 128, 0.2) 100%
            );
        }
        
        .app-konsul .app-icon-wrapper {
            background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
        }
        
        .app-jadwal {
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.3) 0%, 
                rgba(37, 99, 235, 0.2) 100%
            );
        }
        
        .app-jadwal .app-icon-wrapper {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }
        
        .app-jurnal {
            background: linear-gradient(135deg, 
                rgba(251, 146, 60, 0.3) 0%, 
                rgba(249, 115, 22, 0.2) 100%
            );
        }
        
        .app-jurnal .app-icon-wrapper {
            background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
        }
        
        .app-informasi {
            background: linear-gradient(135deg, 
                rgba(147, 51, 234, 0.3) 0%, 
                rgba(124, 58, 237, 0.2) 100%
            );
        }
        
        .app-informasi .app-icon-wrapper {
            background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%);
        }
        
        /* App Text */
        .app-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
            color: white;
            line-height: 1.2;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            letter-spacing: 0.3px;
        }
        
        .app-description {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.3;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            max-width: 120px;
            text-align: center;
        }
        
        /* Haptic feedback effect */
        .app-card:active {
            animation: haptic 0.1s ease-out;
        }
        
        @keyframes haptic {
            0% { transform: scale(1.05); }
            50% { transform: scale(0.98); }
            100% { transform: scale(1.02); }
        }
        
        /* Status bar style indicator */
        .status-indicator {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0.3) 0%,
                rgba(255, 255, 255, 0.6) 50%,
                rgba(255, 255, 255, 0.3) 100%
            );
            z-index: 1000;
            animation: pulse 2s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.7; }
        }
            font-size: 2.8rem; /* Larger base title */
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            line-height: 1.2;
        }
        
        .welcome-subtitle {
            color: var(--text-secondary);
            font-size: 1.2rem; /* Larger base subtitle */
            font-weight: 400;
            opacity: 0.9;
            line-height: 1.4;
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
        
        /* Specific BK Safe Space app card colors */
        .app-konsul {
            background: linear-gradient(135deg, 
                rgba(156, 163, 175, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 100%
            );
        }
        
        .app-konsul .app-icon-wrapper {
            background: linear-gradient(135deg, #9ca3af, #6b7280);
            color: white;
        }
        
        .app-jadwal {
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 100%
            );
        }
        
        .app-jadwal .app-icon-wrapper {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }
        
        .app-jurnal {
            background: linear-gradient(135deg, 
                rgba(251, 146, 60, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 100%
            );
        }
        
        .app-jurnal .app-icon-wrapper {
            background: linear-gradient(135deg, #fb923c, #f97316);
            color: white;
        }
        
        .app-informasi {
            background: linear-gradient(135deg, 
                rgba(147, 51, 234, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 100%
            );
        }
        
        .app-informasi .app-icon-wrapper {
            background: linear-gradient(135deg, #9333ea, #7c3aed);
            color: white;
        }
        
        .app-title {
            font-size: 1.35rem; /* Slightly larger base size */
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            line-height: 1.3;
        }
        
        .app-description {
            font-size: 1rem; /* Larger base description */
            color: var(--text-secondary);
            line-height: 1.5;
            opacity: 0.85;
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
        
        /* Responsive Design - Mobile First */
        @media (max-width: 480px) {
            .safe-area {
                padding: 20px 16px;
            }
            
            .app-grid {
                gap: 16px;
                padding: 30px 16px;
                max-width: 340px;
            }
            
            .app-card {
                padding: 20px 12px;
                min-height: 120px;
                border-radius: 20px;
            }
            
            .app-icon-wrapper {
                width: 48px;
                height: 48px;
                margin-bottom: 10px;
            }
            
            .app-icon-wrapper i {
                font-size: 20px;
            }
            
            .app-title {
                font-size: 13px;
            }
            
            .app-description {
                font-size: 10px;
                max-width: 100px;
            }
        }
        
        @media (min-width: 481px) and (max-width: 768px) {
            .app-grid {
                max-width: 500px;
                gap: 24px;
                padding: 50px 24px;
            }
            
            .app-card {
                padding: 28px 20px;
                min-height: 160px;
            }
            
            .app-icon-wrapper {
                width: 64px;
                height: 64px;
                margin-bottom: 16px;
            }
            
            .app-icon-wrapper i {
                font-size: 28px;
            }
            
            .app-title {
                font-size: 16px;
                margin-bottom: 6px;
            }
            
            .app-description {
                font-size: 12px;
                max-width: 140px;
            }
        }
        
        @media (min-width: 769px) {
            .app-grid {
                max-width: 600px;
                gap: 28px;
                padding: 60px 30px;
            }
            
            .app-card {
                padding: 32px 24px;
                min-height: 180px;
            }
            
            .app-icon-wrapper {
                width: 72px;
                height: 72px;
                margin-bottom: 20px;
            }
            
            .app-icon-wrapper i {
                font-size: 32px;
            }
            
            .app-title {
                font-size: 18px;
                margin-bottom: 8px;
            }
            
            .app-description {
                font-size: 13px;
                max-width: 160px;
            }
        }
            /* Mobile-first approach with larger elements */
            .dashboard-container {
                padding: 1.5rem 0;
            }
            
            .welcome-section {
                margin-bottom: 2.5rem;
                padding: 0 1rem;
            }
            
            .welcome-title {
                font-size: 2.2rem; /* Larger title for mobile */
                line-height: 1.2;
                margin-bottom: 0.75rem;
            }
            
            .welcome-subtitle {
                font-size: 1.1rem; /* Larger subtitle */
                line-height: 1.4;
            }
            
            .app-grid {
                padding: 0 1rem;
                grid-template-columns: 1fr;
                gap: 1.5rem;
                margin-bottom: 2.5rem;
            }
            
            .app-card {
                padding: 2rem 1.5rem; /* More generous padding */
                min-height: 160px; /* Taller cards */
                border-radius: 20px; /* More rounded corners */
            }
            
            .app-icon-wrapper {
                width: 80px; /* Larger icons */
                height: 80px;
                margin-bottom: 1rem;
            }
            
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .app-card {
                background: rgba(0, 0, 0, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .app-card:hover {
                background: rgba(0, 0, 0, 0.3);
            }
        }
        
        /* Reduced motion for accessibility */
        @media (prefers-reduced-motion: reduce) {
            .app-card {
                transition: none;
            }
            
            .app-icon-wrapper {
                transition: none;
            }
            
            .dashboard-container::before {
                animation: none;
            }
            
            .status-indicator {
                animation: none;
            }
        }
        
        /* High contrast mode */
        @media (prefers-contrast: high) {
            .app-card {
                border: 2px solid rgba(255, 255, 255, 0.6);
                background: rgba(0, 0, 0, 0.8);
            }
            
            .app-title, .app-description {
                text-shadow: none;
                color: white;
            }
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Status Indicator -->
<div class="status-indicator"></div>

<div class="dashboard-container page-transition">
    <div class="safe-area">
        <!-- Main Apps Grid -->
        <div class="app-grid">
        <!-- Konsul Cepat & Anonim -->
        <a href="<?= base_url('safe-space/konsul-cepat') ?>" class="app-card app-konsul slide-up">
            <div class="app-icon-wrapper">
                <i class="fas fa-comments"></i>
            </div>
            <div class="app-title">💬 Konsul Cepat & Anonim</div>
            <div class="app-description">Chat langsung dengan Guru BK<br>Bisa anonim untuk kenyamanan siswa</div>
        </a>
        
        <!-- Jadwalkan Sesi Konseling -->
        <a href="<?= base_url('safe-space/jadwal-konseling') ?>" class="app-card app-jadwal slide-up">
            <div class="app-icon-wrapper">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="app-title">📅 Jadwalkan Sesi Konseling</div>
            <div class="app-description">Buat jadwal konseling tatap muka atau online<br>Sistem booking yang mudah</div>
        </a>
        
        <!-- Jurnal Digital & Pelacak Emosi -->
        <a href="<?= base_url('safe-space/jurnal-digital') ?>" class="app-card app-jurnal slide-up">
            <div class="app-icon-wrapper">
                <i class="fas fa-journal-whills"></i>
            </div>
            <div class="app-title">📔 Jurnal Digital & Pelacak Emosi</div>
            <div class="app-description">Catat harian dan lacak mood setiap hari<br>Fitur mood tracker terintegrasi</div>
        </a>
        
        <!-- Pusat Informasi & Bantuan -->
        <a href="<?= base_url('safe-space/pusat-informasi') ?>" class="app-card app-informasi slide-up">
            <div class="app-icon-wrapper">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="app-title">ℹ️ Pusat Informasi & Bantuan</div>
            <div class="app-description">Artikel, video, tips untuk kesehatan mental<br>Resource pembelajaran dan bantuan</div>
        </a>        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Modern Mobile-Style Interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced mobile interactions
        initializeMobileInteractions();
        
        // Add stagger animation to cards
        staggerCardAnimations();
        
        // Initialize haptic feedback
        initializeHapticFeedback();
        
        // Add touch feedback
        addTouchFeedback();
        
        // Prevent zoom on double tap
        preventDoubleZoom();
    });
    
    function initializeMobileInteractions() {
        const appCards = document.querySelectorAll('.app-card');
        
        appCards.forEach((card, index) => {
            // Add custom data attribute for identification
            card.setAttribute('data-card-index', index);
            
            // Enhanced touch interactions
            card.addEventListener('touchstart', handleTouchStart, { passive: false });
            card.addEventListener('touchend', handleTouchEnd, { passive: false });
            card.addEventListener('touchmove', handleTouchMove, { passive: false });
            
            // Mouse interactions for desktop
            card.addEventListener('mousedown', handleMouseDown);
            card.addEventListener('mouseup', handleMouseUp);
            card.addEventListener('mouseleave', handleMouseLeave);
            
            // Focus interactions for accessibility
            card.addEventListener('focus', handleFocus);
            card.addEventListener('blur', handleBlur);
        });
    }
    
    function staggerCardAnimations() {
        const appCards = document.querySelectorAll('.app-card');
        
        appCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }
    
    function initializeHapticFeedback() {
        // Modern haptic feedback using Vibration API
        if ('vibrate' in navigator) {
            const appCards = document.querySelectorAll('.app-card');
            
            appCards.forEach(card => {
                card.addEventListener('touchstart', () => {
                    // Light haptic feedback (10ms)
                    navigator.vibrate(10);
                });
                
                card.addEventListener('touchend', () => {
                    // Slightly stronger feedback on release (15ms)
                    navigator.vibrate(15);
                });
            });
        }
    }
    
    function addTouchFeedback() {
        const appCards = document.querySelectorAll('.app-card');
        
        appCards.forEach(card => {
            let pressTimer;
            let isLongPress = false;
            
            card.addEventListener('touchstart', (e) => {
                isLongPress = false;
                card.classList.add('touching');
                
                // Long press detection
                pressTimer = setTimeout(() => {
                    isLongPress = true;
                    // Add special long press effect
                    card.style.transform = 'scale(0.95) translateY(-2px)';
                    if ('vibrate' in navigator) {
                        navigator.vibrate(50); // Longer vibration for long press
                    }
                }, 500);
            });
            
            card.addEventListener('touchend', (e) => {
                clearTimeout(pressTimer);
                card.classList.remove('touching');
                
                if (!isLongPress) {
                    // Normal tap - add ripple effect
                    createRippleEffect(e, card);
                }
                
                // Reset transform
                setTimeout(() => {
                    card.style.transform = '';
                }, 150);
            });
            
            card.addEventListener('touchmove', () => {
                clearTimeout(pressTimer);
                card.classList.remove('touching');
            });
        });
    }
    
    function createRippleEffect(event, element) {
        const ripple = document.createElement('div');
        const rect = element.getBoundingClientRect();
        
        // Calculate touch position
        const touch = event.changedTouches ? event.changedTouches[0] : event;
        const size = Math.max(rect.width, rect.height);
        const x = touch.clientX - rect.left - size / 2;
        const y = touch.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            z-index: 10;
        `;
        
        element.style.position = 'relative';
        element.appendChild(ripple);
        
        // Remove ripple after animation
        setTimeout(() => {
            if (ripple.parentNode) {
                ripple.remove();
            }
        }, 600);
    }
    
    function preventDoubleZoom() {
        // Prevent double-tap zoom on mobile
        let lastTouchEnd = 0;
        document.addEventListener('touchend', function(event) {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    }
    
    // Touch event handlers
    function handleTouchStart(e) {
        this.classList.add('touching');
        this.style.transform = 'scale(0.98) translateY(-2px)';
    }
    
    function handleTouchEnd(e) {
        this.classList.remove('touching');
        this.style.transform = 'scale(1.02) translateY(-4px)';
        
        setTimeout(() => {
            this.style.transform = '';
        }, 200);
    }
    
    function handleTouchMove(e) {
        this.classList.remove('touching');
        this.style.transform = '';
    }
    
    // Mouse event handlers
    function handleMouseDown(e) {
        this.style.transform = 'scale(0.98) translateY(-2px)';
    }
    
    function handleMouseUp(e) {
        this.style.transform = 'scale(1.02) translateY(-4px)';
        setTimeout(() => {
            this.style.transform = '';
        }, 200);
    }
    
    function handleMouseLeave(e) {
        this.style.transform = '';
        this.classList.remove('touching');
    }
    
    // Focus handlers for accessibility
    function handleFocus(e) {
        this.style.outline = '3px solid rgba(255, 255, 255, 0.8)';
        this.style.outlineOffset = '2px';
    }
    
    function handleBlur(e) {
        this.style.outline = 'none';
    }
    
    // Add custom CSS for ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .app-card.touching {
            transition-duration: 0.1s;
        }
        
        .app-card:focus {
            outline: 3px solid rgba(255, 255, 255, 0.8);
            outline-offset: 2px;
        }
        
        /* iOS-style spring animation */
        .app-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        /* Smooth color transitions */
        .app-icon-wrapper {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Status indicator pulse */
        .status-indicator {
            animation: statusPulse 3s ease-in-out infinite;
        }
        
        @keyframes statusPulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.8; }
        }
    `;
    document.head.appendChild(style);
</script>
<?= $this->endSection() ?>
        
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
