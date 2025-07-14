<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestPengguna extends Controller
{
    public function index()
    {
        echo "<h2>Test Pengguna Controller</h2>";
        echo "This is a simple test controller<br>";
        echo "Base URL: " . base_url() . "<br>";
        echo "Current URL: " . current_url() . "<br>";
        echo "PHP Version: " . PHP_VERSION . "<br>";
        
        // Test database
        try {
            $db = \Config\Database::connect();
            $query = $db->query('SELECT COUNT(*) as count FROM petugas');
            $result = $query->getRow();
            echo "Database connection: ✅ Success<br>";
            echo "Petugas count: " . $result->count . "<br>";
        } catch (Exception $e) {
            echo "Database connection: ❌ Failed - " . $e->getMessage() . "<br>";
        }
        
        // Test models
        try {
            $petugasModel = new \App\Models\PetugasModel();
            echo "PetugasModel: ✅ Loaded<br>";
            $count = $petugasModel->countAll();
            echo "Petugas count via model: $count<br>";
        } catch (Exception $e) {
            echo "PetugasModel: ❌ Failed - " . $e->getMessage() . "<br>";
        }
        
        echo "<hr>";
        echo "<h3>Next Steps</h3>";
        echo "If this test works, the issue is in the specific controllers.<br>";
        echo "Try: <a href='" . base_url('pengguna-sekolah') . "'>Pengguna Sekolah</a><br>";
    }
}
