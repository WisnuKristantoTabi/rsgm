<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Login extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var HTTP\IncomingRequest
     */
    protected $request;

    public function index(): string
    {
        return view('auth/login');
    }

    public function auth()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $model->where('username', $username)->first();
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    // 'user_id'       => $data['user_id'],
                    'username'     => $data['username'],
                    'role'         => $data['role'],
                    // 'user_email'    => $data['user_email'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
                // echo "berhasil" ;
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/');
                // echo "Wrong Password" ;
            }
        } else {
            $session->setFlashdata('msg', 'Username Tidak Ditemukan');
            return redirect()->to('/');
            // echo "Email not Found" ;
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
