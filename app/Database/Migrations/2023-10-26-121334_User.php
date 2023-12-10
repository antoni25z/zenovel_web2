<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'user_image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'token_fcm' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 1
            ],
            'created' => [
                'type' => 'TIMESTAMP',
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('user', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
