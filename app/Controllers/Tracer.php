<?php

namespace App\Controllers;

use App\Models\RecordMedicalModel;
use App\Models\TransactionCoassModel;
use Picqer\Barcode\BarcodeGeneratorHTML;
use App\Models\TransactionModel;

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

    public function findloanpublic()
    {
        $recordmedicalModel = new RecordMedicalModel();
        $generator = new BarcodeGeneratorHTML();
        $id = $this->request->getVar('id');
        $transactionmodels = new TransactionModel();
        if ($transactionmodels->find(['id' => $id])) {
            $data['data'] = $recordmedicalModel
                ->select('transaction.id as tid , medical_records.rm_id as id_rekam_medik, medical_records.fullname,
            transaction.loan_date,transaction.loan_desc,service_unit.service_name')
                ->join('transaction', 'medical_records.rm_id = transaction.rm_id')
                ->join('transaction_public', 'transaction.id = transaction_public.transaction_id')
                ->join('public_doc', 'public_doc.id = transaction_public.public_id')
                ->join('service_unit', 'service_unit.id = public_doc.service_id')
                ->getwhere(['transaction.id' => $id])
                ->getRow();
            $data['title'] = 'Tracer Rekam Medis';
            $data['pagesidebar'] = 3;
            $data['subsidebar'] = 4;
            $data['role'] = session()->get('role');
            $data['username'] = session()->get('username');
            $data['barcode'] = $generator->getBarcode($id, $generator::TYPE_CODE_128, 1);
            // print_r($data);
            return view('publicloan/find', $data);
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('loanpublic');
        }
    }

    public function findloancoass()
    {
        $tcModel = new TransactionCoassModel();
        $generator = new BarcodeGeneratorHTML();
        $id = $this->request->getVar('id');
        $transactionmodels = new TransactionModel();
        if ($transactionmodels->find(['id' => $id])) {
            $data['data'] = $tcModel
                ->select('transaction.id as tid, medical_records.rm_id as id_rekam_medik, medical_records.fullname,
            transaction.loan_date,transaction.loan_desc,service_unit.service_name')
                ->join('transaction', 'transaction.id = transaction_coass.transaction_id')
                ->join('medical_records', 'medical_records.rm_id = transaction.rm_id')
                ->join('coass_doc', 'coass_doc.id = transaction_coass.coass_id')
                ->join('service_unit', 'coass_doc.service_id = service_unit.id')
                ->getwhere(['transaction.id' => $id])
                ->getRow();
            $data['title'] = 'Tracer Rekam Medis';
            $data['pagesidebar'] = 3;
            $data['subsidebar'] = 4;
            $data['role'] = session()->get('role');
            $data['username'] = session()->get('username');

            // print_r($data);
            $data['barcode'] = $generator->getBarcode($id, $generator::TYPE_CODE_128, 1);
            // // print_r($data);
            return view('coassloan/find', $data);
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('loancoass');
        }
    }
}
