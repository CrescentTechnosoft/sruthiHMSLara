<?php

use ViewClasses\Reports\Footer;

$pdf = new Footer();
$pdf->aliasNbPages();
$pdf->addPage();
$pdf->addFont("texgyrepagella", "B");
$pdf->addFont("texgyrepagella", "");
$pdf->setFont('texgyrepagella', 'B', 12);
$pdf->cell(180, 10, "IP Admission Report", 0, 1, 'C');

$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(20, 5, 'PID', 1, 0);
$pdf->cell(20, 5, 'IP No', 1, 0);
$pdf->cell(80, 5, 'Patient Name', 1, 0);
$pdf->cell(50, 5, 'Admission Date', 1, 1);

$pdf->setFont('texgyrepagella', '', 10);
foreach ($admissions as $admission) {
    $pdf->cell(20, 6, $admission->pt_id, 1, 0);
    $pdf->cell(20, 6, $admission->ip_no, 1, 0);
    $pdf->cell(80, 6, $admission->patient->salutation.'.'.$admission->patient->name, 1, 0);
    $pdf->cell(50, 6, $admission->created_at->format('d-m-Y'), 1, 1);
}
$pdf->ln(2);


$pdf->output('I', 'IP Report.pdf');
