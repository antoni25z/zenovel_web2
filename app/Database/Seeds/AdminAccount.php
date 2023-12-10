<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminAccount extends Seeder
{
    public function run()
    {
        $account = [
            'id_administrator' => uniqid(),
            'username' => 'Admin',
            'password' => password_hash('Admin', PASSWORD_BCRYPT),
            'user_level' => 1,
            'status' => 1
        ];
        $this->db->table('administrator')->insert($account);
    }
}
