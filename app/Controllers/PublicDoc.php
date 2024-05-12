<?php

namespace App\Controllers;

use App\Models\PublicModel;
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
        $data['title'] = 'Data Public';
        $data['nomor'] = nomor($this->request->getVar('page_publicdoc'), 20);
        $data['username'] = session()->get('username');
        return view('publicdoc/index', $data);
    }

    public function add()
    {
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 7;
        $data['role'] = session()->get('role');
        $data['title'] = 'Tambah Data Publik';
        $data['username'] = session()->get('username');
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
        ];
        $publicModels = new PublicModel();

        if ($this->validate($rules)) {

            $publicdata = [
                'fullname'          => $this->request->getPost('fullname'),
                'identity_number'   => $this->request->getPost('identitynumber'),
                'address'           => $this->request->getPost('address'),
                'phone'             => $this->request->getPost('phone'),
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
            $publicdata = $publicModels->select('fullname,identity_number,address,phone')
                // ->where('id', $id)
                ->find($id);
            $data['publicdata'] = $publicdata;
            $data['title'] = 'Data Public';
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

        if ($publicModels->find($id)) {
            $publicdata = $publicModels->select('id,fullname,identity_number,address,phone')
                // ->where('id', $id)
                ->find($id);
            $data['publicdata'] = $publicdata;
            $data['title'] = 'Data Public';
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
        ];
        $publicModels = new PublicModel();

        if ($this->validate($rules)) {

            $publicdata = [
                'fullname'          => $this->request->getPost('fullname'),
                'identity_number'   => $this->request->getPost('identitynumber'),
                'address'           => $this->request->getPost('address'),
                'phone'             => $this->request->getPost('phone'),
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
