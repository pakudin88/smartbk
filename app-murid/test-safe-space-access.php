<?php
echo "<h1>🔍 Test Akses Safe Space</h1>";

// Test 1: Basic PHP
echo "<h2>✅ Test 1: PHP berjalan dengan baik</h2>";

// Test 2: Check if we can access the app directory
$appPath = __DIR__ . '/app';
if (is_dir($appPath)) {
    echo "<h2>✅ Test 2: Direktori app ditemukan</h2>";
} else {
    echo "<h2>❌ Test 2: Direktori app tidak ditemukan</h2>";
}

// Test 3: Check SafeSpaceController file
$controllerPath = __DIR__ . '/app/Controllers/SafeSpaceController.php';
if (file_exists($controllerPath)) {
    echo "<h2>✅ Test 3: SafeSpaceController.php ditemukan</h2>";
    echo "<p>Ukuran file: " . filesize($controllerPath) . " bytes</p>";
} else {
    echo "<h2>❌ Test 3: SafeSpaceController.php tidak ditemukan</h2>";
}

// Test 4: Check Routes.php
$routesPath = __DIR__ . '/app/Config/Routes.php';
if (file_exists($routesPath)) {
    echo "<h2>✅ Test 4: Routes.php ditemukan</h2>";
    $content = file_get_contents($routesPath);
    if (strpos($content, 'safe-space') !== false) {
        echo "<p>✅ Route safe-space ditemukan dalam konfigurasi</p>";
    } else {
        echo "<p>❌ Route safe-space tidak ditemukan dalam konfigurasi</p>";
    }
} else {
    echo "<h2>❌ Test 4: Routes.php tidak ditemukan</h2>";
}

// Test 5: Check App.php baseURL
$appConfigPath = __DIR__ . '/app/Config/App.php';
if (file_exists($appConfigPath)) {
    echo "<h2>✅ Test 5: App.php ditemukan</h2>";
    $content = file_get_contents($appConfigPath);
    if (strpos($content, 'baseURL') !== false) {
        preg_match("/baseURL\s*=\s*['\"]([^'\"]*)['\"];/", $content, $matches);
        if (!empty($matches[1])) {
            echo "<p>Base URL saat ini: <strong>" . $matches[1] . "</strong></p>";
        }
    }
} else {
    echo "<h2>❌ Test 5: App.php tidak ditemukan</h2>";
}

// Test 6: Direct access URLs
echo "<h2>🔗 Test 6: URL untuk testing</h2>";
echo "<p><strong>Untuk XAMPP Apache (tanpa port):</strong></p>";
echo "<ul>";
echo "<li><a href='http://localhost/simaklah-main/app-murid/public/safe-space/konsul-cepat' target='_blank'>Konsul Cepat</a></li>";
echo "<li><a href='http://localhost/simaklah-main/app-murid/public/safe-space/jadwal-konseling' target='_blank'>Jadwal Konseling</a></li>";
echo "<li><a href='http://localhost/simaklah-main/app-murid/public/safe-space/jurnal-digital' target='_blank'>Jurnal Digital</a></li>";
echo "<li><a href='http://localhost/simaklah-main/app-murid/public/safe-space/pusat-informasi' target='_blank'>Pusat Informasi</a></li>";
echo "</ul>";

echo "<p><strong>Untuk php spark serve (port 8080):</strong></p>";
echo "<ul>";
echo "<li><a href='http://localhost:8080/safe-space/konsul-cepat' target='_blank'>Konsul Cepat</a></li>";
echo "<li><a href='http://localhost:8080/safe-space/jadwal-konseling' target='_blank'>Jadwal Konseling</a></li>";
echo "<li><a href='http://localhost:8080/safe-space/jurnal-digital' target='_blank'>Jurnal Digital</a></li>";
echo "<li><a href='http://localhost:8080/safe-space/pusat-informasi' target='_blank'>Pusat Informasi</a></li>";
echo "</ul>";

echo "<p><strong>Direct routes (bypass group):</strong></p>";
echo "<ul>";
echo "<li><a href='http://localhost/simaklah-main/app-murid/public/direct-konsul-cepat' target='_blank'>Direct Konsul Cepat (XAMPP)</a></li>";
echo "<li><a href='http://localhost:8080/direct-konsul-cepat' target='_blank'>Direct Konsul Cepat (Spark)</a></li>";
echo "</ul>";

echo "<hr>";
echo "<p>📅 " . date('Y-m-d H:i:s') . "</p>";
?>
