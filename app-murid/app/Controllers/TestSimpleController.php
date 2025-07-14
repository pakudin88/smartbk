<?php

namespace App\Controllers;

class TestSimpleController extends BaseController
{
    public function index()
    {
        echo "<h1>✅ TestSimpleController Works!</h1>";
        echo "<p>Jika Anda melihat halaman ini, berarti controller berfungsi dengan baik.</p>";
        echo "<hr>";
        echo "<h2>🔗 Test Safe Space Routes</h2>";
        echo "<p><a href='" . base_url('safe-space/konsul-cepat') . "' target='_blank'>Test Konsul Cepat</a></p>";
        echo "<p><a href='" . base_url('safe-space/jadwal-konseling') . "' target='_blank'>Test Jadwal Konseling</a></p>";
        echo "<p><a href='" . base_url('safe-space/jurnal-digital') . "' target='_blank'>Test Jurnal Digital</a></p>";
        echo "<p><a href='" . base_url('safe-space/pusat-informasi') . "' target='_blank'>Test Pusat Informasi</a></p>";
        echo "<hr>";
        echo "<p>Base URL: " . base_url() . "</p>";
        echo "<p>Current URL: " . current_url() . "</p>";
        echo "<p>📅 " . date('Y-m-d H:i:s') . "</p>";
    }
}
