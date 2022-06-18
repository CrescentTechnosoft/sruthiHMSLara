<?php

namespace ViewClasses\Reports;

use App\Libraries\Fpdf\Scripts\McTable;

class Footer extends McTable
{
    public function footer()
    {
        // Position at 1.5 cm from bottom
        $this->setY(-15);
        // Arial italic 8
        $this->setFont('Arial', 'I', 8);
        // Page number
        $this->cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
