<?php

namespace View;

use App\Libraries\Fpdf\Scripts\Code128;

class PDF extends Code128
{
    public bool $isLastPage = false;

    public string $headerType;

    public string $reportedPerson = '';

    public object $patientData;

    public object $firstLabData;

    public string $billDate;

    public string $rptDate;

    public function header(): void
    {
        if ($this->headerType === 'wh') {
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
        $this->cell(100, 12, ': '.$this->patientData->registration->salutation.'.'.$this->patientData->registration->name, 0, 0);
        $this->code128(163, $this->getY() + 1, $this->patientData->bill_no, 35, 7);

        $this->setFont('opensans', '', 10);

        $this->cell(25, 12, 'SID', 0, 0);
        $this->text(163, $this->getY() + 11, $this->patientData->bill_no);
        $this->cell(40, 12, ': ', 0, 1);

        $this->cell(25, 6, 'Age / Gender', 0, 0);
        $this->cell(100, 6, ': '.$this->patientData->registration->age.' / '.$this->patientData->registration->gender, 0, 0);

        $this->cell(25, 6, 'Contact No', 0, 0);
        $this->cell(40, 6, ': '.$this->patientData->registration->contact_no, 0, 1);

        $this->cell(25, 6, 'UHID', 0, 0);
        $this->cell(100, 6, ': '.$this->patientData->pt_id, 0, 0);

        $this->cell(25, 6, 'Collected On', 0, 0);
        $this->cell(40, 6, ': '.$this->billDate, 0, 1);

        $this->cell(25, 6, 'Referred By', 0, 0);
        $this->cell(100, 6, ': '.$this->patientData->consultant, 0, 0);

        $this->cell(25, 6, 'Reported On', 0, 0);
        $this->cell(40, 6, ': '.$this->rptDate, 0, 1);

        if ($this->pageNo() !== 1) {
            $this->ln(5);
            $this->addHeader();
        }
    }

    public function footer(): void
    {
        $this->setY(-17);
        if ($this->headerType === 'WH') {
            // $this->image(APPPATH.'Images/Footer.jpg', 0, $this->getY(), 210, 15);
        }
    }

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
        for ($i = 0; $i < count($data); ++$i ) {
            $nb = max($nb, $this->nbLines($this->widths[$i], $data[$i]));
        }
        $h = $height * $nb;
        // Issue a page break first if needed
        $this->checkPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); ++$i ) {
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

$pdf = new PDF();
$pdf->setAuthor('Crescent Technosoft');

// $pdf->firstLabData=$LabData[0];
$pdf->patientData = $data;
$pdf->headerType = $HeaderType;
// $pdf->reportedPerson=$LabData[0]->ReportedBy;
$pdf->billDate = $data->created_at->format('d/m/Y h:i A');
$pdf->rptDate = $data->result->updated_at->format('d/m/Y h:i A');
$pdf->addFont('archivo', 'B');
$pdf->addFont('archivo', '');
$pdf->addFont('opensans', 'B');
$pdf->addFont('opensans', '');
$pdf->setFont('archivo', 'B', 10);

$pdf->aliasNbPages();
$pdf->addPage();
$pdf->setLeftMargin(10);
$pdf->setAutoPageBreak(true, 10);

// $pdf->setDrawColor(171, 176, 172);
$pdf->setLineWidth(.1);
$pdf->setWidths([
    65,
    40,
    25,
    60,
]);
$pdf->setAligns([
    'L',
    'C',
    'L',
]);
$pdf->setFont('opensans', 'B', 12);
$pdf->cell(190, 7, 'FINAL REPORT', 0, 1, 'C');
// $pdf->line(95, $pdf->getY()-2, 115, $pdf->getY()-2);
$pdf->addHeader();

$categories = array_values(array_unique(array_map(fn (array $val): string => $val['category'], $catData)));

$totalCat = count($categories) - 1;
$totalTests = count($catData) - 1;
$totalFields = count($results) - 1;

$groups = [];
$addedTests = [];
foreach ($categories as $catIndex => $category) {
    $pdf->ln(2);
    $pdf->checkPageBreak(18);
    $pdf->setFont('opensans', 'B', 10);
    $pdf->multiCell(190, 7, $category, 0, 'C');
    foreach ($catData as $testIndex => $coll) {
        if ($coll['category'] === $category) {
            foreach ($results as $fieldIndex => $lab) {
                if ($coll['category'] === ($lab->category ?? $lab->test->category) && $coll['testName'] === ($lab->name ?? $lab->test->name)) {
                    // Checking using TestName and Field Name in case of TestID and FieldID Same Problem
                    if ($lab->name !== null && !in_array($lab->test_id, $addedTests) && $lab->name !== $lab->test->name) {
                        $pdf->checkPageBreak(12);
                        $pdf->setFont('opensans', 'B', 10);
                        $pdf->multiCell(190, 6, $lab->name, 0, 'L');
                        $addedTests[] = $lab->test_id;
                    }
                    if ($lab->FieldCategory !== '') {
                        $pdf->setFont('opensans', 'B');
                        $pdf->cell(190, 6, $lab->FieldCategory, 0, 1);
                    }
                    $pdf->setFont('opensans', '', 9);
                    $pdf->ln(3);
                    $test_name = $lab->test->method !== '' ? $lab->test->name.' ('.$lab->test->method.')' : $lab->test->name;
                    $isLast = $totalCat === $catIndex && $totalTests === $testIndex && $totalFields === $fieldIndex;
                    if ($isLast) {
                        $lines = max($pdf->nbLines(60, $test_name), $pdf->nbLines(60, $lab->test->reference_range));
                        $pdf->checkPageBreak((6 * $lines) + 25);
                    }
                    $pdf->rowForResult([
                        $test_name,
                        $lab->result,
                        $lab->test->units,
                        $lab->test->reference_range,
                    ], 5, false, $lab->result_type);
                    if (strlen(trim($lab->Comments)) > 0) {
                        $pdf->setFontSize(9);
                        $nb = $pdf->nbLines(190, $lab->Comments);
                        $pdf->checkPageBreak($nb * 5);
                        $pdf->multiCell(190, 5, $lab->Comments, 1, 'L');
                    }
                }
            }
        }
    }
}

$pdf->setY($pdf->getY() + 10);

// $pdf->image(APPPATH.'Images/ApexDoctorSign.jpg', 15, $pdf->getY()-10, 35, 12);
if ($data->hasSignature) {
    $pdf->image($data->Signature, 150, $pdf->getY() - 8, 40, 12);
}

$pdf->setTextColor(0, 0, 0);
$pdf->setFont('archivo', 'B', 10);
$pdf->setX(11);
$pdf->cell(25, 5, '', 0, 0, 'C');
$pdf->cell(60);
$pdf->cell(85, 5, '', 0, 1, 'R');
$pdf->setX(20);
$pdf->cell(140, 5, 'Dr.Demo', 0, 0);

$pdf->cell(50, 5, $data->technician, 0, 1);

$pdf->output(isset($type) ? $type : 'I', isset($name) ? $name : 'Bill #'.$data->month.$data->bill_no.'.pdf', 1);
