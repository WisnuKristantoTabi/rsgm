<?php

namespace App\Controllers;

use App\Models\RecordMedicalModel;
use Picqer\Barcode\BarcodeGeneratorHTML;

class Find extends BaseController
{

    public function find()
    {
        // $generator = new BarcodeGeneratorHTML();
        // $recordmedicalModel = new RecordMedicalModel();
        // $data['profile'] = $recordmedicalModel->join('service_unit', 'service_unit.id = medical_records.service_unit')->getWhere(['medical_records.rm_id' => $id])->getRow();
        // $data['title'] = 'Detail Rekam Medis';
        // $data['username'] = session()->get('username');
        // $data['barcode'] = $generator->getBarcode('rsgm-unej.youtoimage.com/f/' . $id, $generator::TYPE_CODE_128, 1);

        return view('recordmedical/find');
    }
}
