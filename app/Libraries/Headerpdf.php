<?php

namespace App\Libraries;

use TCPDF;

class Headerpdf extends TCPDF
{
    public function Header()
    {
        // $image_file = base_url('public/img/logo.png');
        $image_file = K_PATH_IMAGES . 'logo_example.jpg';
        $this->Image($image_file, 10, 10, 7, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('helvetica', 'B', 10);
        $this->SetY(13);
        $this->SetX(19);
        $this->Cell(0, 15, 'RSGM Universitas Jember', 0, 1, 'L', 0, '', 0, false, 'M', 'M');

        $this->SetY(20);
        $this->Cell(0, 0, '', 'T', 0, 'C');
    }
}
