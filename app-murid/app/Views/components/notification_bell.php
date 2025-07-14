<!-- Notification Bell Component -->
<div class="notification-container">
    <!-- Notification Bell Icon -->
    <div class="dropdown">
        <button class="btn btn-light position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell" style="font-size: 1.2rem;"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display: none;">
                0
            </span>
        </button>
        
        <!-- Notification Dropdown -->
        <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown" style="width: 350px; max-height: 400px; overflow-y: auto;">
            <!-- Header -->
            <li class="dropdown-header d-flex justify-content-between align-items-center">
                <span><strong>Notifikasi</strong></span>
                <button class="btn btn-sm btn-outline-secondary" id="markAllReadBtn" onclick="markAllAsRead()">
                    <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                </button>
            </li>
            <li><hr class="dropdown-divider"></li>
            
            <!-- Notifications List -->
            <div id="notificationsList">
                <li class="dropdown-item text-center text-muted">
                    <i class="fas fa-spinner fa-spin"></i> Memuat notifikasi...
                </li>
            </div>
            
            <!-- Footer -->
            <li><hr class="dropdown-divider"></li>
            <li class="dropdown-item text-center">
                <button class="btn btn-sm btn-primary" onclick="sendTestNotification()">
                    <i class="fas fa-plus"></i> Test Notifikasi
                </button>
            </li>
        </ul>
    </div>
</div>

<!-- Toast Container for New Notifications -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="notificationToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <!-- Toast content will be inserted here -->
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Notification Styles -->
<style>
.notification-dropdown {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e0e0e0;
}

.notification-item {
    padding: 10px 15px;
    border-bottom: 1px solid #f0f0f0;
    cursor: pointer;
    transition: background-color 0.2s;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-item.unread {
    background-color: #e3f2fd;
    border-left: 4px solid #2196f3;
}

.notification-item .notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: white;
}

.notification-item .notification-content {
    flex: 1;
    margin-left: 10px;
}

.notification-item .notification-title {
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 2px;
}

.notification-item .notification-message {
    font-size: 0.8rem;
    color: #666;
    line-height: 1.3;
}

.notification-item .notification-time {
    font-size: 0.75rem;
    color: #999;
    margin-top: 2px;
}

.notification-pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.notification-sound {
    display: none;
}
</style>

<!-- Audio for notification sound -->
<audio id="notificationSound" class="notification-sound" preload="auto">
    <source src="data:audio/mpeg;base64,SUQzBAAAAAABEVRYWFgAAAAtAAADY29tbWVudABCaWdTb3VuZEJhbmsuY29tIC8gTGFTb25vdGhlcXVlLm9yZwBURU5DAAAAHQAAAC9yZWFjdGlvbi9zb3VuZC9iZWVwXzI4LndhZgA=" type="audio/mpeg">
</audio>

<!-- Notification JavaScript -->
<script>
let notificationCheckInterval;
let lastNotificationCheck = new Date().toISOString();

// Initialize notifications when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
    startNotificationPolling();
});

// Load notifications from server
function loadNotifications() {
    fetch('<?= base_url() ?>notifications/get')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                displayNotifications(data.data);
                updateNotificationBadge(data.unread_count);
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            document.getElementById('notificationsList').innerHTML = 
                '<li class="dropdown-item text-center text-danger">Gagal memuat notifikasi</li>';
        });
}

// Display notifications in dropdown
function displayNotifications(notifications) {
    const notificationsList = document.getElementById('notificationsList');
    
    if (notifications.length === 0) {
        notificationsList.innerHTML = 
            '<li class="dropdown-item text-center text-muted">Tidak ada notifikasi</li>';
        return;
    }
    
    const notificationsHTML = notifications.map(notification => `
        <li class="notification-item ${!notification.read ? 'unread' : ''}" 
            onclick="handleNotificationClick('${notification.id}', '${notification.url}')">
            <div class="d-flex align-items-start">
                <div class="notification-icon bg-${notification.color}">
                    <i class="${notification.icon}"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">${notification.title}</div>
                    <div class="notification-message">${notification.message}</div>
                    <div class="notification-time">${formatNotificationTime(notification.timestamp)}</div>
                </div>
                ${!notification.read ? '<div class="text-primary"><i class="fas fa-circle" style="font-size: 0.5rem;"></i></div>' : ''}
            </div>
        </li>
    `).join('');
    
    notificationsList.innerHTML = notificationsHTML;
}

