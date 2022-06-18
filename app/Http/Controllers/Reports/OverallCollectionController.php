<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\OPBill;
use App\Models\IPBill;
use App\Models\Advance;
use Carbon\Carbon;

class OverallCollectionController extends Controller
{

    public function index(string $start_date, string $end_date, string $base = null)
    {
        $op_collections = OPBill::with(['patient:salutation,id,name'])
                ->whereBetween('created_at', [$start_date . ' 00:00:01', $end_date . ' 23:59:59'])
                ->get(['pt_id', 'bill_no', 'total', 'discount', 'sub_total', 'paid', 'due', 'payment_method', 'created_at']);

        $ip_collections = IPBill::with(['patient:id,salutation,name', 'admission:id,ip_no'])
                ->whereBetween('created_at', [$start_date . ' 00:00:01', $end_date . ' 23:59:59'])
                ->get(['pt_id', 'ip_id', 'bill_no', 'total', 'discount', 'sub_total', 'advance_paid', 'paid', 'due', 'payment_method', 'created_at']);

        $advances = Advance::with(['admission', 'patient'])
                ->whereBetween('created_at', [$start_date . ' 00:00:01', $end_date . ' 23:59:59'])
                ->get(['pt_id', 'ip_id', 'advance_no', 'amount', 'pay_type', 'other_pay_type', 'created_at']);

        $data = [
            'start_date' => Carbon::parse($start_date)->format('d-m-Y'),
            'end_date' => Carbon::parse($end_date)->format('d-m-Y'),
            'op_collections' => $op_collections,
            'ip_collections' => $ip_collections,
            'advances' => $advances
        ];

        $view = view('reports.overall_collection', $data);

        if ($base !== null) {
            return response(\base64_encode($view))->header('Content-Type', 'text/plain');
        } else {
            return response($view)->header('Content-Type', 'application/pdf');
        }
    }

}
