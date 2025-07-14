<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJabatanTables extends Migration
{
    public function up()
    {
        // Table: jabatan
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'kode_jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['guru_mapel', 'kepala_sekolah', 'wakil_kepala_sekolah', 'guru_bk', 'admin', 'staff'],
                'null' => false,
            ],
            'departemen' => [
                'type' => 'ENUM',
                'constraint' => ['akademik', 'administrasi', 'bimbingan_konseling', 'kepala_sekolah'],
                'null' => false,
            ],
            'level' => [
                'type' => 'ENUM',
                'constraint' => ['pimpinan', 'koordinator', 'pelaksana'],
                'null' => false,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
                'default' => 'aktif',
            ],
            'tahun_ajaran_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['kode_jabatan', 'tahun_ajaran_id']);
        $this->forge->addForeignKey('tahun_ajaran_id', 'school_years', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jabatan');

        // Table: petugas (staff/guru)
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
                'null' => true,
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
                'null' => true,
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'agama' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'no_telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'pendidikan_terakhir' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'bidang_keahlian' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'tanggal_masuk' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status_kepegawaian' => [
                'type' => 'ENUM',
                'constraint' => ['tetap', 'kontrak', 'honorer'],
                'default' => 'tetap',
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('nip');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('petugas');

        // Table: petugas_jabatan (pivot table)
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'petugas_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'jabatan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'tahun_ajaran_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'nonaktif', 'selesai'],
                'default' => 'aktif',
            ],
            'keterangan' => [
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['petugas_id', 'jabatan_id', 'tahun_ajaran_id']);
        $this->forge->addForeignKey('petugas_id', 'petugas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('jabatan_id', 'jabatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tahun_ajaran_id', 'school_years', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('petugas_jabatan');
    }

    public function down()
    {
        // Drop tables in reverse order to avoid foreign key constraints
        $this->forge->dropTable('petugas_jabatan', true);
        $this->forge->dropTable('petugas', true);
        $this->forge->dropTable('jabatan', true);
    }
}
