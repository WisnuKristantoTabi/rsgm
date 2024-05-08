<?php

namespace App\Models;

use CodeIgniter\Model;

class RecordMedicalModel extends Model
{
    protected $table      = 'medical_records';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['rm_id', 'fullname', 'address', 'gender', 'birth_date', 'identity_number', 'birth_place'];
}
