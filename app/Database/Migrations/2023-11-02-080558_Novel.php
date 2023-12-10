<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Novel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'novel_image' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'novel_title' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'novel_summary' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'genre_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'chapter_status' => [
                'type' => 'INT',
                'constraint' => '1'
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => '1'
            ],
            'created' => [
                'type' => 'TIMESTAMP',
            ]

        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('novel', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('novel');
    }
}
