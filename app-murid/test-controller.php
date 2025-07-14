<?php
// Simple test to check if SafeSpaceController is working
require_once __DIR__ . '/app/Controllers/SafeSpaceController.php';

use App\Controllers\SafeSpaceController;

echo "<h2>SafeSpaceController Test</h2>";

try {
    // Test if class exists
    if (class_exists('App\Controllers\SafeSpaceController')) {
        echo "✅ SafeSpaceController class exists<br>";
        
        // Test if method exists
        if (method_exists('App\Controllers\SafeSpaceController', 'konsulCepat')) {
            echo "✅ konsulCepat method exists<br>";
        } else {
            echo "❌ konsulCepat method NOT found<br>";
        }
        
        if (method_exists('App\Controllers\SafeSpaceController', 'jadwalKonseling')) {
            echo "✅ jadwalKonseling method exists<br>";
        } else {
            echo "❌ jadwalKonseling method NOT found<br>";
        }
        
        if (method_exists('App\Controllers\SafeSpaceController', 'jurnalDigital')) {
            echo "✅ jurnalDigital method exists<br>";
        } else {
            echo "❌ jurnalDigital method NOT found<br>";
        }
        
        if (method_exists('App\Controllers\SafeSpaceController', 'pusatInformasi')) {
            echo "✅ pusatInformasi method exists<br>";
        } else {
            echo "❌ pusatInformasi method NOT found<br>";
        }
        
    } else {
        echo "❌ SafeSpaceController class NOT found<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br><strong>Test URLs:</strong><br>";
echo "<a href='http://localhost:9000/safe-space/konsul-cepat' target='_blank'>Test Konsul Cepat</a><br>";
echo "<a href='http://localhost:9000/safe-space/jadwal-konseling' target='_blank'>Test Jadwal Konseling</a><br>";
echo "<a href='http://localhost:9000/safe-space/jurnal-digital' target='_blank'>Test Jurnal Digital</a><br>";
echo "<a href='http://localhost:9000/safe-space/pusat-informasi' target='_blank'>Test Pusat Informasi</a><br>";
?>
