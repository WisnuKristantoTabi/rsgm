<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\ServiceUnitModel;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class Dashboard extends BaseController
{

    // protected $session = null;

    public function index()
    {
        $poli = $this->request->getVar('poli');
        $transactionModels = new TransactionModel();
        $serviceUnitModels = new ServiceUnitModel();
        $data['title'] = "Dashboard";
        $data['username'] = session()->get('username');
        $data['role'] = session()->get('role');
        $data['pagesidebar'] = 1;
        $data['subsidebar'] = 0;
        $data['serviceunits'] = $serviceUnitModels->findAll();
        $data['poli'] = $poli;


        $tlp = $transactionModels->select("
        MONTH(loan_date) as month,
        SUM(CASE WHEN loan_date IS NOT NULL THEN 1 ELSE 0 END) as totalloan,
        SUM(CASE WHEN return_date IS NOT NULL THEN 1 ELSE 0 END) as totalreturn
        
        ")
            ->join('transaction_public', 'transaction_public.transaction_id = transaction.id')
            ->join('public_doc', 'public_doc.id = transaction_public.public_id')
            ->orderBy('transaction.loan_date')
            ->where('YEAR(transaction.loan_date)', '2024')
            ->where('public_doc.service_id', $poli)
            ->groupBy('MONTH(transaction.loan_date)')
            ->find();

        $tlc = $transactionModels->select("COUNT(loan_date) as totalloan, COUNT(return_date) as totalreturn")
            ->join('transaction_coass', 'transaction_coass.transaction_id = transaction.id')
            ->join('coass_doc', 'coass_doc.id = transaction_coass.coass_id')
            ->orderBy('transaction.loan_date')
            ->where('YEAR(transaction.loan_date)', '2024')
            ->where('coass_doc.service_id', $poli)
            ->groupBy('MONTH(transaction.loan_date)')
            ->first();


        $data['transactions'] = array([
            'month' => $tlp['month'],
            'totalloan' => $tlp['totalloan'] + $tlc['totalloan'],
            'totalreturn' => $tlp['totalreturn'] + $tlc['totalreturn'],
        ]);

        // print_r($data);

        //     $count = $transactionModels
        //         ->select('COUNT(*) as count_late')

        //         ->where('return_date > deadline')
        //         ->where('service_id', $poli)
        //         ->first();

        //     $data['count'] = $count;



        //     return view('dashboard', $data);
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
