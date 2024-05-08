<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table      = 'transaction';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'rm_id', 'loan_date', 'return_date', 'loan_type', 'loan_desc', 'return_desc', 'deadline', 'is_return', 'service_id'
    ];
}
