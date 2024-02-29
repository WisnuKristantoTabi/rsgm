<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceUnitModel extends Model
{
    protected $table      = 'service_unit';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['service_name'];
}
