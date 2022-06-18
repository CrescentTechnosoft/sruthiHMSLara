<?php

use ViewClasses\OPLabResult;

// Instanciation of inherited class
$pdf = new OPLabResult();
$pdf->AliasNbPages();
$pdf->header = $header;
$pdf->AddFont('times');
$pdf->AddFont('times', 'B');
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 15);
// $pdf->Rect(10, $pdf->GetY(), 190, 32);

$pdf->SetFont('times', '', 11);
$pdf->Cell(190, 7, 'PATIENT INFORMATION', 1, 1);

$pdf->SetFont('times', '', 10);
$pdf->Cell(25, 12, 'Patient Name', 'LBR', 0);

$pdf->SetFont('times', 'B', 10);
$pdf->Cell(100, 12, $bill_data->registration->salutation.'.'.$bill_data->registration->name, 'BR', 0);
$pdf->code128(163, $pdf->GetY() + 1, $bill_data->bill_no, 25, 7);

$pdf->SetFont('times', '', 10);

$pdf->Cell(25, 12, 'SID', 'BR', 0);
$pdf->Text(163, $pdf->GetY() + 11, $bill_data->bill_no);
$pdf->Cell(40, 12, '', 'BR', 1);

$pdf->Cell(25, 6, 'Age / Gender', 'LBR', 0);
$pdf->Cell(100, 6, $bill_data->registration->age.' / '.$bill_data->registration->gender, 'BR', 0);

$pdf->Cell(25, 6, 'Contact No', 'BR', 0);
$pdf->Cell(40, 6, $bill_data->registration->contact_no, 'BR', 1);

$pdf->Cell(25, 6, 'UHID', 'LBR', 0);
$pdf->Cell(100, 6, $bill_data->registration->id, 'BR', 0);

$pdf->Cell(25, 6, 'Collected On', 'BR', 0);
$pdf->Cell(40, 6, $bill_data->created_at->format('d-m-Y h:i A'), 'BR', 1);

$pdf->Cell(25, 6, 'Consultant', 'LBR', 0);
$pdf->Cell(100, 6, $bill_data->doctor->name, 'BR', 0);

$pdf->Cell(25, 6, 'Reported On', 'BR', 0);
$pdf->Cell(40, 6, $report_date->created_at->format('d-m-Y h:i A'), 'BR', 1);
$pdf->Ln(3);

$pdf->SetWidths([60, 45, 25, 60]);
$pdf->SetAligns(['L', 'L', 'L', 'L']);
$pdf->SetFont('times', 'B', 10);
$pdf->createRow(['Test Name', 'Result', 'Units', 'Normal Range']);
$pdf->SetFont('times', '', 9);

$tests = $results->map->only(['category', 'name'])->unique();
$categories = $tests->pluck('category')->unique();

$added_tests = [];
$pdf->SetDrawColor(122, 125, 123);
foreach ($categories as $category) {
    $pdf->CheckPageBreak(24);
    $pdf->SetFont('times', 'B', 10);
    $pdf->SetY($pdf->GetY());
    $pdf->SetX(10);
    $pdf->MultiCell(190, 7, $category, 1, 'C');
    $pdf->SetFont('times', '');
    foreach ($tests as $test) {
        if ($test['category'] === $category) {
            foreach ($results as $result) {
                if ($category === $result->category && $test['name'] === $result->name) {
                    if ($result->name !== $result->field_name && !in_array($result->name, $added_tests)) {
                        $pdf->CheckPageBreak(18);
                        $pdf->SetFont('times', 'B');
                        $pdf->MultiCell(190, 7, $result->name, 1, 'L');
                        $pdf->SetFont('times', '');
                        $added_tests[] = $result->name;
                    }
                    if (strlen(trim($result->field_category)) > 0) {
                        $pdf->CheckPageBreak(12);
                        $pdf->SetFont('times', 'B');
                        $pdf->MultiCell(190, 5, $result->field_category, 1, 'L');
                        $pdf->SetFont('times', '');
                    }
                    $pdf->rowForResult([
                        $result->field_name,
                        $result->result,
                        $result->units,
                        $result->reference_range,
                    ], 6, true, $result->type);

                    if (strlen(trim($result->method)) > 0) {
                        $pdf->SetFontSize(8);
                        $pdf->CheckPageBreak(5);
                        $border = strlen(trim($result->comments)) > 0 ? 'LR' : 'LBR';
                        $pdf->MultiCell(190, 5, 'Method : '.$result->method, $border, 'L');
                        $pdf->SetFontSize(10);
                    }
                    if (strlen(trim($result->comments)) > 0) {
                        $pdf->SetFontSize(9);
                        $nb = $pdf->NbLines(190, $result->comments);
                        $pdf->CheckPageBreak($nb * 5);
                        $pdf->MultiCell(190, 5, $result->comments, 'LBR', 'L');
                        $pdf->SetFontSize(10);
                    }
                }
            }
        }
    }
}
$pdf->Ln(15);
$pdf->SetFont('times', 'B', 10);
$pdf->Cell(85, 5, '', 0, 0);
$pdf->Cell(80, 5, '', 0, 1, 'R');

$pdf->Cell(93, 5, '', 0, 0);
$pdf->Cell(80, 5, '(Lab Incharge)', 0, 1, 'R');
$pdf->Output('', 'Bill #'.$bill_data->bill_no.'.pdf', 1);
