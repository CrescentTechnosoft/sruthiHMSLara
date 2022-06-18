<?php

use ViewClasses\Reports\Registrations;

$pdf = new Registrations();
$pdf->aliasNbPages();

$pdf->start_date = $start_date;
$pdf->end_date = $end_date;
$pdf->setWidths([12, 20, 50, 30, 30, 50]);
$pdf->setAligns(['R']);
$pdf->addPage();

$pdf->setFont("times", '', 9);
foreach ($regs as $reg) {
    $pdf->createRow(
            [
                $reg->id,
                $reg->created_at->format('d-m-Y'),
                $reg->salutation.'.'.$reg->name,
                $reg->age . ' / ' . $reg->gender,
                $reg->contact_no,
                $reg->doctor->name
            ], 6, true);
}
$pdf->setFont('times', 'B', 10);
$pdf->cell(192, 8, 'Total Patients Registered is ' . $regs->count(), 'LBR', 1, 'L');
$pdf->output("I", "Registration List.pdf");
