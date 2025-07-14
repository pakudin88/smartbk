<?php
echo "<h2>Login Test - App Murid</h2>\n";

// Test auto-login for student
$username = "siswa_test";
$password = "password123";

echo "<h3>Testing Student Login</h3>";
echo "Username: $username<br>\n";
echo "Password: $password<br>\n";

try {
    // Connect to database
    $hostname = 'srv1412.hstgr.io';
    $db_username = 'u809035070_simaklah';
    $db_password = 'Simaklah88#';
    $database = 'u809035070_simaklah';
    
    $conn = new mysqli($hostname, $db_username, $db_password, $database);
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
    
    echo "✅ Database connected<br>\n";
    
    // Check if test student exists
    $stmt = $conn->prepare("SELECT id, username, role_id FROM users WHERE username = ? AND role_id = 4");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "✅ Student account found: ID {$user['id']}<br>\n";
        echo "✅ Role ID: {$user['role_id']} (Student)<br>\n";
        
        // Generate login link
        $login_url = "http://localhost/simaklah-main/app-murid/login";
        $dashboard_url = "http://localhost/simaklah-main/app-murid/dashboard";
        
        echo "<h3>Quick Login</h3>";
        echo "🔗 <a href='$login_url' target='_blank'>Login Page</a><br>\n";
        echo "🔗 <a href='$dashboard_url' target='_blank'>Dashboard (after login)</a><br>\n";
        
        echo "<h3>Login Instructions</h3>";
        echo "1. Click the login link above<br>\n";
        echo "2. Use username: <strong>$username</strong><br>\n";
        echo "3. Use password: <strong>$password</strong><br>\n";
        echo "4. You should be redirected to the dashboard<br>\n";
        
    } else {
        echo "❌ Student account not found. Creating test account...<br>\n";
        
        // Create test student account
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, role_id, nama, email, is_active) VALUES (?, ?, 4, ?, ?, 1)");
        $nama = "Siswa Test";
        $email = "siswa_test@example.com";
        $stmt->bind_param("ssss", $username, $hashed_password, $nama, $email);
        
        if ($stmt->execute()) {
            echo "✅ Test student account created successfully!<br>\n";
            echo "✅ Username: $username<br>\n";
            echo "✅ Password: $password<br>\n";
            echo "✅ Role: Student (ID: 4)<br>\n";
        } else {
            echo "❌ Failed to create test account<br>\n";
        }
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>\n";
}

echo "<h3>Feature Test URLs</h3>";
echo "🔗 <a href='http://localhost/simaklah-main/app-murid/konsul-cepat' target='_blank'>Konsul Cepat</a><br>\n";
echo "🔗 <a href='http://localhost/simaklah-main/app-murid/jadwal-konseling' target='_blank'>Jadwal Konseling</a><br>\n";
echo "🔗 <a href='http://localhost/simaklah-main/app-murid/jurnal-digital' target='_blank'>Jurnal Digital</a><br>\n";
echo "🔗 <a href='http://localhost/simaklah-main/app-murid/pusat-informasi' target='_blank'>Pusat Informasi</a><br>\n";

echo "<h3>Test Complete!</h3>";
echo "All systems should be working now. Use the links above to test functionality.<br>\n";
?>
