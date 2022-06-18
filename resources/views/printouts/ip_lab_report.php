<?php

use ViewClasses\IPLabResult;

$pdf = new IPLabResult();
$pdf->setAuthor('SRUTHI SPECIALITY HOSPITAL');

// $pdf->firstLabData=$LabData[0];
$pdf->admission = $data->admission;
$pdf->header = $HeaderType;
// $pdf->reportedPerson=$LabData[0]->ReportedBy;
$pdf->bill_date = $data->created_at->format('d/m/Y h:i A');
$pdf->rpt_date = $data->result->updated_at->format('d/m/Y h:i A');
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
