<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\ServiceUnitModel;
use App\Models\CoassModel;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;


class Coass extends BaseController
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
        $coassModels = new CoassModel();
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 6;
        $data['role'] = session()->get('role');
        $data['coassmodels'] = $coassModels
            ->select('coass_name,clinic_name,coass_number,coass_date,phone,id')
            ->orderBy('coass_date', 'desc')
            ->paginate(20, 'coass');
        $data['pager'] = $coassModels->pager;
        $data['nomor'] = nomor($this->request->getVar('page_coass'), 20);
        $data['title'] = 'Data Coass';
        $data['username'] = session()->get('username');
        return view('coass/index', $data);
    }

    public function add()
    {
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 6;
        $data['role'] = session()->get('role');
        $data['title'] = 'Tambah Data COASS';
        $data['username'] = session()->get('username');
        return view('coass/add', $data);
    }

    public function store()
    {
        $session = session();
        $rules = [
            'fullname'              => 'required|min_length[2]|max_length[50]',
            'coassnumber'           => 'required|min_length[2]|max_length[100]',
            'phone'                 => 'required|min_length[2]',
            'onsitedate'            => 'required',
            'clinic'                => 'required',
        ];
        $coassmodels = new CoassModel();

        if ($this->validate($rules)) {

            $coassdata = [
                'coass_name'    => $this->request->getPost('fullname'),
                'clinic_name'   => $this->request->getPost('clinic'),
                'coass_number'  => $this->request->getPost('coassnumber'),
                'coass_date'    => $this->request->getPost('onsitedate'),
                'phone'         => $this->request->getPost('phone'),
            ];

            $coassmodels->save($coassdata);
            $session->setFlashdata('success', "Data Berhasil Di Tambahkan");
            return redirect()->to('coass');
            // print_r($coassdata);
        } else {
            $msg = $this->validator->listErrors();
            $session->setFlashdata('error', $msg);
            return redirect()->to('coass/add');
        }
    }

    public function show($id)
    {
        $data['username'] = session()->get('username');
        $data['role'] = session()->get('role');
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 6;

        $coassModels = new CoassModel();

        if ($coassModels->find($id)) {
            $coass = $coassModels->select('coass_name,coass_number, coass_date, clinic_name,phone,id')
                // ->where('id', $id)
                ->find($id);
            $data['coass'] = $coass;
            $data['title']  = 'Tampil Coass ';
            return view('coass/show', $data);
            // print_r($coass);
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('/coass');
        }
    }

    public function edit($id)
    {
        $data['username'] = session()->get('username');
        $data['role'] = session()->get('role');
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 6;

        $coassModels = new CoassModel();

        if ($coassModels->find($id)) {
            $coass = $coassModels->select('coass_name,coass_number, coass_date, clinic_name,phone,id')
                // ->where('id', $id)
                ->find($id);
            $data['coass'] = $coass;
            $data['title']  = 'Edit Coass ';
            return view('coass/edit', $data);
            // print_r($coass);
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('/coass');
        }
    }

    public function update()
    {
        $session = session();
        $id = $this->request->getPost('id');
        $rules = [
            'fullname'              => 'required|min_length[2]|max_length[50]',
            'coassnumber'           => 'required|min_length[2]|max_length[100]',
            'phone'                 => 'required|min_length[2]',
            'onsitedate'            => 'required',
            'clinic'                => 'required',
        ];
        $coassmodels = new CoassModel();

        if ($this->validate($rules)) {

            $coassdata = [
                'coass_name'    => $this->request->getPost('fullname'),
                'clinic_name'   => $this->request->getPost('clinic'),
                'coass_number'  => $this->request->getPost('coassnumber'),
                'coass_date'    => $this->request->getPost('onsitedate'),
                'phone'         => $this->request->getPost('phone'),
            ];

            if ($coassmodels->find(['id' => $id])) {
                $coassmodels->update($id, $coassdata);

                session()->setFlashdata('success', 'Data Berhasil Di edit');
                return redirect()->to('coass/edit/' . $id);
            } else {
                session()->setFlashdata('error', 'Data Tidak Berhasil Di edit');
                return redirect()->to('coass/edit/' . $id);
            }
        } else {
            $msg = $this->validator->listErrors();
            session()->setFlashdata('error', $msg);
            return redirect()->to('coass/edit/' . $id);
        }
    }

    public function delete($id)
    {
        $coassmodels = new CoassModel();
        if ($coassmodels->find($id)) {
            $coassmodels->where('id', $id)->delete();
            session()->setFlashdata('success', 'Data Berhasil Di Hapus');
            return redirect()->to('coass/');
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('coass/');
        }
    }
}
