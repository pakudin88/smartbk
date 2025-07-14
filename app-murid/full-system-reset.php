<?php
// Full System Reset and Test Script

chdir(__DIR__);
echo "<h1>🔄 Full System Reset & Test</h1>";
echo "<hr>";

// Step 1: Clear all caches
echo "<h2>Step 1: Clearing All Caches</h2>";
$commands = [
    'php spark cache:clear',
    'composer dump-autoload',
    'php spark route:clear'
];

foreach ($commands as $cmd) {
    echo "<h3>Running: $cmd</h3>";
    exec($cmd . ' 2>&1', $output, $return);
    echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
    foreach ($output as $line) {
        echo htmlspecialchars($line) . "\n";
    }
    echo "</pre>";
    echo "<p>Return code: $return</p>";
    $output = []; // Reset output array
}

// Step 2: Test file existence
echo "<hr><h2>Step 2: File Existence Check</h2>";
$files = [
    'app/Controllers/SafeSpaceController.php',
    'app/Config/Routes.php',
    'app/Config/App.php',
    'public/.htaccess',
    'public/index.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p>✅ $file exists (" . number_format(filesize($file)) . " bytes)</p>";
    } else {
        echo "<p>❌ $file missing</p>";
    }
}

// Step 3: Test routes directly
echo "<hr><h2>Step 3: Route Test</h2>";
echo "<h3>XAMPP Apache URLs (Port 80):</h3>";
$xamppBase = "http://localhost/simaklah-main/app-murid/public/";
$routes = [
    'dashboard' => 'Dashboard',
    'test-simple' => 'Test Simple Controller',
    'direct-konsul-cepat' => 'Direct Konsul Cepat',
    'safe-space/konsul-cepat' => 'Safe Space - Konsul Cepat',
    'safe-space/jadwal-konseling' => 'Safe Space - Jadwal Konseling',
    'safe-space/jurnal-digital' => 'Safe Space - Jurnal Digital',
    'safe-space/pusat-informasi' => 'Safe Space - Pusat Informasi'
];

foreach ($routes as $route => $name) {
    $url = $xamppBase . $route;
    echo "<p><a href='$url' target='_blank' style='padding: 5px 10px; background: #007bff; color: white; text-decoration: none; border-radius: 3px;'>$name</a> - <code>$url</code></p>";
}

echo "<h3>Spark Serve URLs (Port 8080):</h3>";
$sparkBase = "http://localhost:8080/";
foreach ($routes as $route => $name) {
    $url = $sparkBase . $route;
    echo "<p><a href='$url' target='_blank' style='padding: 5px 10px; background: #28a745; color: white; text-decoration: none; border-radius: 3px;'>$name</a> - <code>$url</code></p>";
}

// Step 4: Server information
echo "<hr><h2>Step 4: Server Information</h2>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Document Root:</strong> " . (isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : 'Not set') . "</p>";
echo "<p><strong>HTTP Host:</strong> " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'Not set') . "</p>";
echo "<p><strong>Request URI:</strong> " . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'Not set') . "</p>";

// Step 5: Instructions
echo "<hr><h2>Step 5: Instructions</h2>";
echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; border-left: 4px solid #28a745;'>";
echo "<h3>🚀 Untuk menggunakan XAMPP Apache:</h3>";
echo "<ol>";
echo "<li>Pastikan XAMPP Apache sudah berjalan</li>";
echo "<li>Klik link XAMPP di atas untuk test</li>";
echo "<li>Login dengan username: <strong>siswa_001</strong>, password: <strong>siswa123</strong></li>";
echo "</ol>";
echo "</div>";

echo "<div style='background: #d1ecf1; padding: 15px; border-radius: 5px; border-left: 4px solid #17a2b8; margin-top: 10px;'>";
echo "<h3>⚡ Untuk menggunakan php spark serve:</h3>";
echo "<ol>";
echo "<li>Jalankan: <code>start-and-test-server.bat</code></li>";
echo "<li>Atau manual: <code>php spark serve --host=127.0.0.1 --port=8080</code></li>";
echo "<li>Klik link Spark Serve di atas untuk test</li>";
echo "<li>Login dengan username: <strong>siswa_001</strong>, password: <strong>siswa123</strong></li>";
echo "</ol>";
echo "</div>";

echo "<hr>";
echo "<p>📅 " . date('Y-m-d H:i:s') . "</p>";
?>
