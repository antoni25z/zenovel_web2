<?php

namespace App\Models;

use CodeIgniter\Model;

class GenreModel extends Model
{

    protected $table = "genre";
    protected $primaryKey = "id";
    protected $useAutoIncrement = false;
    protected $returnType = "object";
    protected $allowedFields = ['id', 'genre', 'status', 'created'];
}