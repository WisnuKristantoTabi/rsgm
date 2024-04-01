<?php

namespace App\Controllers;

use App\Models\TransactionModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportLoan extends BaseController
{

    // protected $session = null;

    public function index()
    {
        $data['pagesidebar'] = 4;
        $data['subsidebar'] = 6;
        $data['title'] = 'Laporan Peminjaman';
        $data['username'] = session()->get('username');
        return view('report/loanreport', $data);
    }

    public function saveExcel()
    {
        $transactionModel = new TransactionModel();
        $transactions = $transactionModel->select('transaction.loan_date,coass_name, clinic_name,medical_records.rm_id as rm_number ,medical_records.fullname as patient_name, return_date')
            ->join('coass_doc', 'transaction.rm_id = coass_doc.rm_id')
            ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            ->orderBy('loan_date', 'desc')
            ->findAll();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'LAPORAN :PEMINJAMAN REKAM MEDIS ');
        $activeWorksheet->setCellValue('A2', 'PERIODE :');
        $activeWorksheet->setCellValue('A3', 'OUTPUT :');
        $activeWorksheet->setCellValue('A4', 'FILTER BERDASARKAN :');

        $activeWorksheet->setCellValue('A5', 'NO');
        $activeWorksheet->setCellValue('B5', 'TANGGAL');
        $activeWorksheet->setCellValue('C5', 'NAMA');
        $activeWorksheet->setCellValue('D5', 'KLINIK');
        $activeWorksheet->setCellValue('E5', 'NO.RM');
        $activeWorksheet->setCellValue('F5', 'PASIEN');
        $activeWorksheet->setCellValue('G5', 'KEMBALI');

        $i = 6;
        foreach ($transactions as $value) {
            $activeWorksheet->setCellValue('A' . $i, $i - 5);
            $activeWorksheet->setCellValue('B' . $i, $value['loan_date']);
            $activeWorksheet->setCellValue('C' . $i, $value['coass_name']);
            $activeWorksheet->setCellValue('D' . $i, $value['clinic_name']);
            $activeWorksheet->setCellValue('E' . $i, $value['rm_number']);
            $activeWorksheet->setCellValue('F' . $i, $value['patient_name']);
            $activeWorksheet->setCellValue('G' . $i, $value['return_date']);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=LaporanPeminjaman.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
