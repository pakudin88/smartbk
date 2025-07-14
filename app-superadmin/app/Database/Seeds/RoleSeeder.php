<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Data roles yang akan diinsert
        $roles = [
            [
                'role_name' => 'Super Admin',
                'description' => 'Administrator utama yang memiliki akses penuh ke seluruh sistem termasuk manajemen pengguna, pengaturan sistem, dan semua fitur administrasi.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_name' => 'Guru Mapel',
                'description' => 'Guru mata pelajaran yang bertanggung jawab mengajar mata pelajaran tertentu, mengelola nilai siswa, absensi, dan tugas-tugas dalam kelas yang diampu.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_name' => 'Wali Kelas',
                'description' => 'Guru yang ditunjuk sebagai wali kelas dengan tanggung jawab tambahan untuk mengelola administrasi kelas dan koordinasi dengan orang tua siswa.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_name' => 'Siswa',
                'description' => 'Peserta didik yang terdaftar di sekolah. Memiliki akses untuk melihat jadwal pelajaran, tugas, nilai, dan absensi mereka sendiri.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_name' => 'Orangtua',
                'description' => 'Orang tua atau wali siswa yang memiliki akses untuk memantau perkembangan akademik anak mereka termasuk nilai, absensi, dan pengumuman sekolah.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_name' => 'Staff Administrasi',
                'description' => 'Staf administrasi sekolah yang bertanggung jawab untuk mengelola data siswa, guru, dan administrasi umum sekolah.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_name' => 'Kepala Sekolah',
                'description' => 'Pimpinan sekolah yang memiliki akses untuk melihat laporan, statistik, dan mengawasi keseluruhan operasional sekolah.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert batch data roles
        $this->db->table('roles')->insertBatch($roles);

        // Menampilkan pesan sukses
        echo "✅ Seeder RoleSeeder berhasil dijalankan!\n";
        echo "📋 Data yang telah diinsert:\n";
        foreach ($roles as $role) {
            echo "   - {$role['role_name']}\n";
        }
        echo "\n";
    }
}
