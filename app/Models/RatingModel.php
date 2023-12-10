<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{

    protected $table = "rating";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "object";
    protected $allowedFields = ['id', 'user_id', 'novel_id', 'rating', 'created'];
}