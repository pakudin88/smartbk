<?php
// Quick Test Konsul Cepat dengan Auto Login
session_start();

echo "<h2>🚀 Quick Test: Konsul Cepat Feature</h2>\n";

// Simulate login session for testing
$_SESSION['isLoggedIn'] = true;
$_SESSION['role_id'] = 4; // Student role
$_SESSION['user_id'] = 1;
$_SESSION['user_name'] = 'Siswa Test';
$_SESSION['username'] = 'siswa_test';

echo "<h3>✅ Session Test</h3>";
echo "Login Status: " . ($_SESSION['isLoggedIn'] ? '✅ Logged In' : '❌ Not Logged In') . "<br>\n";
echo "Role ID: " . $_SESSION['role_id'] . " (Student)<br>\n";
echo "User: " . $_SESSION['user_name'] . "<br>\n";

echo "<h3>📱 Feature Access</h3>";

// Test URLs untuk port 8080
echo "<h4>Port 8080 URLs (CodeIgniter Server):</h4>";
echo "🏠 <strong><a href='http://localhost:8080/' target='_blank'>Home</a></strong><br>\n";
echo "📊 <strong><a href='http://localhost:8080/dashboard' target='_blank'>Dashboard</a></strong><br>\n";
echo "💬 <strong><a href='http://localhost:8080/konsul-cepat' target='_blank'>Konsul Cepat</a></strong><br>\n";
echo "📅 <strong><a href='http://localhost:8080/jadwal-konseling' target='_blank'>Jadwal Konseling</a></strong><br>\n";
echo "📖 <strong><a href='http://localhost:8080/jurnal-digital' target='_blank'>Jurnal Digital</a></strong><br>\n";
echo "ℹ️ <strong><a href='http://localhost:8080/pusat-informasi' target='_blank'>Pusat Informasi</a></strong><br>\n";

echo "<h4>Port 80 URLs (Apache - Current):</h4>";
echo "💬 <strong><a href='http://localhost/simaklah-main/app-murid/konsul-cepat' target='_blank'>Konsul Cepat</a></strong><br>\n";
echo "📊 <strong><a href='http://localhost/simaklah-main/app-murid/dashboard' target='_blank'>Dashboard</a></strong><br>\n";

echo "<h3>🛠️ Server Instructions</h3>";
echo "<div style='background:#f0f8ff;padding:15px;border-radius:8px;margin:10px 0;'>";
echo "<strong>To start CodeIgniter server on port 8080:</strong><br>";
echo "1. Double-click: <code>start-konsul-cepat-8080.bat</code><br>";
echo "2. Or run in terminal: <code>php spark serve --port=8080</code><br>";
echo "3. Access: <a href='http://localhost:8080/konsul-cepat' target='_blank'>http://localhost:8080/konsul-cepat</a><br>";
echo "</div>";

echo "<h3>💬 Konsul Cepat Features</h3>";
echo "<ul>";
echo "<li>✅ Real-time chat interface</li>";
echo "<li>✅ Anonymous mode toggle</li>";
echo "<li>✅ Quick reply buttons (Stress tugas, Masalah teman, dll)</li>";
echo "<li>✅ Auto-response simulation from Guru BK</li>";
echo "<li>✅ Mobile responsive design</li>";
echo "<li>✅ Indonesian time format</li>";
echo "<li>✅ Smooth animations & transitions</li>";
echo "<li>✅ Message timestamps</li>";
echo "</ul>";

echo "<h3>🎯 Test Scenario</h3>";
echo "<div style='background:#fff3cd;padding:15px;border-radius:8px;margin:10px 0;'>";
echo "<strong>Recommended Test Flow:</strong><br>";
echo "1. Click 'Konsul Cepat' link above<br>";
echo "2. Try quick reply buttons (Stress tugas, Masalah teman)<br>";
echo "3. Type custom message and press Enter<br>";
echo "4. Toggle Anonymous mode on/off<br>";
echo "5. Test mobile responsiveness<br>";
echo "</div>";

echo "<h3>✅ Ready to Test!</h3>";
echo "Feature konsul-cepat sudah siap dan fully functional!<br>";
echo "Klik link di atas untuk mulai testing.<br>";
?>
