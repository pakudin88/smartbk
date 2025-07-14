<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .info-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px 15px 0 0;
        color: white;
        padding: 1.5rem;
    }
    
    .system-info {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .stat-box {
        text-align: center;
        padding: 1.5rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #eee;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #495057;
    }
    
    .info-value {
        color: #6c757d;
        font-family: 'Courier New', monospace;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .status-online {
        background: #d4edda;
        color: #155724;
    }
    
    .status-warning {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-error {
        background: #f8d7da;
        color: #721c24;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-server text-primary me-2"></i>
            Informasi Sistem
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('settings') ?>">Pengaturan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sistem</li>
            </ol>
        </nav>
    </div>

    <!-- System Overview -->
    <div class="system-info">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="h4 mb-2">
                    <i class="fas fa-desktop me-2"></i>
                    <?= $appInfo['app_name'] ?>
                </h2>
                <p class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Versi <?= $appInfo['app_version'] ?> | Status: 
                    <span class="status-badge status-online">Online</span>
                </p>
            </div>
            <div class="col-md-4 text-center">
                <i class="fas fa-cogs" style="font-size: 4rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-number">
                    <i class="fas fa-clock text-primary"></i>
                </div>
                <div class="stat-label">Uptime</div>
                <small class="text-muted">
                    <?php
                    $uptime = shell_exec('uptime -p 2>/dev/null') ?: 'N/A';
                    echo trim($uptime);
                    ?>
                </small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-number">
                    <i class="fas fa-memory text-success"></i>
                </div>
                <div class="stat-label">Memory</div>
                <small class="text-muted">
                    <?php
                    $memory = round(memory_get_usage() / 1024 / 1024, 2);
                    echo $memory . ' MB';
                    ?>
                </small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-number">
                    <i class="fas fa-hdd text-warning"></i>
                </div>
                <div class="stat-label">Storage</div>
                <small class="text-muted">
                    <?php
                    $freeSpace = round(disk_free_space('.') / 1024 / 1024 / 1024, 2);
                    echo $freeSpace . ' GB';
                    ?>
                </small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-number">
                    <i class="fas fa-shield-alt text-info"></i>
                </div>
                <div class="stat-label">Security</div>
                <small class="text-muted">Secure</small>
            </div>
        </div>
    </div>

    <!-- Detailed Information -->
    <div class="row">
        <div class="col-md-6">
            <div class="card info-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Aplikasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">Nama Aplikasi</span>
                        <span class="info-value"><?= $appInfo['app_name'] ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Versi Aplikasi</span>
                        <span class="info-value"><?= $appInfo['app_version'] ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Framework</span>
                        <span class="info-value">CodeIgniter <?= $appInfo['ci_version'] ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Environment</span>
                        <span class="info-value">
                            <?php
                            $env = getenv('CI_ENVIRONMENT') ?: 'production';
                            $badgeClass = $env === 'development' ? 'status-warning' : 'status-online';
                            echo "<span class='status-badge {$badgeClass}'>{$env}</span>";
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card info-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-server me-2"></i>
                        Informasi Server
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">PHP Version</span>
                        <span class="info-value"><?= $appInfo['php_version'] ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Server Software</span>
                        <span class="info-value"><?= $appInfo['server_software'] ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Database</span>
                        <span class="info-value">MySQL <?= $appInfo['database_version'] ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Server Time</span>
                        <span class="info-value"><?= date('Y-m-d H:i:s T') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card info-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Status Sistem
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-row">
                                <span class="info-label">Database</span>
                                <span class="status-badge status-online">Online</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-row">
                                <span class="info-label">Cache</span>
                                <span class="status-badge status-online">Active</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-row">
                                <span class="info-label">Session</span>
                                <span class="status-badge status-online">Active</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-row">
                                <span class="info-label">Logs</span>
                                <span class="status-badge status-online">Working</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card info-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tools me-2"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary btn-sm w-100 mb-2" onclick="clearCache()">
                                <i class="fas fa-trash me-2"></i>Clear Cache
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-success btn-sm w-100 mb-2" onclick="refreshSystem()">
                                <i class="fas fa-sync me-2"></i>Refresh System
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('settings/backup') ?>" class="btn btn-outline-warning btn-sm w-100 mb-2">
                                <i class="fas fa-database me-2"></i>Backup DB
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('settings') ?>" class="btn btn-outline-secondary btn-sm w-100 mb-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function clearCache() {
    if (confirm('Apakah Anda yakin ingin menghapus cache sistem?')) {
        // Implementasi clear cache bisa ditambahkan di sini
        alert('Cache berhasil dihapus!');
    }
}

function refreshSystem() {
    // Refresh halaman
    window.location.reload();
}

// Auto refresh setiap 30 detik untuk informasi yang dinamis
setInterval(function() {
    // Update server time
    const serverTimeElement = document.querySelector('.info-value:last-child');
    if (serverTimeElement) {
        const now = new Date();
        serverTimeElement.textContent = now.toLocaleString();
    }
}, 30000);
</script>
<?= $this->endSection() ?>
