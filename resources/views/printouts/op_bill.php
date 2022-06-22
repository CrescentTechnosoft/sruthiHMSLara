<?php

use ViewClasses\OPBill;

// Instanciation of inherited class
$pdf = new OPBill();
$pdf->type = $data->type;

$pdf->aliasNbPages();

$pdf->addPage();
$pdf->count = $data->billDetails->count();
$pdf->rect(10, $pdf->getY(), 190, 19);
$pdf->ln(3);
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'UHID', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(100, 5, ': ' . $data->registration->uhid, 0, 0);

$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Bill No', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(50, 5, ': ' . $data->bill_no, 0, 1);

// New Line
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Patient Name', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(100, 5, ': ' . $data->registration->salutation . '.' . $data->registration->name, 0, 0);

$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Bill Date', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(50, 5, ': ' . $data->created_at->format('d-m-Y g:i A'), 0, 1);

// New Line
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Consultant', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(100, 5, ': ' . $data->doctor->name, 0, 1);

// New Line
// $pdf->setFont('times', 'B', 10);
// $pdf->cell(25, 7, "Contact No", 0, 0);
//
// $pdf->setFont('times', '', 10);
// $pdf->cell(110, 7, ": " . $data->ContactNo, 0, 1);

$pdf->setFont('times', 'B', 10);

$pdf->ln(1);
$pdf->cell(15, 7, '  S NO', 1, 0, 'R');
$pdf->cell(155, 7, 'Service Name', 'TB', 0, 'C');
$pdf->cell(20, 7, 'Amount', 1, 1, 'R');

$pdf->setFont('times', '', 9);

$sNo = 0;
// $pdf->isFinished = false;
foreach ($data->billDetails as $result) {
    if (floatval($result->fees) > 0) {
        $pdf->cell(15, 7, ++$sNo, 'LR', 0, 'R');
        $pdf->cell(155, 7, $result->category . ' - ' . $result->fees_type, 0, 0);
        $pdf->cell(20, 7, $result->fees, 'LR', 1, 'R');
    }
}
//$pdf->setWidths([
//    ''
//]);
// New Line
$pdf->ln(1);
$pdf->setFont('times', 'B', 10);

$pdf->rect(10, $pdf->getY() - 1, 190, ((float) $data->discount > 0 || (float) $data->due > 0) ? 30 : 20);

$pdf->cell(22, 5, 'Total Amount ', 0, 0);
$pdf->cell(120, 5, ': Rs.' . $data->total, 0, 0);

if (floatval($data->discount) > 0) {
    $pdf->cell(22, 5, 'Discount', 0, 0);
    $pdf->cell(32, 5, ': Rs.' . $data->discount, 0, 1);

    $pdf->cell(23, 5, 'Net Amount', 0, 0);
    $pdf->cell(32, 5, ': Rs.' . $data->sub_total, 0, 1);
} else {
    $pdf->ln(5);
}

if (floatval($data->due) > 0) {
    $pdf->cell(22, 5, 'Paid Amount', 0, 0);
    $pdf->cell(120, 5, ': Rs.' . $data->paid, 0, 0);
    $pdf->cell(23, 5, 'Due Amount', 0, 0);
    $pdf->cell(32, 5, ': Rs.' . $data->due, 0, 1);
}

$pdf->ln(6);
$pdf->cell(144, 5, 'Billed By : ' . $data->user->name, 0, 0);
$pdf->cell(20, 5, 'Cashier', 0, 0);
//
// $pdf->isFinished = true;

$pdf->output('', 'Bill #' . $data->BillNo . '.pdf', 1);
