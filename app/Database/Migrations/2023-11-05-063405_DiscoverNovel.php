<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DiscoverNovel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'auto_increment' => TRUE,
                'type' => 'INT',
                'constraint' => '11',
            ],
            'novel_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'discover_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],

        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('discover_novel', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('discover_novel');
    }
}
