<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Models\IPAdmission;
use App\Models\IPBill;
use App\Models\IPDischarge;
use App\Models\OPBill;
use App\Models\Registration;
use App\Models\Ward;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        $data = [];
        $today = Carbon::today();

        $data['Regs'] = Registration::whereDate('created_at', $today)->count();
        $data['OPBills'] = OPBill::whereDate('created_at', $today)->count();
        $data['IPBills'] = IPBill::whereDate('created_at', $today)->count();
        $data['IPAd'] = IPAdmission::whereDate('created_at', $today)->count();
        $data['IPD'] = IPDischarge::whereDate('created_at', $today)->count();
        $data['IPWard'] = Ward::where('status', true)->count();

        return $data;
    }
}
