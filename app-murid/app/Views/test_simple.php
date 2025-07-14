<!DOCTYPE html>
<html>
<head>
    <title>Test App Murid - Simple</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        .test-item { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>Test App Murid - Simple Debug</h1>
    
    <div class="test-item">
        <h3>Server Information:</h3>
        <p><strong>PHP Version:</strong> <?= PHP_VERSION ?></p>
        <p><strong>Server Port:</strong> <?= $_SERVER['SERVER_PORT'] ?? 'tidak diketahui' ?></p>
        <p><strong>HTTP Host:</strong> <?= $_SERVER['HTTP_HOST'] ?? 'tidak diketahui' ?></p>
        <p><strong>Request URI:</strong> <?= $_SERVER['REQUEST_URI'] ?? 'tidak diketahui' ?></p>
        <p><strong>Script Name:</strong> <?= $_SERVER['SCRIPT_NAME'] ?? 'tidak diketahui' ?></p>
    </div>

    <div class="test-item">
        <h3>CodeIgniter Status:</h3>
        <p class="success">✅ CodeIgniter Framework berhasil dimuat</p>
        <p class="success">✅ Controller dapat diakses</p>
        <p class="success">✅ View dapat dirender</p>
    </div>

    <div class="test-item">
        <h3>Test Links:</h3>
        <p><a href="<?= base_url() ?>">Home (base_url)</a></p>
        <p><a href="<?= base_url('login') ?>">Login Page</a></p>
        <p><a href="<?= base_url('safe-space/konsul-cepat') ?>">Safe Space - Konsul Cepat</a></p>
        <p><a href="<?= base_url('safe-space/test-url') ?>">Safe Space - Test URL</a></p>
    </div>

    <div class="test-item">
        <h3>Manual URL Tests:</h3>
        <p>Coba akses secara manual:</p>
        <ul>
            <li>XAMPP: <code>http://localhost/simaklah-main/app-murid/public/</code></li>
            <li>XAMPP Safe Space: <code>http://localhost/simaklah-main/app-murid/public/safe-space/konsul-cepat</code></li>
            <li>Spark: <code>http://localhost:8080/</code></li>
            <li>Spark Safe Space: <code>http://localhost:8080/safe-space/konsul-cepat</code></li>
        </ul>
    </div>
</body>
</html>
