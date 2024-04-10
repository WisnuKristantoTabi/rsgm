<?php

namespace App\Controllers;

use App\Models\UserModel;

class Officer extends BaseController
{
    /**
     * Instance of the main Request object.
     *
     * @var HTTP\IncomingRequest
     */
    protected $request;

    public function index()
    {
        $UserModel = new UserModel();
        $data['role'] = session()->get('role');
        $data['officers'] = $UserModel->findAll();
        $data['title'] = 'Petugas';
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 2;
        $data['username'] = session()->get('username');
        return view('officer/index', $data);
    }

    public function edit($id)
    {
        $data['title'] = "Edit Petugas ";
        $data['username'] = 'Petugas';
        $data['role'] = session()->get('role');
        $data['pagesidebar'] = 2;
        $data['subsidebar'] = 2;
        $userModel = new UserModel();
        $users = $userModel->getWhere(['id' => $id])->getRow();
        if (isset($users)) {
            $data['id'] = $users->id;
            $data['name'] =  $users->username;
            $data['fullname'] = $users->fullname;
            $data['email'] = $users->email;
            $data['role'] = $users->role;
            return view('officer/edit', $data);
        } else {
            session()->setFlashdata('error', 'Data Tidak Berhasil Di edit');
            return redirect()->to('officer');
        }
    }

    public function update()
    {
        $rules = [
            // 'username'          => 'required|min_length[2]|max_length[100]|is_unique[user.username]',
            'fullname'          => 'required|min_length[2]|max_length[100]',
            'email'             => 'required|min_length[4]|max_length[100]|valid_email|is_unique[user.email]',
            'role'              => 'required'
        ];
        $UserModel = new UserModel();
        $id = $this->request->getPost('id');

        if ($this->validate($rules)) {
            if ($UserModel->find($id)) {
                $userModel = new UserModel();
                $data = [
                    'username'      => $this->request->getVar('username'),
                    'fullname'      => $this->request->getVar('fullname'),
                    'email'         => $this->request->getVar('email'),
                    'role'          => $this->request->getVar('role'),
                ];
                $UserModel->update($id, $data);
                session()->setFlashdata('success', 'Data Berhasil Di edit');
                return redirect()->to('officer');
            } else {
                session()->setFlashdata('error', 'Data Tidak Ditemukan');
                return redirect()->to('officer');
            }
        } else {
            $msg = $this->validator->listErrors();
            session()->setFlashdata('error', $msg);
            return redirect()->to('officer');
        }
    }



    public function delete($id)
    {
        $UserModel = new UserModel();

        $check = $UserModel->find($id);
        if ($check) {
            $UserModel->delete($id);
            session()->setFlashdata('success', 'Data Berhasil Di Hapus');
            return redirect()->to('officer/');
        } else {
            session()->setFlashdata('error', 'Data Tidak Ditemukan');
            return redirect()->to('officer/');
        }
    }
}
