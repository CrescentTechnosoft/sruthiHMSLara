<?php

use App\Libraries\Fpdf\Scripts\McTable;

$pdf = new McTable();
$pdf->aliasNbPages();
$pdf->AddPage();

$pdf->SetFont('times', 'B', 12);
$monthName = DateTime::createFromFormat('n', $month)->format('M');
$pdf->Cell(110, 10, 'Monthly Collection of ' . $monthName . ' ' . $year, 0, 1, 'C');

$pdf->ln(3);
$pdf->setDrawColor(169, 169, 169);
$pdf->setFont('times', 'B', 10);

$pdf->setAligns(['R', 'L', 'R', 'R', 'R', 'R', 'R']);
$pdf->setWidths([10, 25, 25, 25, 25, 25, 25]);

$pdf->createRow(['S No', 'Bill Date', 'No of Bills', 'Cash', 'Card', 'Others', 'Total'], 7, true);
$pdf->setFont('times', '', 9);

$dates = $collections->pluck('date')->unique();

$grandTotal = 0;
$grandCash = 0;
$grandCard = 0;
$grandOthers = 0;
$total = 0;
$cash = 0;
$card = 0;
$others = 0;
$bills = 0;
$totalBills = 0;

$i = 0;
foreach ($dates as $date) {
    $total = 0;
    $cash = 0;
    $card = 0;
    $others = 0;
    $bills = 0;
    foreach ($collections as $collection) {
        if ($date === $collection->date) {

            $total += $collection->paid;
            $bills++;
            switch ($collection->payment_method) {
                case 'Cash':
                    $cash += floatval($collection->paid);
                    break;
                case 'Card':
                    $card += floatval($collection->paid);
                    break;
                default :
                    $others += floatval($collection->paid);
            }
        }
    }
    $pdf->createRow([++$i, $date, $bills, $cash, $card, $others, $total], 6, true);
    $grandTotal += $total;
    $grandCash += $cash;
    $grandCard += $card;
    $grandOthers += $others;
    $totalBills += $bills;
}

$pdf->SetFont('times', 'B', 10);

$pdf->Cell(160, 7, 'Total No of Bills Done ' . $totalBills, 'LTR', 1);
$pdf->Cell(160, 7, 'Total Amount Collected is Rs.' . number_format($grandTotal, 2), 'LR', 1);
$pdf->Cell(160, 7, 'Total Amount Collected as Cash is Rs.' . number_format($grandCash, 2), 'LR', 1);
$pdf->Cell(160, 7, 'Total Amount Collected as Card is Rs.' . number_format($grandCard, 2), 'LR', 1);
$pdf->Cell(160, 7, 'Total Amount Collected as Other Payments is Rs.' . number_format($grandOthers, 2), 'LBR', 1);


$pdf->Output('I', 'Monthly Collection.pdf');
