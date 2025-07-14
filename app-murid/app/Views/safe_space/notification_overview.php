<?= $this->extend('layouts/minimal_layout') ?>

<?= $this->section('content') ?>

<style>
.integration-card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    border-left: 5px solid;
    transition: all 0.3s ease;
}

.integration-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

.integration-card.dashboard {
    border-color: #28a745;
}

.integration-card.chat {
    border-color: #007bff;
}

.integration-card.schedule {
    border-color: #17a2b8;
}

.integration-card.journal {
    border-color: #ffc107;
}

.integration-card.info {
    border-color: #6f42c1;
}

.integration-card.demo {
    border-color: #fd7e14;
}

.feature-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    margin: 0.25rem;
}

.badge-success { background: rgba(40, 167, 69, 0.1); color: #28a745; }
.badge-primary { background: rgba(0, 123, 255, 0.1); color: #007bff; }
.badge-info { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
.badge-warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
.badge-secondary { background: rgba(111, 66, 193, 0.1); color: #6f42c1; }
.badge-orange { background: rgba(253, 126, 20, 0.1); color: #fd7e14; }

.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 0.5rem;
}

.status-active { background: #28a745; }
.status-partial { background: #ffc107; }
.status-pending { background: #6c757d; }

.notification-count {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    margin-bottom: 2rem;
}

.count-item {
    text-align: center;
    padding: 1rem;
}

.count-number {
    font-size: 2.5rem;
    font-weight: bold;
    display: block;
    margin-bottom: 0.5rem;
}

.count-label {
    font-size: 0.9rem;
    opacity: 0.9;
}
</style>

<!-- Header Summary -->
<div class="row mb-4">
    <div class="col-12">
        <div class="notification-count">
            <h2 class="mb-3">
                <i class="fas fa-check-circle me-2"></i>
                Integrasi Notifikasi Complete
            </h2>
            <p class="mb-4">Semua halaman Safe Space telah dilengkapi dengan sistem notifikasi realtime</p>
            
            <div class="row">
                <div class="col-md-2 col-4">
                    <div class="count-item">
                        <span class="count-number">6</span>
                        <span class="count-label">Halaman</span>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="count-item">
                        <span class="count-number">15+</span>
                        <span class="count-label">Jenis Notifikasi</span>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="count-item">
                        <span class="count-number">100%</span>
                        <span class="count-label">Terintegrasi</span>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="count-item">
                        <span class="count-number">10s</span>
                        <span class="count-label">Polling</span>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="count-item">
                        <span class="count-number">🔊</span>
                        <span class="count-label">Audio</span>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="count-item">
                        <span class="count-number">📱</span>
                        <span class="count-label">Responsive</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Integration Cards -->
<div class="row">
    <div class="col-12">
        <h3 class="mb-4">
            <i class="fas fa-sitemap me-2"></i>
            Status Integrasi Per Halaman
        </h3>
    </div>
</div>

<div class="row">
    <!-- Dashboard -->
    <div class="col-md-6 mb-3">
        <div class="integration-card dashboard">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5>
                        <span class="status-indicator status-active"></span>
                        <i class="fas fa-home me-2"></i>Dashboard Safe Space
                    </h5>
                    <p class="text-muted mb-2">Halaman utama dengan overview dan statistik</p>
                </div>
                <span class="badge bg-success">ACTIVE</span>
            </div>
            
            <div class="mb-3">
                <span class="feature-badge badge-success">Welcome Notification</span>
                <span class="feature-badge badge-success">Stats Update</span>
                <span class="feature-badge badge-success">Activity Tracking</span>
                <span class="feature-badge badge-success">Tips Harian</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>Auto-notification: 3s delay
                </small>
                <a href="<?= base_url('safe-space/dashboard') ?>" class="btn btn-sm btn-success">
                    <i class="fas fa-external-link-alt me-1"></i>Kunjungi
                </a>
            </div>
        </div>
    </div>
    
    <!-- Konsul Cepat -->
    <div class="col-md-6 mb-3">
        <div class="integration-card chat">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5>
                        <span class="status-indicator status-active"></span>
                        <i class="fas fa-comments me-2"></i>Konsul Cepat & Anonim
                    </h5>
                    <p class="text-muted mb-2">Chat realtime dengan konselor profesional</p>
                </div>
                <span class="badge bg-primary">ACTIVE</span>
            </div>
            
            <div class="mb-3">
                <span class="feature-badge badge-primary">Chat Welcome</span>
                <span class="feature-badge badge-primary">Message Response</span>
                <span class="feature-badge badge-primary">Mode Switch</span>
                <span class="feature-badge badge-primary">Typing Indicator</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>Auto-notification: 2s delay
                </small>
                <a href="<?= base_url('safe-space/konsul-cepat') ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-external-link-alt me-1"></i>Kunjungi
                </a>
            </div>
        </div>
    </div>
    
    <!-- Jadwal Konseling -->
    <div class="col-md-6 mb-3">
        <div class="integration-card schedule">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5>
                        <span class="status-indicator status-active"></span>
                        <i class="fas fa-calendar me-2"></i>Jadwal Konseling
                    </h5>
                    <p class="text-muted mb-2">Booking appointment dengan konselor</p>
                </div>
                <span class="badge bg-info">ACTIVE</span>
            </div>
            
            <div class="mb-3">
                <span class="feature-badge badge-info">Schedule Welcome</span>
                <span class="feature-badge badge-info">Appointment Confirmation</span>
                <span class="feature-badge badge-info">Reminder Alert</span>
                <span class="feature-badge badge-info">Quick Schedule</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>Auto-notification: 2.5s delay
                </small>
                <a href="<?= base_url('safe-space/jadwal-konseling') ?>" class="btn btn-sm btn-info">
                    <i class="fas fa-external-link-alt me-1"></i>Kunjungi
                </a>
            </div>
        </div>
    </div>
    
    <!-- Jurnal Digital -->
    <div class="col-md-6 mb-3">
        <div class="integration-card journal">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5>
                        <span class="status-indicator status-active"></span>
                        <i class="fas fa-book-open me-2"></i>Jurnal Digital
                    </h5>
                    <p class="text-muted mb-2">Tracking mood dan menulis jurnal harian</p>
                </div>
                <span class="badge bg-warning">ACTIVE</span>
            </div>
            
            <div class="mb-3">
                <span class="feature-badge badge-warning">Journal Welcome</span>
                <span class="feature-badge badge-warning">Entry Saved</span>
                <span class="feature-badge badge-warning">Mood Tracked</span>
                <span class="feature-badge badge-warning">Daily Reminder</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>Auto-notification: 2s delay
                </small>
                <a href="<?= base_url('safe-space/jurnal-digital') ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-external-link-alt me-1"></i>Kunjungi
                </a>
            </div>
        </div>
    </div>
    
    <!-- Pusat Informasi -->
    <div class="col-md-6 mb-3">
        <div class="integration-card info">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5>
                        <span class="status-indicator status-active"></span>
                        <i class="fas fa-info-circle me-2"></i>Pusat Informasi
                    </h5>
                    <p class="text-muted mb-2">Artikel dan tips kesehatan mental</p>
                </div>
                <span class="badge bg-secondary">ACTIVE</span>
            </div>
            
            <div class="mb-3">
                <span class="feature-badge badge-secondary">Info Welcome</span>
                <span class="feature-badge badge-secondary">Article Read</span>
                <span class="feature-badge badge-secondary">Resource Download</span>
                <span class="feature-badge badge-secondary">New Content</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>Auto-notification: 2.2s delay
                </small>
                <a href="<?= base_url('safe-space/pusat-informasi') ?>" class="btn btn-sm btn-secondary">
                    <i class="fas fa-external-link-alt me-1"></i>Kunjungi
                </a>
            </div>
        </div>
    </div>
    
    <!-- Demo Notifikasi -->
    <div class="col-md-6 mb-3">
        <div class="integration-card demo">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5>
                        <span class="status-indicator status-active"></span>
                        <i class="fas fa-bell me-2"></i>Demo Notifikasi
                    </h5>
                    <p class="text-muted mb-2">Testing dan simulasi semua notifikasi</p>
                </div>
                <span class="badge" style="background: #fd7e14; color: white;">DEMO</span>
            </div>
            
            <div class="mb-3">
                <span class="feature-badge badge-orange">Multiple Types</span>
                <span class="feature-badge badge-orange">Real-time Testing</span>
                <span class="feature-badge badge-orange">Activity Log</span>
                <span class="feature-badge badge-orange">Statistics</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>Interactive demo interface
                </small>
                <a href="<?= base_url('safe-space/all-notifications-demo') ?>" class="btn btn-sm" style="background: #fd7e14; color: white;">
                    <i class="fas fa-external-link-alt me-1"></i>Kunjungi
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Technical Details -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card-custom p-4">
            <h4 class="mb-3">
                <i class="fas fa-cogs me-2"></i>
                Detail Teknis Implementasi
            </h4>
            
            <div class="row">
                <div class="col-md-4">
                    <h6><i class="fas fa-code me-2"></i>Arsitektur</h6>
                    <ul class="list-unstyled">
                        <li>✅ Layout terpadu dengan notifikasi</li>
                        <li>✅ Controller API endpoints</li>
                        <li>✅ Komponen reusable</li>
                        <li>✅ JavaScript polling system</li>
                    </ul>
                </div>
                
                <div class="col-md-4">
                    <h6><i class="fas fa-mobile-alt me-2"></i>Features</h6>
                    <ul class="list-unstyled">
                        <li>✅ Real-time notifications (10s polling)</li>
                        <li>✅ Toast notifications dengan suara</li>
                        <li>✅ Badge counter otomatis</li>
                        <li>✅ Responsive design</li>
                    </ul>
                </div>
                
                <div class="col-md-4">
                    <h6><i class="fas fa-database me-2"></i>API Endpoints</h6>
                    <ul class="list-unstyled">
                        <li>✅ <code>/notification/get</code></li>
                        <li>✅ <code>/notification/read/{id}</code></li>
                        <li>✅ <code>/notification/updates</code></li>
                        <li>✅ <code>/notification/test</code></li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="text-center">
                <h5 class="text-success mb-3">
                    <i class="fas fa-check-circle me-2"></i>
                    Sistem Notifikasi Safe Space - 100% Complete!
                </h5>
                <p class="text-muted mb-0">
                    Semua halaman telah terintegrasi dengan sistem notifikasi realtime. 
                    User dapat menikmati pengalaman Safe Space yang lengkap dengan feedback yang responsif.
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Send overview notification after page loads
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        if (typeof sendTestNotification === 'function') {
            const overviewNotification = {
                id: 'overview-page-' + Date.now(),
                type: 'success',
                title: 'Integrasi Complete',
                message: 'Semua 6 halaman Safe Space telah dilengkapi dengan sistem notifikasi realtime!',
                timestamp: new Date().toISOString(),
                read: false,
                icon: 'fas fa-check-circle',
                color: 'success',
                url: '#'
            };
            
            if (typeof showToastNotification === 'function') {
                showToastNotification(overviewNotification);
            }
        }
    }, 2000);
});

// Add click tracking for integration cards
document.querySelectorAll('.integration-card').forEach(card => {
    card.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') return; // Don't trigger on button clicks
        
        // Add ripple effect
        this.style.transform = 'scale(0.98)';
        setTimeout(() => {
            this.style.transform = 'translateY(-3px)';
        }, 100);
    });
});
</script>
<?= $this->endSection() ?>
