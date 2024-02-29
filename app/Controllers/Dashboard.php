<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    // protected $session = null;

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['username'] = session()->get('username');

        return view('dashboard', $data);
        // print_r($data);
    }
}
