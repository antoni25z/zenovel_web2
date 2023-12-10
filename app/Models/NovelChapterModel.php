<?php

namespace App\Models;

use CodeIgniter\Model;

class NovelChapterModel extends Model
{

    protected $table = "novel_chapter";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "object";
    protected $allowedFields = ['id', 'novel_id', 'content', 'chapter_name', 'status', 'created'];
}