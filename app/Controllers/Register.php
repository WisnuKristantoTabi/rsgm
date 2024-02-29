<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Register extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var HTTP\IncomingRequest
     */
    protected $request;

    public function index()
    {
        $data['title'] = "Daftar User";
        $data['username'] = 'Petugas';
        return view('auth/register', $data);
    }

    public function store()
    {
        $rules = [
            'username'          => 'required|min_length[2]|max_length[100]',
            'fullname'          => 'required|min_length[2]|max_length[100]',
            'email'             => 'required|min_length[4]|max_length[100]|valid_email|is_unique[user.email]',
            'password'          => 'required|min_length[4]|max_length[100]',
            'confirmpassword'   => 'matches[password]'
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $data = [
                'username'      => $this->request->getVar('username'),
                'fullname'      => $this->request->getVar('fullname'),
                'email'         => $this->request->getVar('email'),
                'password'      => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $userModel->save($data);
            session()->setFlashdata('success', 'Data Berhasil Di edit');
            return redirect()->to('officer');
        } else {
            $data['validation'] = $this->validator;
            session()->setFlashdata('error', "Tidak Berhasil");
            return redirect()->to('officer');
        }
    }
}
