<?php

namespace App\Http\Controllers\IPProcess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IPAdmission;
use App\Models\Ward;
use App\Models\IPTreatment;
use App\Models\IPTreatmentDetails;
use Carbon\Carbon;

class WardShiftingController extends Controller
{

    public function __construct()
    {
        $this->middleware('compress')->only('index');
    }

    public function index()
    {
        $years = IPAdmission::distinct()->orderBy('year', 'desc')->pluck('year');
        $ip_nos = $years->isEmpty() ? [] : $this->getIpNos($years->first());
        $rooms = Ward::where('status', '=', 0)->get(['id', 'floor', 'ward', 'room', 'bed', 'rent']);

        return [
            'years' => $years,
            'ipNos' => $ip_nos,
            'rooms' => $rooms
        ];
    }

    public function getIpNos(string $year): \Illuminate\Database\Eloquent\Collection
    {
        return IPAdmission::where('year', '=', $year)
            ->has('ward')
            ->get(['id', 'ip_no as ipNo'])
            ->sortByDesc('id')
            ->values();
    }

    public function show(int $id)
    {
        return Ward::where('ip_id', $id)->first(['pt_id as ptId', 'id as roomId', 'name', 'ward', 'room', 'bed', 'rent']);
    }

    public function store(Request $request)
    {
        $request_values = \json_decode($request->getContent());
        $data = $request_values->data;
        $selected_room_id = $request_values->room;

        if ($this->isRoomOccupied($selected_room_id)) {
            return [
                'status' => false,
                'message' => 'Sorry that room was occupied by another patient!!!'
            ];
        }

        IPTreatment::create([
            'ip_id' => $data->ipNo,
            'pt_id' => $data->ptId,
            'ref_no' => 0,
            'user_id' => $request->session()->get('user_id')
        ]);
        $treatment_id = IPTreatment::max('id');
        $ward_details = Ward::find($data->roomId);
        $days = $this->getDayDiff($ward_details->updated_at->timestamp);

        IPTreatmentDetails::insert([
            'treatment_id' => $treatment_id,
            'ip_id' => $data->ipNo,
            'pt_id' => $data->ptId,
            's_no' => 1,
            'fees_id' => 0,
            'department' => 'IP Room Fees',
            'category' => 'Bed Charges',
            'fees_type' => $ward_details->room . ' ' . $ward_details->updated_at->format('d-m-Y') . ' - ' . Carbon::now()->format('d-m-Y'),
            'test_type' => '',
            'qty' => $days,
            'cost' => $ward_details->rent,
            'total' => ((float) $ward_details->rent) * $days
        ]);

        //Clear old Room
        $ward_details->ip_id = null;
        $ward_details->pt_id = null;
        $ward_details->name = '';
        $ward_details->status = 0;
        $ward_details->save();

        Ward::where('id', $selected_room_id)
            ->update([
                'ip_id' => $data->ipNo,
                'pt_id' => $data->ptId,
                'name' => $data->name,
                'status' => 1
            ]);

        return [
            'status' => true,
            'message' => $days . $ward_details->updated_at
        ];
    }

    private function isRoomOccupied(int $id): bool
    {
        return Ward::find($id)->status;
    }

    private function getDayDiff(int $start_time): int
    {
        return ceil((time() - $start_time) / (Carbon::SECONDS_PER_MINUTE * Carbon::MINUTES_PER_HOUR * Carbon::HOURS_PER_DAY));
    }
}
