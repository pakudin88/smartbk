<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Safe Space</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .top-header {
            background: #667eea;
            color: white;
            padding: 0.5rem 0;
            font-size: 0.9rem;
        }
        .time-display {
            font-weight: 600;
        }
        .date-display {
            font-weight: 500;
        }
    </style>
</head>
<body>
    <!-- Top Header with Date and Time -->
    <div class="top-header">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="date-display">
                <?php
                    $hari = array(
                        'Sunday' => 'Minggu',
                        'Monday' => 'Senin', 
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu'
                    );
                    
                    $bulan = array(
                        'January' => 'Januari',
                        'February' => 'Februari',
                        'March' => 'Maret',
                        'April' => 'April',
                        'May' => 'Mei',
                        'June' => 'Juni',
                        'July' => 'Juli',
                        'August' => 'Agustus',
                        'September' => 'September',
                        'October' => 'Oktober',
                        'November' => 'November',
                        'December' => 'Desember'
                    );
                    
                    $hari_ini = $hari[date('l')];
                    $tanggal = date('d');
                    $bulan_ini = $bulan[date('F')];
                    $tahun = date('Y');
                    
                    echo "$hari_ini, $tanggal $bulan_ini $tahun";
                ?>
            </div>
            <div class="time-display" id="current-time">
                <?= date('H:i:s') ?>
            </div>
        </div>
    </div>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
                <i class="fas fa-shield-heart me-2"></i>
                Safe Space
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link position-relative d-flex align-items-center" href="#" onclick="showNotifications()">
                    <i class="fas fa-bell" style="font-size: 1.1rem;"></i>
                    <span class="position-absolute badge rounded-pill bg-danger" style="
                        top: -8px; 
                        right: -8px; 
                        font-size: 0.65rem; 
                        min-width: 18px; 
                        height: 18px; 
                        display: flex; 
                        align-items: center; 
                        justify-content: center;
                        padding: 0;
                        border: 2px solid white;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                    ">
                        3
                    </span>
                </a>
            </div>
        </div>
    </nav>
    
    <main class="container-fluid">
        <?= $this->renderSection('content') ?>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Notification function for navbar
    function showNotifications() {
        showAlert('📢 Notifikasi:\n• Pesan baru dari Guru BK\n• Reminder: Isi jurnal harian\n• Update: Jadwal konseling tersedia');
    }
    
    // Simple alert function
    function showAlert(message) {
        const alert = document.createElement('div');
        alert.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #3b82f6;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            z-index: 1001;
            max-width: 300px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        `;
        alert.innerHTML = message;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
    
    // Update time every second
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('current-time').textContent = timeString;
    }
    
    // Start time update
    setInterval(updateTime, 1000);
    updateTime(); // Initial call
    </script>
</body>
</html>
