<?php

namespace ViewClasses;

use App\Libraries\Fpdf\Scripts\McTable;

class DischargeView extends McTable
{
    public function header()
    {
        $this->image(config('paths.logo'), 12, 6, 30, 20);
        $this->SetFont('times', 'B', 12);
        $this->SetY(32);
        $this->Cell(190, 5, 'DISCHARGE SUMMARY', 0, 1, 'C');
        $this->Ln(3);
    }

    public function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}
