<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductionDataSeeder extends Seeder
{
    public function run()
    {
        echo "🏭 Memulai ProductionDataSeeder untuk data production...\n";
        
        // Jalankan CompleteSchoolSystemSeeder terlebih dahulu
        $this->call('CompleteSchoolSystemSeeder');
        
        // Tambahkan data production yang lebih lengkap
        $this->seedMoreUsers();
        $this->seedMoreStudents();
        $this->seedMoreClasses();
        $this->seedMoreAssignments();
        
        echo "✅ ProductionDataSeeder berhasil dijalankan!\n\n";
    }
    
    private function seedMoreUsers()
    {
        echo "👤 Menambahkan lebih banyak data Users...\n";
        
        $users = [
            // Guru-guru tambahan
            [
                'username' => 'guru003',
                'email' => 'ahmad.rifai@sekolah.com',
                'password' => password_hash('guru123', PASSWORD_DEFAULT),
                'full_name' => 'Ahmad Rifai, S.Pd',
                'role_id' => 2, // Guru Mapel
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'guru004',
                'email' => 'rika.sari@sekolah.com',
                'password' => password_hash('guru123', PASSWORD_DEFAULT),
                'full_name' => 'Rika Sari, S.Pd',
                'role_id' => 3, // Wali Kelas
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'guru005',
                'email' => 'dedi.kurniawan@sekolah.com',
                'password' => password_hash('guru123', PASSWORD_DEFAULT),
                'full_name' => 'Dedi Kurniawan, S.Pd',
                'role_id' => 2, // Guru Mapel
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'guru006',
                'email' => 'maya.indah@sekolah.com',
                'password' => password_hash('guru123', PASSWORD_DEFAULT),
                'full_name' => 'Maya Indah, S.Pd',
                'role_id' => 3, // Wali Kelas
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Siswa-siswa tambahan
            [
                'username' => 'siswa003',
                'email' => 'rini.kusuma@sekolah.com',
                'password' => password_hash('siswa123', PASSWORD_DEFAULT),
                'full_name' => 'Rini Kusuma',
                'role_id' => 4, // Siswa
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'siswa004',
                'email' => 'fajar.nugraha@sekolah.com',
                'password' => password_hash('siswa123', PASSWORD_DEFAULT),
                'full_name' => 'Fajar Nugraha',
                'role_id' => 4, // Siswa
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'siswa005',
                'email' => 'lisa.permata@sekolah.com',
                'password' => password_hash('siswa123', PASSWORD_DEFAULT),
                'full_name' => 'Lisa Permata',
                'role_id' => 4, // Siswa
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'siswa006',
                'email' => 'dimas.pratama@sekolah.com',
                'password' => password_hash('siswa123', PASSWORD_DEFAULT),
                'full_name' => 'Dimas Pratama',
                'role_id' => 4, // Siswa
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Orang tua tambahan
            [
                'username' => 'ortu002',
                'email' => 'ibu.rini@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Ibu Rini (Orang Tua)',
                'role_id' => 5, // Orangtua
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'ortu003',
                'email' => 'bapak.fajar@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Bapak Fajar (Orang Tua)',
                'role_id' => 5, // Orangtua
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('users')->insertBatch($users);
        echo "   ✅ " . count($users) . " users tambahan berhasil ditambahkan\n";
    }
    
    private function seedMoreStudents()
    {
        echo "👨‍🎓 Menambahkan lebih banyak data Students...\n";
        
        $students = [
            [
                'user_id' => 13, // Rini Kusuma
                'nis' => '2024005',
                'nisn' => '1234567894',
                'nama_lengkap' => 'Rini Kusuma',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2010-01-12',
                'agama' => 'Islam',
                'alamat' => 'Jl. Siswa No. 111, Jakarta Timur',
                'no_telepon' => '081234567894',
                'email' => 'rini.kusuma@sekolah.com',
                'tahun_masuk' => 2024,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 14, // Fajar Nugraha
                'nis' => '2024006',
                'nisn' => '1234567895',
                'nama_lengkap' => 'Fajar Nugraha',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2010-06-18',
                'agama' => 'Islam',
                'alamat' => 'Jl. Siswa No. 222, Jakarta Selatan',
                'no_telepon' => '081234567895',
                'email' => 'fajar.nugraha@sekolah.com',
                'tahun_masuk' => 2024,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 15, // Lisa Permata
                'nis' => '2024007',
                'nisn' => '1234567896',
                'nama_lengkap' => 'Lisa Permata',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2010-09-25',
                'agama' => 'Islam',
                'alamat' => 'Jl. Siswa No. 333, Jakarta Utara',
                'no_telepon' => '081234567896',
                'email' => 'lisa.permata@sekolah.com',
                'tahun_masuk' => 2024,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 16, // Dimas Pratama
                'nis' => '2024008',
                'nisn' => '1234567897',
                'nama_lengkap' => 'Dimas Pratama',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2010-12-03',
                'agama' => 'Islam',
                'alamat' => 'Jl. Siswa No. 444, Jakarta Barat',
                'no_telepon' => '081234567897',
                'email' => 'dimas.pratama@sekolah.com',
                'tahun_masuk' => 2024,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Siswa tanpa akun user (data legacy)
            [
                'user_id' => null,
                'nis' => '2024009',
                'nisn' => '1234567898',
                'nama_lengkap' => 'Arif Hidayat',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2009-02-14',
                'agama' => 'Islam',
                'alamat' => 'Jl. Siswa No. 555, Jakarta Pusat',
                'no_telepon' => '081234567898',
                'email' => 'arif.hidayat@sekolah.com',
                'tahun_masuk' => 2023,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => null,
                'nis' => '2024010',
                'nisn' => '1234567899',
                'nama_lengkap' => 'Sinta Maharani',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2009-04-30',
                'agama' => 'Islam',
                'alamat' => 'Jl. Siswa No. 666, Jakarta Timur',
                'no_telepon' => '081234567899',
                'email' => 'sinta.maharani@sekolah.com',
                'tahun_masuk' => 2023,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('murid')->insertBatch($students);
        echo "   ✅ " . count($students) . " murid tambahan berhasil ditambahkan\n";
        
        // Tambahkan student-class relationships untuk siswa baru
        $studentClasses = [
            [
                'murid_id' => 5, // Rini Kusuma
                'kelas_id' => 1, // 7A
                'tahun_ajaran_id' => 1, // 2024/2025 Ganjil
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'murid_id' => 6, // Fajar Nugraha
                'kelas_id' => 2, // 7B
                'tahun_ajaran_id' => 1, // 2024/2025 Ganjil
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'murid_id' => 7, // Lisa Permata
                'kelas_id' => 3, // 8A
                'tahun_ajaran_id' => 1, // 2024/2025 Ganjil
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'murid_id' => 8, // Dimas Pratama
                'kelas_id' => 4, // 8B
                'tahun_ajaran_id' => 1, // 2024/2025 Ganjil
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'murid_id' => 9, // Arif Hidayat
                'kelas_id' => 5, // 9A
                'tahun_ajaran_id' => 1, // 2024/2025 Ganjil
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'murid_id' => 10, // Sinta Maharani
                'kelas_id' => 6, // 9B
                'tahun_ajaran_id' => 1, // 2024/2025 Ganjil
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('murid_kelas')->insertBatch($studentClasses);
        echo "   ✅ " . count($studentClasses) . " student-class relationships tambahan berhasil ditambahkan\n";
    }
    
    private function seedMoreClasses()
    {
        echo "🏫 Mengupdate wali kelas untuk semua kelas...\n";
        
        // Update wali kelas untuk kelas-kelas yang belum ada wali kelasnya
        $this->db->table('classes')->where('id', 2)->update(['wali_kelas_id' => 10]); // 7B - Rika Sari
        $this->db->table('classes')->where('id', 3)->update(['wali_kelas_id' => 12]); // 8A - Maya Indah
        $this->db->table('classes')->where('id', 4)->update(['wali_kelas_id' => 9]); // 8B - Ahmad Rifai
        $this->db->table('classes')->where('id', 5)->update(['wali_kelas_id' => 11]); // 9A - Dedi Kurniawan
        $this->db->table('classes')->where('id', 6)->update(['wali_kelas_id' => 2]); // 9B - Budi Santoso
        
        echo "   ✅ Wali kelas berhasil diupdate untuk semua kelas\n";
    }
    
    private function seedMoreAssignments()
    {
        echo "👨‍🏫 Menambahkan lebih banyak Teacher Assignments...\n";
        
        $assignments = [
            // Ahmad Rifai - IPA
            [
                'teacher_id' => 9, // Ahmad Rifai
                'subject_id' => 4, // IPA
                'class_id' => 1, // 7A
                'school_year_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => 9, // Ahmad Rifai
                'subject_id' => 4, // IPA
                'class_id' => 2, // 7B
                'school_year_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Rika Sari - Bahasa Inggris
            [
                'teacher_id' => 10, // Rika Sari
                'subject_id' => 3, // Bahasa Inggris
                'class_id' => 1, // 7A
                'school_year_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => 10, // Rika Sari
                'subject_id' => 3, // Bahasa Inggris
                'class_id' => 2, // 7B
                'school_year_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Dedi Kurniawan - IPS
            [
                'teacher_id' => 11, // Dedi Kurniawan
                'subject_id' => 5, // IPS
                'class_id' => 3, // 8A
                'school_year_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => 11, // Dedi Kurniawan
                'subject_id' => 5, // IPS
                'class_id' => 4, // 8B
                'school_year_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Maya Indah - PKN
            [
                'teacher_id' => 12, // Maya Indah
                'subject_id' => 7, // PKN
                'class_id' => 5, // 9A
                'school_year_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => 12, // Maya Indah
                'subject_id' => 7, // PKN
                'class_id' => 6, // 9B
                'school_year_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('teacher_assignments')->insertBatch($assignments);
        echo "   ✅ " . count($assignments) . " teacher assignments tambahan berhasil ditambahkan\n";
    }
}
