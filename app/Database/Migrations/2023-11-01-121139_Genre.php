<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Genre extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'genre' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => '1'
            ],

            'created' => [
                'type' => 'TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('genre', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('genre');
    }
}
