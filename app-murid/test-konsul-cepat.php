<?php
echo "<h2>Test Konsul Cepat Feature</h2>\n";

// Test 1: Check file exists
echo "<h3>1. File Structure Test</h3>";
$konsul_file = __DIR__ . '/app/Views/safe_space/konsul_cepat.php';
if (file_exists($konsul_file)) {
    echo "✅ File konsul_cepat.php exists<br>\n";
    $file_size = filesize($konsul_file);
    echo "✅ File size: " . number_format($file_size) . " bytes<br>\n";
} else {
    echo "❌ File konsul_cepat.php missing<br>\n";
}

// Test 2: Check controller
echo "<h3>2. Controller Test</h3>";
$dashboard_file = __DIR__ . '/app/Controllers/Dashboard.php';
if (file_exists($dashboard_file)) {
    $content = file_get_contents($dashboard_file);
    if (strpos($content, 'konsulCepat') !== false) {
        echo "✅ Method konsulCepat found in Dashboard controller<br>\n";
    } else {
        echo "❌ Method konsulCepat missing in Dashboard controller<br>\n";
    }
} else {
    echo "❌ Dashboard controller missing<br>\n";
}

// Test 3: Check routes
echo "<h3>3. Routes Test</h3>";
$routes_file = __DIR__ . '/app/Config/Routes.php';
if (file_exists($routes_file)) {
    $content = file_get_contents($routes_file);
    if (strpos($content, 'konsul-cepat') !== false) {
        echo "✅ Route konsul-cepat found in Routes.php<br>\n";
    } else {
        echo "❌ Route konsul-cepat missing in Routes.php<br>\n";
    }
} else {
    echo "❌ Routes.php missing<br>\n";
}

// Test 4: URLs
echo "<h3>4. Access URLs</h3>";
echo "🔗 Apache (port 80): <a href='http://localhost/simaklah-main/app-murid/konsul-cepat' target='_blank'>http://localhost/simaklah-main/app-murid/konsul-cepat</a><br>\n";
echo "🔗 CodeIgniter Server (port 8080): <a href='http://localhost:8080/konsul-cepat' target='_blank'>http://localhost:8080/konsul-cepat</a><br>\n";

// Test 5: Feature details
echo "<h3>5. Feature Details</h3>";
if (file_exists($konsul_file)) {
    $content = file_get_contents($konsul_file);
    
    if (strpos($content, 'mode-toggle') !== false) {
        echo "✅ Anonymous mode toggle available<br>\n";
    }
    
    if (strpos($content, 'sendMessage') !== false) {
        echo "✅ Chat functionality implemented<br>\n";
    }
    
    if (strpos($content, 'quick-replies') !== false) {
        echo "✅ Quick reply buttons available<br>\n";
    }
    
    if (strpos($content, 'minimal_layout') !== false) {
        echo "✅ Using minimal_layout for consistent design<br>\n";
    }
}

echo "<h3>Instructions:</h3>";
echo "1. <strong>For Apache (current):</strong> Click the port 80 link above<br>\n";
echo "2. <strong>For CodeIgniter Server:</strong> Run the batch file 'start-server-8080.bat' then click port 8080 link<br>\n";
echo "3. <strong>Login required:</strong> Use siswa_test/password123 to test<br>\n";

echo "<h3>Feature Capabilities:</h3>";
echo "• Real-time chat interface with typing simulation<br>\n";
echo "• Anonymous mode toggle for privacy<br>\n";
echo "• Quick reply buttons for common issues<br>\n";
echo "• Responsive mobile-first design<br>\n";
echo "• Indonesian time format<br>\n";
echo "• Auto-scroll chat messages<br>\n";

echo "<h3>Test Complete!</h3>";
?>
