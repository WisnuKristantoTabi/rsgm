<?php

namespace App\Controllers;

use App\Models\ReturnDocumentModel;

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
        $returndocumentModel = new ReturnDocumentModel();
        $data['recordmedicals'] = $returndocumentModel->orderBy('id', 'desc')->findAll();
        $data['title'] = 'Rekam Medis';
        $data['username'] = session()->get('username');
        return view('recordmedical/index', $data);
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

    // public function add()
    // {
    //     $serviceunitmodel = new ServiceUnitModel();
    //     $data['title'] = 'Tambah Rekam Medis';
    //     $data['username'] = session()->get('username');
    //     $data['serviceunits'] = $serviceunitmodel->findAll();

    //     return view('recordmedical/add', $data);
    // }

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
}
