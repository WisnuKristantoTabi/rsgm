<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionCoassModel;
use App\Models\TransactionPublicModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends BaseController
{

    // protected $session = null;
    protected $request;

    public function index()
    {
        $data['pagesidebar'] = 4;
        $data['subsidebar'] = 6;
        $data['role'] = session()->get('role');
        $data['title'] = 'Laporan';
        $data['username'] = session()->get('username');
        return view('report/report', $data);
    }

    public function saveExcel()
    {
        $y = $this->request->getPost('year');
        $m = $this->request->getPost('month');
        $t = $this->request->getPost('category');
        $report = new Report();
        if ($t == 1) {
            $report->savecoass($y, $m);
        } elseif ($t == 2) {
            $report->savepublic($y, $m);
        }
    }

    function savepublic($y, $m)
    {
        $tpModel = new TransactionPublicModel();
        $transactions = $tpModel->select('transaction.loan_date,
        public_doc.fullname,
        public_doc.address,
        transaction.deadline,
        medical_records.rm_id as rm_number,
        medical_records.fullname as patient_name, 
        transaction.return_date')
            ->join('transaction', 'transaction.id = transaction_public.transaction_id')
            ->join('public_doc', 'public_doc.id = transaction_public.public_id')
            ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            ->where('YEAR(loan_date)', $y)
            ->where('MONTH(loan_date)', $m)
            ->orWhere('MONTH(return_date)', $m)
            ->orderBy('loan_date', 'desc')
            ->findAll();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'LAPORAN ');
        $activeWorksheet->mergeCells('A1:D1');
        $activeWorksheet->setCellValue('A2', 'PERIODE :');
        $activeWorksheet->setCellValue('B2', 'Tahun: ' . $y . ' - Bulan: ' . $m);
        $activeWorksheet->setCellValue('A3', 'OUTPUT :');
        $activeWorksheet->setCellValue('B3', 'EXCEL');
        $activeWorksheet->setCellValue('A4', 'Kategori :');
        $activeWorksheet->setCellValue('B4', 'Public');

        $activeWorksheet->setCellValue('A7', 'NO');
        $activeWorksheet->setCellValue('B7', 'TGL PINJAM');
        $activeWorksheet->setCellValue('C7', 'NAMA');
        $activeWorksheet->setCellValue('D7', 'ALAMAT');
        $activeWorksheet->setCellValue('E7', 'NO.RM');
        $activeWorksheet->setCellValue('F7', 'PASIEN');
        $activeWorksheet->setCellValue('G7', 'TGL KEMBALI');
        $activeWorksheet->setCellValue('H7', 'KETERANGAN');
        $i = 8;
        foreach ($transactions as $value) {
            $activeWorksheet->setCellValue('A' . $i, $i - 7);
            $activeWorksheet->setCellValue('B' . $i, $value['loan_date']);
            $activeWorksheet->setCellValue('C' . $i, $value['fullname']);
            $activeWorksheet->setCellValue('D' . $i, $value['address']);
            $activeWorksheet->setCellValue('E' . $i, $value['rm_number']);
            $activeWorksheet->setCellValue('F' . $i, $value['patient_name']);
            $activeWorksheet->setCellValue('G' . $i, $value['return_date']);
            $activeWorksheet->setCellValue('H' . $i, ($value['return_date'] > $value['deadline']) ? "Terlambat" : "-");
            $i++;
        }

        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=LaporanPeminjaman_Tahun_' . $y . '_Bulan_' . $m . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    function savecoass($y, $m)
    {
        $tcModel = new TransactionCoassModel();
        $transactions = $tcModel->select('transaction.loan_date,
        coass_doc.coass_name, 
        transaction.deadline,
        coass_doc.clinic_name,
        medical_records.rm_id as rm_number ,
        medical_records.fullname as patient_name, 
        transaction.return_date')
            ->join('transaction', 'transaction.id = transaction_coass.transaction_id')
            ->join('coass_doc', 'transaction_coass.coass_id = coass_doc.id')
            ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            ->where('YEAR(transaction.loan_date)', $y)
            ->where('MONTH(transaction.loan_date)', $m)
            // ->orWhere('MONTH(transaction.return _date)', $m)
            ->orderBy('transaction.loan_date', 'desc')
            ->findAll();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'LAPORAN ');
        $activeWorksheet->mergeCells('A1:D1');
        $activeWorksheet->setCellValue('A2', 'PERIODE :');
        $activeWorksheet->setCellValue('B2', 'Tahun: ' . $y . ' - Bulan: ' . $m);
        $activeWorksheet->setCellValue('A3', 'OUTPUT :');
        $activeWorksheet->setCellValue('B3', 'EXCEL');
        $activeWorksheet->setCellValue('A4', 'Kategori :');
        $activeWorksheet->setCellValue('B4', 'Coass');

        $activeWorksheet->setCellValue('A7', 'NO');
        $activeWorksheet->setCellValue('B7', 'TGL PINJAM');
        $activeWorksheet->setCellValue('C7', 'NAMA COASS');
        $activeWorksheet->setCellValue('D7', 'KLINIK');
        $activeWorksheet->setCellValue('E7', 'NO.RM');
        $activeWorksheet->setCellValue('F7', 'PASIEN');
        $activeWorksheet->setCellValue('G7', 'TGL KEMBALI');
        $activeWorksheet->setCellValue('H7', 'KETERANGAN');
        $i = 8;
        foreach ($transactions as $value) {
            $activeWorksheet->setCellValue('A' . $i, $i - 7);
            $activeWorksheet->setCellValue('B' . $i, $value['loan_date']);
            $activeWorksheet->setCellValue('C' . $i, $value['coass_name']);
            $activeWorksheet->setCellValue('D' . $i, $value['clinic_name']);
            $activeWorksheet->setCellValue('E' . $i, $value['rm_number']);
            $activeWorksheet->setCellValue('F' . $i, $value['patient_name']);
            $activeWorksheet->setCellValue('G' . $i, $value['return_date']);
            $activeWorksheet->setCellValue('H' . $i, ($value['return_date'] > $value['deadline']) ? "Terlambat" : "-");
            $i++;
        }

        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=LaporanPeminjaman_Tahun_' . $y . '_Bulan_' . $m . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
