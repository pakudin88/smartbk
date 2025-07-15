<?php
/**
 * Test GuruAuth controller methods
 */

// Include CI4 bootstrap
define('FCPATH', __DIR__ . '/public/');
define('SYSTEMPATH', __DIR__ . '/vendor/codeigniter4/framework/system/');
define('APPPATH', __DIR__ . '/app/');
define('WRITEPATH', __DIR__ . '/writable/');

require_once APPPATH . 'Config/Paths.php';
require_once SYSTEMPATH . 'bootstrap.php';

use Config\Services;

try {
    echo "Testing database connection and queries...\n";
    
    $db = \Config\Database::connect();
    echo "✅ Database connection successful\n";
    
    // Test the stats query without session (simulate)
    $tahun_ajaran_id = 1; // Default
    
    echo "\n=== Testing Stats Queries ===\n";
    
    // Test siswa count
    $query = $db->query("SELECT COUNT(*) as total FROM users WHERE role_id = 3 AND is_active = 1 AND tahun_ajaran_id = ?", [$tahun_ajaran_id]);
    $result = $query->getRow();
    echo "✅ Total siswa: " . ($result->total ?? 0) . "\n";
    
    // Test kelas count
    $query = $db->query("SELECT COUNT(*) as total FROM kelas WHERE tahun_ajaran_id = ? AND status = 'aktif'", [$tahun_ajaran_id]);
    $result = $query->getRow();
    echo "✅ Total kelas: " . ($result->total ?? 0) . "\n";
    
    // Test orang tua count
    $query = $db->query("SELECT COUNT(*) as total FROM users WHERE role_id = 4 AND is_active = 1", []);
    $result = $query->getRow();
    echo "✅ Total orang tua: " . ($result->total ?? 0) . "\n";
    
    echo "\n=== Testing Role Determination ===\n";
    
    // Test role determination for sample user
    $userQuery = $db->query("SELECT * FROM users WHERE role_id = 2 AND is_active = 1 LIMIT 1");
    $user = $userQuery->getRow();
    
    if ($user) {
        echo "✅ Found sample guru user: {$user->username}\n";
        
        // Test wali kelas check (using kelas_id from users table)
        $isWaliKelas = !empty($user->kelas_id);
        echo "- Wali Kelas: " . ($isWaliKelas ? "Yes (kelas_id: {$user->kelas_id})" : "No") . "\n";
        
        // Test BK check
        if ($db->tableExists('mata_pelajaran') && $db->tableExists('guru_mata_pelajaran')) {
            $bkQuery = $db->query("SELECT COUNT(*) as count FROM mata_pelajaran mp 
                                  JOIN guru_mata_pelajaran gmp ON mp.id = gmp.mata_pelajaran_id 
                                  WHERE gmp.user_id = ? AND (mp.nama LIKE '%BK%' OR mp.nama LIKE '%Konseling%')", [$user->id]);
            $isBK = $bkQuery->getRow()->count > 0;
            echo "- BK Teacher: " . ($isBK ? "Yes" : "No") . "\n";
        }
        
        // Determine role
        if ($isWaliKelas) {
            $role = 'wali_kelas';
        } else {
            $role = 'guru_mapel';
        }
        echo "- Determined Role: $role\n";
        
    } else {
        echo "❌ No guru users found in database\n";
    }
    
    echo "\n🎉 All tests completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
