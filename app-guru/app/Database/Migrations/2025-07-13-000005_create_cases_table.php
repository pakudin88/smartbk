<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCasesTable extends Migration
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
            'report_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'counselor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'case_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'case_description' => [
                'type' => 'TEXT',
            ],
            'priority' => [
                'type'       => 'ENUM',
                'constraint' => ['rendah', 'sedang', 'tinggi', 'darurat'],
                'default'    => 'sedang',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['baru', 'dalam_proses', 'selesai'],
                'default'    => 'baru',
            ],
            'intervention_plan' => [
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('report_id', 'reports', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('counselor_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cases');
    }

    public function down()
    {
        $this->forge->dropTable('cases');
    }
}
