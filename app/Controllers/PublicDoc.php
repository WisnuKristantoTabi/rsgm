<?php

namespace App\Controllers;

use App\Models\PublicModel;
use App\Models\ServiceUnitModel;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;


class PublicDoc extends BaseController
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
        $publicModels = new PublicModel();
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 7;
        $data['role'] = session()->get('role');
        $data['publicdata'] = $publicModels
            ->select('fullname,address,phone,id')
            ->orderBy('id', 'desc')
            ->paginate(20, 'publicdoc');
        $data['pager'] = $publicModels->pager;
        $data['title'] = 'Data Peminjam';
        $data['nomor'] = nomor($this->request->getVar('page_publicdoc'), 20);
        $data['username'] = session()->get('username');
        return view('publicdoc/index', $data);
    }

    public function add()
    {
        $serviceUnitModels = new ServiceUnitModel();
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 7;
        $data['role'] = session()->get('role');
        $data['title'] = 'Tambah Data Peminjam';
        $data['username'] = session()->get('username');
        $data['serviceunits'] = $serviceUnitModels->findAll();
        return view('publicdoc/add', $data);
    }

    public function store()
    {
        $session = session();
        $rules = [
            'fullname'              => 'required|min_length[2]|max_length[200]',
            'identitynumber'        => 'required|min_length[2]|max_length[50]',
            'phone'                 => 'required|min_length[2]|max_length[30]',
            'address'               => 'required',
            'service'               => 'required',
        ];
        $publicModels = new PublicModel();

        if ($this->validate($rules)) {

            $publicdata = [
                'fullname'          => $this->request->getPost('fullname'),
                'identity_number'   => $this->request->getPost('identitynumber'),
                'address'           => $this->request->getPost('address'),
                'phone'             => $this->request->getPost('phone'),
                'service_id'        => $this->request->getPost('service'),
            ];

            $publicModels->save($publicdata);
            $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
            return redirect()->to('public');
            // print_r($coassdata);
        } else {
            $msg = $this->validator->listErrors();
            $session->setFlashdata('error', $msg);
            return redirect()->to('public/add');
        }
    }

    public function show($id)
    {
        $data['username'] = session()->get('username');
        $data['role'] = session()->get('role');
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 7;

        $publicModels = new PublicModel();

        if ($publicModels->find($id)) {
            $publicdata = $publicModels->select('public_doc.fullname,
            public_doc.identity_number,
            public_doc.address,
            public_doc.phone, 
            service_unit.service_name')
                ->join('service_unit', 'service_unit.id = public_doc.service_id')
                ->find($id);
            $data['publicdata'] = $publicdata;
            $data['title'] = 'Data Peminjam';
            return view('publicdoc/show', $data);
            // print_r($coass);
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('/public');
        }
    }

    public function edit($id)
    {
        $data['username'] = session()->get('username');
        $data['role'] = session()->get('role');
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 6;

        $publicModels = new PublicModel();
        $serviceUnitModels = new ServiceUnitModel();

        if ($publicModels->find($id)) {
            $publicdata = $publicModels->select('id,fullname,identity_number,address,phone,service_id')
                // ->where('id', $id)
                ->find($id);
            $data['serviceunits'] = $serviceUnitModels->findAll();
            $data['publicdata'] = $publicdata;
            $data['title'] = 'Edit Data Peminjam';
            return view('publicdoc/edit', $data);
            // print_r($coass);
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('/public');
        }
    }

    public function update()
    {

        $id = $this->request->getPost('id');
        $rules = [
            'fullname'              => 'required|min_length[2]|max_length[200]',
            'identitynumber'        => 'required|min_length[2]|max_length[50]',
            'phone'                 => 'required|min_length[2]|max_length[30]',
            'address'               => 'required',
            'service'               => 'required',
        ];
        $publicModels = new PublicModel();

        if ($this->validate($rules)) {

            $publicdata = [
                'fullname'          => $this->request->getPost('fullname'),
                'identity_number'   => $this->request->getPost('identitynumber'),
                'address'           => $this->request->getPost('address'),
                'phone'             => $this->request->getPost('phone'),
                'service_id'        => $this->request->getPost('service'),
            ];

            if ($publicModels->find(['id' => $id])) {
                $publicModels->update($id, $publicdata);

                session()->setFlashdata('success', 'Data Berhasil Di edit');
                return redirect()->to('public');
            } else {
                session()->setFlashdata('error', 'Data Tidak Berhasil Di edit');
                return redirect()->to('public/edit' . $id);
            }
        } else {
            $msg = $this->validator->listErrors();
            session()->setFlashdata('error', $msg);
            return redirect()->to('public/edit' . $id);
        }
    }

    public function delete($id)
    {
        $publicModels = new PublicModel();
        if ($publicModels->find($id)) {
            $publicModels->where('id', $id)->delete();
            session()->setFlashdata('success', 'Data Berhasil Di Hapus');
            return redirect()->to('public/');
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('public/');
        }
    }
}
