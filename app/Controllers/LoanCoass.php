<?php

namespace App\Controllers;

// use App\Models\RecordMedicalModel;
use App\Models\CoassModel;
use App\Models\TransactionModel;
use App\Models\TransactionCoassModel;
use App\Models\ServiceUnitModel;
use Picqer\Barcode\BarcodeGeneratorHTML;

class LoanCoass extends BaseController
{
    /**
     * Instance of the main Request object.
     *
     * @var HTTP\IncomingRequest
     */
    protected $request;

    public function index()
    {
        // $recordmedicalModel = new RecordMedicalModel();
        $tcmodels = new TransactionCoassModel();
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 4;
        $data['role'] = session()->get('role');
        $data['coassmodels'] = $tcmodels
            ->select('coass_doc.coass_name,coass_doc.clinic_name,coass_doc.coass_number,
           coass_doc.phone, transaction_coass.transaction_id, medical_records.fullname as patient')
            ->join('transaction', 'transaction.id = transaction_coass.transaction_id')
            ->join('coass_doc', 'coass_doc.id = transaction_coass.coass_id')
            ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            ->orderBy('coass_date', 'desc')
            ->paginate(20, 'loancoass');
        $data['pager'] = $tcmodels->pager;
        $data['nomor'] = nomor($this->request->getVar('page_loancoass'), 20);
        $data['title'] = 'Peminjaman Coass';
        $data['type'] = 2;
        $data['username'] = session()->get('username');
        return view('coassloan/index', $data);
    }

    // public function show($id)
    // {
    //     $generator = new BarcodeGeneratorHTML();
    //     $recordmedicalModel = new RecordMedicalModel();
    //     $data['profile'] = $recordmedicalModel->join('service_unit', 'service_unit.id = medical_records.service_unit')->getWhere(['medical_records.rm_id' => $id])->getRow();
    //     $data['title'] = 'Detail Rekam Medis';
    //     $data['username'] = session()->get('username');
    //     $data['barcode'] = $generator->getBarcode($id, $generator::TYPE_CODE_128, 1);
    //     return view('recordmedical/show', $data);
    //     // print_r($data);
    // }

    public function add()
    {

        $serviceUnitModels = new ServiceUnitModel();
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 4;
        $data['role'] = session()->get('role');
        $data['title'] = 'Tambah Pinjaman COASS';
        $data['username'] = session()->get('username');
        $data['serviceunits'] = $serviceUnitModels->findAll();

        return view('coassloan/add', $data);
    }

    public function store()
    {
        $session = session();

        $rules = [
            'rmid'                 => 'required|min_length[2]|max_length[50]|',
            'coassid'              => 'required',
            'loandate'             => 'required',
            'deadline'             => 'required',
            'service'              => 'required',
        ];
        $transactionmodels = new TransactionModel();
        $tcmodels = new TransactionCoassModel();

        if ($this->validate($rules)) {

            $transactiondata = [
                'rm_id'          => $this->request->getPost('rmid'),
                'loan_date'      => $this->request->getPost('loandate'),
                'loan_type'      => 2,
                'loan_desc'      => implode(" ", $this->request->getPost('loandesc')),
                'deadline'       => $this->request->getPost('deadline'),
                'is_return'      => 1,
                'service_id'     => $this->request->getPost('service')
            ];

            $transactionmodels->insert($transactiondata);
            $tcmodels->save([
                'transaction_id'    => $transactionmodels->getInsertId(),
                'coass_id'          =>  $this->request->getPost('coassid')
            ]);

            $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
            return redirect()->to('f?id=' . $transactionmodels->getInsertId());
        } else {
            $msg = $this->validator->listErrors();
            $session->setFlashdata('error', $msg);
            return redirect()->to('loancoass/add');
        }
    }

    public function edit($id)
    {
        $data['username'] = session()->get('username');
        $data['role'] = session()->get('role');


        $tcModels = new TransactionCoassModel();
        $serviceUnitModels = new ServiceUnitModel();
        $tcData = $tcModels->select('transaction.rm_id, coass_doc.coass_name, transaction.deadline,  
        coass_doc.coass_number, coass_doc.coass_date, coass_doc.clinic_name, transaction.loan_date, coass_doc.phone,
        medical_records.fullname, transaction.id as tid, coass_doc.id as coassid, transaction.service_id')
            ->join('transaction', 'transaction.id = transaction_coass.transaction_id')
            ->join('coass_doc', 'coass_doc.id = transaction_coass.coass_id')
            ->join('medical_records', 'medical_records.rm_id = transaction.rm_id')
            ->getWhere(['transaction.id' => $id, 'loan_type' => 2])
            ->getRow();

        if ($tcModels->where(['transaction_id' => $id])->first()) {
            $data['transactions'] = $tcData;
            $data['serviceunits'] = $serviceUnitModels->findAll();
            $data['title']  = 'Edit Data Pinjaman Coass';
            $data['pagesidebar'] = 3;
            $data['subsidebar'] = 4;
            return view('coassloan/edit', $data);
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('/loancoass');
        }
    }

    public function update()
    {
        $id = $this->request->getPost('tid');
        $rules = [
            'rmid'                 => 'required|min_length[2]|max_length[50]|',
            'coassid'              => 'required',
            'loandate'             => 'required',
            'deadline'             => 'required',
            'service'              => 'required',
        ];

        $transactionmodels = new TransactionModel();
        $tcModels = new TransactionCoassModel();

        if ($this->validate($rules)) {

            $transactiondata = [
                'rm_id'          => $this->request->getPost('rmid'),
                'loan_date'      => $this->request->getPost('loandate'),
                'loan_type'      => 2,
                // 'loan_desc'      => implode(" ", $this->request->getPost('loandesc')),
                'deadline'       => $this->request->getPost('deadline'),
                'is_return'      => 1,
                'service_id'     => $this->request->getPost('service')
            ];

            if ($transactionmodels->find(['id' => $id])) {
                $transactionmodels->update($id, $transactiondata);
                $tcModels->set(['coass_id' => $this->request->getPost('coassid')])->where('transaction_id', $id)->update();
                session()->setFlashdata('success', 'Data Berhasil Di edit');
                return redirect()->to('f?id=' . $id);
            } else {
                session()->setFlashdata('error', 'Data Tidak Berhasil Di edit');
                return redirect()->to('loancoass/edit/' . $id);
            }
        } else {
            $msg = $this->validator->listErrors();
            session()->setFlashdata('error', $msg);
            return redirect()->to('loancoass/edit/' . $id);
        }
    }

    public function delete($id)
    {
        $tcModels = new TransactionCoassModel();
        $transactionmodels = new TransactionModel();

        $check = $transactionmodels->find($id);
        if ($check) {
            $transactionmodels->delete(['id' => $id]);
            $tcModels->where('transaction_id', $id)->delete();
            session()->setFlashdata('success', 'Data Berhasil Di Hapus');
            return redirect()->to('loancoass/');
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('loancoass/');
        }
    }

    public function searchCoass()
    {
        $postData = $this->request->getVar('searchTerm');

        $response = array();
        $coassModels = new CoassModel();

        if (!isset($postData)) {
            // Fetch record
            $coassData = $coassModels->select('id,coass_name,coass_number')
                ->orderBy('id')
                ->findAll(5);
        } else {
            $coassData = $coassModels->select('id,coass_name,coass_number')
                ->like('coass_name', $postData)
                ->orLike('coass_number')
                ->orderBy('id')
                ->findAll(5);
        }

        $data = array();
        foreach ($coassData as $coass) {
            $data[] = array(
                "id" => $coass['id'],
                "text" => $coass['coass_name'] . ' - ' . $coass['coass_number'],
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }

    public function showCoass()
    {
        $postData = $this->request->getVar('id');
        $coassModels = new CoassModel();
        $coassData = $coassModels->select('id,coass_name,coass_number,phone,coass_date,clinic_name')
            ->where('id', $postData)
            ->orderBy('id')
            ->get();

        $data = array();
        foreach ($coassData->getResult() as $coass) {
            $data[] = array(
                "id"            => $coass->id,
                "coassname"    => $coass->coass_name,
                "coassnumber"  => $coass->coass_number,
                "phone"         => $coass->phone,
                "coassdate"    => $coass->coass_date,
                "clinicname"   => $coass->clinic_name,
            );
            break;
        }
        return $this->response->setJSON($data);
    }
}
