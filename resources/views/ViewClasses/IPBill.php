<?php

namespace ViewClasses;

use App\Libraries\Fpdf\Scripts\McTable;

class IPBill extends McTable
{
    public string $type;
    public function header()
    {
        if ($this->type === 'hospital') {
            // $this->image(config('paths.logo'), 12, 6, 30, 20);
            $this->setFont('times', 'B', 14);
            $this->setY(7);
            $this->cell(190, 6, config('about.name'), 0, 0, 'C');
            $this->rect(10, 5, 190, 22);

            $this->setFont('times', 'B', 12);
            $this->setY(22);
            $this->cell(190, 5, 'IP BILL', 0, 1, 'C');
            $this->setXY(150, 6);
            $this->setFont('times', '', 9);
            $this->multiCell(52, 5, config('about.address'));
            $this->ln(6);
        } else {
            // $this->image(config('paths.logo'), 12, 6, 30, 20);
            $this->setFont('times', 'B', 14);
            $this->setY(7);
            $this->cell(190, 6, 'SRUTHI CLINIC', 0, 0, 'C');
            $this->rect(10, 5, 190, $this->getY() + 10);

            $this->setFont('times', 'B', 12);
            $this->setY(22);
            $this->cell(190, 5, 'IP BILL', 0, 1, 'C');
            $this->setXY(150, 6);
            $this->setFont('times', '', 9);
            $address = "P-5/1, Bye Pass Road,Opp - To Vasan Eye Care.Ambur";
            $this->multiCell(52, 5, $address);
            $this->ln(6);
        }
    }

    public function footer()
    {
        $this->SetTextColor(0, 0, 0);
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
