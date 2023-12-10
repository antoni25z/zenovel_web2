<?php

namespace App\Models;

use CodeIgniter\Model;

class DiscoverModel extends Model
{

    protected $table = "discover";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "object";
    protected $allowedFields = ['id', 'discover_name', 'status'];
}