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
            $this->setY(20);
            $this->cell(190, 6, 'SRUTHI SPECIALITY HOSPITAL', 0, 0, 'C');
            $this->rect(10, 20, 190, $this->getY()+5);

            $this->setFont('times', 'B', 12);
            $this->setY(35);
            $this->cell(190, 5, 'OP RECEIPT', 0, 1, 'C');
            $this->setXY(150, 20);
            $this->setFont('times', '', 9);
            $this->multiCell(52, 5, config('about.address'));
            $this->ln(6);
        }else{
            $this->image(storage_path('app/public/images/img.jpg'), 12, 19, 27, 20);
            $this->setFont('times', 'B', 14);
            $this->setY(20);
            $this->multiCell(190, 6, "SRUTHI CLINIC ",0,'C');
            $this->rect(10, 15, 190, $this->getY()+1);

            $this->setFont('times', 'B', 12);
            $this->setY(35);
            $this->cell(190, 5, 'OP RECEIPT', 0, 1, 'C');
            $this->setXY(150, 20);
            $this->setFont('times', '', 10);
            $address = "P-5/1, Bye Pass Road,\nOpp - To Vasan Eye Care.Ambur\n Contact : 9566638438";
            $this->multiCell(52, 5, $address);
            $this->ln(6);
        }
    }
}
