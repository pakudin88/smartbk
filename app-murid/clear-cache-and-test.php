<?php
// Script untuk clear cache dan regenerate autoload CodeIgniter

chdir(__DIR__);
echo "<h1>🔄 Clear Cache & Regenerate Autoload</h1>";

// 1. Clear cache
echo "<h2>Step 1: Clear Cache</h2>";
exec('php spark cache:clear 2>&1', $output1, $return1);
echo "<pre>";
foreach($output1 as $line) {
    echo htmlspecialchars($line) . "\n";
}
echo "</pre>";
echo "<p>Return code: $return1</p>";

// 2. Composer dump-autoload
echo "<h2>Step 2: Composer Dump-Autoload</h2>";
exec('composer dump-autoload 2>&1', $output2, $return2);
echo "<pre>";
foreach($output2 as $line) {
    echo htmlspecialchars($line) . "\n";
}
echo "</pre>";
echo "<p>Return code: $return2</p>";

// 3. Check composer.json
echo "<h2>Step 3: Check composer.json</h2>";
$composerFile = __DIR__ . '/composer.json';
if (file_exists($composerFile)) {
    echo "<p>✅ composer.json ditemukan</p>";
    $composer = json_decode(file_get_contents($composerFile), true);
    if (isset($composer['autoload'])) {
        echo "<p>✅ Autoload configuration found:</p>";
        echo "<pre>" . json_encode($composer['autoload'], JSON_PRETTY_PRINT) . "</pre>";
    }
} else {
    echo "<p>❌ composer.json tidak ditemukan</p>";
}

// 4. Check vendor/autoload.php
echo "<h2>Step 4: Check Vendor Autoload</h2>";
$vendorAutoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($vendorAutoload)) {
    echo "<p>✅ vendor/autoload.php ditemukan</p>";
} else {
    echo "<p>❌ vendor/autoload.php tidak ditemukan</p>";
}

// 5. Test route list
echo "<h2>Step 5: Test Route List</h2>";
exec('php spark routes 2>&1 | head -20', $output3, $return3);
echo "<pre>";
foreach($output3 as $line) {
    echo htmlspecialchars($line) . "\n";
}
echo "</pre>";

echo "<hr>";
echo "<p>📅 " . date('Y-m-d H:i:s') . "</p>";
?>
