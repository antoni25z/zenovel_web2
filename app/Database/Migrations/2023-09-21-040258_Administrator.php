<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Administrator extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_administrator' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_level' => [
                'type' => 'INT',
                'constraint' => 1
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 1
            ],
            'created' => [
                'type' => 'TIMESTAMP',
            ]
        ]);
        $this->forge->addKey('id_administrator', TRUE);
        $this->forge->createTable('administrator', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('administrator');
    }
}
