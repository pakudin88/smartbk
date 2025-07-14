<?php
/**
 * Debug Script untuk Aplikasi Murid
 * Jalankan file ini untuk memeriksa konfigurasi dan status aplikasi
 */

echo "<h1>Debug Aplikasi Murid - SIMAKLAH</h1>";
echo "<hr>";

// 1. Cek lokasi file
echo "<h2>1. Lokasi File</h2>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";
echo "<p><strong>App Directory:</strong> " . __DIR__ . "/app</p>";
echo "<p><strong>Routes File:</strong> " . (__DIR__ . "/app/Config/Routes.php") . "</p>";

// 2. Cek file-file penting
echo "<h2>2. File Penting</h2>";
$files = [
    'app/Config/Routes.php' => 'Routes Configuration',
    'app/Controllers/Auth.php' => 'Auth Controller',
    'app/Views/auth/login.php' => 'Login View',
    'app/Views/dashboard/index.php' => 'Dashboard View',
    'app/Controllers/SafeSpaceController.php' => 'Safe Space Controller'
];

foreach ($files as $file => $description) {
    $path = __DIR__ . "/" . $file;
    $exists = file_exists($path);
    $color = $exists ? 'green' : 'red';
    $status = $exists ? '✓ EXISTS' : '✗ MISSING';
    echo "<p><span style='color: $color'><strong>$status</strong></span> - $description ($file)</p>";
}

// 3. Cek konfigurasi database
echo "<h2>3. Konfigurasi Database</h2>";
try {
    // Load CodeIgniter
    require_once __DIR__ . '/vendor/autoload.php';
    
    // Set path constants
    define('APPPATH', __DIR__ . '/app/');
    define('ROOTPATH', __DIR__ . '/');
    define('FCPATH', __DIR__ . '/public/');
    define('WRITEPATH', __DIR__ . '/writable/');
    
    // Load basic config
    $config_path = __DIR__ . '/app/Config/Database.php';
    if (file_exists($config_path)) {
        echo "<p style='color: green'><strong>✓ Database config file exists</strong></p>";
        
        // Try to read config
        include $config_path;
        echo "<p><strong>Config loaded successfully</strong></p>";
    } else {
        echo "<p style='color: red'><strong>✗ Database config file missing</strong></p>";
    }
} catch (Exception $e) {
    echo "<p style='color: orange'><strong>⚠ Could not load database config:</strong> " . $e->getMessage() . "</p>";
}

// 4. Cek Routes
echo "<h2>4. Routes Configuration</h2>";
$routes_file = __DIR__ . '/app/Config/Routes.php';
if (file_exists($routes_file)) {
    $content = file_get_contents($routes_file);
    if (strpos($content, "get('/', 'Auth::login')") !== false) {
        echo "<p style='color: green'><strong>✓ Root route configured to Auth::login</strong></p>";
    } else {
        echo "<p style='color: red'><strong>✗ Root route not configured properly</strong></p>";
    }
    
    if (strpos($content, "get('login', 'Auth::login')") !== false) {
        echo "<p style='color: green'><strong>✓ Login route configured</strong></p>";
    } else {
        echo "<p style='color: red'><strong>✗ Login route missing</strong></p>";
    }
    
    if (strpos($content, "safe-space") !== false) {
        echo "<p style='color: green'><strong>✓ Safe Space routes configured</strong></p>";
    } else {
        echo "<p style='color: red'><strong>✗ Safe Space routes missing</strong></p>";
    }
} else {
    echo "<p style='color: red'><strong>✗ Routes file missing</strong></p>";
}

// 5. Panduan Menjalankan
echo "<h2>5. Cara Menjalankan Aplikasi</h2>";
echo "<ol>";
echo "<li>Buka terminal/command prompt</li>";
echo "<li>Navigasi ke folder: <code>cd " . __DIR__ . "</code></li>";
echo "<li>Jalankan salah satu perintah:</li>";
echo "<ul>";
echo "<li><code>php spark serve</code> (port 8080)</li>";
echo "<li><code>php spark serve --port=9000</code> (port 9000)</li>";
echo "<li><code>php spark serve --port=8082</code> (port 8082)</li>";
echo "</ul>";
echo "<li>Buka browser dan akses URL yang muncul</li>";
echo "</ol>";

// 6. Sample Login
echo "<h2>6. Sample Login untuk Testing</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Username</th><th>Password</th><th>Nama</th></tr>";
echo "<tr><td>ahmad.budi</td><td>123456</td><td>Ahmad Budi</td></tr>";
echo "<tr><td>siti.aisyah</td><td>123456</td><td>Siti Aisyah</td></tr>";
echo "<tr><td>rudi.santoso</td><td>123456</td><td>Rudi Santoso</td></tr>";
echo "<tr><td>maya.sari</td><td>123456</td><td>Maya Sari</td></tr>";
echo "<tr><td>doni.pratama</td><td>123456</td><td>Doni Pratama</td></tr>";
echo "</table>";

// 7. Expected URLs
echo "<h2>7. URL yang Harus Dapat Diakses</h2>";
echo "<ul>";
echo "<li><strong>Root/Home:</strong> http://localhost:[PORT]/ → Halaman Login</li>";
echo "<li><strong>Login:</strong> http://localhost:[PORT]/login → Halaman Login</li>";
echo "<li><strong>Dashboard:</strong> http://localhost:[PORT]/dashboard → Dashboard Murid (setelah login)</li>";
echo "<li><strong>Safe Space:</strong> http://localhost:[PORT]/safe-space/dashboard → Safe Space Dashboard</li>";
echo "</ul>";

// 8. Troubleshooting
echo "<h2>8. Troubleshooting</h2>";
echo "<div style='background: #f5f5f5; padding: 15px; border-radius: 5px;'>";
echo "<h3>Jika muncul halaman Welcome CodeIgniter:</h3>";
echo "<ul>";
echo "<li>Pastikan Anda menjalankan dari folder app-murid yang benar</li>";
echo "<li>Coba hapus cache: <code>php spark cache:clear</code></li>";
echo "<li>Periksa file .htaccess di folder public/</li>";
echo "<li>Pastikan mod_rewrite Apache aktif</li>";
echo "</ul>";

echo "<h3>Jika error 404:</h3>";
echo "<ul>";
echo "<li>Periksa Routes.php sudah benar</li>";
echo "<li>Pastikan Auth controller ada</li>";
echo "<li>Coba akses langsung: /login</li>";
echo "</ul>";

echo "<h3>Jika error database:</h3>";
echo "<ul>";
echo "<li>Pastikan XAMPP MySQL running</li>";
echo "<li>Cek Database.php configuration</li>";
echo "<li>Pastikan tabel murid ada dan berisi data</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<p><em>Generated: " . date('Y-m-d H:i:s') . "</em></p>";
?>
