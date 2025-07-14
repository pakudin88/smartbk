<?= $this->extend('layouts/minimal_layout') ?>

<?= $this->section('content') ?>
<style>
/* Dashboard Prototype - Header, Content, Footer Structure */
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f5f7fa;
}

/* HEADER */
.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 100;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.location-icon {
    font-size: 1.5rem;
    color: white;
}

.app-title {
    font-size: 1.2rem;
    font-weight: 600;
    letter-spacing: 1px;
    margin: 0;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.notification-icon {
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0.5rem;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    position: relative;
}

.notification-icon:hover {
    background: rgba(255,255,255,0.2);
    transform: scale(1.1);
}

.notification-badge {
    position: absolute;
    top: -2px;
    right: -2px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    font-size: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.logout-btn {
    color: white;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: opacity 0.3s ease;
}

.logout-btn:hover {
    opacity: 0.8;
    color: white;
}

/* CONTENT */
.dashboard-content {
    padding: 1.5rem 1rem;
    min-height: calc(100vh - 150px);
    max-width: 500px;
    margin: 0 auto;
}

.apps-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
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
}

.app-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
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

/* Icon Colors */
.app-icon.konsul { 
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); 
}
.app-icon.jadwal { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
}
.app-icon.jurnal { 
    background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); 
}
.app-icon.informasi { 
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); 
}

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

/* FOOTER */
.dashboard-footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    border-radius: 25px 25px 0 0;
    box-shadow: 0 -2px 20px rgba(0,0,0,0.1);
    padding: 1rem 2rem;
    z-index: 100;
}

.bottom-nav {
    display: flex;
    justify-content: space-around;
    align-items: center;
    max-width: 400px;
    margin: 0 auto;
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
    color: #667eea;
}

.nav-item i {
    font-size: 1.2rem;
    margin-bottom: 0.25rem;
}

.nav-item span {
    font-size: 0.7rem;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 480px) {
    .dashboard-content {
        padding: 1.5rem 1rem;
    }
    
    .apps-grid {
        gap: 1rem;
    }
    
    .app-card {
        padding: 1.5rem 1rem;
    }
    
    .dashboard-footer {
        padding: 1rem;
    }
}
</style>

<!-- CONTENT -->
<div class="dashboard-content">
    <div class="apps-grid">
        <!-- Konsul Cepat -->
        <div class="app-card" onclick="navigateTo('konsul-cepat')">
            <div class="app-icon konsul">
                <i class="fas fa-comments"></i>
            </div>
            <div class="app-title-text">Konsul Cepat & Anonim</div>
            <p class="app-description">Chat langsung dengan Guru BK, bisa anonim</p>
        </div>
        
        <!-- Jadwal Konseling -->
        <div class="app-card" onclick="navigateTo('jadwal-konseling')">
            <div class="app-icon jadwal">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="app-title-text">Jadwalkan Sesi Konseling</div>
            <p class="app-description">Atur jadwal konseling tatap muka atau online</p>
        </div>
        
        <!-- Jurnal Digital -->
        <div class="app-card" onclick="navigateTo('jurnal-digital')">
            <div class="app-icon jurnal">
                <i class="fas fa-journal-whills"></i>
            </div>
            <div class="app-title-text">Jurnal Digital & Pelacak Emosi</div>
            <p class="app-description">Catat perasaan dan lacak mood setiap hari</p>
        </div>
        
        <!-- Pusat Informasi -->
        <div class="app-card" onclick="navigateTo('pusat-informasi')">
            <div class="app-icon informasi">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="app-title-text">Pusat Informasi & Bantuan</div>
            <p class="app-description">Artikel, video, tips untuk kesehatan mental</p>
        </div>
    </div>
</div>

<!-- FOOTER -->
<div class="dashboard-footer">
    <div class="bottom-nav">
        <a href="<?= base_url('dashboard') ?>" class="nav-item active">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="#" class="nav-item" onclick="showAlert('Fitur Chat akan segera tersedia')">
            <i class="fas fa-comments"></i>
            <span>Chat</span>
        </a>
        <a href="#" class="nav-item" onclick="navigateTo('jurnal-digital')">
            <i class="fas fa-heart"></i>
            <span>Jurnal</span>
        </a>
        <a href="<?= base_url('logout') ?>" class="nav-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<script>
// Simple navigation function
function navigateTo(page) {
    // Map page names to actual routes
    const routes = {
        'konsul-cepat': '<?= base_url("konsul-cepat") ?>',
        'jadwal-konseling': '<?= base_url("jadwal-konseling") ?>',
        'jurnal-digital': '<?= base_url("jurnal-digital") ?>',
        'pusat-informasi': '<?= base_url("pusat-informasi") ?>'
    };
    
    if (routes[page]) {
        // Redirect to the feature page
        window.location.href = routes[page];
    } else {
        showAlert('Navigasi ke ' + page + ' akan segera tersedia');
    }
}

// Notification function
function showNotifications() {
    showAlert('📢 Notifikasi:\n• Pesan baru dari Guru BK\n• Reminder: Isi jurnal harian\n• Update: Jadwal konseling tersedia');
}

// Simple alert function
function showAlert(message) {
    const alert = document.createElement('div');
    alert.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #3b82f6;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 1001;
        max-width: 300px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    `;
    alert.innerHTML = message;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 3000);
}

// Add click effects
document.addEventListener('DOMContentLoaded', function() {
    const appCards = document.querySelectorAll('.app-card');
    
    appCards.forEach(card => {
        card.addEventListener('click', function() {
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
});
</script>
<?= $this->endSection() ?>
