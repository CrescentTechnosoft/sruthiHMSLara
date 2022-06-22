<?php

use ViewClasses\DischargeView;
use App\Models\Doctor;

$pdf = new DischargeView();

$pdf->aliasNbPages();
$pdf->addPage();
$pdf->setFont('times', 'B', 12);
$pdf->ln(3);
$pdf->setLineWidth(0.3);
$pdf->line(10, $pdf->getY(), 200, $pdf->getY());
$pdf->setY($pdf->getY() + 1);
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Patient Name', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(100, 5, ': ' . $data->patient->salutation.'.'.$data->patient->name, 0, 0);

$pdf->setFont('times', 'B', 10);
$pdf->cell(27, 5, 'IP No', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(50, 5, ': ' . $data->admission->ip_no, 0, 1);

//New Line
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Age / Gender', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(100, 5, ': ' . $data->patient->age . ' / ' . $data->patient->gender, 0, 0);

$pdf->setFont('times', 'B', 10);
$pdf->cell(30, 5, 'Patient ID / UHID', 0, 0);

$pdf->setFont('times', '', 10);

$pdf->cell(50, 5, ': ' . $data->patient->id .'/'.$data->patient->uhid, 0, 1);

//New Line
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Consultant', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(100, 5, ': ' . $data->admission->doctor->name, 0, 0);

$pdf->setFont('times', 'B', 10);
$pdf->cell(27, 5, 'Admitted On', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(50, 5, ': ' . $data->admission->created_at->format('d-m-Y h:i a'), 0, 1);

//New Line
$pdf->setFont('times', 'B', 10);
$pdf->cell(25, 5, 'Address', 0, 0);

$pdf->setFont('times', '', 10);
$pdf->cell(2, 5, ': ', 0, 0);
$pdf->multiCell(100, 5, $data->patient->address);

$pdf->setFont('times', 'B', 10);
$pdf->text(136, 62, 'Discharged On');

$pdf->setFont('times', '', 10);
$pdf->text(163, 62, ': ' . $data->created_at->format('d-m-Y h:i a'));

$pdf->setY($pdf->getY() + 1);
$pdf->line(10, $pdf->getY(), 200, $pdf->getY());

$doctor_ids = \collect(explode('|', $data->consultants))
        ->filter(fn ($val) => $val !== '')
        ->map(fn ($val) => (int) $val);

$doctor_names = $doctor_ids->isEmpty() ? [] : Doctor::whereIn('id', $doctor_ids)->pluck('name')->toArray();

if (count($doctor_names) > 0) {
    $pdf->ln(2);
    $pdf->setFont('times', 'B', 10);
    $pdf->cell(30, 5, 'Consultants : ', 0, 0);
    $pdf->setFont('times', '', 9);
    $pdf->cell(2, 5, ': ');
    $pdf->multiCell(160, 5, implode(PHP_EOL, $doctor_names));
}
if ($data->diagnosis !== '') {
    $pdf->ln(2);
    $pdf->setFont('times', 'B', 10);
    $pdf->cell(30, 5, 'Diagnosis ', 0, 0);
    $pdf->setFont('times', '', 9);
    $pdf->cell(2, 5, ': ');
    $pdf->multiCell(160, 4, $data->diagnosis);
}
if ($data->history !== '') {
    $pdf->ln(2);
    $pdf->setFont('times', 'B', 10);
    $pdf->cell(30, 5, 'History : ', 0, 0);
    $pdf->setFont('times', '', 9);
    $pdf->cell(2, 5, ': ');
    $pdf->multiCell(160, 4, $data->history);
}
if ($data->pt_reaction !== '') {
    $pdf->ln(2);
    $pdf->setFont('times', 'B', 10);
    $pdf->cell(40, 6, 'Clinical Examination : ', 0, 0);
    $pdf->setFont('times', '', 10);
    $pdf->cell(160, 6, $data->pt_reaction, 0, 1);

    $arrKey = ['Pulse', 'BP', 'HB', 'TC', 'WBC', 'Poly', 'Lymp', 'Eos',
        'M', 'B', 'Blood Sugar', 'Blood Urea', 'Scr', 'Crit', 'Plat',];
    $arrVal = ['pulse', 'bp', 'hb', 'tc', 'wbc', 'poly', 'lymp', 'eos',
        'm', 'b', 'blood_sugar', 'urea', 'scr', 'crit', 'plat',];

    foreach ($arrKey as $index => $val) {
        $ln = ($index + 1) % 4 === 0 ? 1 : 0;
        $result = $arrVal[$index];
        $pdf->setFont('times', 'B', 10);
        $pdf->cell(22, 6, $val, 0, 0);
        $pdf->setFont('times', '', 9);
        $pdf->cell(25, 6, ': ' . $data->$result, 0, $ln);
    }
    $pdf->ln(5);
}
$arrKey = ['Investigations', 'Operation Done', 'Courses in Hospital', 'Treatment Given', 'Condition on Discharge', 'Advice', 'Report to the Hospital'];
$arrVal = ['investigations', 'surgery', 'hosp_course', 'treatment', 'condition', 'advice', 'report'];
$dualLines = [2, 4, 6];

$pdf->setWidths([33, 150]);
foreach ($arrKey as $index => $val) {
    $result = $arrVal[$index];
    $lnHeight = in_array($index, $dualLines) ? 8 : 4;
    if ($data->$result !== '') {
        $pdf->ln(2);
        $pdf->setFont('times', 'B', 10);
        $pdf->cell(37, 4, $val);
        $pdf->setFont('times', '', 9);
        $pdf->cell(2, 4, ': ');
        $pdf->multiCell(150, 4, $data->$result);
    }
}
if ($data->death_date !== '|') {
    $date_time = DateTime::createFromFormat('Y-m-d H:i', str_replace('|', ' ', $data->death_date))->format('d-m-Y h:i a');
    $pdf->ln(3);
    $pdf->setFont('times', 'B', 10);
    $pdf->cell(37, 5, 'Time of Death', 0, 0);
    $pdf->setFont('times', '', 9);
    $pdf->cell(120, 5, ': ' . $date_time, 0, 1);
    $pdf->setFont('times', 'B', 10);
    $pdf->cell(37, 5, 'Cause of Death', 0, 0);
    $pdf->setFont('times', '', 9);
    $pdf->cell(2, 5, ': ');
    $pdf->multiCell(150, 5, $data->death_details);
}
$pdf->ln();
$pdf->cell(190, 5, '--End of the Report--', 0, 1, 'C');
$pdf->ln();
$pdf->setFont('times', 'B', 10);
$pdf->cell(160, 5, 'Doctor\'s Signature', 0, 1, 'R');
$pdf->output();
