<?php

namespace App\Controllers;

// use App\Models\RecordMedicalModel;
use App\Models\CoassModel;
use App\Models\TransactionModel;
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
        $coassmodels = new CoassModel();
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 4;
        $data['role'] = session()->get('role');
        $data['coassmodels'] = $coassmodels
            ->select('coass_name,clinic_name,coass_number,coass_date,transaction.phone, coass_doc.transaction_id')
            ->join('transaction', 'transaction.id = coass_doc.transaction_id')
            ->orderBy('coass_date', 'desc')
            ->paginate(20, 'loancoass');
        $data['pager'] = $coassmodels->pager;
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
        // $serviceunitmodel = new ServiceUnitModel();
        $coassmodels = new CoassModel();
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 4;
        $data['role'] = session()->get('role');
        $data['title'] = 'Tambah Pinjaman COASS';
        $data['username'] = session()->get('username');
        $data['coassmodels'] = $coassmodels->findAll();

        return view('coassloan/add', $data);
    }

    public function store()
    {
        $session = session();

        $rules = [
            'rmid'                  => 'required|min_length[2]|max_length[50]|',
            'fullname'              => 'required|min_length[2]|max_length[50]',
            'coassnumber'           => 'required|min_length[2]|max_length[100]',
            'phone'                 => 'required|min_length[2]',
            'onsitedate'            => 'required',
            'clinic'                => 'required',
            'loandate'              => 'required',
            'deadline'              => 'required',
        ];
        $coassmodels = new CoassModel();
        $transactionmodels = new TransactionModel();

        if ($this->validate($rules)) {

            $transactiondata = [
                'rm_id'          => $this->request->getPost('rmid'),
                'loan_date'      => $this->request->getPost('loandate'),
                'loan_type'      => 2,
                'loan_desc'      => implode(" ", $this->request->getPost('loandesc')),
                'phone'          => $this->request->getPost('phone'),
                'deadline'       => $this->request->getPost('deadline'),
            ];

            $transactionmodels->insert($transactiondata);

            $coassdata = [
                'rm_id'          => $this->request->getPost('rmid'),
                'coass_name'      => $this->request->getPost('fullname'),
                'clinic_name'       => $this->request->getPost('clinic'),
                'coass_number'        => $this->request->getPost('coassnumber'),
                'coass_date'      => $this->request->getPost('onsitedate'),
                'transaction_id' => $transactionmodels->getInsertId(),
            ];


            $coassmodels->save($coassdata);
            $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
            return redirect()->to('/loancoass/add');
        } else {
            $msg = $this->validator->listErrors();
            $session->setFlashdata('error', $msg);
            return redirect()->to('loancoass/add');
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
        $transactions = $transactionmodels->select('transaction.rm_id, coass_doc.coass_name, transaction.deadline,  
        coass_doc.coass_number, coass_doc.coass_date, clinic_name, transaction.loan_date,transaction.phone,
        medical_records.fullname, transaction.id as tid  ')
            ->join('medical_records', 'medical_records.rm_id = transaction.rm_id')
            ->join('coass_doc', 'coass_doc.transaction_id = transaction.id')
            ->getWhere(['transaction.id' => $id, 'loan_type' => 2])
            ->getRow();

        if ($transactionmodels->find(['transaction.id' => $id, 'loan_type' => 2])) {
            $data['transactions'] = $transactions;
            $data['title']  = 'Edit Rekam Medis No. ' . $transactions->rm_id;
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
            'rmid'                  => 'required|min_length[2]|max_length[50]|',
            'fullname'              => 'required|min_length[2]|max_length[50]',
            'coassnumber'           => 'required|min_length[2]|max_length[100]',
            'phone'                 => 'required|min_length[2]',
            'onsitedate'            => 'required',
            'clinic'                => 'required',
            'loandate'              => 'required',
            'deadline'              => 'required',
        ];
        $coassmodels = new CoassModel();
        $transactionmodels = new TransactionModel();

        if ($this->validate($rules)) {

            $transactiondata = [
                'rm_id'          => $this->request->getPost('rmid'),
                'loan_date'      => $this->request->getPost('loandate'),
                'loan_desc'        => implode(" ", $this->request->getPost('loandesc')),
                'deadline'       => $this->request->getPost('deadline'),
                'phone'   => $this->request->getPost('phone'),
            ];

            // $transactionmodels->insert($transactiondata);

            $coassdata = [
                'rm_id'          => $this->request->getPost('rmid'),
                'coass_name'      => $this->request->getPost('fullname'),
                'clinic_name'       => $this->request->getPost('clinic'),
                'coass_number'        => $this->request->getPost('coassnumber'),
                'coass_date'      => $this->request->getPost('onsitedate'),
            ];


            // $coassmodels->save($coassdata);
            if ($transactionmodels->find(['id' => $id])) {
                $transactionmodels->update($id, $transactiondata);
                $coassmodels->where('transaction_id', $id)->set($coassdata)->update();

                session()->setFlashdata('success', 'Data Berhasil Di edit');
                return redirect()->to('loancoass/edit/' . $id);
            } else {
                session()->setFlashdata('error', 'Data Tidak Berhasil Di edit');
                return redirect()->to('loancoass/edit/' . $id);
            }
        } else {
            $msg = $this->validator->listErrors();
            session()->setFlashdata('error', $msg);
            return redirect()->to('loancoass/add');
        }

        // $recordmedicalModel = new RecordMedicalModel();
        // $id = $this->request->getPost('recordId');
        // $data = array(
        //     'rm_id'         => $this->request->getPost('rmid'),
        //     'fullname'      => $this->request->getPost('fullname'),
        //     'address'       => $this->request->getPost('address'),
        //     'gender'        => $this->request->getPost('gender'),
        //     'birth_date'    => $this->request->getPost('birthdate'),
        //     'service_unit'  => $this->request->getPost('serviceunit'),
        // );
        // if ($recordmedicalModel->find($id)) {
        //     $recordmedicalModel->update($id, $data);
        //     session()->setFlashdata('success', 'Data Berhasil Di edit');
        //     return redirect()->to('recordmedical/edit/' . $id);
        // } else {
        //     echo "Data Tidak Ditemukan";
        // }
    }

    public function delete($id)
    {
        $coassmodels = new CoassModel();
        $transactionmodels = new TransactionModel();

        $check = $transactionmodels->find($id);
        if ($check) {
            $transactionmodels->delete(['id' => $id]);
            $coassmodels->where('transaction_id', $id)->delete();
            session()->setFlashdata('success', 'Data Berhasil Di Hapus');
            return redirect()->to('loancoass/');
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('loancoass/');
        }
    }
}
