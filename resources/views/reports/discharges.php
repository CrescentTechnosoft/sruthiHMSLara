<?php

use ViewClasses\Reports\Footer;

$pdf = new Footer();
$pdf->aliasNbPages();
$pdf->addPage();
$pdf->addFont("texgyrepagella", "B");
$pdf->addFont("texgyrepagella", "");
$pdf->setFont('texgyrepagella', 'B', 12);
$pdf->cell(180, 10, "IP Discharge Report", 0, 1, 'C');

$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(20, 5, 'PID', 1, 0);
$pdf->cell(20, 5, 'IP No', 1, 0);
$pdf->cell(50, 5, 'Patient Name', 1, 0);
$pdf->cell(50, 5, 'Admitted ON', 1, 0);
$pdf->cell(50, 5, 'Discharged ON', 1, 1);

$pdf->setFont('texgyrepagella', '', 10);
foreach ($discharges as $discharge) {
    $pdf->cell(20, 5, $discharge->pt_id, 1, 0, 'R');
    $pdf->cell(20, 5, $discharge->admission->ip_no, 1, 0, 'R');
    $pdf->cell(50, 5, $discharge->patient->salutation.'.'.$discharge->patient->name, 1, 0);
    $pdf->cell(50, 5, $discharge->admission->created_at->format('d-m-Y'), 1, 0);
    $pdf->cell(50, 5, $discharge->created_at->format('d-m-Y'), 1, 1);
}
$pdf->ln(2);


$pdf->output('I', 'IP Report.pdf');
