<?php

namespace App\Controllers;

use App\Models\ServiceUnitModel;

class ServiceUnit extends BaseController
{
    /**
     * Instance of the main Request object.
     *
     * @var HTTP\IncomingRequest
     */
    protected $request;

    public function index()
    {
        $serviceunitModel = new ServiceUnitModel();
        $data['serviceunits'] = $serviceunitModel
            ->select('(SELECT COALESCE(COUNT(medical_records.service_unit),0) FROM medical_records 
            WHERE medical_records.service_unit = service_unit.id ) AS amount, 
            service_unit.service_name, id')
            ->findAll();
        $data['title'] = 'Unit Pelayanan';
        $data['username'] = session()->get('username');
        return view('serviceunit/index', $data);
        // dd($data);
        // print_r($data);
    }

    public function add()
    {
        $data['title'] = 'Tambah Unit Pelayanan';
        $data['username'] = session()->get('username');

        return view('serviceunit/add', $data);
    }

    public function store()
    {
        $session = session();

        $rules = [
            'servicename'             => 'required|min_length[2]|max_length[50]',

        ];

        if ($this->validate($rules)) {
            $serviceunitModel = new ServiceUnitModel();
            $data = [
                'service_name'          => $this->request->getVar('servicename'),
            ];
            $serviceunitModel->save($data);
            $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
            return redirect()->to('/serviceunit');
        } else {
            $msg = $this->validator->listErrors();
            $session->setFlashdata('error', $msg);
            return redirect()->to('serviceunit/add');
        }
    }

    public function edit($id)
    {
        $data['username'] = session()->get('username');
        $serviceunitModel = new ServiceUnitModel();
        $serviceunits = $serviceunitModel->getWhere(['id' => $id])->getRow();
        if (isset($serviceunits)) {
            $data['serviceunits'] = $serviceunits;
            $data['title']  = 'Edit Pelayanan Unit';
            return view('serviceunit/edit', $data);
        } else {
            session()->setFlashdata('error', 'Data Tidak Berhasil Di edit');
            return redirect()->to('recordmedical');
        }
    }

    public function update()
    {
        $serviceunitModel = new ServiceUnitModel();
        $id = $this->request->getPost('recordId');
        $data = array(
            'service_name'         => $this->request->getPost('servicename'),
        );
        if ($serviceunitModel->find($id)) {
            $serviceunitModel->update($id, $data);
            session()->setFlashdata('success', 'Data Berhasil Di edit');
            return redirect()->to('serviceunit');
        } else {
            echo "Data Tidak Ditemukan";
        }
    }

    public function delete($id)
    {
        $serviceunitModel = new ServiceUnitModel();

        $check = $serviceunitModel->find($id);
        if ($check) {
            $serviceunitModel->delete($id);
            session()->setFlashdata('success', 'Data Berhasil Di Hapus');
            return redirect()->to('serviceunit');
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('serviceunit');
        }
    }
}
