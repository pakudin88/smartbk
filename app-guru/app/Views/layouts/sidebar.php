<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: <?= $theme['sidebar_bg'] ?>;">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="/assets/img/school-logo.png" alt="School Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SmartBK <?= $roleDisplayName ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/assets/img/user-avatar.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?= session()->get('user_name') ?? 'Admin User' ?>
                    <small class="d-block text-muted"><?= $roleDisplayName ?></small>
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu..." aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php foreach ($menuItems as $item): ?>
                    <?php if (isset($item['submenu'])): ?>
                        <!-- Menu dengan submenu -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon <?= $item['icon'] ?>"></i>
                                <p>
                                    <?= $item['title'] ?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php foreach ($item['submenu'] as $subitem): ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url($subitem['url']) ?>" class="nav-link">
                                            <i class="<?= $subitem['icon'] ?> nav-icon"></i>
                                            <p><?= $subitem['title'] ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Menu tunggal -->
                        <li class="nav-item">
                            <a href="<?= base_url($item['url']) ?>" class="nav-link <?= isset($item['active']) && $item['active'] ? 'active' : '' ?>">
                                <i class="nav-icon <?= $item['icon'] ?>"></i>
                                <p><?= $item['title'] ?></p>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>

                <!-- Quick Actions Section -->
                <li class="nav-header">QUICK ACTIONS</li>
                
                <?php if ($userRole === 'guru_bk'): ?>
                    <li class="nav-item">
                        <a href="/konseling/buat-sesi" class="nav-link">
                            <i class="nav-icon fas fa-plus text-info"></i>
                            <p>Buat Sesi Konseling</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/asesmen/cepat" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-check text-warning"></i>
                            <p>Asesmen Cepat</p>
                        </a>
                    </li>
                <?php elseif ($userRole === 'guru_kelas'): ?>
                    <li class="nav-item">
                        <a href="/nilai/input-cepat" class="nav-link">
                            <i class="nav-icon fas fa-edit text-success"></i>
                            <p>Input Nilai Cepat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/absensi/hari-ini" class="nav-link">
                            <i class="nav-icon fas fa-user-check text-primary"></i>
                            <p>Absensi Hari Ini</p>
                        </a>
                    </li>
                <?php elseif ($userRole === 'wali_kelas'): ?>
                    <li class="nav-item">
                        <a href="/siswa/monitoring" class="nav-link">
                            <i class="nav-icon fas fa-eye text-purple"></i>
                            <p>Monitor Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/komunikasi/kontak-orangtua" class="nav-link">
                            <i class="nav-icon fas fa-phone text-info"></i>
                            <p>Kontak Orang Tua</p>
                        </a>
                    </li>
                <?php elseif ($userRole === 'kepala_sekolah'): ?>
                    <li class="nav-item">
                        <a href="/laporan/executive" class="nav-link">
                            <i class="nav-icon fas fa-chart-line text-danger"></i>
                            <p>Laporan Executive</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/monitoring/real-time" class="nav-link">
                            <i class="nav-icon fas fa-desktop text-warning"></i>
                            <p>Monitor Real-time</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- System Section -->
                <li class="nav-header">SISTEM</li>
                <li class="nav-item">
                    <a href="/profile" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/settings" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/help" class="nav-link">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Bantuan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/logout" class="nav-link text-danger">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Keluar</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Custom CSS for role-specific theming -->
<style>
    .main-sidebar {
        background-color: <?= $theme['sidebar_bg'] ?> !important;
    }
    
    .nav-link.active {
        background-color: <?= $theme['primary_color'] ?> !important;
        color: white !important;
    }
    
    .nav-link:hover {
        background-color: rgba(<?= hexToRgb($theme['primary_color']) ?>, 0.1) !important;
    }
    
    .brand-link {
        border-bottom: 1px solid <?= $theme['accent_color'] ?>;
    }
    
    .brand-text {
        color: <?= $theme['accent_color'] ?> !important;
    }
    
    .nav-header {
        color: <?= $theme['accent_color'] ?> !important;
        border-bottom: 1px solid rgba(<?= hexToRgb($theme['accent_color']) ?>, 0.3);
    }
    
    .text-purple {
        color: #6f42c1 !important;
    }
</style>

<?php
// Helper function to convert hex to RGB
function hexToRgb($hex) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return "$r, $g, $b";
}
?>
