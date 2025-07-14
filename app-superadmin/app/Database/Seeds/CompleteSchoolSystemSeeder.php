<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompleteSchoolSystemSeeder extends Seeder
{
    public function run()
    {
        // Jalankan seeder untuk roles terlebih dahulu
        $this->call('RoleSeeder');
        
        echo "🏫 Memulai seeder CompleteSchoolSystemSeeder...\n";
        
        // 1. Insert School Years
        $this->seedSchoolYears();
        
        // 2. Insert Subjects
        $this->seedSubjects();
        
        // 3. Insert School Data
        $this->seedSchoolData();
        
        // 4. Insert Users (SuperAdmin, Guru, Siswa)
        $this->seedUsers();
        
        // 5. Insert Classes
        $this->seedClasses();
        
        // 6. Insert Students (Murid)
        $this->seedStudents();
        
        // 7. Insert Student-Class Relationships
        $this->seedStudentClasses();
        
        // 8. Insert Teacher Assignments
        $this->seedTeacherAssignments();
        
        // 9. Insert Announcements
        $this->seedAnnouncements();
        
        // 10. Insert Settings
        $this->seedSettings();
        
        echo "✅ CompleteSchoolSystemSeeder berhasil dijalankan!\n\n";
    }
    
    private function seedSchoolYears()
    {
        echo "📅 Menambahkan data School Years...\n";
        
        $schoolYears = [
            [
                'year' => '2024/2025',
                'nama' => 'Tahun Ajaran 2024/2025',
                'semester' => 'Ganjil',
                'start_date' => '2024-07-01',
                'end_date' => '2024-12-31',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'year' => '2024/2025',
                'nama' => 'Tahun Ajaran 2024/2025',
                'semester' => 'Genap',
                'start_date' => '2025-01-01',
                'end_date' => '2025-06-30',
                'is_active' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'year' => '2025/2026',
                'nama' => 'Tahun Ajaran 2025/2026',
                'semester' => 'Ganjil',
                'start_date' => '2025-07-01',
                'end_date' => '2025-12-31',
                'is_active' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('school_years')->insertBatch($schoolYears);
        echo "   ✅ " . count($schoolYears) . " school years berhasil ditambahkan\n";
    }
    
    private function seedSubjects()
    {
        echo "📚 Menambahkan data Subjects (Mata Pelajaran)...\n";
        
        $subjects = [
            [
                'kode_mapel' => 'MTK',
                'nama_mapel' => 'Matematika',
                'deskripsi' => 'Mata pelajaran Matematika untuk semua jenjang',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_mapel' => 'BIN',
                'nama_mapel' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran Bahasa Indonesia',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_mapel' => 'BING',
                'nama_mapel' => 'Bahasa Inggris',
                'deskripsi' => 'Mata pelajaran Bahasa Inggris',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_mapel' => 'IPA',
                'nama_mapel' => 'Ilmu Pengetahuan Alam',
                'deskripsi' => 'Mata pelajaran IPA (Fisika, Kimia, Biologi)',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_mapel' => 'IPS',
                'nama_mapel' => 'Ilmu Pengetahuan Sosial',
                'deskripsi' => 'Mata pelajaran IPS (Sejarah, Geografi, Ekonomi)',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_mapel' => 'PAI',
                'nama_mapel' => 'Pendidikan Agama Islam',
                'deskripsi' => 'Mata pelajaran Pendidikan Agama Islam',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_mapel' => 'PKN',
                'nama_mapel' => 'Pendidikan Pancasila dan Kewarganegaraan',
                'deskripsi' => 'Mata pelajaran PKN',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_mapel' => 'SBK',
                'nama_mapel' => 'Seni Budaya',
                'deskripsi' => 'Mata pelajaran Seni Budaya dan Kerajinan',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_mapel' => 'PJOK',
                'nama_mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan',
                'deskripsi' => 'Mata pelajaran PJOK',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_mapel' => 'TIK',
                'nama_mapel' => 'Teknologi Informasi dan Komunikasi',
                'deskripsi' => 'Mata pelajaran TIK/Komputer',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('subjects')->insertBatch($subjects);
        echo "   ✅ " . count($subjects) . " subjects berhasil ditambahkan\n";
    }
    
    private function seedSchoolData()
    {
        echo "🏢 Menambahkan data Sekolah...\n";
        
        $schools = [
            [
                'nama_sekolah' => 'SMP Negeri 1 Jakarta',
                'npsn' => '20100001',
                'alamat' => 'Jl. Pendidikan No. 123, Jakarta Pusat',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '10110',
                'telepon' => '021-12345678',
                'email' => 'info@smpn1jakarta.sch.id',
                'website' => 'https://smpn1jakarta.sch.id',
                'kepala_sekolah' => 'Dr. Ahmad Sudrajat, M.Pd',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('sekolah')->insertBatch($schools);
        echo "   ✅ " . count($schools) . " sekolah berhasil ditambahkan\n";
    }
    
    private function seedUsers()
    {
        echo "👤 Menambahkan data Users...\n";
        
        $users = [
            [
                'username' => 'superadmin',
                'email' => 'superadmin@sekolah.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'full_name' => 'Super Administrator',
                'role_id' => 1, // Super Admin
                'is_active' => 1,
                'last_login' => null,
                'profile_picture' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'guru001',
                'email' => 'budi.santoso@sekolah.com',
                'password' => password_hash('guru123', PASSWORD_DEFAULT),
                'full_name' => 'Budi Santoso, S.Pd',
                'role_id' => 2, // Guru Mapel
                'is_active' => 1,
                'last_login' => null,
                'profile_picture' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'guru002',
                'email' => 'siti.rahayu@sekolah.com',
                'password' => password_hash('guru123', PASSWORD_DEFAULT),
                'full_name' => 'Siti Rahayu, S.Pd',
                'role_id' => 3, // Wali Kelas
                'is_active' => 1,
                'last_login' => null,
                'profile_picture' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'siswa001',
                'email' => 'andi.pratama@sekolah.com',
                'password' => password_hash('siswa123', PASSWORD_DEFAULT),
                'full_name' => 'Andi Pratama',
                'role_id' => 4, // Siswa
                'is_active' => 1,
                'last_login' => null,
                'profile_picture' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'siswa002',
                'email' => 'sari.indah@sekolah.com',
                'password' => password_hash('siswa123', PASSWORD_DEFAULT),
                'full_name' => 'Sari Indah',
                'role_id' => 4, // Siswa
                'is_active' => 1,
                'last_login' => null,
                'profile_picture' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'ortu001',
                'email' => 'bapak.andi@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Bapak Andi (Orang Tua)',
                'role_id' => 5, // Orangtua
                'is_active' => 1,
                'last_login' => null,
                'profile_picture' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'admin001',
                'email' => 'admin@sekolah.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'full_name' => 'Administrator Sekolah',
                'role_id' => 6, // Staff Administrasi
                'is_active' => 1,
                'last_login' => null,
                'profile_picture' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'kepsek001',
                'email' => 'kepala.sekolah@sekolah.com',
                'password' => password_hash('kepsek123', PASSWORD_DEFAULT),
                'full_name' => 'Dr. Ahmad Sudrajat, M.Pd',
                'role_id' => 7, // Kepala Sekolah
                'is_active' => 1,
                'last_login' => null,
                'profile_picture' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('users')->insertBatch($users);
        echo "   ✅ " . count($users) . " users berhasil ditambahkan\n";
    }
    
    private function seedClasses()
    {
        echo "🏫 Menambahkan data Classes (Kelas)...\n";
        
        $classes = [
            [
                'nama_kelas' => '7A',
                'tingkat' => 7,
                'jurusan' => null,
                'wali_kelas_id' => 3, // Siti Rahayu
                'kapasitas' => 30,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_kelas' => '7B',
                'tingkat' => 7,
                'jurusan' => null,
                'wali_kelas_id' => null,
                'kapasitas' => 30,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_kelas' => '8A',
                'tingkat' => 8,
                'jurusan' => null,
                'wali_kelas_id' => null,
                'kapasitas' => 30,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_kelas' => '8B',
                'tingkat' => 8,
                'jurusan' => null,
                'wali_kelas_id' => null,
                'kapasitas' => 30,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_kelas' => '9A',
                'tingkat' => 9,
                'jurusan' => null,
                'wali_kelas_id' => null,
                'kapasitas' => 30,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_kelas' => '9B',
                'tingkat' => 9,
                'jurusan' => null,
                'wali_kelas_id' => null,
                'kapasitas' => 30,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('classes')->insertBatch($classes);
        echo "   ✅ " . count($classes) . " kelas berhasil ditambahkan\n";
    }
    
    private function seedStudents()
    {
        echo "👨‍🎓 Menambahkan data Students (Murid)...\n";
        
        $students = [
            [
                'user_id' => 4, // Andi Pratama
                'nis' => '2024001',
                'nisn' => '1234567890',
                'nama_lengkap' => 'Andi Pratama',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2010-03-15',
                'agama' => 'Islam',
                'alamat' => 'Jl. Siswa No. 123, Jakarta Timur',
                'no_telepon' => '081234567890',
                'email' => 'andi.pratama@sekolah.com',
                'tahun_masuk' => 2024,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 5, // Sari Indah
                'nis' => '2024002',
                'nisn' => '1234567891',
                'nama_lengkap' => 'Sari Indah',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2010-05-20',
                'agama' => 'Islam',
                'alamat' => 'Jl. Siswa No. 456, Jakarta Selatan',
                'no_telepon' => '081234567891',
                'email' => 'sari.indah@sekolah.com',
                'tahun_masuk' => 2024,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => null,
                'nis' => '2024003',
                'nisn' => '1234567892',
                'nama_lengkap' => 'Budi Setiawan',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2010-08-10',
                'agama' => 'Islam',
                'alamat' => 'Jl. Siswa No. 789, Jakarta Utara',
                'no_telepon' => '081234567892',
                'email' => 'budi.setiawan@sekolah.com',
                'tahun_masuk' => 2024,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => null,
                'nis' => '2024004',
                'nisn' => '1234567893',
                'nama_lengkap' => 'Dewi Sartika',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2010-11-25',
                'agama' => 'Islam',
                'alamat' => 'Jl. Siswa No. 321, Jakarta Barat',
                'no_telepon' => '081234567893',
                'email' => 'dewi.sartika@sekolah.com',
                'tahun_masuk' => 2024,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('murid')->insertBatch($students);
        echo "   ✅ " . count($students) . " murid berhasil ditambahkan\n";
    }
    
    private function seedStudentClasses()
    {
        echo "👥 Menambahkan data Student-Class relationships...\n";
        
        $studentClasses = [
            [
                'murid_id' => 1,
                'kelas_id' => 1, // 7A
                'tahun_ajaran_id' => 1, // 2024/2025 Ganjil
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'murid_id' => 2,
                'kelas_id' => 1, // 7A
                'tahun_ajaran_id' => 1, // 2024/2025 Ganjil
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'murid_id' => 3,
                'kelas_id' => 2, // 7B
                'tahun_ajaran_id' => 1, // 2024/2025 Ganjil
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'murid_id' => 4,
                'kelas_id' => 2, // 7B
                'tahun_ajaran_id' => 1, // 2024/2025 Ganjil
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('murid_kelas')->insertBatch($studentClasses);
        echo "   ✅ " . count($studentClasses) . " student-class relationships berhasil ditambahkan\n";
    }
    
    private function seedTeacherAssignments()
    {
        echo "👨‍🏫 Menambahkan data Teacher Assignments...\n";
        
        $assignments = [
            [
                'teacher_id' => 2, // Budi Santoso
                'subject_id' => 1, // Matematika
                'class_id' => 1, // 7A
                'school_year_id' => 1, // 2024/2025 Ganjil
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => 2, // Budi Santoso
                'subject_id' => 1, // Matematika
                'class_id' => 2, // 7B
                'school_year_id' => 1, // 2024/2025 Ganjil
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => 3, // Siti Rahayu
                'subject_id' => 2, // Bahasa Indonesia
                'class_id' => 1, // 7A
                'school_year_id' => 1, // 2024/2025 Ganjil
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('teacher_assignments')->insertBatch($assignments);
        echo "   ✅ " . count($assignments) . " teacher assignments berhasil ditambahkan\n";
    }
    
    private function seedAnnouncements()
    {
        echo "📢 Menambahkan data Announcements...\n";
        
        $announcements = [
            [
                'title' => 'Selamat Datang di Sistem Sekolah Multi-App',
                'content' => 'Sistem ini telah berhasil diinstal dan dikonfigurasi. Semua pengguna dapat mulai menggunakan sistem dengan login menggunakan kredensial yang telah diberikan.',
                'author_id' => 1, // Super Admin
                'target_role' => 'all',
                'is_active' => 1,
                'published_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Panduan Penggunaan Sistem untuk Guru',
                'content' => 'Bapak/Ibu guru dapat menggunakan sistem ini untuk mengelola nilai, absensi, dan tugas siswa. Silakan hubungi administrator jika mengalami kesulitan.',
                'author_id' => 1, // Super Admin
                'target_role' => 'Guru Mapel',
                'is_active' => 1,
                'published_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Informasi untuk Siswa',
                'content' => 'Siswa dapat menggunakan sistem ini untuk melihat jadwal pelajaran, nilai, dan tugas. Pastikan selalu menggunakan kredensial yang benar.',
                'author_id' => 1, // Super Admin
                'target_role' => 'Siswa',
                'is_active' => 1,
                'published_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('announcements')->insertBatch($announcements);
        echo "   ✅ " . count($announcements) . " announcements berhasil ditambahkan\n";
    }
    
    private function seedSettings()
    {
        echo "⚙️ Menambahkan data Settings...\n";
        
        $settings = [
            [
                'setting_key' => 'school_name',
                'setting_value' => 'SMP Negeri 1 Jakarta',
                'description' => 'Nama sekolah yang akan ditampilkan di sistem',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'school_address',
                'setting_value' => 'Jl. Pendidikan No. 123, Jakarta Pusat',
                'description' => 'Alamat lengkap sekolah',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'school_phone',
                'setting_value' => '021-12345678',
                'description' => 'Nomor telepon sekolah',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'school_email',
                'setting_value' => 'info@smpn1jakarta.sch.id',
                'description' => 'Email resmi sekolah',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'app_version',
                'setting_value' => '1.0.0',
                'description' => 'Versi aplikasi sistem sekolah',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'maintenance_mode',
                'setting_value' => '0',
                'description' => 'Mode maintenance (0 = off, 1 = on)',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'max_students_per_class',
                'setting_value' => '30',
                'description' => 'Maksimal jumlah siswa per kelas',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'current_academic_year',
                'setting_value' => '2024/2025',
                'description' => 'Tahun ajaran yang sedang aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('settings')->insertBatch($settings);
        echo "   ✅ " . count($settings) . " settings berhasil ditambahkan\n";
    }
}
