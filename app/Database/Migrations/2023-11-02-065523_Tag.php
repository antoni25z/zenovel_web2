<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tag extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'tag' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'created' => [
                'type' => 'TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('tag', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tag');
    }
}
