<?php
// Test script to verify Safe Space routes are working
echo "<h2>Safe Space Routes Test</h2>";

$routes = [
    'http://localhost:9000/safe-space/konsul-cepat' => 'Konsul Cepat & Anonim',
    'http://localhost:9000/safe-space/jadwal-konseling' => 'Jadwal Konseling',
    'http://localhost:9000/safe-space/jurnal-digital' => 'Jurnal Digital',
    'http://localhost:9000/safe-space/pusat-informasi' => 'Pusat Informasi'
];

foreach ($routes as $url => $description) {
    echo "<div style='margin: 10px 0;'>";
    echo "<strong>$description:</strong> ";
    echo "<a href='$url' target='_blank'>$url</a>";
    echo "</div>";
}

echo "<br><p><strong>Instructions:</strong></p>";
echo "<ol>";
echo "<li>Make sure your web server is running on port 9000</li>";
echo "<li>Click each link above to test the routes</li>";
echo "<li>If you get 404 errors, check the SafeSpaceController and Routes configuration</li>";
echo "</ol>";

echo "<br><p><strong>Controller Status:</strong></p>";
$controllerPath = __DIR__ . '/app/Controllers/SafeSpaceController.php';
if (file_exists($controllerPath)) {
    echo "✅ SafeSpaceController.php exists<br>";
    $content = file_get_contents($controllerPath);
    if (strpos($content, 'class SafeSpaceController') !== false) {
        echo "✅ SafeSpaceController class found<br>";
    } else {
        echo "❌ SafeSpaceController class not found<br>";
    }
} else {
    echo "❌ SafeSpaceController.php not found<br>";
}

echo "<br><p><strong>Views Status:</strong></p>";
$views = ['konsul_cepat', 'jadwal_konseling', 'jurnal_digital', 'pusat_informasi'];
foreach ($views as $view) {
    $viewPath = __DIR__ . "/app/Views/safe_space/{$view}.php";
    if (file_exists($viewPath)) {
        echo "✅ {$view}.php exists<br>";
    } else {
        echo "❌ {$view}.php not found<br>";
    }
}
?>
