<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rating extends Migration
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
            'novel_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'rating' => [
                'type' => 'FLOAT',
                'constraint' => '10'
            ],
            'created' => [
                'type' => 'TIMESTAMP',
            ]

        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('rating', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('rating');
    }
}
