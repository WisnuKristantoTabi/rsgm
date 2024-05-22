<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\RecordMedicalModel;
use App\Models\TransactionPublicModel;

class ReturnDocument extends BaseController
{
    /**
     * Instance of the main Request object.
     *
     * @var HTTP\IncomingRequest
     */
    protected $request;

    public function index()
    {
        $tpModels = new TransactionPublicModel();
        $data['trasactions'] = $tpModels
            ->select('transaction.id as tid,transaction.rm_id as idrm, public_doc.fullname, 
            service_unit.service_name, transaction.loan_date, public_doc.phone,
            transaction.return_date, transaction.deadline, transaction.is_return')
            ->join('transaction', 'transaction.id = transaction_public.transaction_id')
            ->join('public_doc', 'public_doc.id = transaction_public.public_id')
            ->join('service_unit', 'service_unit.id = public_doc.service_id')
            ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            // ->where('is_return', 2)
            ->orderBy('return_date', 'desc')
            ->paginate(20, 'returndoc');
        $data['title'] = 'Pengembalian Rekam Medis';
        $data['pager'] = $tpModels->pager;
        $data['nomor'] = nomor($this->request->getVar('page_returndoc'), 20);
        $data['role'] = session()->get('role');
        $data['type'] = 1;
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 5;
        $data['username'] = session()->get('username');
        return view('returndocument/index', $data);
    }

    public function sendmessage()
    {
        $message = $this->request->getVar('message');
        $phone = $this->request->getVar('phone');
        return redirect()->to('https://wa.me/' . '62' . $phone . "?text=" . $message);
    }

    public function show($id)
    {
        $tpModel = new TransactionPublicModel();
        $transaction = $tpModel
            ->select('transaction.id,transaction.rm_id, medical_records.fullname,
             service_unit.service_name, transaction.loan_date, 
             transaction.return_date, transaction.return_desc')
            ->join('transaction', 'transaction.id = transaction_public.transaction_id')
            ->join('public_doc', 'public_doc.id = transaction_public.public_id')
            ->join('medical_records', 'medical_records.rm_id = transaction.rm_id')
            ->join('service_unit', 'service_unit.id = public_doc.service_id')
            ->getWhere(['transaction.id' => $id])
            ->getRow();
        if (isset($transaction)) {
            $data['title'] = 'Tampilkan Pengembalian';
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

        return view('returndocument/add', $data);
    }

    public function edit($id)
    {

        $transactionModels = new TransactionModel();
        $transaction = $transactionModels
            ->select('transaction.id,transaction.rm_id, medical_records.fullname,service_name, 
            transaction.loan_date, transaction.return_date, transaction.return_desc ')
            ->join('medical_records', 'medical_records.rm_id = transaction.rm_id')
            ->join('service_unit', 'service_unit.id = medical_records.service_unit')
            ->getWhere(['transaction.id' => $id])->getRow();
        if (isset($transaction)) {
            $data['title'] = 'Edit Pengembalian';
            $data['username'] = session()->get('username');
            $data['role'] = session()->get('role');
            $data['pagesidebar'] = 3;
            $data['subsidebar'] = 5;
            $data['transaction'] = $transaction;
            return view('returndocument/edit', $data);
        } else {
            session()->setFlashdata('error', 'Data Tidak Berhasil Di edit');
            return redirect()->to('returndoc');
        }
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
                return redirect()->to('/returndoc');
            } else {
                $session->setFlashdata('error', "Data Tidak Ditemukan");
                return redirect()->to('returndoc');
            }
        } else {
            $msg = $this->validator->listErrors();
            $session->setFlashdata('error', $msg);
            return redirect()->to('returndoc/add');
        }
    }

    public function verif($id)
    {
        $session = session();
        $transactionModel = new TransactionModel();

        if ($transactionModel->find($id)) {
            $data = [
                'return_date'      => date('Y-m-d'),
                'is_return'        => 2,
            ];
            $transactionModel->update($id, $data);
            $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
            return redirect()->to('/returndoc');
        } else {
            $session->setFlashdata('error', "Data Tidak Ditemukan");
            return redirect()->to('returndoc');
        }
    }

    // public function store()
    // {
    //     $session = session();

    //     $rules = [
    //         'rmid'               => 'required|min_length[2]|max_length[50]|is_unique[medical_records.rm_id]',
    //         'fullname'           => 'required|min_length[2]|max_length[50]',
    //         'address'            => 'required|min_length[2]|max_length[100]',
    //         'gender'             => 'required',
    //         'birthday'           => 'required',
    //         'serviceunit'        => 'required',
    //     ];

    //     if ($this->validate($rules)) {
    //         $recordmedicalModel = new RecordMedicalModel();
    //         $data = [
    //             'rm_id'          => $this->request->getVar('rmid'),
    //             'fullname'      => $this->request->getVar('fullname'),
    //             'address'       => $this->request->getVar('address'),
    //             'gender'        => $this->request->getVar('gender'),
    //             'birth_date'      => $this->request->getVar('birthday'),
    //             'service_unit'   => $this->request->getVar('serviceunit'),
    //         ];
    //         $recordmedicalModel->save($data);
    //         $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
    //         return redirect()->to('/recordmedical');
    //     } else {
    //         $msg = $this->validator->listErrors();
    //         $session->setFlashdata('error', $msg);
    //         return redirect()->to('recordmedical/add');
    //     }
    // }

    // public function edit($id)
    // {
    //     $data['username'] = session()->get('username');
    //     $recordmedicalModel = new RecordMedicalModel();
    //     $serviceunitmodel = new ServiceUnitModel();
    //     $recordmedicals = $recordmedicalModel->getWhere(['id' => $id])->getRow();
    //     if (isset($recordmedicals)) {
    //         $data['recordmedicals'] = $recordmedicals;
    //         $data['title']  = 'Edit Rekam Medis No. ' . $recordmedicals->rm_id;
    //         $data['serviceunits'] = $serviceunitmodel->findAll();

    //         return view('recordmedical/edit', $data);
    //     } else {
    //         session()->setFlashdata('error', 'Data Tidak Berhasil Di edit');
    //         return redirect()->to('recordmedical');
    //     }
    // }

    // public function update()
    // {
    //     $recordmedicalModel = new RecordMedicalModel();
    //     $id = $this->request->getPost('recordId');
    //     $data = array(
    //         'rm_id'         => $this->request->getPost('rmid'),
    //         'fullname'      => $this->request->getPost('fullname'),
    //         'address'       => $this->request->getPost('address'),
    //         'gender'        => $this->request->getPost('gender'),
    //         'birth_date'    => $this->request->getPost('birthdate'),
    //         'service_unit'  => $this->request->getPost('serviceunit'),
    //     );
    //     if ($recordmedicalModel->find($id)) {
    //         $recordmedicalModel->update($id, $data);
    //         session()->setFlashdata('success', 'Data Berhasil Di edit');
    //         return redirect()->to('recordmedical/edit/' . $id);
    //     } else {
    //         echo "Data Tidak Ditemukan";
    //     }
    // }

    public function delete($id)
    {
        $trasactionModels = new TransactionModel();

        $check = $trasactionModels->find($id);
        if ($check) {
            $trasactionModels->update($id, ['is_return' => 1]);
            session()->setFlashdata('success', 'Data Berhasil Di Hapus');
            return redirect()->to('/returndoc/');
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('/returndoc/');
        }
    }

    public function find()
    {
        $postData = $this->request->getVar('searchTerm');

        $response = array();
        $tpModel = new TransactionPublicModel();

        if (!isset($postData)) {
            // Fetch record
            $transactions = $tpModel->select('transaction.id,transaction.rm_id,public_doc.fullname')
                ->join('transaction', 'transaction.id = transaction_public.transaction_id')
                ->join('public_doc', 'public_doc.id = transaction_public.public_id')
                ->orderBy('transaction.rm_id')
                ->where(['loan_type' => 1, 'is_return' => 2])
                ->findAll(5);
        } else {
            $searchTerm = $postData;

            // Fetch record
            $transactions = $tpModel->select('transaction.id,transaction.rm_id,public_doc.fullname')
                ->join('transaction', 'transaction.id = transaction_public.transaction_id')
                ->join('public_doc', 'public_doc.id = transaction_public.public_id')
                ->like('fullname', $searchTerm)
                ->orLike('transaction.rm_id', $searchTerm)
                ->orderBy('transaction.id')
                ->where(['loan_type' => 1, 'is_return' => 2])
                ->findAll(5);
        }

        $data = array();
        foreach ($transactions as $transaction) {
            $data[] = array(
                "id" => $transaction['id'],
                "text" => 'ID: ' . $transaction['id'] . ', Nama: ' . $transaction['fullname'] . ', RM.ID: ' . $transaction['rm_id'],
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($data);
    }

    public function searchData()
    {

        $postData = $this->request->getVar('searchTerm');

        $response = array();
        $tpModel = new TransactionPublicModel();

        if (!isset($postData)) {
            // Fetch record
            $transactions = $tpModel->select('transaction.id,transaction.rm_id')
                ->join('transaction', 'transaction.id = transaction_public.transaction_id')
                ->where('is_return', 1)
                ->where('loan_type', 1)
                ->orderBy('transaction.loan_date')
                ->findAll(5);
        } else {

            $transactions = $tpModel->select('transaction.id,transaction.rm_id')
                ->join('transaction', 'transaction.id = transaction_public.transaction_id')
                ->like('id', $postData)
                ->where('is_return', 1)
                ->where('loan_type', 1)
                ->orderBy('transaction.loan_date')
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
        $tpModel = new TransactionPublicModel();
        $transactions = $tpModel
            ->select('transaction.id,transaction.rm_id, medical_records.fullname,service_unit.service_name, transaction.loan_date ')
            ->join('transaction', 'transaction.id = transaction_public.transaction_id')
            ->join('public_doc', 'public_doc.id = transaction_public.public_id')
            ->join('service_unit', 'service_unit.id = public_doc.service_id')
            ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            ->where('transaction.id', $postData)
            ->where('loan_type', 1)
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
