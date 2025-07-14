<?php
// Simple test file to check if public directory is accessible
echo "<h1>✅ Public Directory Test</h1>";
echo "<p>Jika Anda melihat halaman ini, berarti akses ke direktori public berhasil.</p>";
echo "<hr>";

// Test include path
echo "<h2>🔍 Path Information</h2>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Public Directory:</strong> " . realpath(__DIR__) . "</p>";

// Test if index.php exists
$indexFile = __DIR__ . '/index.php';
if (file_exists($indexFile)) {
    echo "<p>✅ index.php ditemukan di public directory</p>";
} else {
    echo "<p>❌ index.php tidak ditemukan di public directory</p>";
}

// Test .htaccess
$htaccessFile = __DIR__ . '/.htaccess';
if (file_exists($htaccessFile)) {
    echo "<p>✅ .htaccess ditemukan di public directory</p>";
} else {
    echo "<p>❌ .htaccess tidak ditemukan di public directory</p>";
}

// Test direct controller access
echo "<hr>";
echo "<h2>🔗 Test Links</h2>";
echo "<p><a href='index.php' target='_blank'>Test index.php</a></p>";
echo "<p><a href='safe-space/konsul-cepat' target='_blank'>Test safe-space/konsul-cepat</a></p>";
echo "<p><a href='direct-konsul-cepat' target='_blank'>Test direct-konsul-cepat</a></p>";

echo "<hr>";
echo "<p>📅 " . date('Y-m-d H:i:s') . "</p>";
?>
