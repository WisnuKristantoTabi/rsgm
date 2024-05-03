<?php

namespace App\Controllers;

use App\Models\RecordMedicalModel;
use Picqer\Barcode\BarcodeGeneratorHTML;

class Tracer extends BaseController
{

    public function find($id)
    {

        $recordmedicalModel = new RecordMedicalModel();
        $generator = new BarcodeGeneratorHTML();
        $data['data'] = $recordmedicalModel
            ->select('transaction.id as tid , medical_records.rm_id as id_rekam_medik, fullname,loan_date,loan_desc,service_name')
            ->join('transaction', 'medical_records.rm_id = transaction.rm_id')
            ->join('service_unit', 'service_unit.id = medical_records.service_unit')
            ->getwhere(['transaction.id' => $id])
            ->getRow();
        $data['title'] = 'Tracer Rekam Medis';
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 4;
        $data['role'] = session()->get('role');
        $data['username'] = session()->get('username');
        $data['barcode'] = $generator->getBarcode($id, $generator::TYPE_CODE_128, 1);
        // print_r($data);
        return view('recordmedical/find', $data);
    }

    public function findloan()
    {
        $recordmedicalModel = new RecordMedicalModel();
        $generator = new BarcodeGeneratorHTML();
        $id = $this->request->getVar('id');
        $data['data'] = $recordmedicalModel
            ->select('transaction.id as tid , medical_records.rm_id as id_rekam_medik, fullname,loan_date,loan_desc,service_name')
            ->join('transaction', 'medical_records.rm_id = transaction.rm_id')
            ->join('service_unit', 'service_unit.id = medical_records.service_unit')
            ->getwhere(['transaction.id' => $id])
            ->getRow();
        $data['title'] = 'Tracer Rekam Medis';
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 4;
        $data['role'] = session()->get('role');
        $data['username'] = session()->get('username');
        $data['barcode'] = $generator->getBarcode($id, $generator::TYPE_CODE_128, 1);
        // print_r($data);
        return view('recordmedical/find', $data);
    }
}
