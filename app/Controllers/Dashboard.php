<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\ServiceUnitModel;


class Dashboard extends BaseController
{

    // protected $session = null;

    public function index()
    {
        $poli = $this->request->getVar('poli');
        $type = $this->request->getVar('type');
        if (is_null($poli)) {
            $poli = 1;
        };

        if (is_null($type)) {
            $type = 1;
        }
        $serviceUnitModels = new ServiceUnitModel();
        $data['title'] = "Dashboard";
        $data['username'] = session()->get('username');
        $data['role'] = session()->get('role');
        $data['pagesidebar'] = 1;
        $data['subsidebar'] = 0;
        $data['serviceunits'] = $serviceUnitModels->findAll();
        $data['poli'] = $poli;
        $data['type'] = $type;
        $db = \Config\Database::connect();

        if ($type == 1) {
            $data["transactions"] = $db->table('transaction_public')
                ->select("MONTH(loan_date) as month ,COUNT(loan_date)  as totalloan, COUNT(return_date)  as totalreturn")
                ->join('transaction', 'transaction.id = transaction_public.transaction_id')
                ->join('public_doc', 'public_doc.id = transaction_public.public_id')
                ->orderBy('transaction.loan_date')
                ->where('YEAR(transaction.loan_date)', '2024')
                ->where('public_doc.service_id', $poli)
                ->groupBy('MONTH(transaction.loan_date)')
                ->get()
                ->getRow();

            $count = $db->table('transaction_public')
                ->select('COUNT(transaction.id) as count_late')
                ->join('transaction', 'transaction.id = transaction_public.transaction_id')
                ->join('public_doc', 'public_doc.id = transaction_public.public_id')
                ->where('transaction.return_date > transaction.deadline')
                ->where('public_doc.service_id', $poli)
                ->get()
                ->getRow();
            $data['count'] = $count;
        } elseif ($type == 2) {
            $data["transactions"] = $db->table('transaction_coass')
                ->select("MONTH(loan_date) as month, COUNT(loan_date) as totalloan, COUNT(return_date) as totalreturn")
                ->join('transaction', 'transaction.id = transaction_coass.transaction_id')
                ->join('coass_doc', 'coass_doc.id = transaction_coass.coass_id')
                ->orderBy('transaction.loan_date')
                ->where('YEAR(transaction.loan_date)', '2024')
                ->where('coass_doc.service_id', $poli)
                ->groupBy('MONTH(transaction.loan_date)')
                ->get()
                ->getRow();

            $count = $db->table('transaction_coass')
                ->select('COUNT(transaction.id) as count_late')
                ->join('transaction', 'transaction.id = transaction_coass.transaction_id')
                ->join('coass_doc', 'coass_doc.id = transaction_coass.coass_id')
                ->where('transaction.return_date > transaction.deadline')
                ->where('coass_doc.service_id', $poli)
                ->get()
                ->getRow();

            $data['count'] = $count;
        }

        return view('dashboard', $data);
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
