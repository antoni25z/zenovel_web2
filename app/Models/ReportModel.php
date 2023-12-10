<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{

    protected $table = "report";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "object";
    protected $allowedFields = ['id', 'user_id', 'message', 'created'];
}