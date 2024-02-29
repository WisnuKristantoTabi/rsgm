<?php

namespace App\Models;

use CodeIgniter\Model;

class ReturnDocumentModel extends Model
{
    protected $table      = 'return_doc';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['rm_id', 'return_date', 'description'];
}
