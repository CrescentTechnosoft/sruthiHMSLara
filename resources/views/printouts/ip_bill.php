<?php

use ViewClasses\IPBill;

$room_name=$data->billDetails
->where('department', '=', 'IP Room Fees')
->last()
->fees_type;

$pdf = new IPBill();
$pdf->aliasNbPages();
$pdf->addPage();
$pdf->rect(10, $pdf->getY(), 190, 30);
$pdf->ln(3);
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'IP NO', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(100, 5, ': ' . $data->admission->ip_no, 0, 0);

$pdf->setFont('times', 'B', 10);
$pdf->cell(27, 5, 'Bill Type', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(50, 5, ': ' . $data->payment_method, 0, 1);

//New Line
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Patient Name', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(100, 5, ': ' .$data->patient->salutation.'.'.$data->patient->name, 0, 0);

$pdf->setFont('times', 'B', 10);
$pdf->cell(27, 5, 'Bill No', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(50, 5, ': ' . $data->bill_no, 0, 1);

//New Line
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Age / Gender', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(100, 5, ': ' . $data->patient->age . ' / ' . $data->patient->gender, 0, 0);

$pdf->setFont('times', 'B', 10);
$pdf->cell(27, 5, 'Admission Date', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(50, 5, ': ' .$data->admission->created_at->format('d-m-Y h:i A'), 0, 1);

//New Line
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Consultant', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(100, 5, ': ' . $data->admission->doctor->name, 0, 0);

$pdf->setFont('times', 'B', 10);
$pdf->cell(27, 5, 'Discharge Date', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(50, 5, ': ' . $data->discharge->created_at->format('d-m-Y h:i A'), 0, 1);

//New Line
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Room Details', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(100, 5, ': ' . $room_name, 0, 0);

$pdf->setFont('times', 'B', 10);
$pdf->cell(27, 5, 'Bill Date', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(50, 5, ': ' .$data->created_at->format('d-m-Y h:i A'), 0, 1);

$pdf->ln(2);
//Table Starts Here
$pdf->setWidths([10,60,70,18,10,22]);
$pdf->setAligns(['R','L','L','R','R','R']);
$pdf->setFont('times', 'B', 10);
$pdf->createRow(['S.No','Category','Fees Type','Fees','Qty','Total'], 7, true);

$pdf->setFont('times', '', 9);


$sNo = 0;
foreach ($data->billDetails as $val) {
    if ((float)$val->total>0) {
        $pdf->createRow([++$sNo.'.',$val->category,$val->fees_type,$val->cost,$val->qty,$val->total], 6, true);
    }
}

//New Line
$pdf->ln();
$pdf->setFont('times', 'B', 10);
$pdf->cell(170, 5, 'Total Amount : ', 0, 0, 'R');
$pdf->cell(20, 5, 'Rs. '.$data->total, 0, 1, 'R');
if ((float)$data->advance_paid > 0) {
    $pdf->cell(170, 5, 'Advance Paid : ', 0, 0, 'R');
    $pdf->cell(20, 5, 'Rs. '.$data->advance_paid, 0, 1, 'R');
}
if ((float)$data->discount > 0) {
    $pdf->cell(170, 5, 'Discount : ', 0, 0, 'R');
    $pdf->cell(20, 5, 'Rs. '.$data->discount, 0, 1, 'R');
}
if ($data->total !== $data->sub_total) {
    $pdf->cell(170, 5, 'Sub Total : ', 0, 0, 'R');
    $pdf->cell(20, 5, 'Rs. '.$data->sub_total, 0, 1, 'R');
}
$pdf->cell(170, 5, 'Paid Amount : ', 0, 0, 'R');
$pdf->cell(20, 5, 'Rs. '.$data->paid, 0, 1, 'R');
if ((float)$data->due > 0) {
    $pdf->cell(170, 5, 'Due Amount : ', 0, 0, 'R');
    $pdf->cell(20, 5, 'Rs. '.$data->due, 0, 1, 'R');
}
$pdf->setY($pdf->getY()-8);
$pdf->setTextColor(12, 117, 15);
$pdf->cell(190, 10, 'Paid Amount In Words : ' . getIndianCurrency(floatval($data->paid)), 0, 1, 'L');

$pdf->output('', 'Bill #' . $data->bill_no . '.pdf', 1);
