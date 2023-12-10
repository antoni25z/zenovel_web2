<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NovelPage extends Migration
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
            'chapter_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'page_no' => [
                'type' => 'INT',
                'constraint' => '11'
            ],
            'page_content' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'created' => [
                'type' => 'TIMESTAMP',
            ]

        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('novel_page', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('novel_page');
    }
}
