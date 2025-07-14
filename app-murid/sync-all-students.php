<?php

// Create murid profiles for all existing students
$host = 'srv1412.hstgr.io';
$username = 'u809035070_simaklah';
$password = 'Simaklah88#';
$database = 'u809035070_simaklah';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Creating murid profiles for all students...\n";
    
    // Get all students that don't have murid profiles yet
    $stmt = $pdo->query("
        SELECT u.id, u.username, u.full_name, u.email 
        FROM users u 
        LEFT JOIN app_murid m ON u.id = m.user_id 
        WHERE u.role_id = 4 AND u.is_active = 1 AND m.user_id IS NULL
    ");
    
    $studentsWithoutProfiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($studentsWithoutProfiles)) {
        echo "✅ All students already have murid profiles!\n";
    } else {
        echo "Found " . count($studentsWithoutProfiles) . " students without profiles.\n";
        
        // Get active tahun ajaran
        $stmt = $pdo->query("SELECT id FROM tahun_ajaran WHERE is_active = 1 LIMIT 1");
        $tahunAjaran = $stmt->fetch(PDO::FETCH_ASSOC);
        $tahunAjaranId = $tahunAjaran['id'] ?? 1;
        
        // Get available kelas
        $stmt = $pdo->query("SELECT id FROM kelas ORDER BY id");
        $kelasIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        foreach ($studentsWithoutProfiles as $index => $student) {
            $kelasId = !empty($kelasIds) ? $kelasIds[$index % count($kelasIds)] : null;
            $nisn = '000' . str_pad($student['id'], 7, '0', STR_PAD_LEFT);
            $nis = str_pad($student['id'], 5, '0', STR_PAD_LEFT);
            
            $stmt = $pdo->prepare("
                INSERT INTO app_murid (
                    user_id, nisn, nis, nama_lengkap, jenis_kelamin, 
                    email, kelas_id, tahun_ajaran_id, status
                ) VALUES (
                    :user_id, :nisn, :nis, :nama_lengkap, 'L', 
                    :email, :kelas_id, :tahun_ajaran_id, 'aktif'
                )
            ");
            
            try {
                $stmt->execute([
                    'user_id' => $student['id'],
                    'nisn' => $nisn,
                    'nis' => $nis,
                    'nama_lengkap' => $student['full_name'],
                    'email' => $student['email'],
                    'kelas_id' => $kelasId,
                    'tahun_ajaran_id' => $tahunAjaranId
                ]);
                
                echo "✅ Created profile for: {$student['username']} - {$student['full_name']}\n";
            } catch (PDOException $e) {
                echo "❌ Failed for {$student['username']}: {$e->getMessage()}\n";
            }
        }
    }
    
    // Final verification
    $stmt = $pdo->query("
        SELECT COUNT(*) as total_users FROM users WHERE role_id = 4 AND is_active = 1
    ");
    $totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];
    
    $stmt = $pdo->query("
        SELECT COUNT(*) as total_profiles FROM app_murid
    ");
    $totalProfiles = $stmt->fetch(PDO::FETCH_ASSOC)['total_profiles'];
    
    echo "\n=== FINAL STATUS ===\n";
    echo "Total active students: $totalUsers\n";
    echo "Total murid profiles: $totalProfiles\n";
    
    if ($totalUsers == $totalProfiles) {
        echo "✅ All students now have murid profiles!\n";
    } else {
        echo "⚠️ There are still " . ($totalUsers - $totalProfiles) . " students without profiles.\n";
    }
    
    // Test query to verify everything works
    echo "\n=== TEST QUERY ===\n";
    $stmt = $pdo->query("
        SELECT u.username, u.full_name, m.nisn, m.nis, k.nama_kelas, ta.nama_tahun_ajaran
        FROM users u
        JOIN app_murid m ON u.id = m.user_id
        LEFT JOIN kelas k ON m.kelas_id = k.id
        LEFT JOIN tahun_ajaran ta ON m.tahun_ajaran_id = ta.id
        WHERE u.role_id = 4 AND u.is_active = 1
        LIMIT 5
    ");
    
    echo "Sample joined data:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['username']}: {$row['full_name']} (NISN: {$row['nisn']}, Kelas: {$row['nama_kelas']})\n";
    }
    
    echo "\n✅ Database is now ready for app-murid!\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

?>
