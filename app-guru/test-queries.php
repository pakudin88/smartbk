<?php
/**
 * Simple test script untuk test query database
 */

// Database configuration
$db_config = [
    'hostname' => 'srv1412.hstgr.io',
    'username' => 'u809035070_simaklah',
    'password' => 'Simaklah88#',
    'database' => 'u809035070_simaklah',
    'port'     => 3306,
];

try {
    $dsn = "mysql:host={$db_config['hostname']};port={$db_config['port']};dbname={$db_config['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $db_config['username'], $db_config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== Testing Fixed Queries ===\n";
    
    $tahun_ajaran_id = 1;
    
    // Test siswa count
    echo "\n1. Testing siswa count...\n";
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM users WHERE role_id = 3 AND is_active = 1 AND tahun_ajaran_id = ?");
    $stmt->execute([$tahun_ajaran_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Total siswa: " . ($result['total'] ?? 0) . "\n";
    
    // Test kelas count
    echo "\n2. Testing kelas count...\n";
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM kelas WHERE tahun_ajaran_id = ? AND status = 'aktif'");
    $stmt->execute([$tahun_ajaran_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Total kelas: " . ($result['total'] ?? 0) . "\n";
    
    // Test orang tua count
    echo "\n3. Testing orang tua count...\n";
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM users WHERE role_id = 4 AND is_active = 1");
    $stmt->execute([]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Total orang tua: " . ($result['total'] ?? 0) . "\n";
    
    // Test role determination
    echo "\n4. Testing role determination...\n";
    $stmt = $pdo->prepare("SELECT * FROM users WHERE role_id = 2 AND is_active = 1 LIMIT 1");
    $stmt->execute([]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "✅ Found sample guru: {$user['username']}\n";
        
        // Check wali kelas based on kelas_id
        $isWaliKelas = !empty($user['kelas_id']);
        echo "- Wali Kelas: " . ($isWaliKelas ? "Yes (kelas_id: {$user['kelas_id']})" : "No") . "\n";
        
        // Check BK teacher
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM mata_pelajaran mp 
                              JOIN guru_mata_pelajaran gmp ON mp.id = gmp.mata_pelajaran_id 
                              WHERE gmp.user_id = ? AND (mp.nama LIKE '%BK%' OR mp.nama LIKE '%Konseling%')");
        $stmt->execute([$user['id']]);
        $bkResult = $stmt->fetch(PDO::FETCH_ASSOC);
        $isBK = $bkResult['count'] > 0;
        echo "- BK Teacher: " . ($isBK ? "Yes" : "No") . "\n";
        
        // Determine role
        if ($isBK) {
            $role = 'guru_bk';
        } elseif ($isWaliKelas) {
            $role = 'wali_kelas';
        } else {
            $role = 'guru_mapel';
        }
        echo "- Final Role: $role\n";
        
    } else {
        echo "❌ No guru users found\n";
    }
    
    echo "\n🎉 All queries executed successfully without errors!\n";
    echo "The 'wali_kelas_id' error should now be resolved.\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
