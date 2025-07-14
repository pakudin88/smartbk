// PWA App JavaScript
class SuperAdminApp {
    constructor() {
        this.deferredPrompt = null;
        this.init();
    }

    init() {
        this.registerServiceWorker();
        this.setupPWAInstallPrompt();
        this.setupOfflineDetection();
        this.setupNotifications();
        this.setupFormValidation();
    }

    // Service Worker Registration
    registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('SW registered: ', registration);
                    })
                    .catch(registrationError => {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
    }

    // PWA Install Prompt
    setupPWAInstallPrompt() {
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            this.deferredPrompt = e;
            this.showInstallPrompt();
        });

        window.addEventListener('appinstalled', () => {
            console.log('PWA was installed');
            this.hideInstallPrompt();
        });
    }

    showInstallPrompt() {
        const prompt = document.createElement('div');
        prompt.className = 'pwa-install-prompt show';
        prompt.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-mobile-alt me-2"></i>
                <span>Install aplikasi untuk akses yang lebih mudah</span>
                <button class="btn btn-sm" onclick="app.installPWA()">Install</button>
                <button class="btn-close" onclick="app.hideInstallPrompt()">×</button>
            </div>
        `;
        document.body.appendChild(prompt);
        
        // Auto hide after 10 seconds
        setTimeout(() => {
            this.hideInstallPrompt();
        }, 10000);
    }

    hideInstallPrompt() {
        const prompt = document.querySelector('.pwa-install-prompt');
        if (prompt) {
            prompt.remove();
        }
    }

    installPWA() {
        if (this.deferredPrompt) {
            this.deferredPrompt.prompt();
            this.deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the install prompt');
                } else {
                    console.log('User dismissed the install prompt');
                }
                this.deferredPrompt = null;
            });
        }
        this.hideInstallPrompt();
    }

    // Offline Detection
    setupOfflineDetection() {
        const offlineIndicator = document.createElement('div');
        offlineIndicator.className = 'offline-indicator';
        offlineIndicator.innerHTML = `
            <i class="fas fa-wifi me-2"></i>
            Anda sedang offline. Beberapa fitur mungkin tidak tersedia.
        `;
        document.body.appendChild(offlineIndicator);

        window.addEventListener('online', () => {
            offlineIndicator.classList.remove('show');
            this.showNotification('Koneksi internet tersambung kembali', 'success');
        });

        window.addEventListener('offline', () => {
            offlineIndicator.classList.add('show');
            this.showNotification('Koneksi internet terputus', 'warning');
        });
    }

    // Notifications
    setupNotifications() {
        if ('Notification' in window) {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    console.log('Notification permission granted');
                }
            });
        }
    }

    showNotification(message, type = 'info') {
        // Create toast notification
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'info'} border-0`;
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

        // Add to toast container
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        toastContainer.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

        // Remove after hide
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }

    // Form Validation
    setupFormValidation() {
        const forms = document.querySelectorAll('.needs-validation');
        forms.forEach(form => {
            form.addEventListener('submit', (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    }

    // Utilities
    showLoading(element) {
        element.classList.add('loading');
        element.style.position = 'relative';
    }

    hideLoading(element) {
        element.classList.remove('loading');
    }

    formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    formatDate(date) {
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(date));
    }

    formatDateTime(date) {
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }).format(new Date(date));
    }

    // AJAX Helper
    async request(url, options = {}) {
        const defaultOptions = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        const config = { ...defaultOptions, ...options };

        try {
            const response = await fetch(url, config);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Request failed:', error);
            this.showNotification('Terjadi kesalahan pada server', 'error');
            throw error;
        }
    }

    // Local Storage Helper
    setLocalStorage(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
        } catch (error) {
            console.error('Failed to save to localStorage:', error);
        }
    }

    getLocalStorage(key) {
        try {
            const item = localStorage.getItem(key);
            return item ? JSON.parse(item) : null;
        } catch (error) {
            console.error('Failed to get from localStorage:', error);
            return null;
        }
    }

    removeLocalStorage(key) {
        try {
            localStorage.removeItem(key);
        } catch (error) {
            console.error('Failed to remove from localStorage:', error);
        }
    }
}

// Initialize app when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.app = new SuperAdminApp();
});

// Global functions for HTML onclick events
function installPWA() {
    if (window.app) {
        window.app.installPWA();
    }
}

function hideInstallPrompt() {
    if (window.app) {
        window.app.hideInstallPrompt();
    }
}
