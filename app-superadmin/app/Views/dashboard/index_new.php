<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <!-- Welcome Section -->
    <section class="welcome-section">
        <h2 class="welcome-title">Selamat Datang, <?= $user['full_name'] ?? 'Administrator' ?>!</h2>
        <p class="welcome-subtitle">Kelola sistem sekolah multi-aplikasi dari panel administrasi ini</p>
        <div class="quick-actions">
            <a href="<?= base_url('users') ?>" class="quick-action-btn">
                <span>👥</span> Kelola Pengguna
            </a>
            <a href="<?= base_url('schools') ?>" class="quick-action-btn">
                <span>🏫</span> Kelola Sekolah
            </a>
            <a href="<?= base_url('reports') ?>" class="quick-action-btn">
                <span>📈</span> Laporan
            </a>
        </div>
    </section>

    <!-- Statistics Cards -->
    <section class="stats-container">
        <div class="stat-card">
            <span class="stat-icon">👥</span>
            <div class="stat-number"><?= $stats['total_users'] ?? 1 ?></div>
            <div class="stat-label">Total Pengguna</div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">🏫</span>
            <div class="stat-number"><?= $stats['total_schools'] ?? 0 ?></div>
            <div class="stat-label">Total Sekolah</div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">📚</span>
            <div class="stat-number"><?= $stats['total_subjects'] ?? 0 ?></div>
            <div class="stat-label">Mata Pelajaran</div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">🎓</span>
            <div class="stat-number"><?= $stats['total_classes'] ?? 0 ?></div>
            <div class="stat-label">Total Kelas</div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions">
        <h3 class="section-title">Menu Aksi Cepat</h3>
        <div class="actions-grid">
            <a href="<?= base_url('users') ?>" class="action-card">
                <span class="action-icon">👥</span>
                <h4 class="action-title">Kelola Pengguna</h4>
            </a>
            <a href="<?= base_url('schools') ?>" class="action-card">
                <span class="action-icon">🏫</span>
                <h4 class="action-title">Kelola Sekolah</h4>
            </a>
            <a href="<?= base_url('classes') ?>" class="action-card">
                <span class="action-icon">🎓</span>
                <h4 class="action-title">Kelola Kelas</h4>
            </a>
            <a href="<?= base_url('subjects') ?>" class="action-card">
                <span class="action-icon">📚</span>
                <h4 class="action-title">Mata Pelajaran</h4>
            </a>
            <a href="<?= base_url('school-years') ?>" class="action-card">
                <span class="action-icon">📅</span>
                <h4 class="action-title">Tahun Ajaran</h4>
            </a>
            <a href="<?= base_url('reports') ?>" class="action-card">
                <span class="action-icon">📈</span>
                <h4 class="action-title">Laporan</h4>
            </a>
        </div>
    </section>

    <!-- System Info (Only in development) -->
    <?php if (ENVIRONMENT === 'development'): ?>
    <section class="card">
        <div class="card-header">
            <h5>System Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Session Status:</strong> <?= session()->get('isLoggedIn') ? 'Logged In' : 'Not Logged In' ?></p>
                    <p><strong>User ID:</strong> <?= session()->get('user_id') ?? 'N/A' ?></p>
                    <p><strong>Username:</strong> <?= session()->get('username') ?? 'N/A' ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Role:</strong> <?= session()->get('role_name') ?? 'N/A' ?></p>
                    <p><strong>Current Time:</strong> <?= date('Y-m-d H:i:s') ?></p>
                    <p><strong>Environment:</strong> <?= ENVIRONMENT ?></p>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
<?= $this->endSection() ?>
