<?php

namespace App\Models;

use CodeIgniter\Model;

class AdministratorModel extends Model
{

    protected $table = "administrator";
    protected $primaryKey = "id_administrator";
    protected $useAutoIncrement = false;
    protected $returnType = "object";
    protected $allowedFields = ['id_administrator', 'password', 'username', 'status', 'user_level'];
}