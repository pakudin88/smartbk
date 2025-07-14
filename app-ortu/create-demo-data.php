<?php
// Create demo data for app-ortu testing

echo "=== CREATING DEMO DATA FOR APP-ORTU ===\n";

try {
    $pdo = new PDO("mysql:host=srv1412.hstgr.io;dbname=u809035070_simaklah;charset=utf8", 
                   "u809035070_simaklah", "Simaklah88#", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "✓ Connected to database\n";
    
    // Create demo student if not exists
    $checkStudent = $pdo->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
    $checkStudent->execute(['demo_student']);
    $student = $checkStudent->fetch();
    
    if (!$student) {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, full_name, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            'demo_student',
            'demo.student@school.com', 
            password_hash('demo123', PASSWORD_DEFAULT),
            'Ahmad Demo Siswa',
            'student'
        ]);
        $studentId = $pdo->lastInsertId();
        echo "✓ Created demo student with ID: $studentId\n";
    } else {
        $studentId = $student['id'];
        echo "✓ Using existing demo student ID: $studentId\n";
    }
    
    // Create parent invitation with easy token
    $easyToken = 'DEMO2024ORTU';
    $expires = date('Y-m-d H:i:s', strtotime('+6 months'));
    
    // Check if token exists
    $checkToken = $pdo->prepare("SELECT id FROM parent_invitations WHERE invitation_token = ?");
    $checkToken->execute([$easyToken]);
    
    if (!$checkToken->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO parent_invitations (student_id, parent_name, parent_email, invitation_token, expires_at, is_active) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->execute([
            $studentId,
            'Bapak/Ibu Ahmad Demo',
            'demo.parent@family.com',
            $easyToken,
            $expires
        ]);
        echo "✓ Created demo invitation with token: $easyToken\n";
    } else {
        echo "✓ Demo invitation already exists\n";
    }
    
    // Create sample summaries
    $summaries = [
        [
            'type' => 'academic',
            'title' => 'Laporan Akademik Semester Ini',
            'content' => 'Ahmad menunjukkan prestasi yang konsisten dalam mata pelajaran Matematika (nilai rata-rata 85) dan IPA (nilai rata-rata 82). Namun, masih memerlukan perhatian khusus dalam mata pelajaran Bahasa Indonesia, terutama dalam kemampuan menulis karangan.',
            'recommendations' => 'Disarankan untuk: 1) Memberikan waktu membaca buku cerita 30 menit setiap hari, 2) Latihan menulis diary sederhana, 3) Diskusi tentang buku yang dibaca bersama orang tua'
        ],
        [
            'type' => 'behavior',
            'title' => 'Perkembangan Perilaku Sosial',
            'content' => 'Ahmad menunjukkan kemajuan dalam berinteraksi dengan teman sebaya. Sudah lebih berani untuk bertanya kepada guru dan aktif dalam diskusi kelompok. Namun, kadang masih terlihat malu-malu saat presentasi di depan kelas.',
            'recommendations' => 'Untuk meningkatkan kepercayaan diri: 1) Berikan apresiasi atas usaha yang dilakukan, 2) Latihan berbicara di depan keluarga, 3) Encourage untuk ikut kegiatan ekstrakurikuler'
        ],
        [
            'type' => 'emotional',
            'title' => 'Perkembangan Emosional',
            'content' => 'Ahmad menunjukkan kemampuan mengelola emosi yang semakin baik. Sudah mampu mengekspresikan perasaan dengan kata-kata daripada tindakan impulsif. Terlihat lebih tenang dalam menghadapi tantangan akademik.',
            'recommendations' => 'Untuk mendukung perkembangan emosional: 1) Terus berikan ruang untuk mengekspresikan perasaan, 2) Ajarkan teknik relaksasi sederhana, 3) Konsisten dengan rutinitas harian'
        ]
    ];
    
    foreach ($summaries as $summary) {
        $stmt = $pdo->prepare("INSERT INTO parent_summaries (student_id, summary_type, title, content, recommendations, created_by, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)");
        $stmt->execute([
            $studentId,
            $summary['type'],
            $summary['title'],
            $summary['content'],
            $summary['recommendations'],
            1 // Assumed teacher ID
        ]);
    }
    echo "✓ Created 3 sample summaries\n";
    
    // Create action plans
    $actionPlans = [
        [
            'title' => 'Program Membaca Harian',
            'description' => 'Membaca buku cerita atau artikel sederhana selama 30 menit setiap hari untuk meningkatkan kemampuan literasi dan kosakata.',
            'target_area' => 'home',
            'priority' => 1,
            'target_date' => date('Y-m-d', strtotime('+4 weeks'))
        ],
        [
            'title' => 'Latihan Presentasi Mingguan',
            'description' => 'Latihan presentasi sederhana di rumah setiap minggu untuk meningkatkan kepercayaan diri berbicara di depan umum.',
            'target_area' => 'home',
            'priority' => 2,
            'target_date' => date('Y-m-d', strtotime('+6 weeks'))
        ],
        [
            'title' => 'Kegiatan Sosial di Sekolah',
            'description' => 'Partisipasi aktif dalam kegiatan kelompok dan ekstrakurikuler untuk mengembangkan kemampuan sosial.',
            'target_area' => 'school',
            'priority' => 2,
            'target_date' => date('Y-m-d', strtotime('+8 weeks'))
        ]
    ];
    
    foreach ($actionPlans as $plan) {
        $stmt = $pdo->prepare("INSERT INTO action_plans (student_id, title, description, target_area, priority, target_date, created_by, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
        $stmt->execute([
            $studentId,
            $plan['title'],
            $plan['description'],
            $plan['target_area'],
            $plan['priority'],
            $plan['target_date'],
            1
        ]);
        
        $planId = $pdo->lastInsertId();
        
        // Add progress for each plan
        $progressData = [
            1 => ['status' => 'in_progress', 'percentage' => 60, 'notes' => 'Sudah berjalan 2 minggu, anak menunjukkan antusiasme dalam membaca'],
            2 => ['status' => 'pending', 'percentage' => 10, 'notes' => 'Baru dimulai minggu ini, perlu dorongan lebih'],
            3 => ['status' => 'in_progress', 'percentage' => 40, 'notes' => 'Sudah ikut 2 kegiatan ekstrakurikuler, terlihat lebih percaya diri']
        ];
        
        $currentProgress = $progressData[count($progressData) - (count($actionPlans) - array_search($plan, $actionPlans))] ?? $progressData[1];
        
        $stmt2 = $pdo->prepare("INSERT INTO action_progress (action_plan_id, status, progress_percentage, notes, updated_by) VALUES (?, ?, ?, ?, ?)");
        $stmt2->execute([
            $planId,
            $currentProgress['status'],
            $currentProgress['percentage'], 
            $currentProgress['notes'],
            'Guru BK'
        ]);
    }
    echo "✓ Created 3 action plans with progress\n";
    
    // Create sample feedback
    $stmt = $pdo->prepare("INSERT INTO parent_feedback (invitation_id, student_id, feedback_text, rating, created_at) VALUES ((SELECT id FROM parent_invitations WHERE invitation_token = ?), ?, ?, ?, NOW())");
    $stmt->execute([
        $easyToken,
        $studentId,
        'Terima kasih atas laporan yang sangat detail. Kami di rumah sudah mulai menerapkan program membaca harian dan Ahmad terlihat sangat antusias. Kami berharap kerjasama ini bisa terus berlanjut untuk mendukung perkembangan Ahmad.',
        5
    ]);
    echo "✓ Created sample feedback\n";
    
    echo "\n=== DEMO DATA CREATED SUCCESSFULLY ===\n";
    echo "You can now test the application with:\n";
    echo "Demo URL: http://localhost/smartbk/app-ortu/public/?token=$easyToken\n";
    echo "Parent Name: Bapak/Ibu Ahmad Demo\n";
    echo "Student: Ahmad Demo Siswa\n";
    echo "\nThe demo includes:\n";
    echo "- 3 Academic/Behavioral summaries\n";
    echo "- 3 Action plans with progress tracking\n";
    echo "- Sample parent feedback\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
