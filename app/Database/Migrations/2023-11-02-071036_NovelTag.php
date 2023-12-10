<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NovelTag extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'auto_increment' => TRUE,
                'type' => 'INT',
            ],
            'novel_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'tag_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('novel_tag', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('novel_tag');
    }
}
