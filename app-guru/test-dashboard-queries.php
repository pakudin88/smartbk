<?php
require_once 'vendor/autoload.php';

// Load CodeIgniter
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

try {
    // Connect to database
    $db = \Config\Database::connect();
    echo "✓ Database connection successful\n";
    
    // Test mata_pelajaran table
    echo "\nTesting mata_pelajaran table queries:\n";
    $bkQuery = $db->query("SELECT COUNT(*) as count FROM mata_pelajaran mp 
                          WHERE mp.nama_mapel LIKE '%BK%' OR mp.nama_mapel LIKE '%Konseling%' OR mp.nama_mapel LIKE '%Bimbingan%'");
    $bkCount = $bkQuery->getRow()->count;
    echo "✓ BK subjects found: $bkCount\n";
    
    // Show sample BK subjects
    $bkSamples = $db->query("SELECT nama_mapel FROM mata_pelajaran 
                            WHERE nama_mapel LIKE '%BK%' OR nama_mapel LIKE '%Konseling%' OR nama_mapel LIKE '%Bimbingan%' 
                            LIMIT 3")->getResult();
    echo "Sample BK subjects:\n";
    foreach ($bkSamples as $subject) {
        echo "  - " . $subject->nama_mapel . "\n";
    }
    
    // Test users table
    echo "\nTesting users table:\n";
    $userCount = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'guru'")->getRow()->count;
    echo "✓ Guru users found: $userCount\n";
    
    // Test kelas table
    if ($db->tableExists('kelas')) {
        $kelasCount = $db->query("SELECT COUNT(*) as count FROM kelas")->getRow()->count;
        echo "✓ Kelas records found: $kelasCount\n";
    }
    
    // Test subjects/mata_pelajaran count
    $subjectCount = $db->query("SELECT COUNT(*) as count FROM mata_pelajaran")->getRow()->count;
    echo "✓ Total mata pelajaran: $subjectCount\n";
    
    echo "\n✅ All dashboard queries should work now!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
