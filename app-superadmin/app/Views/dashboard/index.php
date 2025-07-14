<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <!-- Welcome Section -->
    <section class="welcome-section">
        <h2 class="welcome-title">Selamat Datang, <?= $user['full_name'] ?? 'Administrator' ?>!</h2>
        <p class="welcome-subtitle">Kelola sistem sekolah multi-aplikasi dari panel administrasi ini</p>
    </section>

    <!-- Active School Year Status Card -->
    <?php
    // FORCE: Get active school year data directly in view as emergency fix
    $forceActiveYear = null;
    try {
        $mysqli = new mysqli('localhost', 'root', '', 'sekolah_multiapp');
        if (!$mysqli->connect_error) {
            $result = $mysqli->query("SELECT * FROM school_years WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
            if ($result && $result->num_rows > 0) {
                $forceActiveYear = $result->fetch_assoc();
            }
            $mysqli->close();
        }
    } catch (Exception $e) {
        // Ignore errors
    }
    
    // Use forced data if available, otherwise use original stats
    $displayActiveYear = $forceActiveYear ?? ($stats['active_school_year'] ?? null);
    ?>
    
    <section class="school-year-status-container">
        <?php if ($displayActiveYear): ?>
            <div class="school-year-status-card active">
                <div class="status-header">
                    <i class="fas fa-calendar-check status-icon"></i>
                    <div class="status-info">
                        <h4 class="status-title">Tahun Ajaran Aktif</h4>
                        <p class="status-period"><?= $displayActiveYear['nama_tahun_ajaran'] ?></p>
                    </div>
                </div>
                <div class="status-details">
                    <div class="status-item">
                        <span class="status-label">Semester:</span>
                        <span class="status-value"><?= $displayActiveYear['semester'] ?></span>
                    </div>
                    <div class="status-item">
                        <span class="status-label">Mulai:</span>
                        <span class="status-value"><?= date('d/m/Y', strtotime($displayActiveYear['start_date'])) ?></span>
                    </div>
                    <div class="status-item">
                        <span class="status-label">Berakhir:</span>
                        <span class="status-value"><?= date('d/m/Y', strtotime($displayActiveYear['end_date'])) ?></span>
                    </div>
                </div>
                <div class="status-badge">
                    <span class="badge-active">AKTIF</span>
                </div>
            </div>
        <?php else: ?>
            <div class="school-year-status-card inactive">
                <div class="status-header">
                    <i class="fas fa-calendar-times status-icon"></i>
                    <div class="status-info">
                        <h4 class="status-title">Tahun Ajaran</h4>
                        <p class="status-period">Belum Ditetapkan</p>
                    </div>
                </div>
                <div class="status-details">
                    <p class="status-message">Silakan tetapkan tahun ajaran aktif untuk mulai mengelola sistem.</p>
                </div>
                <div class="status-badge">
                    <span class="badge-inactive">TIDAK AKTIF</span>
                </div>
                <div class="status-action">
                    <a href="<?= base_url('school-years') ?>" class="btn-set-active">
                        <i class="fas fa-cog"></i> Atur Tahun Ajaran
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <!-- Statistics Cards -->
    <?php
    // FORCE: Get statistics directly in view as emergency fix
    $forceStats = [];
    try {
        $mysqli = new mysqli('localhost', 'root', '', 'sekolah_multiapp');
        if (!$mysqli->connect_error) {
            // Get active school year
            $result = $mysqli->query("SELECT * FROM school_years WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
            $activeYear = null;
            if ($result && $result->num_rows > 0) {
                $activeYear = $result->fetch_assoc();
            }
            
            if ($activeYear) {
                $activeYearId = $activeYear['id'];
                
                // Total users
                $result = $mysqli->query("SELECT COUNT(*) as total FROM users");
                $forceStats['total_users'] = $result->fetch_assoc()['total'];
                
                // Active users
                $result = $mysqli->query("SELECT COUNT(*) as total FROM users WHERE is_active = 1");
                $forceStats['active_users'] = $result->fetch_assoc()['total'];
                
                // Total schools
                $result = $mysqli->query("SELECT COUNT(*) as total FROM sekolah");
                $forceStats['total_schools'] = $result->fetch_assoc()['total'];
                
                // Classes in active school year
                $stmt = $mysqli->prepare("SELECT COUNT(*) as total FROM kelas WHERE tahun_ajaran_id = ?");
                $stmt->bind_param("i", $activeYearId);
                $stmt->execute();
                $result = $stmt->get_result();
                $forceStats['total_classes'] = $result->fetch_assoc()['total'];
                
                // Subjects in active school year
                $stmt = $mysqli->prepare("SELECT COUNT(*) as total FROM mata_pelajaran WHERE tahun_ajaran_id = ?");
                $stmt->bind_param("i", $activeYearId);
                $stmt->execute();
                $result = $stmt->get_result();
                $forceStats['total_subjects'] = $result->fetch_assoc()['total'];
                
                // Siswa in active school year
                $stmt = $mysqli->prepare("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name = 'Siswa' AND u.tahun_ajaran_id = ?
                ");
                $stmt->bind_param("i", $activeYearId);
                $stmt->execute();
                $result = $stmt->get_result();
                $forceStats['total_siswa'] = $result->fetch_assoc()['total'];
                
                // Guru in active school year
                $stmt = $mysqli->prepare("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name = 'Guru' AND u.tahun_ajaran_id = ?
                ");
                $stmt->bind_param("i", $activeYearId);
                $stmt->execute();
                $result = $stmt->get_result();
                $forceStats['total_guru'] = $result->fetch_assoc()['total'];
                
                // Kepala Sekolah in active school year
                $stmt = $mysqli->prepare("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name = 'Kepala Sekolah' AND u.tahun_ajaran_id = ?
                ");
                $stmt->bind_param("i", $activeYearId);
                $stmt->execute();
                $result = $stmt->get_result();
                $forceStats['total_kepala_sekolah'] = $result->fetch_assoc()['total'];
                
                // Admin in active school year
                $stmt = $mysqli->prepare("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name IN ('Super Admin', 'Admin') AND u.tahun_ajaran_id = ?
                ");
                $stmt->bind_param("i", $activeYearId);
                $stmt->execute();
                $result = $stmt->get_result();
                $forceStats['total_admin'] = $result->fetch_assoc()['total'];
                
                // Total pengguna aktif (tanpa wali murid)
                $stmt = $mysqli->prepare("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name NOT IN ('Orangtua', 'Wali Murid') AND u.tahun_ajaran_id = ?
                ");
                $stmt->bind_param("i", $activeYearId);
                $stmt->execute();
                $result = $stmt->get_result();
                $forceStats['total_pengguna_aktif'] = $result->fetch_assoc()['total'];
            }
            
            $mysqli->close();
        }
    } catch (Exception $e) {
        // Ignore errors
    }
    
    // Use forced data if available, otherwise use original stats
    $displayStats = [];
    foreach (['total_users', 'active_users', 'total_schools', 'total_classes', 'total_subjects', 'total_siswa', 'total_guru', 'total_kepala_sekolah', 'total_admin', 'total_pengguna_aktif'] as $key) {
        $displayStats[$key] = $forceStats[$key] ?? ($stats[$key] ?? 0);
    }
    ?>
    
    <section class="stats-container">
        <!-- Total Pengguna Aktif (tanpa wali murid) -->
        <div class="stat-card">
            <i class="fas fa-users stat-icon" style="color: #3b82f6;"></i>
            <div class="stat-number"><?= $displayStats['total_pengguna_aktif'] ?? 0 ?></div>
            <div class="stat-label">Total Pengguna</div>
            <div class="stat-sublabel">
                Aktif: <?= $displayStats['total_pengguna_aktif'] ?? 0 ?>
            </div>
        </div>
        
        <!-- Siswa dalam Tahun Ajaran -->
        <div class="stat-card">
            <i class="fas fa-user-graduate stat-icon" style="color: #10b981;"></i>
            <div class="stat-number"><?= $displayStats['total_siswa'] ?? 0 ?></div>
            <div class="stat-label">Siswa</div>
            <?php if (isset($displayActiveYear) && $displayActiveYear): ?>
                <div class="stat-sublabel">
                    Tahun Ajaran <?= $displayActiveYear['nama_tahun_ajaran'] ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Guru dalam Tahun Ajaran -->
        <div class="stat-card">
            <i class="fas fa-chalkboard-teacher stat-icon" style="color: #f59e0b;"></i>
            <div class="stat-number"><?= $displayStats['total_guru'] ?? 0 ?></div>
            <div class="stat-label">Guru</div>
            <?php if (isset($displayActiveYear) && $displayActiveYear): ?>
                <div class="stat-sublabel">
                    Tahun Ajaran <?= $displayActiveYear['nama_tahun_ajaran'] ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Kepala Sekolah dalam Tahun Ajaran -->
        <div class="stat-card">
            <i class="fas fa-user-tie stat-icon" style="color: #ef4444;"></i>
            <div class="stat-number"><?= $displayStats['total_kepala_sekolah'] ?? 0 ?></div>
            <div class="stat-label">Kepala Sekolah</div>
            <?php if (isset($displayActiveYear) && $displayActiveYear): ?>
                <div class="stat-sublabel">
                    Tahun Ajaran <?= $displayActiveYear['nama_tahun_ajaran'] ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Additional Statistics for Active School Year -->
    <section class="stats-container mt-4">
        <div class="stat-card">
            <i class="fas fa-school stat-icon" style="color: #8b5cf6;"></i>
            <div class="stat-number"><?= $displayStats['total_schools'] ?? 0 ?></div>
            <div class="stat-label">Total Sekolah</div>
        </div>
        
        <div class="stat-card">
            <i class="fas fa-book stat-icon" style="color: #06b6d4;"></i>
            <div class="stat-number"><?= $displayStats['total_subjects'] ?? 0 ?></div>
            <div class="stat-label">Mata Pelajaran</div>
            <?php if (isset($displayActiveYear) && $displayActiveYear): ?>
                <div class="stat-sublabel">
                    Tahun Ajaran <?= $displayActiveYear['nama_tahun_ajaran'] ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="stat-card">
            <i class="fas fa-graduation-cap stat-icon" style="color: #84cc16;"></i>
            <div class="stat-number"><?= $displayStats['total_classes'] ?? 0 ?></div>
            <div class="stat-label">Total Kelas</div>
            <?php if (isset($displayActiveYear) && $displayActiveYear): ?>
                <div class="stat-sublabel">
                    Tahun Ajaran <?= $displayActiveYear['nama_tahun_ajaran'] ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="stat-card">
            <i class="fas fa-user-shield stat-icon" style="color: #f97316;"></i>
            <div class="stat-number"><?= $displayStats['total_admin'] ?? 0 ?></div>
            <div class="stat-label">Administrator</div>
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
