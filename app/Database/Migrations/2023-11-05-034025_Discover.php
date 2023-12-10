<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Discover extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'auto_increment' => TRUE,
                'type' => 'INT',
                'constraint' => '11',
            ],
            'discover_name' => [
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
        $this->forge->createTable('discover', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('discover');
    }
}
