<!DOCTYPE html>
<html>
<head>
    <title>Test URL Dinamis - Safe Space</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .test-item { margin: 10px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .success { background-color: #d4edda; border-color: #c3e6cb; }
        .error { background-color: #f8d7da; border-color: #f5c6cb; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Test URL Dinamis - Safe Space Features</h1>
        
        <div class="test-item">
            <h5>Informasi Server:</h5>
            <p><strong>Current URL:</strong> <?= $currentUrl ?></p>
            <p><strong>Server Port:</strong> <?= $_SERVER['SERVER_PORT'] ?? 'tidak diketahui' ?></p>
            <p><strong>HTTP Host:</strong> <?= $_SERVER['HTTP_HOST'] ?? 'tidak diketahui' ?></p>
            <p><strong>Server Name:</strong> <?= $_SERVER['SERVER_NAME'] ?? 'tidak diketahui' ?></p>
        </div>

        <div class="test-item">
            <h5>Test Safe Space Routes:</h5>
            <div class="row">
                <div class="col-md-6">
                    <a href="<?= $currentUrl ?>/safe-space/konsul-cepat" class="btn btn-primary btn-block mb-2 w-100">
                        📞 Konsul Cepat & Anonim
                    </a>
                    <a href="<?= $currentUrl ?>/safe-space/jadwal-konseling" class="btn btn-info btn-block mb-2 w-100">
                        📅 Jadwal Konseling
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="<?= $currentUrl ?>/safe-space/jurnal-digital" class="btn btn-warning btn-block mb-2 w-100">
                        📖 Jurnal Digital
                    </a>
                    <a href="<?= $currentUrl ?>/safe-space/pusat-informasi" class="btn btn-success btn-block mb-2 w-100">
                        ℹ️ Pusat Informasi
                    </a>
                </div>
            </div>
        </div>

        <div class="test-item">
            <h5>Test AJAX URL untuk Konsul Cepat:</h5>
            <button id="testAjax" class="btn btn-secondary">Test AJAX Send Message</button>
            <div id="ajaxResult" class="mt-3"></div>
        </div>

        <div class="test-item">
            <h5>Session Information:</h5>
            <?php if (isset($_SESSION) && !empty($_SESSION)): ?>
                <p><strong>User Logged In:</strong> <?= isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] ? 'Ya' : 'Tidak' ?></p>
                <p><strong>Role:</strong> <?= $_SESSION['role'] ?? 'tidak diketahui' ?></p>
                <p><strong>Nama:</strong> <?= $_SESSION['nama'] ?? 'tidak diketahui' ?></p>
            <?php else: ?>
                <p class="text-warning">Session tidak ditemukan atau belum login</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('testAjax').addEventListener('click', function() {
            const currentUrl = '<?= $currentUrl ?>';
            const ajaxUrl = currentUrl + '/safe-space/send-message';
            
            fetch(ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    message: 'Test message untuk verifikasi URL dinamis',
                    anonymous: false
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('ajaxResult').innerHTML = 
                    '<div class="alert alert-success">AJAX berhasil! Response: ' + JSON.stringify(data) + '</div>';
            })
            .catch(error => {
                document.getElementById('ajaxResult').innerHTML = 
                    '<div class="alert alert-danger">AJAX gagal: ' + error.message + '</div>';
            });
        });
    </script>
</body>
</html>
