<?php

namespace App\Controllers;

use App\Models\TransactionModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportLoan extends BaseController
{

    // protected $session = null;
    protected $request;

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
        $y = $this->request->getPost('year');
        $m = $this->request->getPost('month');

        $transactionModel = new TransactionModel();
        $transactions = $transactionModel->select('transaction.loan_date,coass_name, clinic_name,medical_records.rm_id as rm_number ,medical_records.fullname as patient_name, return_date')
            ->join('coass_doc', 'transaction.rm_id = coass_doc.rm_id')
            ->join('medical_records', 'transaction.rm_id = medical_records.rm_id')
            ->where('YEAR(loan_date)', $y)
            ->where('MONTH(loan_date)', $m)
            ->orderBy('loan_date', 'desc')
            ->findAll();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'LAPORAN :PEMINJAMAN REKAM MEDIS ');
        $activeWorksheet->mergeCells('A1:D1');
        $activeWorksheet->setCellValue('A2', 'PERIODE :');
        $activeWorksheet->setCellValue('C2', 'Tahun: ' . $y . ' - Bulan: ' . $m);
        $activeWorksheet->setCellValue('A3', 'OUTPUT :');
        $activeWorksheet->setCellValue('B3', 'EXCEL');
        $activeWorksheet->setCellValue('A4', 'FILTER BERDASARKAN :');

        $activeWorksheet->setCellValue('A7', 'NO');
        $activeWorksheet->setCellValue('B7', 'TANGGAL');
        $activeWorksheet->setCellValue('C7', 'NAMA');
        $activeWorksheet->setCellValue('D7', 'KLINIK');
        $activeWorksheet->setCellValue('E7', 'NO.RM');
        $activeWorksheet->setCellValue('F7', 'PASIEN');
        $activeWorksheet->setCellValue('G7', 'KEMBALI');

        $i = 8;
        foreach ($transactions as $value) {
            $activeWorksheet->setCellValue('A' . $i, $i - 7);
            $activeWorksheet->setCellValue('B' . $i, $value['loan_date']);
            $activeWorksheet->setCellValue('C' . $i, $value['coass_name']);
            $activeWorksheet->setCellValue('D' . $i, $value['clinic_name']);
            $activeWorksheet->setCellValue('E' . $i, $value['rm_number']);
            $activeWorksheet->setCellValue('F' . $i, $value['patient_name']);
            $activeWorksheet->setCellValue('G' . $i, $value['return_date']);
            $i++;
        }

        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=LaporanPeminjaman.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
