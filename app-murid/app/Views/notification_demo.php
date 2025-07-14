<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Sistem Notifikasi Realtime - Safe Space</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e8f5e8 0%, #e3f2fd 100%);
            min-height: 100vh;
        }
        .demo-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        .demo-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .feature-item {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        .demo-btn {
            transition: all 0.3s ease;
        }
        .demo-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <!-- Header with Notification Bell -->
    <header class="demo-header sticky-top">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-shield-alt text-primary me-2" style="font-size: 1.5rem;"></i>
                    <h4 class="mb-0">Safe Space - Demo Notifikasi</h4>
                </div>
                
                <!-- Notification Bell Component -->
                <?php include APPPATH . 'Views/components/notification_bell.php'; ?>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Welcome Card -->
                <div class="demo-card p-4 mb-4">
                    <div class="text-center">
                        <i class="fas fa-bell text-primary" style="font-size: 3rem;"></i>
                        <h2 class="mt-3 mb-2">Sistem Notifikasi Realtime</h2>
                        <p class="text-muted">
                            Sistem notifikasi yang memberikan update realtime untuk pesan chat, 
                            persetujuan kegiatan, dan pengingat jurnal digital.
                        </p>
                    </div>
                </div>

                <!-- Features Demo -->
                <div class="demo-card p-4 mb-4">
                    <h5 class="mb-4"><i class="fas fa-cogs me-2"></i>Fitur Notifikasi</h5>
                    
                    <div class="feature-item">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-comments text-primary" style="font-size: 1.5rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Pesan Chat Realtime</h6>
                                <p class="mb-0 text-muted">Notifikasi instant ketika ada balasan dari konselor</p>
                            </div>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-calendar-check text-success" style="font-size: 1.5rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Persetujuan Kegiatan</h6>
                                <p class="mb-0 text-muted">Update langsung ketika jadwal konseling disetujui</p>
                            </div>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-calendar-plus text-info" style="font-size: 1.5rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Kegiatan Baru</h6>
                                <p class="mb-0 text-muted">Pemberitahuan kegiatan dan workshop yang tersedia</p>
                            </div>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-book text-warning" style="font-size: 1.5rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Reminder Jurnal</h6>
                                <p class="mb-0 text-muted">Pengingat untuk mengisi jurnal digital harian</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Demo Controls -->
                <div class="demo-card p-4 mb-4">
                    <h5 class="mb-4"><i class="fas fa-play me-2"></i>Demo Controls</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button class="btn btn-primary demo-btn w-100" onclick="sendTestNotification()">
                                <i class="fas fa-bell me-2"></i>Kirim Test Notifikasi
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button class="btn btn-success demo-btn w-100" onclick="simulateChatMessage()">
                                <i class="fas fa-comments me-2"></i>Simulasi Chat Masuk
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button class="btn btn-info demo-btn w-100" onclick="simulateApproval()">
                                <i class="fas fa-check me-2"></i>Simulasi Persetujuan
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button class="btn btn-warning demo-btn w-100" onclick="simulateReminder()">
                                <i class="fas fa-clock me-2"></i>Simulasi Reminder
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Real-time Status -->
                <div class="demo-card p-4 mb-4">
                    <h5 class="mb-3"><i class="fas fa-wifi me-2"></i>Status Realtime</h5>
                    <div class="d-flex align-items-center">
                        <div class="spinner-grow text-success me-2" role="status" style="width: 1rem; height: 1rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="text-success">Terhubung - Polling setiap 10 detik</span>
                    </div>
                    <small class="text-muted">
                        Sistem secara otomatis memeriksa notifikasi baru dan menampilkan 
                        toast notification + suara untuk update realtime.
                    </small>
                </div>

                <!-- Navigation Links -->
                <div class="demo-card p-4">
                    <h5 class="mb-3"><i class="fas fa-link me-2"></i>Navigasi Safe Space</h5>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="<?= base_url('safe-space/konsul-cepat') ?>" class="btn btn-outline-primary w-100">
                                <i class="fas fa-comments me-2"></i>Konsul Cepat
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="<?= base_url('safe-space/jadwal-konseling') ?>" class="btn btn-outline-success w-100">
                                <i class="fas fa-calendar me-2"></i>Jadwal Konseling
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="<?= base_url('safe-space/jurnal-digital') ?>" class="btn btn-outline-warning w-100">
                                <i class="fas fa-book me-2"></i>Jurnal Digital
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="<?= base_url('safe-space/pusat-informasi') ?>" class="btn btn-outline-info w-100">
                                <i class="fas fa-info-circle me-2"></i>Pusat Informasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Additional demo functions
        function simulateChatMessage() {
            const chatNotification = {
                id: Date.now(),
                type: 'chat',
                title: 'Pesan Chat Baru',
                message: 'Konselor telah membalas pesan Anda di Safe Space',
                timestamp: new Date().toISOString(),
                read: false,
                icon: 'fas fa-comments',
                color: 'primary',
                url: '/safe-space/konsul-cepat'
            };
            showToastNotification(chatNotification);
            setTimeout(() => loadNotifications(), 500);
        }

        function simulateApproval() {
            const approvalNotification = {
                id: Date.now(),
                type: 'approval',
                title: 'Konseling Disetujui',
                message: 'Jadwal konseling Anda untuk besok telah disetujui oleh konselor',
                timestamp: new Date().toISOString(),
                read: false,
                icon: 'fas fa-calendar-check',
                color: 'success',
                url: '/safe-space/jadwal-konseling'
            };
            showToastNotification(approvalNotification);
            setTimeout(() => loadNotifications(), 500);
        }

        function simulateReminder() {
            const reminderNotification = {
                id: Date.now(),
                type: 'reminder',
                title: 'Reminder Jurnal',
                message: 'Jangan lupa mengisi jurnal digital Anda hari ini',
                timestamp: new Date().toISOString(),
                read: false,
                icon: 'fas fa-book',
                color: 'warning',
                url: '/safe-space/jurnal-digital'
            };
            showToastNotification(reminderNotification);
            setTimeout(() => loadNotifications(), 500);
        }

        // Show welcome message
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const welcomeNotification = {
                    id: 'welcome',
                    type: 'info',
                    title: 'Selamat Datang!',
                    message: 'Sistem notifikasi realtime telah aktif. Coba tekan tombol demo di bawah.',
                    timestamp: new Date().toISOString(),
                    read: false,
                    icon: 'fas fa-info-circle',
                    color: 'info',
                    url: '#'
                };
                showToastNotification(welcomeNotification);
            }, 2000);
        });
    </script>
</body>
</html>
