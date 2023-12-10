<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = "review";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "object";
    protected $allowedFields = ['id', 'novel_id', 'user_id', 'review','rating', 'created'];
}