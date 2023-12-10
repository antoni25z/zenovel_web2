<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NovelChapter extends Migration
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
            'content' => [
                'type' => 'TEXT',
            ],
            'chapter_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'created' => [
                'type' => 'TIMESTAMP',
            ]

        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('novel_chapter', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('novel_chapter');
    }
}
