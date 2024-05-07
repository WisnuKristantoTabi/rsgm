<?php

namespace App\Controllers;

// use App\Models\RecordMedicalModel;
use App\Models\PublicModel;
use App\Models\TransactionModel;
use Picqer\Barcode\BarcodeGeneratorHTML;

class LoanPublic extends BaseController
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
        $coassmodels = new PublicModel();
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 4;
        $data['role'] = session()->get('role');
        $data['coassmodels'] = $coassmodels->paginate(20, 'publiccoass');
        $data['pager'] = $coassmodels->pager;
        $data['nomor'] = nomor($this->request->getVar('page_loancoass'), 20);
        $data['title'] = 'Peminjaman Umum';
        $data['type'] = 1;
        $data['username'] = session()->get('username');
        return view('publicloan/index', $data);
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
        // $serviceunitmodel = new ServiceUnitModel();
        $coassmodels = new PublicModel();
        $data['title'] = 'Tambah Pinjaman Umum';
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 4;
        $data['role'] = session()->get('role');
        $data['username'] = session()->get('username');
        $data['coassmodels'] = $coassmodels->findAll();

        return view('publicloan//add', $data);
    }

    public function store()
    {
        $session = session();

        $rules = [
            'rmid'                  => 'required|min_length[2]|max_length[50]|',
            'fullname'              => 'required|min_length[2]|max_length[200]',
            'identitynumber'        => 'required|min_length[2]|max_length[100]',
            'phone'                 => 'required|min_length[2]',
            'address'               => 'required',
            'loandate'              => 'required',
            'deadline'              => 'required',
        ];
        $publicmodels = new PublicModel();
        $transactionmodels = new TransactionModel();

        if ($this->validate($rules)) {

            $transactiondata = [
                'rm_id'          => $this->request->getPost('rmid'),
                'loan_date'      => $this->request->getPost('loandate'),
                'loan_type'      => 1,
                'loan_desc'      => '-',
                'phone'          => $this->request->getPost('phone'),
                'deadline'       => $this->request->getPost('deadline'),
                'is_return'      => 1,
            ];

            $transactionmodels->insert($transactiondata);

            $publicdata = [
                'rm_id'                 => $this->request->getPost('rmid'),
                'fullname'              => $this->request->getPost('fullname'),
                'identity_number'       => $this->request->getPost('identitynumber'),
                'address'               => $this->request->getPost('address'),
                'transaction_id'        => $transactionmodels->getInsertId(),
            ];


            $publicmodels->save($publicdata);
            $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
            return redirect()->to('f?id=' . $transactionmodels->getInsertId());
        } else {
            $msg = $this->validator->listErrors();
            $session->setFlashdata('error', $msg);
            return redirect()->to('/loanpublic/add');
        }
        // $data = [
        //     'rm_id'          => $this->request->getPost('rmid'),
        //     'coass_name'      => $this->request->getPost('fullname'),
        //     'clinic_name'       => $this->request->getPost('clinic'),
        //     'coass_number'        => $this->request->getPost('coassnumber'),
        //     'coass_date'      => $this->request->getPost('onsitedate'),
        //     'coass_phone'   => $this->request->getPost('phone'),
        //     'loan_desc'        => $this->request->getPost('loandesc[]'),
        //     'loan_date'      => $this->request->getPost('loandate'),
        // ];
        // print_r($data);
    }

    public function edit($id)
    {
        $data['username'] = session()->get('username');
        $data['role'] = session()->get('role');
        $transactionmodels = new TransactionModel();
        $transactions = $transactionmodels->select('transaction.rm_id, public_doc.fullname as patientname, transaction.deadline,
        transaction.phone, public_doc.identity_number, public_doc.address, transaction.loan_date,
        medical_records.fullname, transaction.id as tid  ')
            ->join('medical_records', 'medical_records.rm_id = transaction.rm_id')
            ->join('public_doc', 'public_doc.transaction_id = transaction.id')
            ->getWhere(['transaction.id' => $id, 'loan_type' => 1])
            ->getRow();

        if ($transactionmodels->find(['transaction.id' => $id, 'loan_type' => 1])) {
            $data['transaction'] = $transactions;
            $data['title']  = 'Edit Rekam Medis No. ' . $transactions->rm_id;
            $data['pagesidebar'] = 3;
            $data['subsidebar'] = 4;
            // dd($data);
            return view('publicloan/edit', $data);
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('/loanpublic');
        }
    }

    public function update()
    {
        $id = $this->request->getPost('tid');
        $rules = [
            'rmid'                  => 'required|min_length[2]|max_length[50]|',
            'fullname'              => 'required|min_length[2]|max_length[200]',
            'identitynumber'        => 'required|min_length[2]|max_length[100]',
            'phone'                 => 'required|min_length[2]',
            'address'               => 'required',
            'loandate'              => 'required',
            'deadline'              => 'required',
        ];

        $publicmodels = new PublicModel();
        $transactionmodels = new TransactionModel();

        if ($this->validate($rules)) {

            $transactiondata = [
                'rm_id'                 => $this->request->getPost('rmid'),
                'loan_date'             => $this->request->getPost('loandate'),
                'loan_desc'             => implode(" ", $this->request->getPost('loandesc')),
                'deadline'       => $this->request->getPost('deadline'),
                'phone'                 => $this->request->getPost('phone'),
            ];

            $publicdata = [
                'rm_id'                 => $this->request->getPost('rmid'),
                'fullname'              => $this->request->getPost('fullname'),
                'identity_number'       => $this->request->getPost('identitynumber'),
                'address'               => $this->request->getPost('address'),
            ];

            if ($transactionmodels->find(['id' => $id])) {
                $transactionmodels->update($id, $transactiondata);
                $publicmodels->where('transaction_id', $id)->set($publicdata)->update();

                session()->setFlashdata('success', 'Data Berhasil Di edit');
                return redirect()->to('loanpublic/edit/' . $id);
            } else {
                session()->setFlashdata('error', 'Data Tidak Berhasil Di edit');
                return redirect()->to('loanpublic/edit/' . $id);
            }
        } else {
            $msg = $this->validator->listErrors();
            session()->setFlashdata('error', $msg);
            return redirect()->to('/loanpublic/add');
        }
    }

    public function delete($id)
    {
        $publicmodels = new PublicModel();
        $transactionmodels = new TransactionModel();

        $check = $transactionmodels->find($id);
        if ($check) {
            $transactionmodels->delete(['id' => $id]);
            $publicmodels->where('transaction_id', $id)->delete();
            session()->setFlashdata('success', 'Data Berhasil Di Hapus');
            return redirect()->to('loanpublic/');
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('loanpublic/');
        }
    }
}
