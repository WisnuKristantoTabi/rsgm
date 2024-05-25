<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionCoassModel;
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
        $tcModels = new TransactionCoassModel();
        $data['trasactions'] = $tcModels
            ->select('transaction.id as tid,transaction.rm_id as idrm,coass_doc.phone, 
            coass_doc.coass_name, service_unit.service_name, transaction.loan_date, 
            transaction.return_date, transaction.deadline, transaction.is_return')
            ->join('transaction', 'transaction.id = transaction_coass.transaction_id')
            ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            ->join('coass_doc', 'coass_doc.id = transaction_coass.coass_id')
            ->join('service_unit', 'service_unit.id = coass_doc.service_id')
            // ->where('is_return', 2)
            ->orderBy('loan_date', 'desc')
            ->paginate(20, 'returndoc');
        $data['title'] = 'Pengembalian Dokumen Coass';
        $data['pager'] = $tcModels->pager;
        $data['nomor'] = nomor($this->request->getVar('page_returndoccoass'), 20);
        $data['role'] = session()->get('role');
        $data['type'] = 2;
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 5;
        $data['username'] = session()->get('username');
        return view('returndocument/index_coass', $data);
    }

    public function show($id)
    {
        $tcModel = new TransactionCoassModel();
        $transaction = $tcModel
            ->select('transaction.id,transaction.rm_id, medical_records.fullname,
             service_unit.service_name, transaction.loan_date, 
             transaction.return_date')
            ->join('transaction', 'transaction.id = transaction_coass.transaction_id')
            ->join('coass_doc', 'coass_doc.id = transaction_coass.coass_id')
            ->join('medical_records', 'medical_records.rm_id = transaction.rm_id')
            ->join('service_unit', 'service_unit.id = coass_doc.service_id')
            ->getWhere(['transaction.id' => $id])
            ->getRow();
        if (isset($transaction)) {
            $data['title'] = 'Tampilkan Pengembalian Coass';
            $data['username'] = session()->get('username');
            $data['role'] = session()->get('role');
            $data['pagesidebar'] = 3;
            $data['subsidebar'] = 5;
            $data['transaction'] = $transaction;
            return view('returndocument/show', $data);
        } else {
            session()->setFlashdata('error', 'Data Tidak Berhasil Di Tampilkan');
            return redirect()->to('returndoc');
        }
    }

    public function add()
    {
        // $serviceunitmodel = new ServiceUnitModel();
        $data['title'] = 'Tambah Pengembalian';
        $data['username'] = session()->get('username');
        $data['role'] = session()->get('role');
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 5;
        // $data['serviceunits'] = $serviceunitmodel->findAll();

        return view('returndocument/add_coass', $data);
    }

    public function update()
    {
        $session = session();
        $transactionModel = new TransactionModel();
        $id = $this->request->getPost('tid');
        $rules = [
            'returndate'   => 'required',
        ];

        if ($this->validate($rules)) {
            $data = [
                'return_date'      => $this->request->getPost('returndate'),
                'return_desc'      => $this->request->getPost('returndesc'),
                'is_return'        => 2,
            ];
            if ($transactionModel->find($id)) {
                $transactionModel->update($id, $data);
                $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
                return redirect()->to('/returndocoass');
            } else {
                $session->setFlashdata('error', "Data Tidak Ditemukan");
                return redirect()->to('returndocoass');
            }
        } else {
            $msg = $this->validator->listErrors();
            $session->setFlashdata('error', $msg);
            return redirect()->to('returndocoass/add');
        }
    }

    public function verif($id, $rmid)
    {
        $session = session();
        $transactionModel = new TransactionModel();
        $recordmedicalModel = new RecordMedicalModel();

        if ($transactionModel->find($id)) {
            $data = [
                'return_date'      => date('Y-m-d'),
                'is_return'        => 2,
            ];
            $transactionModel->update($id, $data);
            $recordmedicalModel->set(['is_return' => 2])->where('rm_id', $rmid)->update();
            $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
            return redirect()->to('/returndocoass');
        } else {
            $session->setFlashdata('error', "Data Tidak Ditemukan");
            return redirect()->to('/returndocoass');
        }
    }

    public function find()
    {
        $postData = $this->request->getVar('searchTerm');

        $response = array();
        $tcModel = new TransactionCoassModel();

        if (!isset($postData)) {
            // Fetch record

            $transactions = $tcModel->select('transaction.id,transaction.rm_id,coass_doc.coass_name')
                ->join('transaction', 'transaction.id = transaction_coass.transaction_id')
                ->join('coass_doc', 'coass_doc.id = transaction_coass.coass_id')
                ->where(['loan_type' => 2, 'is_return' => 2])
                ->orderBy('transaction.rm_id')
                ->findAll(5);
        } else {
            $searchTerm = $postData;
            $transactions = $tcModel->select('transaction.id,transaction.rm_id,coass_doc.coass_name')
                ->join('transaction', 'transaction.id = transaction_coass.transaction_id')
                ->join('coass_doc', 'coass_doc.id = transaction_coass.coass_id')
                ->like('coass_doc.coass_name', $searchTerm)
                ->orLike('transaction.rm_id', $searchTerm)
                ->where(['loan_type' => 2, 'is_return' => 2])
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

    public function searchData()
    {

        $postData = $this->request->getVar('searchTerm');

        $response = array();

        if (!isset($postData)) {
            // Fetch record
            $transactionModel = new TransactionModel();

            $transactions = $transactionModel->select('id,rm_id')
                ->where('is_return', 1)
                ->where('loan_type', 2)
                ->orderBy('id')
                ->findAll(5);
        } else {
            $searchTerm = $postData;

            // Fetch record
            $transactionModel = new TransactionModel();
            $transactions = $transactionModel->select('id , rm_id ')
                ->like('id', $searchTerm)
                ->where('is_return', 1)
                ->where('loan_type', 2)
                ->orderBy('id')
                ->findAll(5);
        }

        $data = array();
        foreach ($transactions as $transaction) {
            $data[] = array(
                "id" => $transaction['id'],
                "text" => 'ID : ' . $transaction['id'],
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }

    public function showData()
    {
        $postData = $this->request->getVar('id');
        $tcModel = new TransactionCoassModel();
        $transactions = $tcModel
            ->select('transaction.id,transaction.rm_id, medical_records.fullname,service_unit.service_name, transaction.loan_date ')
            ->join('transaction', 'transaction.id = transaction_coass.transaction_id')
            ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            ->join('coass_doc', 'coass_doc.id = transaction_coass.coass_id')
            ->join('service_unit', 'service_unit.id = coass_doc.service_id')
            ->where('transaction.id', $postData)
            ->where('loan_type', 2)
            ->orderBy('id')
            ->get();

        $data = array();
        foreach ($transactions->getResult() as $transaction) {
            $data[] = array(
                "tid" => $transaction->id,
                "rmid" => $transaction->rm_id,
                "patientname" => $transaction->fullname,
                "poli" => $transaction->service_name,
                "loandate" => $transaction->loan_date,
            );
            break;
        }
        return $this->response->setJSON($data);
    }
}
