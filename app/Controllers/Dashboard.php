<?php

namespace App\Controllers;

use App\Models\TransactionModel;

class Dashboard extends BaseController
{

    // protected $session = null;

    public function index()
    {
        $transactionModels = new TransactionModel();
        $data['title'] = "Dashboard";
        $data['username'] = session()->get('username');
        $data['pagesidebar'] = 1;
        $data['subsidebar'] = 0;

        $transactions = $transactionModels->select("MONTH(loan_date) as month, COUNT(loan_date) as totalloan, COUNT(return_date) as totalreturn")
            ->orderBy('loan_date')
            ->where('YEAR(loan_date)', '2024')
            ->groupBy('MONTH(loan_date)')
            ->findAll();

        $data['transactions'] = $transactions;

        $count = $transactionModels
            ->select('COUNT(*) as count_late')
            ->where('is_late', 2)
            ->first();

        $data['count'] = $count;



        return view('dashboard', $data);
        // return $this->response->setJSON($data);
    }


    public function getDataLoan()
    {
        $transactionModels = new TransactionModel();
        $response = array();
        $data = array();
        $transactions = $transactionModels->select('MONTH(loan_date) as month, COUNT(*) as total')
            ->orderBy('loan_date')
            ->where('YEAR(loan_date)', '2024')
            ->groupBy('MONTH(loan_date)')
            ->findAll();

        foreach ($transactions as $record) {
            $data[] = array(
                "month" => $record['month'],
                "total" => $record['total'],
            );
        }
        $response['loan'] = $data;

        return $this->response->setJSON($response);
    }

    public function getDataReturn()
    {
        $transactionModels = new TransactionModel();
        $response = array();
        $data = array();
        $transactions = $transactionModels->select('MONTH(return_date) as month, COUNT(*) as total')
            ->orderBy('return_date')
            ->where('YEAR(return_date)', '2024')
            ->groupBy('MONTH(return_date)')
            ->findAll();

        // for ($i = 1; $i <= 12; $i++) {
        //     $data[$i] = [
        //         'month' => $i,
        //         'total' => 0
        //     ];
        // }
        foreach ($transactions as $record) {
            $data[] = array(
                "month" => $record['month'],
                "total" => $record['total'],
            );
        }
        $response['return'] = $data;

        return $this->response->setJSON($response);
    }
}
