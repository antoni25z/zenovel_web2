<?php

namespace App\Models;

use CodeIgniter\Model;

class TagModel extends Model
{

    protected $table = "tag";
    protected $primaryKey = "id";
    protected $useAutoIncrement = false;
    protected $returnType = "object";
    protected $allowedFields = ['id', 'tag', 'created'];
}