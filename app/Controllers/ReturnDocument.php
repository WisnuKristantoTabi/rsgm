<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\RecordMedicalModel;

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
        $trasactionModels = new TransactionModel();
        $data['trasactions'] = $trasactionModels
            ->select('transaction.id as tid,transaction.rm_id as idrm, public_doc.fullname, 
            service_unit.service_name, transaction.loan_date, transaction.phone,
            transaction.return_date, transaction.deadline ')
            ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            ->join('public_doc', 'public_doc.transaction_id = transaction.id')
            ->join('service_unit', 'service_unit.id = medical_records.service_unit')
            ->orderBy('return_date', 'asc')
            ->paginate(20, 'returndoc');
        $data['title'] = 'Pengembalian Rekam Medis';
        $data['pager'] = $trasactionModels->pager;
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
        return redirect()->to('https://wa.me/' . $phone . "?text=" . $message);
    }

    // public function show($id)
    // {
    //     $recordmedicalModel = new RecordMedicalModel();
    //     $data['profile'] = $recordmedicalModel->join('service_unit', 'service_unit.id = medical_records.service_unit')->getWhere(['medical_records.id' => $id])->getRow();
    //     $data['title'] = 'Detail Rekam Medis';
    //     $data['username'] = session()->get('username');
    //     return view('recordmedical/show', $data);
    //     // print_r($data);
    // }

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

    // public function delete($id)
    // {
    //     $recordmedicalModel = new RecordMedicalModel();

    //     $check = $recordmedicalModel->find($id);
    //     if ($check) {
    //         $recordmedicalModel->delete($id);
    //         session()->setFlashdata('success', 'Data Berhasil Di Hapus');
    //         return redirect()->to('recordmedical/');
    //     } else {
    //         session()->setFlashdata('error', 'Data Tidak Ditemukan');
    //         return redirect()->to('recordmedical/');
    //     }
    // }
    public function searchData()
    {

        $postData = $this->request->getVar('searchTerm');

        $response = array();

        if (!isset($postData)) {
            // Fetch record
            $transactionModel = new TransactionModel();

            $transactions = $transactionModel->select('id,fullname')
                ->orderBy('rm_id')
                ->findAll(5);
        } else {
            $searchTerm = $postData;

            // Fetch record
            $transactionModel = new TransactionModel();
            $transactions = $transactionModel->select('rm_id ,fullname')
                ->like('rm_id', $searchTerm)
                ->orderBy('rm_id')
                ->findAll(5);
        }

        $data = array();
        foreach ($transactions as $transaction) {
            $data[] = array(
                "id" => $transaction['rm_id'],
                "text" => $transaction['fullname'] . " - " . $transaction['rm_id'],
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }
}
