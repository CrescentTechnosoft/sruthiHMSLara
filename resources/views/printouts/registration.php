<?php

use App\Libraries\Fpdf\Scripts\RoundedRect;


$pdf = new RoundedRect('P', 'mm', 'A4');
$pdf->aliasNbPages();
$pdf->addPage();

$pdf->setLeftMargin(20);
$pdf->Image(config('paths.logo'), 10, 6, 20, 15);
$pdf->SetFont('times', 'B', 14);
$pdf->SetTextColor(20, 68, 145);
$pdf->Text(35, 15, 'Registration Details');
$pdf->Ln(20);

$pdf->roundedRect(20, 27, 130, 45, 8, 1234);


$pdf->setFont('times', 'B', 11);
$pdf->cell(35, 8, "     UHID", 0, 0);

$pdf->setFont('times', '', 11);
$pdf->cell(100, 8, ": " . $regDetails->uhid, 0, 1);

$pdf->setFont('times', 'B', 11);
$pdf->cell(35, 8, "     Reg Date", 0, 0);

$pdf->setFont('times', '', 11);
$pdf->cell(50, 8, ": " . $regDetails->created_at->format('d-m-Y'), 0, 1);

//New Line
$pdf->setFont('times', 'B', 11);
$pdf->cell(35, 8, "     Patient Name", 0, 0);

$pdf->setFont('times', '', 11);
$pdf->cell(100, 8, ": " . $regDetails->salutation.'.'.$regDetails->name, 0, 1);

$pdf->setFont('times', 'B', 11);
$pdf->cell(35, 8, "     Age / Gender", 0, 0);

$pdf->setFont('times', '', 11);
$pdf->cell(50, 8, ": " . $regDetails->age.' / '.$regDetails->gender, 0, 1);

$pdf->setFont('times', 'B', 11);
$pdf->cell(35, 8, "     Contact No", 0, 0);

$pdf->setFont('times', '', 11);
$pdf->cell(100, 8, ": " . $regDetails->contact_no, 0, 1);

$pdf->output();
