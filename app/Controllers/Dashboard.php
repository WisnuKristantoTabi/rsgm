<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    // protected $session = null;

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['username'] = session()->get('username');
        $data['pagesidebar'] = 1;
        $data['subsidebar'] = 0;

        return view('dashboard', $data);
        // print_r($data);
    }
}
