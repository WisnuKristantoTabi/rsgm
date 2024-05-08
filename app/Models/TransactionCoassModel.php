<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionCoassModel extends Model
{
    protected $table      = 'transaction_coass';

    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'transaction_id', 'coass_id'
    ];
}
