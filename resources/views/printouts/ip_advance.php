<?php

use App\Libraries\Fpdf\Scripts\RoundedRect;


$pdf = new RoundedRect('P', 'mm', [100, 100]);
$pdf->aliasNbPages();
$pdf->addPage();
$pdf->addFont("texgyrepagella", "B");
$pdf->addFont("texgyrepagella", "");

$pdf->Image(config('paths.logo'), 10, 6, 20, 15);
$pdf->SetFont('texgyrepagella', 'B', 12);
$pdf->SetTextColor(20, 68, 145);
$pdf->Text(35, 15, "IP Advance Receipt");
$pdf->Ln(20);

$pdf->roundedRect(10, 27, 80, 45, 8, 1234);


$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(35, 8, "     IP No", 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(100, 8, ": " . $data->admission->ip_no, 0, 1);

$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(35, 8, "     Advance No", 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(50, 8, ": " . $data->advance_no, 0, 1);

//New Line
$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(35, 8, "     Patient Name", 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(100, 8, ": " . $data->patient->salutation.'.'.$data->patient->name, 0, 1);

$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(35, 8, "     Advance Date", 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(50, 8, ": " . $data->created_at->format('d-m-Y h:i A'), 0, 1);

//New Line
$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(35, 8, "     Advance Amount", 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(100, 8, ": " . $data->amount, 0, 1);

$pdf->text(55, 90, "Authorized Signature");

$pdf->output();
