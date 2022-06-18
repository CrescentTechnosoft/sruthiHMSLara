<?php

namespace App\Http\Controllers\IPProcess;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Models\Ward;
use App\Http\Resources\IPProcess\WardStatus\WardResourceCollection;

class WardStatusController extends Controller
{
    public function getWardStatus()
    {
        $ward_details = Ward::with(['patient:id,name,age,gender,contact_no', 'admission.doctor:id,name'])
            ->get(['ip_id', 'pt_id', 'floor', 'ward', 'room', 'bed', 'status', 'rent']);

        return WardResourceCollection::make($ward_details);
    }
}
