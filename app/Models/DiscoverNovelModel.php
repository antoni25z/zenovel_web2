<?php

namespace App\Models;

use CodeIgniter\Model;

class DiscoverNovelModel extends Model
{

    protected $table = "discover_novel";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "object";
    protected $allowedFields = ['id', 'novel_id', 'discover_id'];
}