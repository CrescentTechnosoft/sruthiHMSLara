<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IPAdmission;
use App\Models\IPDischarge;

class IPReportsController extends Controller
{
    public function index(string $type, string $start_date, string $end_date, string $base = null)
    {
        $view='';
        $content_type='';
        $content='';
        if ($type==='admission') {
            $admissions=IPAdmission::whereBetween('created_at', [$start_date.' 00:00:01',$end_date.' 23:59:59'])
            ->with(['patient:id,salutation,name'])
            ->get(['id','pt_id','ip_no','created_at'])
            ->sortByDesc('id');

            $view=\view('reports.admissions', \compact('admissions'));
        } else {
            $discharges=IPDischarge::whereBetween('created_at', [$start_date.' 00:00:01',$end_date.' 23:59:59'])
            ->with(['patient:id,salutation,name','admission:id,ip_no,created_at'])
            ->get(['ip_id','pt_id','created_at'])
            ->sortByDesc('id');

            $view=\view('reports.discharges', \compact('discharges'));
        }

        if (is_null($base)) {
            $content_type='application/pdf';
            $content=$view;
        } else {
            $content_type='text/plain';
            $content=\base64_encode($view);
        }

        return \response($content)->header('Content-Type', $content_type);
    }
}
