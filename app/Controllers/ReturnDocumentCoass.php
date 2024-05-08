<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\RecordMedicalModel;

class ReturnDocumentCoass extends BaseController
{
    /**
     * Instance of the main Request object.
     *
     * @var HTTP\IncomingRequest
     */
    protected $request;

    public function index()
    {
        $trasactionModels = new TransactionModel();
        $data['trasactions'] = $trasactionModels
            ->select('transaction.id as tid,transaction.rm_id as idrm,transaction.phone, coass_doc.coass_name, service_unit.service_name, transaction.loan_date, transaction.return_date, transaction.deadline ')
            ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            ->join('coass_doc', 'coass_doc.transaction_id = transaction.id')
            ->join('service_unit', 'service_unit.id = medical_records.service_unit')
            ->where('is_return', 2)
            ->orderBy('loan_date', 'asc')
            ->paginate(20, 'returndoc');
        $data['title'] = 'Pengembalian Dokumen Coass';
        $data['pager'] = $trasactionModels->pager;
        $data['nomor'] = nomor($this->request->getVar('page_returndoc'), 20);
        $data['role'] = session()->get('role');
        $data['type'] = 2;
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 5;
        $data['username'] = session()->get('username');
        return view('returndocument/index_coass', $data);
    }

    public function find()
    {
        $postData = $this->request->getVar('searchTerm');

        $response = array();

        if (!isset($postData)) {
            // Fetch record
            $transactionModel = new TransactionModel();

            $transactions = $transactionModel->select('transaction.id,transaction.rm_id,coass_doc.coass_name')
                ->join('coass_doc', 'coass_doc.transaction_id = transaction.id')
                ->where('loan_type', 2)
                ->orderBy('transaction.rm_id')
                ->findAll(5);
        } else {
            $searchTerm = $postData;

            // Fetch record
            $transactionModel = new TransactionModel();
            $transactions = $transactionModel->select('transaction.id,transaction.rm_id,coass_doc.coass_name')
                ->join('coass_doc', 'coass_doc.transaction_id = transaction.id')
                ->like('coass_doc.coass_name', $searchTerm)
                ->orLike('transaction.rm_id', $searchTerm)
                ->where('loan_type', 2)
                ->orderBy('transaction.id')
                ->findAll(5);
        }

        $data = array();
        foreach ($transactions as $transaction) {
            $data[] = array(
                "id" => $transaction['id'],
                "text" => 'ID: ' . $transaction['id'] . ', Nama: ' . $transaction['coass_name'] . ', RM.ID: ' . $transaction['rm_id'],
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($data);
    }
}
