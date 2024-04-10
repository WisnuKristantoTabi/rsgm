<?php

namespace App\Models;

use CodeIgniter\Model;

class PublicModel extends Model
{
    protected $table      = 'public_doc';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['rm_id', 'fullname', 'transaction_id', 'identity_number', 'address'];
}
