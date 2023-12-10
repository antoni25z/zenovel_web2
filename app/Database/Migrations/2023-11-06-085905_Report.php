<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Report extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'auto_increment' => TRUE,
                'type' => 'INT',
                'constraint' => '11',
            ],
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'message' => [
                'type' => 'TEXT',
            ],
            'created' => [
                'type' => 'TIMESTAMP',
            ],

        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('report', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('report');
    }
}
