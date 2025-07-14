<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSekolahSystemTables extends Migration
{
    public function up()
    {
        // 1. Tabel roles - Jenis peran pengguna
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'role_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('roles');

        // 2. Tabel users - Akun pengguna utama
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
            ],
            'profile_picture' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users');

        // 3. Tabel school_years - Tahun ajaran
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'year' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'comment' => 'Contoh: 2024/2025',
            ],
            'semester' => [
                'type' => 'ENUM',
                'constraint' => ['Ganjil', 'Genap'],
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'start_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('school_years');

        // 4. Tabel subjects - Mata pelajaran
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'subject_code' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'unique' => true,
                'comment' => 'Contoh: MTK-01',
            ],
            'subject_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('subjects');

        // 5. Tabel guru_profiles - Detail data guru
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'unique' => true,
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'unique' => true,
                'comment' => 'Nomor Induk Pegawai',
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'birth_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
                'null' => true,
            ],
            'specialization' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'comment' => 'Bidang keahlian',
            ],
            'hire_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('guru_profiles');

        // 6. Tabel classes - Kelas (diletakkan setelah guru_profiles karena ada FK ke homeroom_teacher_id)
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'class_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'comment' => 'Contoh: X-IPA-1',
            ],
            'level' => [
                'type' => 'INT',
                'constraint' => 2,
                'comment' => 'Tingkat: 10, 11, 12',
            ],
            'homeroom_teacher_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'Wali kelas',
            ],
            'max_students' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 36,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('homeroom_teacher_id', 'guru_profiles', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('classes');

        // 7. Tabel siswa_profiles - Detail data siswa
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'unique' => true,
            ],
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'unique' => true,
                'comment' => 'Nomor Induk Siswa',
            ],
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'unique' => true,
                'comment' => 'Nomor Induk Siswa Nasional',
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
                'null' => true,
            ],
            'birth_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'birth_place' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'religion' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'blood_type' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
                'null' => true,
            ],
            'entry_date' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Tanggal masuk sekolah',
            ],
            'graduation_date' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Tanggal lulus',
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('siswa_profiles');

        // 8. Tabel orangtua_profiles - Detail data orang tua
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'unique' => true,
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'occupation' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'comment' => 'Pekerjaan',
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'emergency_contact' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('orangtua_profiles');

        // 9. Tabel relasi_orangtua_siswa - Relasi many-to-many antara orang tua dan siswa
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'orangtua_profile_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'siswa_profile_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'relationship_status' => [
                'type' => 'ENUM',
                'constraint' => ['Ayah', 'Ibu', 'Wali'],
                'comment' => 'Status hubungan dengan siswa',
            ],
            'is_emergency_contact' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('orangtua_profile_id', 'orangtua_profiles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('siswa_profile_id', 'siswa_profiles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('relasi_orangtua_siswa');

        // 10. Tabel class_members - Siswa yang terdaftar di kelas pada tahun ajaran tertentu
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'siswa_profile_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'class_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'school_year_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'enrollment_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('siswa_profile_id', 'siswa_profiles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('class_id', 'classes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('school_year_id', 'school_years', 'id', 'CASCADE', 'CASCADE');
        // Tambahkan unique constraint untuk mencegah duplikasi siswa di kelas yang sama pada tahun ajaran yang sama
        $this->forge->addUniqueKey(['siswa_profile_id', 'class_id', 'school_year_id']);
        $this->forge->createTable('class_members');

        // 11. Tabel teacher_assignments - Penugasan guru mengajar mata pelajaran di kelas
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'guru_profile_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'subject_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'class_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'school_year_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'day_of_week' => [
                'type' => 'ENUM',
                'constraint' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                'null' => true,
            ],
            'start_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'end_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('guru_profile_id', 'guru_profiles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('subject_id', 'subjects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('class_id', 'classes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('school_year_id', 'school_years', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('teacher_assignments');

        // 12. Tabel announcements - Pengumuman
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'author_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'content' => [
                'type' => 'TEXT',
            ],
            'target_audience' => [
                'type' => 'ENUM',
                'constraint' => ['Semua', 'Guru', 'Siswa', 'Orangtua'],
                'default' => 'Semua',
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'published_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('author_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('announcements');

        // 13. Tabel grades - Nilai siswa
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'siswa_profile_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'teacher_assignment_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'grade_type' => [
                'type' => 'ENUM',
                'constraint' => ['Tugas', 'Kuis', 'UTS', 'UAS', 'Praktikum'],
            ],
            'grade_value' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
            'max_grade' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 100.00,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'grade_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('siswa_profile_id', 'siswa_profiles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('teacher_assignment_id', 'teacher_assignments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('grades');

        // 14. Tabel attendance - Absensi siswa
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'siswa_profile_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'teacher_assignment_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'attendance_date' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Hadir', 'Izin', 'Sakit', 'Alpha'],
                'default' => 'Hadir',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('siswa_profile_id', 'siswa_profiles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('teacher_assignment_id', 'teacher_assignments', 'id', 'CASCADE', 'CASCADE');
        // Tambahkan unique constraint untuk mencegah duplikasi absensi pada tanggal yang sama
        $this->forge->addUniqueKey(['siswa_profile_id', 'teacher_assignment_id', 'attendance_date']);
        $this->forge->createTable('attendance');
    }

    public function down()
    {
        // Hapus tabel dalam urutan terbalik untuk menghindari error foreign key
        $this->forge->dropTable('attendance', true);
        $this->forge->dropTable('grades', true);
        $this->forge->dropTable('announcements', true);
        $this->forge->dropTable('teacher_assignments', true);
        $this->forge->dropTable('class_members', true);
        $this->forge->dropTable('relasi_orangtua_siswa', true);
        $this->forge->dropTable('orangtua_profiles', true);
        $this->forge->dropTable('siswa_profiles', true);
        $this->forge->dropTable('classes', true);
        $this->forge->dropTable('guru_profiles', true);
        $this->forge->dropTable('subjects', true);
        $this->forge->dropTable('school_years', true);
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('roles', true);
    }
}
