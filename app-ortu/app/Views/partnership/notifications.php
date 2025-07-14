<?= $this->extend('layouts/modern_layout') ?>

<?= $this->section('title') ?>Smart BookKeeping - Notifikasi<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-primary mb-2">
                        <i class="fas fa-bell me-2"></i>
                        Notifikasi
                    </h2>
                    <p class="text-muted">Pantau semua aktivitas dan update terbaru anak Anda</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-check-double me-2"></i>Tandai Semua Dibaca
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills notification-tabs" id="notificationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                        <i class="fas fa-list me-2"></i>Semua
                        <span class="badge bg-primary ms-2">12</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="unread-tab" data-bs-toggle="pill" data-bs-target="#unread" type="button" role="tab">
                        <i class="fas fa-envelope me-2"></i>Belum Dibaca
                        <span class="badge bg-danger ms-2">5</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="academic-tab" data-bs-toggle="pill" data-bs-target="#academic" type="button" role="tab">
                        <i class="fas fa-graduation-cap me-2"></i>Akademik
                        <span class="badge bg-success ms-2">8</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="payment-tab" data-bs-toggle="pill" data-bs-target="#payment" type="button" role="tab">
                        <i class="fas fa-credit-card me-2"></i>Pembayaran
                        <span class="badge bg-warning ms-2">3</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="event-tab" data-bs-toggle="pill" data-bs-target="#event" type="button" role="tab">
                        <i class="fas fa-calendar me-2"></i>Event
                        <span class="badge bg-info ms-2">1</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Notifications Content -->
    <div class="tab-content" id="notificationTabsContent">
        <!-- All Notifications -->
        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
            <div class="notification-list">
                <!-- Urgent Notification -->
                <div class="notification-item urgent unread" data-notification-id="1">
                    <div class="notification-icon">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-header">
                            <h6 class="notification-title mb-1">Tagihan SPP Tertunggak</h6>
                            <span class="notification-time">2 jam yang lalu</span>
                        </div>
                        <p class="notification-message mb-2">
                            Tagihan SPP bulan Januari 2025 belum dibayar. Batas pembayaran: 15 Januari 2025.
                        </p>
                        <div class="notification-actions">
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-credit-card me-1"></i>Bayar Sekarang
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-eye me-1"></i>Detail
                            </button>
                        </div>
                    </div>
                    <div class="notification-status">
                        <span class="status-dot urgent"></span>
                    </div>
                </div>

                <!-- Academic Notification -->
                <div class="notification-item academic unread" data-notification-id="2">
                    <div class="notification-icon">
                        <i class="fas fa-trophy text-warning"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-header">
                            <h6 class="notification-title mb-1">Prestasi Baru Dicapai!</h6>
                            <span class="notification-time">4 jam yang lalu</span>
                        </div>
                        <p class="notification-message mb-2">
                            Selamat! Anak Anda meraih juara 1 dalam kompetisi Matematika tingkat sekolah.
                        </p>
                        <div class="notification-actions">
                            <button class="btn btn-sm btn-primary">
                                <i class="fas fa-download me-1"></i>Download Sertifikat
                            </button>
                            <button class="btn btn-sm btn-outline-success">
                                <i class="fas fa-share me-1"></i>Bagikan
                            </button>
                        </div>
                    </div>
                    <div class="notification-status">
                        <span class="status-dot academic"></span>
                    </div>
                </div>

                <!-- Grade Notification -->
                <div class="notification-item academic read" data-notification-id="3">
                    <div class="notification-icon">
                        <i class="fas fa-chart-line text-success"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-header">
                            <h6 class="notification-title mb-1">Nilai Ujian Tengah Semester</h6>
                            <span class="notification-time">1 hari yang lalu</span>
                        </div>
                        <p class="notification-message mb-2">
                            Hasil ujian tengah semester telah keluar. Rata-rata nilai: 87.5 (Meningkat 5 poin dari sebelumnya).
                        </p>
                        <div class="notification-actions">
                            <button class="btn btn-sm btn-primary">
                                <i class="fas fa-chart-bar me-1"></i>Lihat Detail
                            </button>
                        </div>
                    </div>
                    <div class="notification-status">
                        <span class="status-dot academic"></span>
                    </div>
                </div>

                <!-- Event Notification -->
                <div class="notification-item event unread" data-notification-id="4">
                    <div class="notification-icon">
                        <i class="fas fa-calendar-check text-info"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-header">
                            <h6 class="notification-title mb-1">Rapat Orang Tua</h6>
                            <span class="notification-time">2 hari yang lalu</span>
                        </div>
                        <p class="notification-message mb-2">
                            Undangan rapat orang tua kelas VII A. Tanggal: 20 Januari 2025, Pukul: 08.00 WIB.
                        </p>
                        <div class="notification-actions">
                            <button class="btn btn-sm btn-success">
                                <i class="fas fa-check me-1"></i>Konfirmasi Hadir
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-times me-1"></i>Tidak Bisa Hadir
                            </button>
                        </div>
                    </div>
                    <div class="notification-status">
                        <span class="status-dot event"></span>
                    </div>
                </div>

                <!-- Payment Notification -->
                <div class="notification-item payment read" data-notification-id="5">
                    <div class="notification-icon">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-header">
                            <h6 class="notification-title mb-1">Pembayaran Berhasil</h6>
                            <span class="notification-time">3 hari yang lalu</span>
                        </div>
                        <p class="notification-message mb-2">
                            Pembayaran uang kegiatan ekstrakurikuler sebesar Rp 150.000 telah berhasil diproses.
                        </p>
                        <div class="notification-actions">
                            <button class="btn btn-sm btn-primary">
                                <i class="fas fa-receipt me-1"></i>Lihat Kwitansi
                            </button>
                        </div>
                    </div>
                    <div class="notification-status">
                        <span class="status-dot payment"></span>
                    </div>
                </div>

                <!-- Load More Button -->
                <div class="text-center mt-4">
                    <button class="btn btn-outline-primary load-more-btn">
                        <i class="fas fa-plus me-2"></i>Muat Lebih Banyak
                    </button>
                </div>
            </div>
        </div>

        <!-- Other tab contents would be filtered versions of the above -->
        <div class="tab-pane fade" id="unread" role="tabpanel" aria-labelledby="unread-tab">
            <div class="text-center py-5">
                <i class="fas fa-envelope-open text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-muted">Menampilkan notifikasi yang belum dibaca</h5>
                <p class="text-muted">Filter akan diterapkan untuk menampilkan hanya notifikasi yang belum dibaca</p>
            </div>
        </div>

        <div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="academic-tab">
            <div class="text-center py-5">
                <i class="fas fa-graduation-cap text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-muted">Notifikasi Akademik</h5>
                <p class="text-muted">Prestasi, nilai, dan informasi akademik lainnya</p>
            </div>
        </div>

        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
            <div class="text-center py-5">
                <i class="fas fa-credit-card text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-muted">Notifikasi Pembayaran</h5>
                <p class="text-muted">Tagihan, pembayaran, dan informasi keuangan</p>
            </div>
        </div>

        <div class="tab-pane fade" id="event" role="tabpanel" aria-labelledby="event-tab">
            <div class="text-center py-5">
                <i class="fas fa-calendar text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-muted">Notifikasi Event</h5>
                <p class="text-muted">Acara sekolah, rapat, dan kegiatan lainnya</p>
            </div>
        </div>
    </div>
