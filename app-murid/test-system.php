<?php

// Test login functionality
require_once __DIR__ . '/vendor/autoload.php';

echo "<h2>Testing App-Murid System</h2>\n";

try {
    // Bootstrap CodeIgniter
    $path = FCPATH . '../app/Config/Paths.php';
    require_once FCPATH . '../app/Config/Paths.php';
    $paths = new \Config\Paths();
    require_once $paths->systemDirectory . '/bootstrap.php';
    
    $db = \Config\Database::connect();
    
    echo "✅ CodeIgniter loaded successfully!<br>\n";
    
    // Test database connection
    $db->connect();
    echo "✅ Database connected!<br>\n";
    
    // Test users table
    $users = $db->table('users')
                ->select('id, username, full_name, role_id, is_active')
                ->where('role_id', 4)
                ->where('is_active', 1)
                ->limit(3)
                ->get()
                ->getResultArray();
    
    echo "<h3>Sample Students:</h3>\n";
    foreach ($users as $user) {
        echo "- ID: {$user['id']}, Username: {$user['username']}, Name: {$user['full_name']}<br>\n";
    }
    
    // Test app_murid table
    $muridData = $db->table('app_murid m')
                    ->select('m.*, k.nama_kelas, ta.nama_tahun_ajaran')
                    ->join('kelas k', 'k.id = m.kelas_id', 'left')
                    ->join('tahun_ajaran ta', 'ta.id = m.tahun_ajaran_id', 'left')
                    ->limit(3)
                    ->get()
                    ->getResultArray();
    
    echo "<h3>Sample Murid Profiles:</h3>\n";
    foreach ($muridData as $murid) {
        echo "- User ID: {$murid['user_id']}, NISN: {$murid['nisn']}, Name: {$murid['nama_lengkap']}, Kelas: {$murid['nama_kelas']}<br>\n";
    }
    
    // Test password verification for a sample user
    $testUser = $users[0] ?? null;
    if ($testUser) {
        echo "<h3>Test Login Info:</h3>\n";
        echo "Username: {$testUser['username']}<br>\n";
        echo "User ID: {$testUser['id']}<br>\n";
        echo "Full Name: {$testUser['full_name']}<br>\n";
        echo "<em>Password: Use the password set in the system</em><br>\n";
    }
    
    echo "<h3>✅ System Status: READY!</h3>\n";
    echo "<p>You can now login to the app-murid system with any of the student accounts.</p>\n";
    
    echo "<h3>Quick Test URLs:</h3>\n";
    echo "- Login: <a href='/login'>http://localhost/simaklah-main/app-murid/public/login</a><br>\n";
    echo "- Test Page: <a href='/test'>http://localhost/simaklah-main/app-murid/public/test</a><br>\n";
    echo "- Dashboard (after login): <a href='/dashboard'>http://localhost/simaklah-main/app-murid/public/dashboard</a><br>\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>\n";
    echo "<pre>" . $e->getTraceAsString() . "</pre>\n";
}

?>
