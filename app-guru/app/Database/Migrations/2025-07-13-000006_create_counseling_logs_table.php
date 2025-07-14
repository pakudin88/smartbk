<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCounselingLogsTable extends Migration
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
            'case_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'session_date' => [
                'type' => 'DATETIME',
            ],
            'session_summary' => [
                'type' => 'TEXT',
            ],
            'analysis' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'intervention_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'progress_evaluation' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'next_steps' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_encrypted' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
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
        $this->forge->addForeignKey('case_id', 'cases', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('counseling_logs');
    }

    public function down()
    {
        $this->forge->dropTable('counseling_logs');
    }
}
