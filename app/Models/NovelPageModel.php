<?php

namespace App\Models;

use CodeIgniter\Model;

class NovelPageModel extends Model
{

    protected $table = "novel_page";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "object";
    protected $allowedFields = ['id','novel_id', 'chapter_id', 'page_no', 'page_content', 'created'];
}