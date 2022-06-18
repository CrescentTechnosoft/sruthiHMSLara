<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Carbon\Carbon;

class RegistrationsController extends Controller
{

    public function index(string $start_date, string $end_date, string $base = null): \Illuminate\Http\Response
    {
        $data = [
            'regs' => Registration::whereBetween('created_at', [$start_date . ' 00:00:01', $end_date . ' 23:59:59'])
                    ->with(['doctor:id,name'])
                    ->get(['id','salutation', 'name', 'age', 'gender', 'contact_no', 'doctor_id', 'created_at']),
            'start_date' => Carbon::parse($start_date)->format('d-m-Y'),
            'end_date' => Carbon::parse($end_date)->format('d-m-Y')
        ];

        $view = view('reports.registrations', $data);

        if ($base !== null) {
            return \response(\base64_encode($view))->header('Content-Type', 'text/plain');
        } else {
            return \response($view)->header('Content-Type', 'application/pdf');
        }
    }

}
