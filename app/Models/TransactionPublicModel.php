<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionPublicModel extends Model
{
    protected $table = 'transaction_public';

    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'transaction_id', 'public_id'
    ];
}
