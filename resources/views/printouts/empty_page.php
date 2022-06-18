<?php

use App\ThirdParty\Fpdf\Fpdf;

$pdf = new Fpdf;

$pdf->addPage();
$pdf->addFont('opensans', 'B');
$pdf->setFont('opensans', 'B', 12);
$pdf->cell(190, 6, $message, 0, 1, 'C');
$pdf->output();
