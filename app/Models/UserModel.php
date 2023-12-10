<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

    protected $table = "user";
    protected $primaryKey = "id";
    protected $useAutoIncrement = false;
    protected $returnType = "object";
    protected $allowedFields = ['id', 'email', 'full_name', 'status','user_image','token_fcm', 'created'];
}