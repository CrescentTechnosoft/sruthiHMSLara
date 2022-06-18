<?php

namespace ViewClasses\Reports;

use App\Libraries\Fpdf\Scripts\McTable;

class Registrations extends McTable
{
    public string $start_date;
    public string $end_date;

    public function header()
    {
        $this->setFont("times", "B", 11);
        $this->cell(190, 10, 'Registrations from '. $this->start_date.' to '.$this->end_date, 0, 1, 'C');

        $this->setFontSize(10);
        $this->createRow(['Pt ID', 'Reg Date', 'Patient Name', 'Age / Gender', 'Contact No', 'Ref By'], 6, true);
    }

    public function footer()
    {
        $this->setFont("times", "", 10);
        $this->cell(190, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 1, 'C');
    }
}
