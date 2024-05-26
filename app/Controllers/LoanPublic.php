<?php

namespace App\Controllers;

// use App\Models\RecordMedicalModel;
use App\Models\PublicModel;
use App\Models\TransactionPublicModel;
use App\Models\TransactionModel;
use App\Models\ServiceUnitModel;
use App\Models\RecordMedicalModel;
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
        $tpmodels = new TransactionPublicModel();
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 4;
        $data['role'] = session()->get('role');
        $data['publicdata'] = $tpmodels
            ->select('transaction.id,public_doc.fullname,public_doc.identity_number,transaction.rm_id')
            ->join('transaction', 'transaction.id = transaction_public.transaction_id')
            ->join('public_doc', 'public_doc.id = transaction_public.public_id')
            ->where('transaction.is_return', 1)
            // ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            ->orderBy('loan_date', 'desc')
            ->paginate(20, 'loancoass');
        $data['pager'] = $tpmodels->pager;
        $data['nomor'] = nomor($this->request->getVar('page_loanpublic'), 20);
        $data['title'] = 'Peminjaman Umum';
        $data['type'] = 1;
        $data['username'] = session()->get('username');
        return view('publicloan/index', $data);
    }

    public function add()
    {
        // $serviceunitmodel = new ServiceUnitModel();
        $serviceUnitModels = new ServiceUnitModel();
        $data['title'] = 'Tambah Pinjaman Umum';
        $data['pagesidebar'] = 3;
        $data['subsidebar'] = 4;
        $data['role'] = session()->get('role');
        $data['username'] = session()->get('username');

        return view('publicloan//add', $data);
    }

    public function store()
    {
        $session = session();

        $rules = [
            'rmid'                  => 'required|min_length[2]|max_length[50]|',
            'loandate'              => 'required',
            'deadline'              => 'required',
            'publicid'              => 'required',
        ];
        $tpmodels = new TransactionPublicModel();
        $transactionmodels = new TransactionModel();
        $recordmedicalModel = new RecordMedicalModel();

        if ($this->validate($rules)) {

            $transactiondata = [
                'rm_id'          => $this->request->getPost('rmid'),
                'loan_date'      => $this->request->getPost('loandate'),
                'loan_type'      => 1,
                'loan_desc'      => '-',
                'deadline'       => $this->request->getPost('deadline'),
                'is_return'      => 1,
            ];

            $transactionmodels->insert($transactiondata);

            $tpmodels->save([
                'transaction_id'    => $transactionmodels->getInsertId(),
                'public_id'          =>  $this->request->getPost('publicid')
            ]);

            $recordmedicalModel->set(['is_return' => 1])->where('rm_id', $this->request->getPost('rmid'))->update();

            $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
            return redirect()->to('f/public?id=' . $transactionmodels->getInsertId());
        } else {
            $msg = $this->validator->listErrors();
            $session->setFlashdata('error', $msg);
            return redirect()->to('/loanpublic/add');
        }
    }

    public function edit($id)
    {
        $data['username'] = session()->get('username');
        $data['role'] = session()->get('role');
        $tpmodels = new TransactionPublicModel();
        $transactions = $tpmodels->select('transaction.rm_id, public_doc.fullname as patientname, transaction.deadline,
        public_doc.phone, public_doc.identity_number, public_doc.address, transaction.loan_date,
        medical_records.fullname, transaction.id as tid, service_id , public_doc.id as pid ')
            ->join('transaction', 'transaction.id = transaction_public.transaction_id')
            ->join('public_doc', 'public_doc.id = transaction_public.public_id')
            ->join('medical_records', 'medical_records.rm_id = transaction.rm_id')
            ->getWhere(['transaction.id' => $id, 'loan_type' => 1])
            ->getRow();

        if ($tpmodels->where(['transaction_id' => $id])->first()) {
            $data['transaction'] = $transactions;
            $data['title']  = 'Edit Data Peminjaman ';
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
            'rmid'                  => 'required',
            'publicid'              => 'required',
            'loandate'              => 'required',
            'deadline'              => 'required',
        ];

        $transactionmodels = new TransactionModel();
        $tpmodels = new TransactionPublicModel();
        $recordmedicalModel = new RecordMedicalModel();

        if ($this->validate($rules)) {

            $transactiondata = [
                'rm_id'          => $this->request->getPost('rmid'),
                'loan_date'      => $this->request->getPost('loandate'),
                'loan_desc'      => '-',
                'deadline'       => $this->request->getPost('deadline'),

            ];

            if ($transactionmodels->find(['id' => $id])) {
                $transactionmodels->update($id, $transactiondata);
                $recordmedicalModel->set(['is_return' => 1])->where('rm_id', $this->request->getPost('rmid'))->update();
                $recordmedicalModel->set(['is_return' => 2])->where('rm_id', $this->request->getPost('rmidold'))->update();

                $tpmodels->where('transaction_id', $id)
                    ->set([
                        'public_id'          =>  $this->request->getPost('publicid')
                    ])->update();

                session()->setFlashdata('success', 'Data Berhasil Di edit');
                return redirect()->to('f/public/?id=' . $id);
            } else {
                session()->setFlashdata('error', 'Data Tidak Berhasil Di edit');
                return redirect()->to('loanpublic/edit/' . $id);
            }
        } else {
            $msg = $this->validator->listErrors();
            session()->setFlashdata('error', $msg);
            return redirect()->to('loanpublic/edit/' . $id);
        }
    }

    public function delete($id, $rmid)
    {
        $tcModels = new TransactionPublicModel();
        $transactionmodels = new TransactionModel();
        $recordmedicalModel = new RecordMedicalModel();

        $check = $transactionmodels->find($id);
        if ($check) {
            $transactionmodels->delete(['id' => $id]);
            $tcModels->where('transaction_id', $id)->delete();
            $recordmedicalModel->set(['is_return' => 2])->where('rm_id', $rmid)->update();
            session()->setFlashdata('success', 'Data Berhasil Di Hapus');
            return redirect()->to('loanpublic/');
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('loanpublic/');
        }
    }

    public function searchCoass()
    {
        $postData = $this->request->getVar('searchTerm');

        $response = array();
        $publicModel = new PublicModel();

        if (!isset($postData)) {
            // Fetch record
            $publicData = $publicModel->select('id,fullname,identity_number')
                ->orderBy('id')
                ->findAll(5);
        } else {
            $publicData = $publicModel->select('id,fullname,identity_number')
                ->like('fullname', $postData)
                ->orLike('identity_number', $postData)
                ->orderBy('id')
                ->findAll(5);
        }

        $data = array();
        foreach ($publicData as $public) {
            $data[] = array(
                "id" => $public['id'],
                "text" => $public['fullname'] . ' - ' . $public['identity_number'],
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }

    public function showCoass()
    {
        $postData = $this->request->getVar('id');
        $publicModel = new PublicModel();
        $publicData = $publicModel->select('public_doc.id,
        public_doc.fullname,public_doc.address,public_doc.phone,public_doc.identity_number,
        service_unit.service_name')
            ->join('service_unit', 'public_doc.service_id = service_unit.id ')
            ->where('public_doc.id', $postData)
            ->orderBy('public_doc.id')
            ->get();

        $data = array();
        foreach ($publicData->getResult() as $pb) {
            $data[] = array(
                "id"                => $pb->id,
                "fullname"          => $pb->fullname,
                "address"           => $pb->address,
                "phone"             => $pb->phone,
                "identitynumber"    => $pb->identity_number,
                "servicename"       => $pb->service_name,
            );
            break;
        }
        return $this->response->setJSON($data);
    }
}
