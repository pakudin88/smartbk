<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Jendela Kemitraan - Portal Orang Tua' ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        
        /* Header dengan Tanggal dan Waktu Indonesia */
        .top-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            color: white;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-date {
            font-weight: 500;
        }
        
        .header-time {
            font-weight: 600;
            font-size: 1rem;
        }
        
        /* Main Header */
        .main-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 1rem;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        
        .app-info h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }
        
        .app-info p {
            font-size: 0.9rem;
            color: #718096;
            margin: 0;
        }
        
        .user-section {
            display: flex;
            align-items: center;
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
