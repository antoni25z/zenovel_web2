<?php

namespace App\Models;

use CodeIgniter\Model;

class NovelTagModel extends Model
{

    protected $table = "novel_tag";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $allowedFields = ['id', 'novel_id', 'tag_id'];
}