<?= $this->extend('layouts/minimal_layout') ?>

<?= $this->section('content') ?>

<style>
.demo-section {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

.demo-button {
    margin: 0.5rem;
    min-width: 200px;
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.demo-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.notification-stats {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    display: block;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.page-demo-section {
    border-left: 4px solid;
    padding: 1rem 1.5rem;
    margin: 1rem 0;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.7);
}

.page-demo-section.dashboard {
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.1);
}

.page-demo-section.chat {
    border-color: #007bff;
    background: rgba(0, 123, 255, 0.1);
}

.page-demo-section.schedule {
    border-color: #17a2b8;
    background: rgba(23, 162, 184, 0.1);
}

.page-demo-section.journal {
    border-color: #ffc107;
    background: rgba(255, 193, 7, 0.1);
}

.page-demo-section.info {
    border-color: #6f42c1;
    background: rgba(111, 66, 193, 0.1);
}
</style>

<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="notification-stats">
            <div class="text-center mb-3">
                <h2>
                    <i class="fas fa-bell me-2"></i>
                    Demo Notifikasi Safe Space
                </h2>
                <p class="mb-0">Testing semua jenis notifikasi yang terintegrasi di seluruh halaman</p>
            </div>
            
            <div class="row" id="notificationStats">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <span class="stat-number" id="totalSent">0</span>
                        <span class="stat-label">Total Terkirim</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <span class="stat-number" id="totalRead">0</span>
                        <span class="stat-label">Sudah Dibaca</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <span class="stat-number" id="totalUnread">0</span>
                        <span class="stat-label">Belum Dibaca</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <span class="stat-number" id="activeTime">0</span>
                        <span class="stat-label">Detik Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Demo Controls -->
<div class="row">
    <div class="col-md-6">
        <div class="demo-section">
            <h4 class="mb-3">
                <i class="fas fa-cogs me-2"></i>
                Notifikasi Umum
            </h4>
            
            <button class="btn btn-success demo-button" onclick="sendDashboardNotification()">
                <i class="fas fa-home me-2"></i>Dashboard Welcome
            </button>
            
            <button class="btn btn-primary demo-button" onclick="sendChatNotification()">
                <i class="fas fa-comments me-2"></i>Chat Message
            </button>
            
            <button class="btn btn-info demo-button" onclick="sendScheduleNotification()">
                <i class="fas fa-calendar me-2"></i>Schedule Update
            </button>
            
            <button class="btn btn-warning demo-button" onclick="sendJournalNotification()">
                <i class="fas fa-book me-2"></i>Journal Saved
            </button>
            
            <button class="btn btn-secondary demo-button" onclick="sendInfoNotification()">
                <i class="fas fa-info me-2"></i>New Article
            </button>
            
            <button class="btn btn-danger demo-button" onclick="sendEmergencyNotification()">
                <i class="fas fa-exclamation-triangle me-2"></i>Emergency
            </button>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="demo-section">
            <h4 class="mb-3">
                <i class="fas fa-magic me-2"></i>
                Simulasi Khusus
            </h4>
            
            <button class="btn btn-outline-primary demo-button" onclick="simulatePageVisit('dashboard')">
                <i class="fas fa-home me-2"></i>Simulasi Dashboard
            </button>
            
            <button class="btn btn-outline-success demo-button" onclick="simulatePageVisit('chat')">
                <i class="fas fa-comments me-2"></i>Simulasi Chat
            </button>
            
            <button class="btn btn-outline-info demo-button" onclick="simulatePageVisit('schedule')">
                <i class="fas fa-calendar me-2"></i>Simulasi Jadwal
            </button>
            
            <button class="btn btn-outline-warning demo-button" onclick="simulatePageVisit('journal')">
                <i class="fas fa-book me-2"></i>Simulasi Jurnal
            </button>
            
            <button class="btn btn-outline-secondary demo-button" onclick="simulatePageVisit('info')">
                <i class="fas fa-info me-2"></i>Simulasi Info
            </button>
            
            <button class="btn btn-outline-dark demo-button" onclick="sendMultipleNotifications()">
                <i class="fas fa-rocket me-2"></i>Kirim Multiple
            </button>
        </div>
    </div>
</div>

<!-- Page Integration Demo -->
<div class="row">
    <div class="col-12">
        <div class="demo-section">
            <h4 class="mb-3">
                <i class="fas fa-sitemap me-2"></i>
                Integrasi Per Halaman
            </h4>
            
            <div class="page-demo-section dashboard">
                <h6><i class="fas fa-home me-2"></i>Dashboard Safe Space</h6>
                <p class="mb-2">Notifikasi welcome, statistik update, tips harian</p>
                <a href="<?= base_url('safe-space') ?>" class="btn btn-sm btn-success">
                    <i class="fas fa-external-link-alt me-1"></i>Kunjungi Dashboard
                </a>
            </div>
            
            <div class="page-demo-section chat">
                <h6><i class="fas fa-comments me-2"></i>Konsul Cepat & Anonim</h6>
                <p class="mb-2">Notifikasi chat masuk, respons konselor, mode switch</p>
                <a href="<?= base_url('safe-space/konsul-cepat') ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-external-link-alt me-1"></i>Kunjungi Chat
                </a>
            </div>
            
            <div class="page-demo-section schedule">
                <h6><i class="fas fa-calendar me-2"></i>Jadwal Konseling</h6>
                <p class="mb-2">Notifikasi konfirmasi jadwal, reminder appointment</p>
                <a href="<?= base_url('safe-space/jadwal-konseling') ?>" class="btn btn-sm btn-info">
                    <i class="fas fa-external-link-alt me-1"></i>Kunjungi Jadwal
                </a>
            </div>
            
            <div class="page-demo-section journal">
                <h6><i class="fas fa-book-open me-2"></i>Jurnal Digital</h6>
                <p class="mb-2">Notifikasi entry saved, mood tracking, reminder</p>
                <a href="<?= base_url('safe-space/jurnal-digital') ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-external-link-alt me-1"></i>Kunjungi Jurnal
                </a>
            </div>
            
            <div class="page-demo-section info">
                <h6><i class="fas fa-info-circle me-2"></i>Pusat Informasi</h6>
                <p class="mb-2">Notifikasi artikel baru, resource download</p>
                <a href="<?= base_url('safe-space/pusat-informasi') ?>" class="btn btn-sm btn-secondary">
                    <i class="fas fa-external-link-alt me-1"></i>Kunjungi Info Center
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Live Activity Log -->
<div class="row">
    <div class="col-12">
        <div class="demo-section">
            <h4 class="mb-3">
                <i class="fas fa-list me-2"></i>
                Log Aktivitas Real-time
            </h4>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Aktivitas notifikasi terbaru:</span>
                <button class="btn btn-sm btn-outline-danger" onclick="clearActivityLog()">
                    <i class="fas fa-trash me-1"></i>Clear Log
                </button>
            </div>
            
            <div id="activityLog" style="max-height: 300px; overflow-y: auto; background: rgba(0,0,0,0.05); padding: 1rem; border-radius: 8px;">
                <div class="text-center text-muted">
                    <i class="fas fa-clock me-2"></i>
                    Belum ada aktivitas. Klik tombol demo untuk mulai testing.
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let notificationCount = {
    sent: 0,
    read: 0,
    unread: 0
};

let activeTime = 0;
let activityTimer;

// Start activity timer
document.addEventListener('DOMContentLoaded', function() {
    activityTimer = setInterval(() => {
        activeTime++;
        document.getElementById('activeTime').textContent = activeTime;
    }, 1000);
    
    // Send welcome notification for demo page
    setTimeout(() => {
        sendDemoWelcomeNotification();
    }, 1500);
});

// Demo notification functions
function sendDashboardNotification() {
    const notification = {
        id: 'demo-dashboard-' + Date.now(),
        type: 'success',
        title: 'Dashboard Safe Space',
        message: 'Selamat datang di dashboard! Semua fitur tersedia untuk Anda.',
        timestamp: new Date().toISOString(),
        read: false,
        icon: 'fas fa-home',
        color: 'success',
        url: '<?= base_url("safe-space") ?>'
    };
    
    sendNotificationWithLogging(notification, 'Dashboard Welcome');
}

function sendChatNotification() {
    const notification = {
        id: 'demo-chat-' + Date.now(),
        type: 'chat',
        title: 'Pesan Chat Baru',
        message: 'Konselor telah membalas pesan Anda di konsul cepat.',
        timestamp: new Date().toISOString(),
        read: false,
        icon: 'fas fa-comments',
        color: 'primary',
        url: '<?= base_url("safe-space/konsul-cepat") ?>'
    };
    
    sendNotificationWithLogging(notification, 'Chat Message');
}

function sendScheduleNotification() {
    const notification = {
        id: 'demo-schedule-' + Date.now(),
        type: 'schedule',
        title: 'Jadwal Konseling',
        message: 'Jadwal konseling Anda besok telah dikonfirmasi oleh konselor.',
        timestamp: new Date().toISOString(),
        read: false,
        icon: 'fas fa-calendar-check',
        color: 'info',
        url: '<?= base_url("safe-space/jadwal-konseling") ?>'
    };
    
    sendNotificationWithLogging(notification, 'Schedule Update');
}

function sendJournalNotification() {
    const notification = {
        id: 'demo-journal-' + Date.now(),
        type: 'journal',
        title: 'Jurnal Tersimpan',
        message: 'Entry jurnal harian Anda berhasil disimpan dengan aman.',
        timestamp: new Date().toISOString(),
        read: false,
        icon: 'fas fa-book-open',
        color: 'warning',
        url: '<?= base_url("safe-space/jurnal-digital") ?>'
    };
    
    sendNotificationWithLogging(notification, 'Journal Saved');
}

function sendInfoNotification() {
    const notification = {
        id: 'demo-info-' + Date.now(),
        type: 'info',
        title: 'Artikel Baru',
        message: 'Artikel terbaru tentang manajemen stres telah tersedia.',
        timestamp: new Date().toISOString(),
        read: false,
        icon: 'fas fa-newspaper',
        color: 'secondary',
        url: '<?= base_url("safe-space/pusat-informasi") ?>'
    };
    
    sendNotificationWithLogging(notification, 'New Article');
}

function sendEmergencyNotification() {
    const notification = {
        id: 'demo-emergency-' + Date.now(),
        type: 'emergency',
        title: 'Kontak Darurat',
        message: 'Jika membutuhkan bantuan segera, hubungi hotline crisis 24/7.',
        timestamp: new Date().toISOString(),
        read: false,
        icon: 'fas fa-exclamation-triangle',
        color: 'danger',
        url: '#'
    };
    
    sendNotificationWithLogging(notification, 'Emergency Alert');
}

function sendDemoWelcomeNotification() {
    const notification = {
        id: 'demo-welcome-' + Date.now(),
        type: 'info',
        title: 'Demo Notifikasi Aktif',
        message: 'Selamat datang di demo notifikasi Safe Space! Klik tombol untuk testing.',
        timestamp: new Date().toISOString(),
        read: false,
        icon: 'fas fa-magic',
        color: 'primary',
        url: '#'
    };
    
    sendNotificationWithLogging(notification, 'Demo Welcome');
}

function simulatePageVisit(pageType) {
    const pageNotifications = {
        dashboard: {
            title: 'Dashboard Loaded',
            message: 'Dashboard Safe Space berhasil dimuat dengan semua fitur.',
            icon: 'fas fa-home',
            color: 'success'
        },
        chat: {
            title: 'Chat Ready',
            message: 'Konsul cepat siap digunakan. Konselor tersedia online.',
            icon: 'fas fa-comments',
            color: 'primary'
        },
        schedule: {
            title: 'Schedule Available',
            message: 'Jadwal konseling terbuka. Pilih waktu yang sesuai.',
            icon: 'fas fa-calendar',
            color: 'info'
        },
        journal: {
            title: 'Journal Ready',
            message: 'Jurnal digital siap untuk entry harian Anda.',
            icon: 'fas fa-book',
            color: 'warning'
        },
        info: {
            title: 'Info Center Loaded',
            message: 'Pusat informasi dengan artikel terbaru telah dimuat.',
            icon: 'fas fa-info',
            color: 'secondary'
        }
    };
    
    const pageData = pageNotifications[pageType];
    if (pageData) {
        const notification = {
            id: 'demo-page-' + pageType + '-' + Date.now(),
            type: pageType,
            title: pageData.title,
            message: pageData.message,
            timestamp: new Date().toISOString(),
            read: false,
            icon: pageData.icon,
            color: pageData.color,
            url: '#'
        };
        
        sendNotificationWithLogging(notification, `Page Visit: ${pageType}`);
    }
}

function sendMultipleNotifications() {
    const notifications = [
        'dashboard', 'chat', 'schedule', 'journal', 'info'
    ];
    
    notifications.forEach((type, index) => {
        setTimeout(() => {
            simulatePageVisit(type);
        }, index * 1000);
    });
    
    logActivity('Multiple Notifications', 'Mengirim 5 notifikasi sekaligus dengan delay');
}

function sendNotificationWithLogging(notification, actionName) {
    if (typeof showToastNotification === 'function') {
        showToastNotification(notification);
        notificationCount.sent++;
        notificationCount.unread++;
        updateStats();
        logActivity(actionName, notification.message);
    } else {
        logActivity('Error', 'Fungsi notifikasi tidak tersedia');
    }
}

function updateStats() {
    document.getElementById('totalSent').textContent = notificationCount.sent;
    document.getElementById('totalRead').textContent = notificationCount.read;
    document.getElementById('totalUnread').textContent = notificationCount.unread;
}

function logActivity(action, message) {
    const logContainer = document.getElementById('activityLog');
    const logEntry = document.createElement('div');
    logEntry.className = 'mb-2 p-2 bg-white rounded border-start border-3 border-primary';
    
    const timestamp = new Date().toLocaleTimeString('id-ID');
    logEntry.innerHTML = `
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <strong class="text-primary">${action}</strong>
                <p class="mb-0 small text-muted">${message}</p>
            </div>
            <small class="text-muted">${timestamp}</small>
        </div>
    `;
    
    // Remove placeholder if exists
    if (logContainer.children.length === 1 && logContainer.children[0].classList.contains('text-center')) {
        logContainer.innerHTML = '';
    }
    
    logContainer.insertBefore(logEntry, logContainer.firstChild);
    
    // Keep only last 10 entries
    while (logContainer.children.length > 10) {
        logContainer.removeChild(logContainer.lastChild);
    }
}

function clearActivityLog() {
    const logContainer = document.getElementById('activityLog');
    logContainer.innerHTML = `
        <div class="text-center text-muted">
            <i class="fas fa-clock me-2"></i>
            Log dibersihkan. Klik tombol demo untuk mulai testing lagi.
        </div>
    `;
    
    // Reset stats
    notificationCount = { sent: 0, read: 0, unread: 0 };
    updateStats();
    logActivity('System', 'Activity log cleared and stats reset');
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (activityTimer) {
        clearInterval(activityTimer);
    }
});
</script>
<?= $this->endSection() ?>
