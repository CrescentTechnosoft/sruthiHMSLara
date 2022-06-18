<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\OPBill;
use App\Models\IPBill;
use App\Models\Advance;

class MonthlyCollectionsController extends Controller
{

    public function index(int $year, int $month, string $base = null)
    {
        $date = Carbon::createFromFormat('Y/n/j', $year . '/' . $month . '/1');

        $last_day = $date->daysInMonth;

        $start_date = $date->format('Y-m-d').' 00:00:01';
        $end_date = $date->setDay($last_day)->format('Y-m-d').' 23:59:59';

        $data = [
            'month' => $month,
            'year' => $year,
            'collections' => OPBill::whereBetween('created_at', [$start_date, $end_date])
                    ->select(['paid', 'created_at', 'payment_method'])
                    ->unionAll(IPBill::select(['paid', 'created_at', 'payment_method'])->whereBetween('created_at', [$start_date, $end_date]))
                    ->unionAll(Advance::select(['amount', 'created_at', 'pay_type'])->whereBetween('created_at', [$start_date, $end_date]))
                    ->get()
                    ->sortBy(fn($sort) => $sort->created_at->getTimeStamp())
                    ->map(function($map) {
                        $map->date = $map->created_at->format('d-m-Y');
                        $map->created_at = null;
                        return $map;
                    })
        ];

        $view = view('reports.monthly_collections', $data);
        
        if ($base !== null) {
            return response(\base64_encode($view))->header('Content-Type', 'text/plain');
        } else {
            return response($view)->header('Content-Type', 'application/pdf');
        }
    }

}
