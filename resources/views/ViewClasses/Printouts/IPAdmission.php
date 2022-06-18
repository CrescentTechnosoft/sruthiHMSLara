<?php

namespace ViewClasses\Printouts;

use App\ThirdParty\Fpdf\Fpdf;

class IPAdmission extends Fpdf
{
    public function header()
    {
        // $this->Image(realpath('Images/Assets/logo.png'), 10, 6, 30, 20);
        // $this->AddFont("texgyrepagella", "B");
        // $this->SetFont('texgyrepagella', 'B', 15);
        // $this->SetTextColor(20, 68, 145);
        // $this->Cell(80);
        // $this->Cell(30, 10, 'Vamsam Fertility Research Centre', 0, 0, 'C');
        // $this->Ln(20);
        $this->setY(40);
    }

    public function footer()
    {
        parent::Footer();
        $this->SetY(- 20);
        $this->Cell(175, 10, 'Doctor\'s Signature', 0, 1, 'R');
    }
}
