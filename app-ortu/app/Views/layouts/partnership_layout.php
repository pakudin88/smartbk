<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="fade-in">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </main>
    
    <!-- Modern Footer -->
    <footer class="modern-footer">
        <div class="container">
            <div class="footer-content">
                <h6 class="footer-title">Jendela Kemitraan</h6>
                <p class="footer-text">
                    Portal Kolaborasi untuk Mendukung Perkembangan Siswa<br>
                    &copy; <?= date('Y') ?> - Sistem Informasi Bimbingan Konseling
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Date Time Script -->
    <script>
        function updateDateTime() {
            const now = new Date();
            
            // Format date
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                timeZone: 'Asia/Jakarta'
            };
            const dateStr = now.toLocaleDateString('id-ID', options);
            
            // Format time
            const timeStr = now.toLocaleTimeString('id-ID', {
                timeZone: 'Asia/Jakarta',
                hour12: false
            }) + ' WIB';
            
            // Update elements
            const dateElement = document.getElementById('currentDate');
            const timeElement = document.getElementById('currentTime');
            
            if (dateElement) dateElement.textContent = dateStr;
            if (timeElement) timeElement.textContent = timeStr;
        }
        
        // Update immediately and then every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
        
        // Add smooth scrolling
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Add loading state for buttons
            document.querySelectorAll('button[type="submit"]').forEach(button => {
                button.addEventListener('click', function() {
                    if (this.form && this.form.checkValidity()) {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                        this.disabled = true;
                        
                        // Reset after 3 seconds if still on page
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }, 3000);
                    }
                });
            });
        });
    </script>
</body>
</html>-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Jendela Kemitraan - Portal Orang Tua' ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            color: #2d3748;
            line-height: 1.6;
        }
        
        /* Modern Header */
        .modern-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 30px rgba(102, 126, 234, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-top {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .header-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .header-main {
            padding: 16px 0;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .brand-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .brand-logo {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .brand-logo i {
            font-size: 1.5rem;
            color: white;
        }
        
        .brand-info h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .brand-info p {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-info {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 8px 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .user-name {
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            margin: 0;
        }
        
        .user-role {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.75rem;
            margin: 0;
        }
        
        .logout-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-1px);
        }
        
        /* Navigation */
        .nav-menu {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .nav-container {
            display: flex;
            gap: 8px;
            padding: 12px 0;
        }
        
        .nav-item {
            padding: 8px 16px;
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-item:hover,
        .nav-item.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        /* Main Content */
        .main-content {
            background: #f8fafc;
            min-height: calc(100vh - 200px);
            padding: 32px 0;
        }
        
        /* Footer */
        .modern-footer {
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            color: white;
            padding: 24px 0;
            margin-top: auto;
        }
        
        .footer-content {
            text-align: center;
        }
        
        .footer-title {
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .header-info {
                flex-direction: column;
                gap: 4px;
                text-align: center;
            }
            
            .header-content {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }
            
            .header-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .nav-container {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .brand-info h1 {
                font-size: 1.25rem;
            }
            
            .user-info {
                text-align: center;
                width: 100%;
            }
        }
        
        /* Animation */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Modern Header -->
    <header class="modern-header">
        <!-- Header Top -->
        <div class="header-top">
            <div class="container">
                <div class="header-info">
                    <div class="header-date">
                        <i class="fas fa-calendar-day me-2"></i>
                        <span id="currentDate"></span>
                    </div>
                    <div class="header-time">
                        <i class="fas fa-clock me-2"></i>
                        <span id="currentTime"></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Header Main -->
        <div class="header-main">
            <div class="container">
                <div class="header-content">
                    <div class="brand-section">
                        <div class="brand-logo">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="brand-info">
                            <h1>Jendela Kemitraan</h1>
                            <p>Portal Kolaborasi Orang Tua & Sekolah</p>
                        </div>
                    </div>
                    
                    <div class="header-actions">
                        <?php if (session()->get('parent_logged_in')): ?>
                        <div class="user-info">
                            <p class="user-name"><?= esc(session()->get('parent_name')) ?></p>
                            <p class="user-role">Orang Tua Siswa</p>
                        </div>
                        <a href="<?= base_url('logout') ?>" class="logout-btn">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            Keluar
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <?php if (session()->get('parent_logged_in')): ?>
        <div class="nav-menu">
            <div class="container">
                <div class="nav-container">
                    <a href="<?= base_url('dashboard') ?>" class="nav-item <?= (current_url() === base_url('dashboard')) ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('summary') ?>" class="nav-item <?= (current_url() === base_url('summary')) ? 'active' : '' ?>">
                        <i class="fas fa-file-alt me-2"></i>Laporan
                    </a>
                    <a href="<?= base_url('progress') ?>" class="nav-item <?= (current_url() === base_url('progress')) ? 'active' : '' ?>">
                        <i class="fas fa-chart-line me-2"></i>Progress
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </header>
            gap: 1rem;
        }
        
        .notification-icon {
            position: relative;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .notification-icon:hover {
            background: rgba(102, 126, 234, 0.2);
            transform: scale(1.05);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.9rem;
        }
        
        .user-role {
            font-size: 0.8rem;
            color: #718096;
        }
        
        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
            min-height: calc(100vh - 150px);
        }
        
        /* Card Styles */
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border: none;
        }
        
        .card-header h3 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        /* Footer */
        .footer {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .top-header {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Top Header dengan Waktu Indonesia -->
    <div class="top-header">
        <div class="header-date" id="currentDate">
            <!-- Akan diisi dengan JavaScript -->
        </div>
        <div class="header-time" id="currentTime">
            <!-- Akan diisi dengan JavaScript -->
        </div>
    </div>
    
    <!-- Main Header -->
    <header class="main-header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="app-info">
                    <h1>Jendela Kemitraan</h1>
                    <p>Portal Kemitraan Orang Tua & Sekolah</p>
                </div>
            </div>
            
            <div class="user-section">
                <div class="notification-icon" onclick="showNotifications()">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>
                
                <div class="user-info">
                    <div class="user-name"><?= $user_name ?? 'Bapak/Ibu Wali' ?></div>
                    <div class="user-role">Wali Murid</div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main-content">
        <?= $this->renderSection('content') ?>
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Jendela Kemitraan - Portal Orang Tua. Sistem Informasi Manajemen Sekolah</p>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Update waktu dan tanggal Indonesia secara real-time
        function updateDateTime() {
            const now = new Date();
            
            // Array nama hari dalam bahasa Indonesia
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            
            // Array nama bulan dalam bahasa Indonesia
            const months = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            
            // Format tanggal
            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const dateString = `${dayName}, ${day} ${month} ${year}`;
            
            // Format waktu
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds} WIB`;
            
            // Update elemen
            document.getElementById('currentDate').textContent = dateString;
            document.getElementById('currentTime').textContent = timeString;
        }
        
        // Update setiap detik
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Initial call
        
        // Fungsi notifikasi
        function showNotifications() {
            alert('📢 Notifikasi:\n• Undangan baru dari Guru BK\n• Laporan perkembangan tersedia\n• Rencana aksi telah diperbarui');
        }
        
        // Alert helper
        function showAlert(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                font-size: 14px;
                z-index: 9999;
                max-width: 300px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                animation: slideIn 0.3s ease;
            `;
            alertDiv.innerHTML = message;
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 4000);
        }
        
        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(100%);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
