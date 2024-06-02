<?php

namespace App\Controllers;

use App\Models\RecordMedicalModel;
use App\Models\ServiceUnitModel;
use App\Libraries\Headerpdf;
use App\Models\TransactionModel;
use Picqer\Barcode\BarcodeGeneratorHTML;

class RecordMedical extends BaseController
{
    /**
     * Instance of the main Request object.
     *
     * @var HTTP\IncomingRequest
     */
    protected $request;

    public function index()
    {
        $recordmedicalModel = new RecordMedicalModel();
        $data['role'] = session()->get('role');
        $data['recordmedicals'] = $recordmedicalModel->orderBy('rm_id', 'desc')->paginate(20, 'recordmedicals');
        $data['pager'] = $recordmedicalModel->pager;
        $data['nomor'] = nomor($this->request->getVar('page_recordmedicals'), 20);
        $data['title'] = 'Rekam Medis';
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 1;
        $data['username'] = session()->get('username');
        return view('recordmedical/index', $data);
    }

    public function show($id)
    {
        $generator = new BarcodeGeneratorHTML();
        $recordmedicalModel = new RecordMedicalModel();
        $data['role'] = session()->get('role');
        $data['profile'] = $recordmedicalModel->select('fullname,identity_number,address,gender,birth_date,rm_id,birth_place  ')
            ->getWhere(['medical_records.rm_id' => $id])->getRow();
        $data['title'] = 'Detail Rekam Medis';
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 1;
        $data['username'] = session()->get('username');
        $data['barcode'] = $generator->getBarcode($id, $generator::TYPE_CODE_128, 1);
        return view('recordmedical/show', $data);
        // print_r($data);
    }

    public function add()
    {
        $serviceunitmodel = new ServiceUnitModel();
        $data['title'] = 'Tambah Rekam Medis';
        $data['role'] = session()->get('role');
        $data['username'] = session()->get('username');
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 1;

        return view('recordmedical/add', $data);
    }

    public function store()
    {
        $session = session();

        $rules = [
            'rmid'               => 'required|min_length[2]|max_length[50]|is_unique[medical_records.rm_id]',
            'fullname'           => 'required|min_length[2]|max_length[50]',
            'address'            => 'required|min_length[2]|max_length[100]',
            'identitynumber'     => 'required',
            'gender'             => 'required',
            'birthday'           => 'required',
            'birthplace'         => 'required',

        ];

        if ($this->validate($rules)) {
            $recordmedicalModel = new RecordMedicalModel();
            $data = [
                'rm_id'             => $this->request->getVar('rmid'),
                'fullname'          => $this->request->getVar('fullname'),
                'identity_number'   => $this->request->getVar('identitynumber'),
                'address'           => $this->request->getVar('address'),
                'gender'            => $this->request->getVar('gender'),
                'birth_date'        => $this->request->getVar('birthday'),
                'birth_place'       => $this->request->getVar('birthplace'),
                'is_return'         => 2,
            ];
            $recordmedicalModel->save($data);
            $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
            return redirect()->to('/recordmedical');
        } else {
            $msg = $this->validator->listErrors();
            $session->setFlashdata('error', $msg);
            return redirect()->to('recordmedical/add');
        }
    }

    public function edit($id)
    {
        $data['username'] = session()->get('username');
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 1;
        $data['role'] = session()->get('role');
        $recordmedicalModel = new RecordMedicalModel();
        $recordmedicals = $recordmedicalModel->getWhere(['id' => $id])->getRow();
        if (isset($recordmedicals)) {
            $data['recordmedicals'] = $recordmedicals;
            $data['title']  = 'Edit Rekam Medis No. ' . $recordmedicals->rm_id;
            return view('recordmedical/edit', $data);
        } else {
            session()->setFlashdata('error', 'Data Tidak Berhasil Di edit');
            return redirect()->to('recordmedical');
        }
    }

    public function update()
    {
        $recordmedicalModel = new RecordMedicalModel();
        $id = $this->request->getPost('recordId');
        $data = array(
            'rm_id'             => $this->request->getPost('rmid'),
            'fullname'          => $this->request->getPost('fullname'),
            'identity_number'   => $this->request->getPost('identitynumber'),
            'address'           => $this->request->getPost('address'),
            'gender'            => $this->request->getPost('gender'),
            'birth_date'        => $this->request->getPost('birthday'),
            'birth_place'       => $this->request->getPost('birthplace'),

        );
        if ($recordmedicalModel->find($id)) {
            $recordmedicalModel->update($id, $data);
            session()->setFlashdata('success', 'Data Berhasil Di edit');
            return redirect()->to('recordmedical/edit/' . $id);
        } else {
            echo "Data Tidak Ditemukan";
        }
    }

    public function delete($id)
    {
        $recordmedicalModel = new RecordMedicalModel();

        $check = $recordmedicalModel->find($id);
        if ($check) {
            $recordmedicalModel->delete($id);
            session()->setFlashdata('success', 'Data Berhasil Di Hapus');
            return redirect()->to('recordmedical/');
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('recordmedical/');
        }
    }

    public function test()
    {
        // helper(['num_to_month']);
        // echo nomor(1, 20);
        echo tanggal();
    }

    public function searchData()
    {

        $postData = $this->request->getVar('searchTerm');

        $response = array();
        $db = \Config\Database::connect();

        $subQuery = $db->table('transaction')
            ->select('rm_id, MAX(id) as latest_transaction_id')
            ->groupBy('rm_id')
            ->getCompiledSelect();
        $recordmedicalModel = new RecordMedicalModel();
        if (!isset($postData)) {
            // Fetch record
            $recordmedicals = $recordmedicalModel->select('medical_records.rm_id, fullname')
                // ->join("($subQuery) as latest_trans", 'medical_records.rm_id = latest_trans.rm_id', 'left')
                // ->join('transaction', 'latest_trans.latest_transaction_id = transaction.id', 'left')
                // ->groupStart()  // Mulai grup kondisi
                ->where('medical_records.is_return', 2)
                // ->orWhere('transaction.is_return IS NULL')
                // ->groupEnd()
                ->orderBy('medical_records.rm_id')
                ->findAll(5);
        } else {
            $recordmedicals = $recordmedicalModel->select('medical_records.rm_id, fullname')
                ->like('medical_records.rm_id', $postData)
                ->orLike('medical_records.fullname', $postData)
                ->where('medical_records.is_return', 2)
                ->orderBy('medical_records.rm_id')
                ->findAll(5);
        }

        $data = array();
        foreach ($recordmedicals as $record) {
            $data[] = array(
                "id" => $record['rm_id'],
                "text" => $record['fullname'] . " - " . $record['rm_id'],
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }
}
