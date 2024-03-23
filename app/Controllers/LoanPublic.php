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
        ];
        $publicmodels = new PublicModel();
        $transactionmodels = new TransactionModel();

        if ($this->validate($rules)) {

            $transactiondata = [
                'rm_id'          => $this->request->getPost('rmid'),
                'loan_date'      => $this->request->getPost('loandate'),
                'loan_type'       => 1,
                'loan_desc'        => implode(" ", $this->request->getPost('loandesc')),
            ];

            $transactionmodels->insert($transactiondata);

            $coassdata = [
                'rm_id'                 => $this->request->getPost('rmid'),
                'fullname'              => $this->request->getPost('fullname'),
                'identity_number'       => $this->request->getPost('identitynumber'),
                'address'               => $this->request->getPost('address'),
                'phone'                 => $this->request->getPost('phone'),
                'transaction_id'        => $transactionmodels->getInsertId(),
            ];


            $publicmodels->save($coassdata);
            $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
            return redirect()->to('/loanpublic');
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

    public function test()
    {
    }
}
