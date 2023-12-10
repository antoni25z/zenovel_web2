<?php

namespace App\Models;

use CodeIgniter\Model;

class NovelModel extends Model
{

    protected $table = "novel";
    protected $primaryKey = "id";
    protected $useAutoIncrement = false;
    protected $returnType = "object";
    protected $allowedFields = ['id', 'novel_title', 'novel_image','novel_summary', 'genre_id','chapter_status', 'status', 'created'];
}