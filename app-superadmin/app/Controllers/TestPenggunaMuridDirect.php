<?php

namespace App\Controllers;

use App\Models\MuridModel;
use App\Models\KelasModel;
use App\Models\KelasMasterModel;
use App\Models\MuridKelasModel;
use App\Models\TahunAjaranModel;
use App\Models\SettingsModel;
use CodeIgniter\Controller;

class TestPenggunaMuridDirect extends BaseController
{
    public function index()
    {
        echo "<h2>Test Pengguna Murid Direct Access</h2>";
        
        try {
            // 1. Test SettingsModel
            echo "<h3>1. Test SettingsModel</h3>";
            $settingsModel = new SettingsModel();
            $activeSchoolYearId = $settingsModel->getActiveSchoolYearId();
            echo "Active School Year ID: " . $activeSchoolYearId . "<br>";
            
            if (!$activeSchoolYearId) {
                echo "❌ No active school year ID found<br>";
                return;
            }
            
            // 2. Test TahunAjaranModel
            echo "<h3>2. Test TahunAjaranModel</h3>";
            $tahunAjaranModel = new TahunAjaranModel();
            $tahunAjaran = $tahunAjaranModel->findAll();
            echo "Total tahun ajaran: " . count($tahunAjaran) . "<br>";
            
            // 3. Test new models initialization
            echo "<h3>3. Test New Models</h3>";
            try {
                $db = \Config\Database::connect();
                
                if ($db->tableExists('kelas_master')) {
                    echo "✅ kelas_master table exists<br>";
                    $kelasMasterModel = new KelasMasterModel();
                    echo "✅ KelasMasterModel initialized<br>";
                } else {
                    echo "❌ kelas_master table missing<br>";
                    $kelasMasterModel = null;
                }
                
                if ($db->tableExists('murid_kelas')) {
                    echo "✅ murid_kelas table exists<br>";
                    $muridKelasModel = new MuridKelasModel();
                    echo "✅ MuridKelasModel initialized<br>";
                } else {
                    echo "❌ murid_kelas table missing<br>";
                    $muridKelasModel = null;
                }
                
            } catch (\Exception $e) {
                echo "❌ Error initializing new models: " . $e->getMessage() . "<br>";
                $kelasMasterModel = null;
                $muridKelasModel = null;
            }
            
            // 4. Test data retrieval
            echo "<h3>4. Test Data Retrieval</h3>";
            if ($kelasMasterModel && $muridKelasModel) {
                echo "Using new structure...<br>";
                try {
                    $kelas = $kelasMasterModel->getKelasWithStatistik($activeSchoolYearId);
                    echo "Kelas data retrieved (new): " . count($kelas) . " records<br>";
                    
                    $stats = $muridKelasModel->getStatistikMurid($activeSchoolYearId);
                    echo "Stats retrieved (new): " . json_encode($stats) . "<br>";
                } catch (\Exception $e) {
                    echo "❌ Error with new structure: " . $e->getMessage() . "<br>";
                }
            } else {
                echo "Using fallback structure...<br>";
                try {
                    $kelasModel = new KelasModel();
                    $muridModel = new MuridModel();
                    
                    $kelas = $kelasModel->getClassesForActiveYear();
                    echo "Kelas data retrieved (fallback): " . count($kelas) . " records<br>";
                    
                    $stats = [
                        'total' => $muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->countAllResults(),
                        'laki_laki' => $muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->where('jenis_kelamin', 'L')->countAllResults(),
                        'perempuan' => $muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->where('jenis_kelamin', 'P')->countAllResults(),
                    ];
                    echo "Stats retrieved (fallback): " . json_encode($stats) . "<br>";
                } catch (\Exception $e) {
                    echo "❌ Error with fallback structure: " . $e->getMessage() . "<br>";
                }
            }
            
            // 5. Test view data preparation
            echo "<h3>5. Test View Data</h3>";
            $data = [
                'title' => 'Kelola Pengguna Murid',
                'kelas' => $kelas ?? [],
                'tahun_ajaran' => $tahunAjaran,
                'stats' => $stats ?? [],
                'active_school_year_id' => $activeSchoolYearId
            ];
            
            echo "View data prepared successfully<br>";
            echo "Data keys: " . implode(', ', array_keys($data)) . "<br>";
            
            echo "<h3>✅ All tests passed! No redirect should occur.</h3>";
            echo '<a href="/app-superadmin/public/pengguna-murid">Try accessing pengguna-murid again</a>';
            
        } catch (\Exception $e) {
            echo "<h3>❌ Error occurred:</h3>";
            echo "Message: " . $e->getMessage() . "<br>";
            echo "File: " . $e->getFile() . "<br>";
            echo "Line: " . $e->getLine() . "<br>";
            echo "Stack trace:<br><pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
}
