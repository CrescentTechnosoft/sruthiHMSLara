<?php

namespace App\Http\Controllers\OutPatient;

use App\Http\Controllers\Controller;
use App\Http\Resources\OutPatients\Prescription\ObservationResource;
use App\Http\Resources\OutPatients\Prescription\PrescriptionResource;
use App\Models\OPRegistration;
use App\Models\Prescription;
use App\Services\OutPatients\PrescriptionService;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PrescriptionService $service): array
    {
        $years = OPRegistration::select('year')->distinct()->pluck('year')->sortDesc()->values();
        $opNos = $years->isEmpty() ? [] :
            OPRegistration::where('year', $years->first())
            ->doesntHave('prescription')
            ->select(['id', 'op_no as opNo'])
            ->get()
            ->sortBy('opNo')
            ->values();

        $medicines = $service->getMedicines();
        $investigations = $service->getTests();
        $treatments = $service->getTreatments();
        $complaints = $service->getComplaints();

        return \compact('years', 'opNos', 'medicines', 'investigations', 'treatments', 'complaints');
    }

    public function getOPNos(Request $request): \Illuminate\Database\Eloquent\Collection
    {
        $year = $request->input('year');

        return OPRegistration::where('year', $year)
            ->doesntHave('prescription')
            ->select(['id', 'op_no as opNo'])
            ->get()
            ->sortBy('opNo')
            ->values();
    }

    public function getObservationDetails(Request $request)
    {
        $id = $request->input('id');
        $observation = OPRegistration::where('id', $id)->first();
        $data = new ObservationResource($observation);

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_values = \json_decode($request->getContent());
        $data = $request_values->data;

        Prescription::create([
            'op_id' => $data->id,
            'opinion' => $data->opinion,
            'patient_info' => $data->patientInfo,
            'diagnosis' => $data->diagnosis,
            'complaints' => \json_encode($request_values->complaints),
            'medicines' => \json_encode($request_values->medicines),
            'investigations' => \json_encode($request_values->investigations),
            'treatments' => \json_encode($request_values->treatments),
        ]);

        return \response('Prescription Added')->header('Content-Type', 'text/plain');
    }

    public function getPrescNos(Request $request): \Illuminate\Database\Eloquent\Collection
    {
        $year = $request->input('year');

        return OPRegistration::where('year', $year)
            ->has('prescription')
            ->select(['id', 'op_no as opNo'])
            ->get()
            ->sortBy('opNo')
            ->values();
    }

    /**
     * Display the specified resource.
     */
    public function show($id): array
    {
        $observation = OPRegistration::where('id', $id)->first();

        PrescriptionResource::withoutWrapping();
        $data = PrescriptionResource::make($observation);

        $data->diagnosis = $observation->prescription->diagnosis;
        $complaints = json_decode($observation->prescription->complaints);
        $medicineDatas = \json_decode($observation->prescription->medicines);
        $investigations = \json_decode($observation->prescription->investigations);
        $treatments = \json_decode($observation->prescription->treatments);

        return compact('data', 'complaints', 'medicineDatas', 'investigations', 'treatments');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id): \Illuminate\Http\Response
    {
        $request_values = \json_decode($request->getContent());
        $data = $request_values->data;

        Prescription::where('op_id', '=', $id)
        ->update([
            'opinion' => $data->opinion,
            'patient_info' => $data->patientInfo,
            'diagnosis' => $data->diagnosis,
            'complaints' => \json_encode($request_values->complaints),
            'medicines' => \json_encode($request_values->medicines),
            'investigations' => \json_encode($request_values->investigations),
            'treatments' => \json_encode($request_values->treatments),
        ]);

        return \response('Prescription Updated!!!')->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id): \Illuminate\Http\Response
    {
        Prescription::where('op_id', '=', $id)->delete();

        return \response('Prescription Deleted!!!')->header('Content-Type', 'text/plain');
    }
}
