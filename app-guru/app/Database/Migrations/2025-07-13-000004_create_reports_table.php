<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'student_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'reporter_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'category' => [
                'type'       => 'ENUM',
                'constraint' => ['akademik', 'sosial', 'perilaku'],
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'priority' => [
                'type'       => 'ENUM',
                'constraint' => ['rendah', 'sedang', 'tinggi'],
                'default'    => 'sedang',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['baru', 'ditangani', 'selesai'],
                'default'    => 'baru',
            ],
            'is_escalated' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reporter_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reports');
    }

    public function down()
    {
        $this->forge->dropTable('reports');
    }
}
