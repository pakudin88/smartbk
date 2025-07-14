<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SekolahSystemSeeder extends Seeder
{
    public function run()
    {
        // 1. Jalankan RoleSeeder terlebih dahulu
        $this->call('RoleSeeder');

        // 2. Insert data tahun ajaran contoh
        $schoolYears = [
            [
                'year' => '2024/2025',
                'semester' => 'Ganjil',
                'is_active' => 1,
                'start_date' => '2024-07-15',
                'end_date' => '2024-12-20',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'year' => '2024/2025',
                'semester' => 'Genap',
                'is_active' => 0,
                'start_date' => '2025-01-06',
                'end_date' => '2025-06-20',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('school_years')->insertBatch($schoolYears);

        // 3. Insert data mata pelajaran contoh
        $subjects = [
            [
                'subject_code' => 'MTK-10',
                'subject_name' => 'Matematika',
                'description' => 'Mata pelajaran Matematika untuk tingkat SMA',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_code' => 'BIN-10',
                'subject_name' => 'Bahasa Indonesia',
                'description' => 'Mata pelajaran Bahasa Indonesia untuk tingkat SMA',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_code' => 'BING-10',
                'subject_name' => 'Bahasa Inggris',
                'description' => 'Mata pelajaran Bahasa Inggris untuk tingkat SMA',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_code' => 'FIS-10',
                'subject_name' => 'Fisika',
                'description' => 'Mata pelajaran Fisika untuk tingkat SMA IPA',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_code' => 'KIM-10',
                'subject_name' => 'Kimia',
                'description' => 'Mata pelajaran Kimia untuk tingkat SMA IPA',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_code' => 'BIO-10',
                'subject_name' => 'Biologi',
                'description' => 'Mata pelajaran Biologi untuk tingkat SMA IPA',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('subjects')->insertBatch($subjects);

        // 4. Insert data users contoh
        $users = [
            [
                'role_id' => 1, // Super Admin
                'username' => 'superadmin',
                'password' => password_hash('superadmin123', PASSWORD_DEFAULT),
                'full_name' => 'Super Administrator',
                'email' => 'superadmin@sekolah.com',
                'profile_picture' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 2, // Guru Mapel
                'username' => 'guru_mtk',
                'password' => password_hash('guru123', PASSWORD_DEFAULT),
                'full_name' => 'Budi Santoso, S.Pd',
                'email' => 'budi.santoso@sekolah.com',
                'profile_picture' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 3, // Wali Kelas
                'username' => 'wali_kelas_10a',
                'password' => password_hash('wali123', PASSWORD_DEFAULT),
                'full_name' => 'Siti Rahayu, S.Pd',
                'email' => 'siti.rahayu@sekolah.com',
                'profile_picture' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 4, // Siswa
                'username' => 'siswa_001',
                'password' => password_hash('siswa123', PASSWORD_DEFAULT),
                'full_name' => 'Ahmad Rizki Pratama',
                'email' => 'ahmad.rizki@email.com',
                'profile_picture' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 5, // Orangtua
                'username' => 'orangtua_001',
                'password' => password_hash('orangtua123', PASSWORD_DEFAULT),
                'full_name' => 'Hadi Pratama',
                'email' => 'hadi.pratama@email.com',
                'profile_picture' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('users')->insertBatch($users);

        // 5. Insert data guru profiles
        $guruProfiles = [
            [
                'user_id' => 2, // Budi Santoso
                'nip' => '19850515200801001',
                'phone_number' => '081234567890',
                'address' => 'Jl. Pendidikan No. 123, Jakarta',
                'birth_date' => '1985-05-15',
                'gender' => 'Laki-laki',
                'specialization' => 'Matematika',
                'hire_date' => '2008-01-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 3, // Siti Rahayu
                'nip' => '19820310200803002',
                'phone_number' => '081234567891',
                'address' => 'Jl. Guru No. 456, Jakarta',
                'birth_date' => '1982-03-10',
                'gender' => 'Perempuan',
                'specialization' => 'Bahasa Indonesia',
                'hire_date' => '2008-03-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('guru_profiles')->insertBatch($guruProfiles);

        // 6. Insert data kelas (setelah guru_profiles karena ada FK homeroom_teacher_id)
        $classes = [
            [
                'class_name' => 'X-IPA-1',
                'level' => 10,
                'homeroom_teacher_id' => 2, // Siti Rahayu sebagai wali kelas
                'max_students' => 36,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'class_name' => 'X-IPA-2',
                'level' => 10,
                'homeroom_teacher_id' => null,
                'max_students' => 36,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'class_name' => 'X-IPS-1',
                'level' => 10,
                'homeroom_teacher_id' => null,
                'max_students' => 36,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('classes')->insertBatch($classes);

        // 7. Insert data siswa profiles
        $siswaProfiles = [
            [
                'user_id' => 4, // Ahmad Rizki
                'nis' => '2024001',
                'nisn' => '1234567890',
                'gender' => 'Laki-laki',
                'birth_date' => '2008-05-20',
                'birth_place' => 'Jakarta',
                'address' => 'Jl. Siswa No. 789, Jakarta',
                'phone_number' => '081234567892',
                'religion' => 'Islam',
                'blood_type' => 'A',
                'entry_date' => '2024-07-15',
                'graduation_date' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('siswa_profiles')->insertBatch($siswaProfiles);

        // 8. Insert data orangtua profiles
        $orangtuaProfiles = [
            [
                'user_id' => 5, // Hadi Pratama
                'phone_number' => '081234567893',
                'occupation' => 'Pegawai Swasta',
                'address' => 'Jl. Siswa No. 789, Jakarta',
                'emergency_contact' => '081234567894',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('orangtua_profiles')->insertBatch($orangtuaProfiles);

        // 9. Insert relasi orangtua-siswa
        $relasiOrangtuaSiswa = [
            [
                'orangtua_profile_id' => 1, // Hadi Pratama
                'siswa_profile_id' => 1, // Ahmad Rizki
                'relationship_status' => 'Ayah',
                'is_emergency_contact' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('relasi_orangtua_siswa')->insertBatch($relasiOrangtuaSiswa);

        // 10. Insert siswa ke kelas (class_members)
        $classMembers = [
            [
                'siswa_profile_id' => 1, // Ahmad Rizki
                'class_id' => 1, // X-IPA-1
                'school_year_id' => 1, // 2024/2025 Ganjil
                'enrollment_date' => '2024-07-15',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('class_members')->insertBatch($classMembers);

        // 11. Insert penugasan guru (teacher_assignments)
        $teacherAssignments = [
            [
                'guru_profile_id' => 1, // Budi Santoso
                'subject_id' => 1, // Matematika
                'class_id' => 1, // X-IPA-1
                'school_year_id' => 1, // 2024/2025 Ganjil
                'day_of_week' => 'Senin',
                'start_time' => '07:00:00',
                'end_time' => '08:30:00',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'guru_profile_id' => 2, // Siti Rahayu
                'subject_id' => 2, // Bahasa Indonesia
                'class_id' => 1, // X-IPA-1
                'school_year_id' => 1, // 2024/2025 Ganjil
                'day_of_week' => 'Selasa',
                'start_time' => '08:30:00',
                'end_time' => '10:00:00',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('teacher_assignments')->insertBatch($teacherAssignments);

        // 12. Insert pengumuman contoh
        $announcements = [
            [
                'author_id' => 1, // Super Admin
                'title' => 'Selamat Datang di Sistem Informasi Sekolah',
                'content' => 'Sistem informasi sekolah telah berhasil diimplementasikan. Semua pengguna dapat mengakses fitur sesuai dengan peran masing-masing.',
                'target_audience' => 'Semua',
                'is_active' => 1,
                'published_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'author_id' => 2, // Guru
                'title' => 'Jadwal Ulangan Harian Matematika',
                'content' => 'Ulangan harian matematika akan dilaksanakan pada hari Jumat, 15 Januari 2025. Materi yang diujikan adalah Fungsi Kuadrat.',
                'target_audience' => 'Siswa',
                'is_active' => 1,
                'published_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('announcements')->insertBatch($announcements);

        // Menampilkan ringkasan data yang telah diinsert
        echo "🎉 Seeder SekolahSystemSeeder berhasil dijalankan!\n";
        echo "📊 Ringkasan data yang telah diinsert:\n";
        echo "   - Roles: 7 role\n";
        echo "   - School Years: 2 tahun ajaran\n";
        echo "   - Subjects: 6 mata pelajaran\n";
        echo "   - Users: 5 pengguna\n";
        echo "   - Guru Profiles: 2 guru\n";
        echo "   - Classes: 3 kelas\n";
        echo "   - Siswa Profiles: 1 siswa\n";
        echo "   - Orangtua Profiles: 1 orangtua\n";
        echo "   - Relasi Orangtua-Siswa: 1 relasi\n";
        echo "   - Class Members: 1 siswa dalam kelas\n";
        echo "   - Teacher Assignments: 2 penugasan guru\n";
        echo "   - Announcements: 2 pengumuman\n";
        echo "\n🔑 Login credentials:\n";
        echo "   - Super Admin: superadmin / admin123\n";
        echo "   - Guru: guru_mtk / guru123\n";
        echo "   - Wali Kelas: wali_kelas_10a / wali123\n";
        echo "   - Siswa: siswa_001 / siswa123\n";
        echo "   - Orangtua: orangtua_001 / orangtua123\n";
        echo "\n";
    }
}
