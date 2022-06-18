<?php

namespace ViewClasses;

use App\Libraries\Fpdf\Scripts\Code128;

class IPLabResult extends Code128
{

    public string $header;
    public object $admission;
    public string $bill_date;
    public string $rpt_date;

    public function header(): void
    {
        if ($this->header === 'wh') {
            $this->ln(5);
            $this->image(config('paths.logo'), 12, 6, 30, 20);

            $this->setFont('archivo', 'B', 16);
            $this->text(75, $this->getY() - 2, 'SRUTHI SPECIALITY HOSPITAL');
            $this->setFont('archivo', '', 10);
            $this->multiCell(200, 5, config('about.address'), 0, 'C');

            $this->setXY(10, 35);
        } else {
            $this->setXY(10, 40);
        }

        $this->setFont('opensans', '', 10);
        $this->cell(25, 12, 'Patient Name', 0, 0);

        $this->setFont('opensans', 'B', 10);
        $this->cell(100, 12, ': ' . $this->admission->patient->salutation . '.' . $this->admission->patient->name, 0, 0);
        $this->code128(163, $this->getY() + 1, $this->admission->ip_no, 35, 7);

        $this->setFont('opensans', '', 10);

        $this->cell(25, 12, 'IP No', 0, 0);
        $this->text(163, $this->getY() + 11, $this->admission->ip_no);
        $this->cell(40, 12, ': ', 0, 1);

        $this->cell(25, 6, 'Age / Gender', 0, 0);
        $this->cell(100, 6, ': ' . $this->admission->patient->age . ' / ' . $this->admission->patient->gender, 0, 0);

        $this->cell(25, 6, 'Contact No', 0, 0);
        $this->cell(40, 6, ': ' . $this->admission->patient->contact_no, 0, 1);

        $this->cell(25, 6, 'UHID', 0, 0);
        $this->cell(100, 6, ': ' . $this->admission->pt_id, 0, 0);

        $this->cell(25, 6, 'Collected On', 0, 0);
        $this->cell(40, 6, ': ' . $this->bill_date, 0, 1);

        $this->cell(25, 6, 'Referred By', 0, 0);
        $this->cell(100, 6, ': ' . $this->admission->doctor->name, 0, 0);

        $this->cell(25, 6, 'Reported On', 0, 0);
        $this->cell(40, 6, ': ' . $this->rpt_date, 0, 1);

        if ($this->pageNo() !== 1) {
            $this->ln(5);
            $this->addHeader();
        }
    }

//    public function footer(): void
//    {
//        $this->setY(-17);
//        if ($this->header === 'WH') {
//             $this->image(APPPATH.'Images/Footer.jpg', 0, $this->getY(), 210, 15);
//        }
//    }

    public function addHeader()
    {
        $this->line(10, $this->getY() - 1, 200, $this->getY() - 1);
        $this->setFont('opensans', 'B', 9);
        $this->createRow([
            'TEST NAME',
            'RESULT',
            'UNIT',
            'BIOLOGICAL REFERENCE INTERVAL',
                ], 6, false);
        $this->line(10, $this->getY(), 200, $this->getY());
    }

    public function rowForResult(array $data, int $height = 5, bool $rect = true, string $norm = 'N')
    {
        // Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); ++$i) {
            $nb = max($nb, $this->nbLines($this->widths[$i], $data[$i]));
        }
        $h = $height * $nb;
        // Issue a page break first if needed
        $this->checkPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); ++$i) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->getX();
            $y = $this->getY();
            // Draw the border
            if ($rect) {
                $this->rect($x, $y, $w, $h);
            }

            if ($i === 1 && $norm !== 'N') {
                $this->setFont('opensans', 'B');
            } else {
                $this->setFont('opensans', '');
            }
            // Print the text
            $this->multiCell($w, $height, $data[$i], 0, $a);
            // Put the position to the right of the cell
            $this->setXY($x + $w, $y);
        }
        // Go to the next line
        $this->ln($h);
    }

}
