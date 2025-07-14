<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDiscussionParticipantsTable extends Migration
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
            'discussion_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'role_in_discussion' => [
                'type'       => 'ENUM',
                'constraint' => ['creator', 'participant', 'observer'],
                'default'    => 'participant',
            ],
            'joined_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('discussion_id', 'case_discussions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addUniqueKey(['discussion_id', 'user_id']);
        $this->forge->createTable('discussion_participants');
    }

    public function down()
    {
        $this->forge->dropTable('discussion_participants');
    }
}
