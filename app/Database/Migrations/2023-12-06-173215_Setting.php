<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Setting extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => TRUE,
            ],
            'privacy' => [
                'type' => 'TEXT',
            ],
            'terms' => [
                'type' => 'TEXT',
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('setting', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('setting');
    }
}
