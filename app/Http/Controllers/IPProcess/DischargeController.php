<?php

namespace App\Http\Controllers\IPProcess;

use App\Http\Controllers\Controller;
use App\Http\Resources\IPProcess\Discharge\DischargeResouce;
use App\Http\Resources\IPProcess\Discharge\PatientResource;
use App\Models\Doctor;
use App\Models\IPAdmission;
use App\Models\IPDischarge;
use App\Models\IPTreatment;
use App\Models\IPTreatmentDetails;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DischargeController extends Controller
{
    public function index(): array
    {
        $years = IPAdmission::distinct()->orderBy('year', 'desc')->pluck('year');
        $ip_nos = $years->isEmpty() ? [] : $this->getIpNos($years->first());
        $consultants = Doctor::where('status', '=', 'Active')->get(['id', 'name'])->sortBy('name')->values();

        return [
            'years' => $years,
            'ipNos' => $ip_nos,
            'cons' => $consultants,
        ];
    }

    public function getIpNos(string $year): \Illuminate\Support\Collection
    {
        return IPAdmission::where('year', '=', $year)
                        ->doesntHave('discharge')
                        ->get(['id', 'ip_no as ipNo'])
                        ->sortByDesc('id')
                        ->values();
    }

    public function getPatientDetails(int $id): array
    {
        $data = IPAdmission::find($id, ['id', 'pt_id', 'consultant']);
        $treatments = IPTreatmentDetails::whereIn(
            'treatment_id',
            IPTreatment::where('ip_id', $id)->where('ref_no', '!=', '0')->pluck('id')
        )
                ->get(['department', 'fees_type as feesType']);

        PatientResource::withoutWrapping();

        return [
            'data' => PatientResource::make($data),
            'treatments' => $treatments,
        ];
    }

    public function store(Request $request): \Illuminate\Http\Response
    {
        $data = \json_decode($request->getContent());
        $admission_details = IPAdmission::findOrFail($data->ipNo, ['pt_id', 'created_at']);

        $this->addRoomRent($data->ipNo, $admission_details->pt_id);

        $consultants = \implode('|', [
            $data->cons1,
            $data->cons2,
            $data->cons3,
            $data->cons4,
            $data->cons5
        ]);

        IPDischarge::create([
            'ip_id' => $data->ipNo,
            'pt_id' => $admission_details->pt_id,
            'history' => $data->history,
            'diagnosis' => $data->diagnosis,
            'investigations' => $data->investigation,
            'surgery' => $data->surgery,
            'treatment' => $data->treatment,
            'advice' => $data->advice,
            'condition' => $data->condition,
            'disease' => $data->disease,
            'consultants' => $consultants,
            'death_date' => $data->dDate . '|' . $data->dTime,
            'death_details' => $data->dCause,
            'hosp_course' => $data->hCourse,
            'report' => $data->report,
            'pt_reaction' => $data->pReaction,
            'pulse' => $data->pulse,
            'bp' => $data->bp,
            'hb' => $data->hb,
            'tc' => $data->tc,
            'wbc' => $data->wbc,
            'poly' => $data->poly,
            'lymp' => $data->lymp,
            'eos' => $data->eos,
            'm' => $data->m,
            'b' => $data->b,
            'blood_sugar' => $data->sugar,
            'urea' => $data->urea,
            'scr' => $data->scr,
            'crit' => $data->crit,
            'plat' => $data->plat,
            'user_id' => $request->session()->get('user_id'),
            'admitted_at' => $admission_details->created_at->format('Y-m-d H:i:s'),
        ]);

        return \response('Discharge Status Saved...')->header('Content', 'text/plain');
    }

    private function addRoomRent(int $ip_id, int $pt_id): void
    {
        $ward_details = Ward::where('ip_id', $ip_id)->first();

        if ($ward_details === null) {
            return;
        }

        IPTreatment::create([
            'ip_id' => $ip_id,
            'pt_id' => $pt_id,
            'ref_no' => 0,
            'user_id' => session('user_id'),
        ]);

        $treatment_id = IPTreatment::max('id');
        $days = $this->getDayDiff($ward_details->updated_at->timestamp);

        IPTreatmentDetails::insert([
            'treatment_id' => $treatment_id,
            'ip_id' => $ip_id,
            'pt_id' => $pt_id,
            's_no' => 1,
            'fees_id' => 0,
            'department' => 'IP Room Fees',
            'category' => 'Bed Charges',
            'fees_type' => $ward_details->room . ' ' . $ward_details->updated_at->format('d-m-Y') . ' - ' . Carbon::now()->format('d-m-Y'),
            'test_type' => '',
            'qty' => $days,
            'cost' => $ward_details->rent,
            'total' => ((float) $ward_details->rent) * $days,
        ]);

        //Clear old Room
        $ward_details->ip_id = null;
        $ward_details->pt_id = null;
        $ward_details->name = '';
        $ward_details->status = 0;
        $ward_details->save();
    }

    private function getDayDiff(int $start_time): int
    {
        return ceil((time() - $start_time) / (Carbon::SECONDS_PER_MINUTE * Carbon::MINUTES_PER_HOUR * Carbon::HOURS_PER_DAY));
    }

    public function getDischargeNos(string $year)
    {
        return IPAdmission::where('year', '=', $year)
                        ->has('discharge')
                        ->get(['id', 'ip_no as ipNo'])
                        ->sortByDesc('id')
                        ->values();
    }

    public function getDischargeDetails(int $id): DischargeResouce
    {
        $data = IPDischarge::where('ip_id', $id)->first();

        return DischargeResouce::make($data);
    }

    public function update(int $id, Request $request): \Illuminate\Http\Response
    {
        $data = \json_decode($request->getContent());

        $consultants = \implode('|', [$data->cons1, $data->cons2, $data->cons3, $data->cons4, $data->cons5]);

        IPDischarge::where('ip_id', '=', $data->oldIPNo)
                ->update([
                    'history' => $data->history,
                    'diagnosis' => $data->diagnosis,
                    'investigations' => $data->investigation,
                    'surgery' => $data->surgery,
                    'treatment' => $data->treatment,
                    'advice' => $data->advice,
                    'condition' => $data->condition,
                    'disease' => $data->disease,
                    'consultants' => $consultants,
                    'death_date' => $data->dDate . '|' . $data->dTime,
                    'death_details' => $data->dCause,
                    'hosp_course' => $data->hCourse,
                    'report' => $data->report,
                    'pt_reaction' => $data->pReaction,
                    'pulse' => $data->pulse,
                    'bp' => $data->bp,
                    'hb' => $data->hb,
                    'tc' => $data->tc,
                    'wbc' => $data->wbc,
                    'poly' => $data->poly,
                    'lymp' => $data->lymp,
                    'eos' => $data->eos,
                    'm' => $data->m,
                    'b' => $data->b,
                    'blood_sugar' => $data->sugar,
                    'urea' => $data->urea,
                    'scr' => $data->scr,
                    'crit' => $data->crit,
                    'plat' => $data->plat,
        ]);

        return \response('Discharge Details Updated')->header('Content-Type', 'text/plain');
    }

    public function destroy(int $id): \Illuminate\Http\Response
    {
        IPDischarge::where('ip_id', $id)->delete();
        return \response('Discharge Details Deleted')->header('Content-Type', 'text/plain');
    }
}
