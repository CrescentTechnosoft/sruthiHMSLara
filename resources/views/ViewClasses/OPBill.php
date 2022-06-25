<?php

namespace ViewClasses;

use App\Libraries\Fpdf\Scripts\McTable;

class OPBill extends McTable
{
    public string $type;

    public function header()
    {
        if ($this->type === 'hospital') {
            // $this->image(config('paths.logo'), 12, 6, 30, 20);
            $this->setFont('times', 'B', 14);
            $this->setY(7);
            $this->cell(190, 6, 'SRUTHI SPECIALITY HOSPITAL', 0, 0, 'C');
            $this->rect(10, 5, 190, 22);

            $this->setFont('times', 'B', 12);
            $this->setY(22);
            $this->cell(190, 5, 'OP RECEIPT', 0, 1, 'C');
            $this->setXY(150, 6);
            $this->setFont('times', '', 9);
            $this->multiCell(52, 5, config('about.address'));
            $this->ln(6);
        }else{
            // $this->image(config('paths.logo'), 12, 6, 30, 20);
            $this->setFont('times', 'B', 14);
            $this->setY(7);
            $this->cell(190, 6, 'SRUTHI CLINIC', 0, 0, 'C');
            $this->rect(10, 5, 190, $this->getY()+10);

            $this->setFont('times', 'B', 12);
            $this->setY(22);
            $this->cell(190, 5, 'OP RECEIPT', 0, 1, 'C');
            $this->setXY(150, 6);
            $this->setFont('times', '', 9);
            $address = "P-5/1, Bye Pass Road,\nOpp - To Vasan Eye Care.Ambur\n Contact : 9566638438";
            $this->multiCell(52, 5, $address);
            $this->ln(6);
        }
    }
}
