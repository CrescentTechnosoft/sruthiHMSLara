<?php

namespace App\Http\Controllers\OutPatient;

use App\Http\Controllers\Controller;
use App\Http\Resources\OutPatients\OPRegistration\ObservationResource;
use App\Models\Doctor;
use App\Models\OPRegistration;
use App\Models\Prescription;
use App\Models\Registration;
use App\Services\OutPatients\OPRegistrationService;
use Illuminate\Http\Request;

class OPRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        $ids = Registration::get(['uhid','id'])->sortDesc()->values();
        $consultants = Doctor::select(['id', 'name'])
        ->where('status', '=', 'Active')
        ->get()
        ->sortBy('name')
        ->values();

        return compact('ids', 'consultants');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, OPRegistrationService $service): \Illuminate\Http\Response
    {
        $data = \json_decode($request->getContent());

        $year = $service->generateYear();
        $op_no = (OPRegistration::where('year', $year)->max('op_no') ?? 0) + 1;

        OPRegistration::create([
            'year' => $year,
            'op_no' => $op_no,
            'pt_id' => $data->ptid,
            'name' => $data->name,
            'age' => $data->age,
            'gender' => $data->gender,
            'contact_no' => $data->contact,
            'doctor_id' => $data->consultant,
            'height' => $data->height,
            'weight' => $data->weight,
            'bsa' => $data->bsa,
            'bp' => $data->bp,
            'pulse' => $data->pulse,
            'status' => $data->status,
            'visit_reason' => $data->reason,
        ]);

        return \response('Registration Success. OP No is '.$op_no)->header('Content-Type', 'text/plain');
    }

    public function getIds(): \Illuminate\Support\Collection
    {
        return Registration::select(['id'])->pluck('id')->sortDesc()->values();
    }

    /**
     * Gets the Patient Details.
     */
    public function getPatientDetails(Request $request): Registration
    {
        $id = $request->input('id');

        $select = "CONCAT(`salutation`,'.',`name`) as `name`,`age`,`gender`,`contact_no` as `contact`, `doctor_id` as `consultant`";

        return Registration::selectRaw($select)
            ->where('id', $id)
            ->first();
    }

    public function getYears(): array
    {
        $years = OPRegistration::select(['year'])
            ->distinct()
            ->pluck('year')
            ->sortDesc()
            ->values();

        $opNos = $years->isEmpty() ? [] :
        OPRegistration::select(['op_no'])
            ->where('year', $years->first())
            ->pluck('op_no')
            ->sortDesc()
            ->values();

        return compact('years', 'opNos');
    }

    public function getOPNos(Request $request): \Illuminate\Support\Collection
    {
        $year = $request->input('year');

        return OPRegistration::select(['op_no'])
            ->where('year', $year)
            ->pluck('op_no')
            ->sortDesc()
            ->values();
    }

    public function getObservationDetails(Request $request): ObservationResource
    {
        ObservationResource::withoutWrapping();

        return new ObservationResource(OPRegistration::where('year', $request->input('year'))
            ->where('op_no', $request->opNo)
            ->first());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id): \Illuminate\Http\Response
    {
        $data = \json_decode($request->getContent());

        OPRegistration::where('id', $id)
            ->update([
                'pt_id' => $data->ptid,
                'name' => $data->name,
                'age' => $data->age,
                'gender' => $data->gender,
                'contact_no' => $data->contact,
                'doctor_id' => $data->consultant,
                'height' => $data->height,
                'weight' => $data->weight,
                'bsa' => $data->bsa,
                'bp' => $data->bp,
                'pulse' => $data->pulse,
                'status' => $data->status,
                'visit_reason' => $data->reason,
                ]);

        return \response('Observation Details Updated!!!')->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id): \Illuminate\Http\Response
    {
        OPRegistration::where('id', $id)->delete();
        Prescription::where('op_id', $id)->delete();

        return \response('Observation Details Deleted!!!')->header('Content-Type', 'text/plain');
    }
}
