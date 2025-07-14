<?php

namespace App\Controllers;

use App\Models\MuridModel;
use CodeIgniter\Controller;

class TestPenggunaMuridSimple extends BaseController
{
    public function index()
    {
        echo "<h2>Test: Pengguna Murid Controller</h2>";
        
        try {
            // Test database connection
            $muridModel = new MuridModel();
            $count = $muridModel->countAllResults();
            echo "✅ Database connection: OK<br>";
            echo "✅ Murid table accessible: $count records<br>";
            
            // Test models
            try {
                $settingsModel = new \App\Models\SettingsModel();
                $activeYear = $settingsModel->getActiveSchoolYearId();
                echo "✅ SettingsModel: OK (Active year: $activeYear)<br>";
            } catch (\Exception $e) {
                echo "❌ SettingsModel error: " . $e->getMessage() . "<br>";
            }
            
            try {
                $muridKelasModel = new \App\Models\MuridKelasModel();
                echo "✅ MuridKelasModel: OK<br>";
            } catch (\Exception $e) {
                echo "❌ MuridKelasModel error: " . $e->getMessage() . "<br>";
            }
            
            try {
                $kelasMasterModel = new \App\Models\KelasMasterModel();
                echo "✅ KelasMasterModel: OK<br>";
            } catch (\Exception $e) {
                echo "❌ KelasMasterModel error: " . $e->getMessage() . "<br>";
            }
            
            echo "<br><a href='/pengguna-murid'>Try Pengguna Murid</a>";
            
        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage();
        }
    }
    
    public function simple()
    {
        // Very simple test
        echo "<h2>Simple Pengguna Murid Test</h2>";
        echo "✅ Controller accessible<br>";
        
        return view('pengguna_murid/index', [
            'title' => 'Test Pengguna Murid',
            'kelas' => [],
            'tahun_ajaran' => [],
            'stats' => [
                'total' => 0,
                'laki_laki' => 0,
                'perempuan' => 0,
                'sudah_kelas' => 0,
                'belum_kelas' => 0
            ],
            'active_school_year_id' => 1
        ]);
    }
}
