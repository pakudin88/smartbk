<?php
// Create required database tables for app-ortu

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Creating Database Tables for App-Ortu\n";
echo "=====================================\n\n";

try {
    $host = 'srv1412.hstgr.io';
    $dbname = 'u809035070_simaklah';
    $username = 'u809035070_simaklah';
    $password = 'Simaklah88#';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "✓ Connected to database\n\n";
    
    // Create parent_invitations table
    $sql1 = "CREATE TABLE IF NOT EXISTS parent_invitations (
        id INT PRIMARY KEY AUTO_INCREMENT,
        student_id INT NOT NULL,
        parent_name VARCHAR(255) NOT NULL,
        parent_email VARCHAR(255) NOT NULL,
        invitation_token VARCHAR(255) UNIQUE NOT NULL,
        expires_at DATETIME NOT NULL,
        is_active TINYINT(1) DEFAULT 1,
        last_accessed DATETIME NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_token (invitation_token),
        INDEX idx_student (student_id),
        INDEX idx_active (is_active),
        INDEX idx_expires (expires_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql1);
    echo "✓ Table parent_invitations created\n";
    
    // Create parent_summaries table
    $sql2 = "CREATE TABLE IF NOT EXISTS parent_summaries (
        id INT PRIMARY KEY AUTO_INCREMENT,
        student_id INT NOT NULL,
        summary_type ENUM('academic', 'behavior', 'social', 'emotional') NOT NULL,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        recommendations TEXT,
        is_active TINYINT(1) DEFAULT 1,
        created_by INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_student (student_id),
        INDEX idx_type (summary_type),
        INDEX idx_active (is_active)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql2);
    echo "✓ Table parent_summaries created\n";
    
    // Create action_plans table
    $sql3 = "CREATE TABLE IF NOT EXISTS action_plans (
        id INT PRIMARY KEY AUTO_INCREMENT,
        student_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        target_area ENUM('home', 'school', 'both') NOT NULL,
        priority TINYINT(1) DEFAULT 1,
        target_date DATE,
        is_active TINYINT(1) DEFAULT 1,
        created_by INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_student (student_id),
        INDEX idx_target (target_area),
        INDEX idx_priority (priority),
        INDEX idx_active (is_active)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql3);
    echo "✓ Table action_plans created\n";
    
    // Create action_progress table
    $sql4 = "CREATE TABLE IF NOT EXISTS action_progress (
        id INT PRIMARY KEY AUTO_INCREMENT,
        action_plan_id INT NOT NULL,
        status ENUM('pending', 'in_progress', 'completed', 'review') DEFAULT 'pending',
        progress_percentage TINYINT DEFAULT 0,
        notes TEXT,
        updated_by VARCHAR(100),
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_plan (action_plan_id),
        INDEX idx_status (status),
        FOREIGN KEY (action_plan_id) REFERENCES action_plans(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql4);
    echo "✓ Table action_progress created\n";
    
    // Create parent_feedback table
    $sql5 = "CREATE TABLE IF NOT EXISTS parent_feedback (
        id INT PRIMARY KEY AUTO_INCREMENT,
        invitation_id INT NOT NULL,
        student_id INT NOT NULL,
        feedback_text TEXT NOT NULL,
        rating TINYINT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_invitation (invitation_id),
        INDEX idx_student (student_id),
        INDEX idx_rating (rating)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql5);
    echo "✓ Table parent_feedback created\n";
    
    echo "\n";
    
    // Insert sample data for testing
    echo "Inserting sample data...\n";
    
    // Sample invitation token for testing
    $token = 'test_' . uniqid() . '_' . date('Ymd');
    $expires = date('Y-m-d H:i:s', strtotime('+30 days'));
    
    $stmt = $pdo->prepare("INSERT INTO parent_invitations 
        (student_id, parent_name, parent_email, invitation_token, expires_at) 
        VALUES (?, ?, ?, ?, ?)");
    
    $stmt->execute([
        1, // Assuming student_id 1 exists
        'Bapak/Ibu Test',
        'parent.test@example.com',
        $token,
        $expires
    ]);
    
    echo "✓ Sample invitation created with token: $token\n";
    echo "✓ Test URL: " . "http://localhost/smartbk/app-ortu/public/?token=$token\n";
    
    // Sample summary
    $stmt2 = $pdo->prepare("INSERT INTO parent_summaries 
        (student_id, summary_type, title, content, recommendations, created_by) 
        VALUES (?, ?, ?, ?, ?, ?)");
    
    $stmt2->execute([
        1,
        'academic',
        'Progres Akademik Bulan Ini',
        'Siswa menunjukkan peningkatan yang baik dalam mata pelajaran Matematika dan IPA. Namun masih perlu perhatian khusus untuk mata pelajaran Bahasa Indonesia.',
        'Disarankan untuk memberikan dukungan tambahan dalam membaca dan menulis di rumah.',
        1
    ]);
    
    echo "✓ Sample summary created\n";
    
    // Sample action plan
    $stmt3 = $pdo->prepare("INSERT INTO action_plans 
        (student_id, title, description, target_area, priority, target_date, created_by) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    $stmt3->execute([
        1,
        'Meningkatkan Kemampuan Membaca',
        'Program membaca bersama orang tua selama 30 menit setiap hari untuk meningkatkan kemampuan literasi.',
        'home',
        1,
        date('Y-m-d', strtotime('+2 weeks')),
        1
    ]);
    
    $planId = $pdo->lastInsertId();
    
    // Sample progress
    $stmt4 = $pdo->prepare("INSERT INTO action_progress 
        (action_plan_id, status, progress_percentage, notes, updated_by) 
        VALUES (?, ?, ?, ?, ?)");
    
    $stmt4->execute([
        $planId,
        'in_progress',
        25,
        'Sudah dimulai program membaca, anak menunjukkan antusiasme yang baik',
        'Guru BK'
    ]);
    
    echo "✓ Sample action plan and progress created\n";
    
    echo "\n=== DATABASE SETUP COMPLETE ===\n";
    echo "You can now test the application!\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
