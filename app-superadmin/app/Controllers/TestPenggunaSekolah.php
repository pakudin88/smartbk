<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestPenggunaSekolah extends Controller
{
    public function index()
    {
        // Bypass auth untuk testing
        echo "<h2>Test Pengguna Sekolah (No Auth)</h2>";
        
        try {
            // Test model loading
            $petugasModel = new \App\Models\PetugasModel();
            echo "✅ PetugasModel loaded successfully<br>";
            
            // Test database connection
            $petugas = $petugasModel->findAll();
            echo "✅ Database connection successful<br>";
            echo "✅ Found " . count($petugas) . " petugas records<br>";
            
            // Test roles
            $roleModel = new \App\Models\RoleModel();
            $roles = $roleModel->findAll();
            echo "✅ Found " . count($roles) . " roles<br>";
            
            // Test stats
            $stats = [
                'super_admin' => $petugasModel->where('role_id', 1)->countAllResults(),
                'kepala_sekolah' => $petugasModel->where('role_id', 7)->countAllResults(),
                'guru' => $petugasModel->whereIn('role_id', [2, 3, 16])->countAllResults(),
                'staff' => $petugasModel->where('role_id', 6)->countAllResults()
            ];
            echo "✅ Stats calculated successfully<br>";
            
            // Test view loading
            $data = [
                'title' => 'Test Pengguna Sekolah',
                'petugas' => $petugas,
                'roles' => $roles,
                'stats' => $stats
            ];
            
            echo "✅ All data prepared successfully<br>";
            echo "<hr>";
            echo "<h3>Data Preview</h3>";
            echo "<strong>Stats:</strong><br>";
            echo "Super Admin: " . $stats['super_admin'] . "<br>";
            echo "Kepala Sekolah: " . $stats['kepala_sekolah'] . "<br>";
            echo "Guru: " . $stats['guru'] . "<br>";
            echo "Staff: " . $stats['staff'] . "<br>";
            
            echo "<strong>Roles:</strong><br>";
            foreach ($roles as $role) {
                echo "- " . $role['role_name'] . "<br>";
            }
            
            echo "<strong>Sample Petugas:</strong><br>";
            $samplePetugas = array_slice($petugas, 0, 3);
            foreach ($samplePetugas as $p) {
                echo "- " . $p['nama_lengkap'] . " (" . $p['username'] . ")<br>";
            }
            
            echo "<hr>";
            echo "<h3>Next Steps</h3>";
            echo "If this works, the main controller should work too after fixing auth.<br>";
            echo "Try: <a href='" . base_url('pengguna-sekolah') . "'>Real Pengguna Sekolah (with auth)</a><br>";
            
        } catch (Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
            echo "Stack trace:<br>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
}
