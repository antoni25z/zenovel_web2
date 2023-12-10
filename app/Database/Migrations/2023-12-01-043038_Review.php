<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Review extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => TRUE,
            ],
            'novel_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'review' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'rating' => [
                'type' => 'FLOAT',
            ],
            'created' => [
                'type' => 'TIMESTAMP',
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('review', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('review');
    }
}
