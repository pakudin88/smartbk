<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SchoolSystemSeeder extends Seeder
{
    public function run()
    {
        // Jalankan seeder untuk roles
        $this->call('RoleSeeder');

        // Insert default school year
        $this->db->table('school_years')->insert([
            'year' => '2024/2025',
            'is_active' => true,
            'start_date' => '2024-07-01',
            'end_date' => '2025-06-30',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Insert subjects
        $subjects = [
            ['name' => 'Matematika', 'code' => 'MTK', 'description' => 'Mata pelajaran Matematika'],
            ['name' => 'Bahasa Indonesia', 'code' => 'BIN', 'description' => 'Mata pelajaran Bahasa Indonesia'],
            ['name' => 'Bahasa Inggris', 'code' => 'BING', 'description' => 'Mata pelajaran Bahasa Inggris'],
            ['name' => 'Ilmu Pengetahuan Alam', 'code' => 'IPA', 'description' => 'Mata pelajaran IPA'],
            ['name' => 'Ilmu Pengetahuan Sosial', 'code' => 'IPS', 'description' => 'Mata pelajaran IPS'],
            ['name' => 'Pendidikan Agama Islam', 'code' => 'PAI', 'description' => 'Mata pelajaran Pendidikan Agama Islam'],
            ['name' => 'Pendidikan Pancasila', 'code' => 'PKN', 'description' => 'Mata pelajaran Pendidikan Pancasila'],
            ['name' => 'Seni Budaya', 'code' => 'SBK', 'description' => 'Mata pelajaran Seni Budaya'],
            ['name' => 'Pendidikan Jasmani', 'code' => 'PJOK', 'description' => 'Mata pelajaran Pendidikan Jasmani'],
            ['name' => 'Teknologi Informasi', 'code' => 'TI', 'description' => 'Mata pelajaran Teknologi Informasi']
        ];

        foreach ($subjects as &$subject) {
            $subject['is_active'] = true;
            $subject['created_at'] = date('Y-m-d H:i:s');
            $subject['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->db->table('subjects')->insertBatch($subjects);

        // Insert default users
        $users = [
            [
                'username' => 'superadmin',
                'email' => 'superadmin@sekolah.com',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'role_id' => 1, // superadmin
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'guru001',
                'email' => 'guru001@sekolah.com',
                'password_hash' => password_hash('guru123', PASSWORD_DEFAULT),
                'role_id' => 2, // guru
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'siswa001',
                'email' => 'siswa001@sekolah.com',
                'password_hash' => password_hash('siswa123', PASSWORD_DEFAULT),
                'role_id' => 3, // siswa
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('users')->insertBatch($users);

        // Insert sample classes
        $classes = [
            [
                'name' => '7A',
                'level' => 7,
                'section' => 'A',
                'school_year_id' => 1,
                'max_students' => 30,
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '7B',
                'level' => 7,
                'section' => 'B',
                'school_year_id' => 1,
                'max_students' => 30,
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '8A',
                'level' => 8,
                'section' => 'A',
                'school_year_id' => 1,
                'max_students' => 30,
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('classes')->insertBatch($classes);

        // Insert sample guru profile
        $this->db->table('guru_profiles')->insert([
            'user_id' => 2, // guru001
            'employee_id' => 'GUR001',
            'full_name' => 'Budi Santoso, S.Pd',
            'phone' => '081234567890',
            'address' => 'Jl. Pendidikan No. 123',
            'date_of_birth' => '1985-05-15',
            'gender' => 'L',
            'specialization' => 'Matematika',
            'hire_date' => '2020-07-01',
            'is_homeroom_teacher' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Insert sample siswa profile
        $this->db->table('siswa_profiles')->insert([
            'user_id' => 3, // siswa001
            'student_id' => 'SIS001',
            'full_name' => 'Andi Pratama',
            'nisn' => '1234567890',
            'class_id' => 1, // 7A
            'phone' => '081234567891',
            'address' => 'Jl. Siswa No. 456',
            'date_of_birth' => '2010-03-20',
            'place_of_birth' => 'Jakarta',
            'gender' => 'L',
            'religion' => 'Islam',
            'blood_type' => 'A',
            'admission_date' => '2024-07-01',
            'parent_name' => 'Sari Pratama',
            'parent_phone' => '081234567892',
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Insert sample class subjects
        $this->db->table('class_subjects')->insert([
            'class_id' => 1, // 7A
            'subject_id' => 1, // Matematika
            'guru_id' => 1, // Budi Santoso
            'schedule_day' => 'Senin',
            'schedule_time_start' => '07:00:00',
            'schedule_time_end' => '08:30:00',
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Insert sample announcement
        $this->db->table('announcements')->insert([
            'author_id' => 1, // superadmin
            'title' => 'Selamat Datang di Sistem Sekolah Multi-App',
            'content' => 'Sistem ini telah berhasil diinstal dan dikonfigurasi. Semua pengguna dapat mulai menggunakan sistem dengan login menggunakan kredensial yang telah diberikan.',
            'target_audience' => 'all',
            'is_active' => true,
            'published_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