</div>

<style>
.notification-tabs .nav-link {
    border-radius: 25px;
    margin-right: 10px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #666;
    transition: all 0.3s ease;
}

.notification-tabs .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.notification-tabs .nav-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.notification-list {
    space-y: 20px;
}

.notification-item {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 16px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
    position: relative;
    overflow: hidden;
}

.notification-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.notification-item:hover::before {
    opacity: 1;
}

.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-color: rgba(102, 126, 234, 0.3);
}

.notification-item.unread {
    border-left: 4px solid #667eea;
    background: rgba(102, 126, 234, 0.02);
}

.notification-item.urgent {
    border-left: 4px solid #dc3545;
    background: rgba(220, 53, 69, 0.02);
}

.notification-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    font-size: 1.2rem;
    flex-shrink: 0;
}

.notification-content {
    flex: 1;
    position: relative;
    z-index: 2;
}

.notification-header {
    display: flex;
    justify-content: between;
    align-items: flex-start;
    margin-bottom: 8px;
}

.notification-title {
    font-weight: 600;
    color: #2d3748;
    margin: 0;
    flex: 1;
}

.notification-time {
    font-size: 0.85rem;
    color: #718096;
    white-space: nowrap;
    margin-left: 12px;
}

.notification-message {
    color: #4a5568;
    line-height: 1.5;
    margin-bottom: 12px;
}

.notification-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.notification-status {
    display: flex;
    align-items: flex-start;
    padding-top: 4px;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #667eea;
    position: relative;
}

.status-dot.urgent {
    background: #dc3545;
    animation: pulse-urgent 2s infinite;
}

