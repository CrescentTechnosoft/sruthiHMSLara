<?php

namespace ViewClasses;

use App\Libraries\Fpdf\Scripts\Code128;

class OPLabResult extends Code128
{

    public string $header;

    public function header()
    {
        if ($this->header === 'wh') {
            $this->Image(config('paths.logo'), 12, 6, 30, 20);
            $this->SetFont('times', 'B', 14);
            $this->setY(7);
            $this->Cell(190, 6, config('about.name'), 0, 0, 'C');
            $this->Rect(10, 5, 190, 22);

            $this->SetFont('times', 'B', 12);
            $this->SetY(22);
            $this->Cell(190, 5, 'OP Lab Result', 0, 1, 'C');
            $this->SetXY(150, 6);
            $this->SetFont('times', '', 9);
            $this->MultiCell(52, 5, config('about.address'));
            $this->Ln(6);
        } else {
            $this->SetY(50);
        }
        if ($this->PageNo() !== 1) {
            $this->Ln(5);
            $this->SetFont('times', 'B', 10);
            $this->createRow(['Test Name', 'Result', 'Units', 'Normal Range']);
        }
    }

    public function rowForResult(array $data, int $height = 5, bool $rect = true, $norm = 'N')
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); ++$i) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = $height * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); ++$i) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($rect) {
                $this->Rect($x, $y, $w, $h);
            }
            //Print the text
            if ($i === 1 && $norm !== 'N') {
                $this->SetFont('times', 'B');
            }
            $this->MultiCell($w, $height, $data[$i], 0, $a);
            if ($i === 1 && $norm !== 'N') {
                $this->SetFont('times');
            }
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

}
