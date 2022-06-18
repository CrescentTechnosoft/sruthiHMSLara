<?php

use ViewClasses\Printouts\IPAdmission;

$pdf = new IPAdmission();
$pdf->addPage();
$pdf->addFont('texgyrepagella', '');
$pdf->addFont('texgyrepagella', 'B');

$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 5, 'IP NO', 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(110, 5, ': ' . $data->ip_no, 0, 0);

$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 5, 'Ward Name', 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(50, 5, ! is_null($data->ward) ? ": " . $data->ward->ward : ':', 0, 1);

// New Line
$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 5, "Patient ID", 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(30, 5, ': ' . $data->pt_id, 0, 0);

$pdf->setFont('texgyrepagella', 'B', 12);

$pdf->cell(80, 10, 'ADMISSION CUM CASE SHEET', 0, 0);
$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 5, "Room Name", 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(50, 5, ': ' . (! is_null($data->ward) ? $data->ward->room : ''), 0, 1);

$pdf->line(10, $pdf->getY() + 4, 200, $pdf->getY() + 4);
$pdf->setY($pdf->getY() + 10);
// New Line
$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 5, 'Consultant');

$pdf->setFont('texgyrepagella', '', 9);
$pdf->cell(90, 8, ': ' . $data->doctor->name);
$pdf->line(37, $pdf->getY() + 7, 120, $pdf->getY() + 7);

$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 8, 'Admitted On');

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(30, 8, ': ' . $data->created_at->format('d-m-Y h:i A'), 0, 1);
$pdf->line(153, $pdf->getY() - 1, 200, $pdf->getY() - 1);

// New Line
$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 8, 'Patient Name', 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(90, 8, ': ' .$data->patient->salutation.'.'.$data->patient->name, 0, 0);
$pdf->line(37, $pdf->getY() + 7, 120, $pdf->getY() + 7);

$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 8, 'Age / Gender', 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(50, 8, ': ' . $data->patient->age . ' / ' . $data->patient->gender, 0, 1);
$pdf->line(153, $pdf->getY() - 1, 200, $pdf->getY() - 1);

// Print the text
$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 8, 'Address', 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(2, 8, ':', 0, 0);
$pdf->setXY($pdf->getX(), $pdf->getY() + 2);

$pdf->multiCell(70, 5, $data->patient->address, 0);
$pdf->setXY(10, $pdf->getY());

$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 8, 'Contact No', 0, 0);

$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(200, 8, ': ' . $data->patient->contact_no, 0, 1);
$pdf->line(37, $pdf->getY() - 1, 120, $pdf->getY() - 1);

$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 8, 'Witness', 0, 0);

$pdf->cell(70, 8, ': ', 0, 1);
$pdf->line(10, $pdf->getY(), 200, $pdf->getY());

$pdf->cell(25, 8, 'Diagnosis          :', 0, 0);
$pdf->setFont('texgyrepagella', '', 10);
$pdf->cell(170, 8, '  ' . $data->diagnosis, 0, 1);

$pdf->setFont('texgyrepagella', 'B', 10);
$pdf->cell(25, 8, 'Complaints', 0, 0);
$pdf->cell(70, 8, ': ', 0, 1);

$pdf->cell(25, 16, 'Duration', 0, 0);
$pdf->cell(70, 16, ': ', 0, 1);
$pdf->line(10, $pdf->getY(), 200, $pdf->getY());

$pdf->cell(25, 8, 'History', 0, 0);
$pdf->cell(70, 8, ': ', 0, 1);
$pdf->setY($pdf->getY() + 10);
$pdf->line(10, $pdf->getY(), 200, $pdf->getY());

$pdf->cell(41, 8, 'Condition on Admission', 0, 0);
$pdf->cell(70, 8, ': ', 0, 1);
$pdf->setY($pdf->getY() + 15);
$pdf->line(10, $pdf->getY(), 200, $pdf->getY());

$pdf->cell(30, 8, 'Special Reports', 0, 0);
$pdf->cell(70, 8, ': ', 0, 1);
$pdf->setY($pdf->getY() + 15);
$pdf->line(10, $pdf->getY(), 200, $pdf->getY());

$pdf->cell(25, 8, 'Treatment', 0, 0);
$pdf->cell(70, 8, ': ', 0, 1);
$pdf->setY($pdf->getY() + 7);
$pdf->line(10, $pdf->getY(), 200, $pdf->getY());

$pdf->cell(32, 8, 'Surgery Proposed', 0, 0);
$pdf->cell(70, 8, ': ', 0, 1);
$pdf->output();