// Handle notification click
function handleNotificationClick(notificationId, url) {
    // Mark as read
    markAsRead(notificationId);
    
    // Navigate to URL if provided
    if (url && url !== '#') {
        window.location.href = '<?= base_url() ?>' + url.replace(/^\//, '');
    }
}

// Mark notification as read
function markAsRead(notificationId) {
    fetch('<?= base_url() ?>notifications/mark-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: notificationId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadNotifications(); // Reload to update UI
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}

// Mark all notifications as read
function markAllAsRead() {
    fetch('<?= base_url() ?>notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadNotifications(); // Reload to update UI
        }
    })
    .catch(error => console.error('Error marking all notifications as read:', error));
}

// Update notification badge
function updateNotificationBadge(count) {
    const badge = document.getElementById('notificationBadge');
    if (count > 0) {
        badge.style.display = 'block';
        badge.textContent = count > 99 ? '99+' : count;
        
        // Add pulse animation
        const bell = document.querySelector('#notificationDropdown i');
        bell.classList.add('notification-pulse');
        setTimeout(() => bell.classList.remove('notification-pulse'), 2000);
    } else {
        badge.style.display = 'none';
    }
}

// Show toast notification
function showToastNotification(notification) {
    const toast = document.getElementById('notificationToast');
    const toastBody = toast.querySelector('.toast-body');
    
    // Set toast color based on notification type
    toast.className = `toast align-items-center border-0 text-white bg-${notification.color}`;
    
    toastBody.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="${notification.icon} me-2"></i>
            <div>
                <div style="font-weight: 600;">${notification.title}</div>
                <div style="font-size: 0.9rem;">${notification.message}</div>
            </div>
        </div>
    `;
    
    // Show toast
    const bsToast = new bootstrap.Toast(toast, {
        delay: 5000,
        autohide: true
    });
    bsToast.show();
    
    // Play notification sound
    playNotificationSound();
}

// Play notification sound
function playNotificationSound() {
    try {
        const audio = document.getElementById('notificationSound');
        if (audio) {
            // Create a simple beep sound using Web Audio API as fallback
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.value = 800;
            oscillator.type = 'sine';
            
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.3);
        }
    } catch (error) {
        console.log('Audio notification not available:', error);
    }
}

// Start polling for new notifications
function startNotificationPolling() {
    notificationCheckInterval = setInterval(() => {
        checkForNewNotifications();
    }, 10000); // Check every 10 seconds
}

// Check for new notifications
function checkForNewNotifications() {
    fetch(`<?= base_url() ?>notifications/updates?since=${encodeURIComponent(lastNotificationCheck)}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success' && data.has_new) {
                // Show toast for each new notification
                data.data.forEach(notification => {
                    showToastNotification(notification);
                });
                
                // Reload all notifications
                loadNotifications();
            }
            lastNotificationCheck = new Date().toISOString();
        })
        .catch(error => console.error('Error checking for new notifications:', error));
}

// Send test notification (for testing purposes)
function sendTestNotification() {
    fetch('<?= base_url() ?>notifications/test', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            showToastNotification(data.data);
            setTimeout(() => loadNotifications(), 1000);
        }
    })
    .catch(error => console.error('Error sending test notification:', error));
}

// Format notification time
function formatNotificationTime(timestamp) {
    const now = new Date();
    const notifTime = new Date(timestamp);
    const diffMs = now - notifTime;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMins / 60);
    const diffDays = Math.floor(diffHours / 24);
    
    if (diffMins < 1) return 'Baru saja';
    if (diffMins < 60) return `${diffMins} menit yang lalu`;
    if (diffHours < 24) return `${diffHours} jam yang lalu`;
    if (diffDays < 7) return `${diffDays} hari yang lalu`;
    
    return notifTime.toLocaleDateString('id-ID');
}

// Clean up interval when page unloads
window.addEventListener('beforeunload', function() {
    if (notificationCheckInterval) {
        clearInterval(notificationCheckInterval);
    }
});
</script>