.status-dot.academic {
    background: #28a745;
}

.status-dot.payment {
    background: #ffc107;
}

.status-dot.event {
    background: #17a2b8;
}

@keyframes pulse-urgent {
    0% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
    }
}

.load-more-btn {
    border-radius: 25px;
    padding: 12px 30px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.load-more-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .notification-tabs {
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 10px;
    }
    
    .notification-tabs .nav-item {
        flex-shrink: 0;
    }
    
    .notification-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .notification-time {
        margin-left: 0;
        margin-top: 4px;
    }
    
    .notification-actions {
        flex-direction: column;
    }
    
    .notification-actions .btn {
        width: 100%;
        justify-content: center;
    }
}

/* Animation for new notifications */
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.notification-item.new {
    animation: slideInRight 0.5s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark as read functionality
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function() {
            if (this.classList.contains('unread')) {
                this.classList.remove('unread');
                this.classList.add('read');
                
                // Update unread count
                updateUnreadCount();
            }
        });
    });
    
    // Mark all as read
    document.querySelector('.btn:contains("Tandai Semua Dibaca")').addEventListener('click', function() {
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
            item.classList.add('read');
        });
        updateUnreadCount();
    });
    
    // Filter functionality
    document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(e) {
            const target = e.target.getAttribute('data-bs-target');
            filterNotifications(target);
        });
    });
    
    function updateUnreadCount() {
        const unreadCount = document.querySelectorAll('.notification-item.unread').length;
        const unreadBadge = document.querySelector('#unread-tab .badge');
        if (unreadBadge) {
            unreadBadge.textContent = unreadCount;
            if (unreadCount === 0) {
                unreadBadge.style.display = 'none';
            }
        }
    }
    
    function filterNotifications(filter) {
        const notifications = document.querySelectorAll('.notification-item');
        
        notifications.forEach(item => {
            let show = true;
            
            switch(filter) {
                case '#unread':
                    show = item.classList.contains('unread');
                    break;
                case '#academic':
                    show = item.classList.contains('academic');
                    break;
                case '#payment':
                    show = item.classList.contains('payment');
                    break;
                case '#event':
                    show = item.classList.contains('event');
                    break;
                default:
                    show = true;
            }
            
            item.style.display = show ? 'flex' : 'none';
        });
    }
    
    // Load more functionality
    document.querySelector('.load-more-btn').addEventListener('click', function() {
        // Simulate loading more notifications
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat...';
        
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-plus me-2"></i>Muat Lebih Banyak';
            // Add animation for new notifications
            document.querySelectorAll('.notification-item').forEach((item, index) => {
                if (index >= 5) { // Simulate new items
                    item.classList.add('new');
                }
            });
        }, 1500);
    });
    
    // Real-time notification simulation
    setInterval(() => {
        if (Math.random() < 0.1) { // 10% chance every 30 seconds
            simulateNewNotification();
        }
    }, 30000);
    
    function simulateNewNotification() {
        const notifications = [
            {
                type: 'academic',
                icon: 'fas fa-book text-primary',
                title: 'Tugas Baru Diberikan',
                message: 'Guru Matematika memberikan tugas bab Geometri. Deadline: Besok pukul 16:00.',
                time: 'Baru saja'
            },
            {
                type: 'payment',
                icon: 'fas fa-exclamation-triangle text-warning',
                title: 'Pengingat Pembayaran',
                message: 'Tagihan uang buku akan jatuh tempo dalam 3 hari.',
                time: 'Baru saja'
            }
        ];
        
        const randomNotification = notifications[Math.floor(Math.random() * notifications.length)];
        
        // Create new notification element
        const newNotificationHtml = `
            <div class="notification-item ${randomNotification.type} unread new" data-notification-id="${Date.now()}">
                <div class="notification-icon">
                    <i class="${randomNotification.icon}"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-header">
                        <h6 class="notification-title mb-1">${randomNotification.title}</h6>
                        <span class="notification-time">${randomNotification.time}</span>
                    </div>
                    <p class="notification-message mb-2">${randomNotification.message}</p>
                </div>
                <div class="notification-status">
                    <span class="status-dot ${randomNotification.type}"></span>
                </div>
            </div>
        `;
        
        // Add to beginning of notification list
        const notificationList = document.querySelector('.notification-list');
        notificationList.insertAdjacentHTML('afterbegin', newNotificationHtml);
        
        // Update counts
        updateUnreadCount();
        
        // Show toast notification
        showToast('Notifikasi baru diterima!', 'info');
    }
    
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }
});
</script>
<?= $this->endSection() ?>
