<?php

namespace App\Http\Controllers\IPProcess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Services\IPProcess\TreatmentService;
use App\Models\IPAdmission;
use App\Models\Fee;
use App\Models\Test;
use App\Models\GroupTest;
use App\Models\Profile;
use App\Models\IPTreatment;
use App\Models\IPTreatmentDetails;
use App\Models\IPLabResult;
use App\Http\Resources\IPProcess\Treatments\PatientResource;
use App\Http\Resources\IPProcess\Treatments\TreatmentResourceCollection;

class TreatmentController extends Controller
{
    /**
     *
     * @var TreatmentService
     */
//    private TreatmentService $service;

    public function __construct()
    {
        $this->middleware('compress')->only('index');
    }

    /**
     *
     * @return array
     */
    public function index(): array
    {
        $years = IPAdmission::select('year')->distinct()
                ->pluck('year')
                ->sortDesc()
                ->values();

        $ipNos = $years->isEmpty() ? [] : $this->getIPNos($years->first());

        $fees = Fee::all(['id', 'department', 'name']);
        $tests = Test::all(['id', 'name']);
        $groupTests = GroupTest::all(['id', 'name']);
        $profiles = Profile::all(['id', 'name']);

        return compact('years', 'ipNos', 'fees', 'tests', 'groupTests', 'profiles');
    }

    public function getIPNos(string $year): \Illuminate\Support\Collection
    {
        return IPAdmission::where('year', '=', $year)
                        ->get(['id', 'ip_no as ipNo'])
                        ->sortByDesc('id')
                        ->values();
    }

    public function getPatientDetails(int $id)
    {
        return PatientResource::make(IPAdmission::find($id));
    }

    public function getFeesCost(int $id): Fee
    {
        return Fee::find($id, ['category', 'ip_cost as cost']);
    }

    public function getTestCost(int $id): Test
    {
        return Test::find($id, ['category', 'fees as cost']);
    }

    public function getGroupTestCost(int $id): GroupTest
    {
        return GroupTest::find($id, ['category', 'fees as cost']);
    }

    public function getProfileCost(int $id): array
    {
        $fees = Profile::find($id, ['fees'])->fees;

        return [
            'category' => 'Profile',
            'cost' => $fees
        ];
    }

    public function store(Request $request): \Illuminate\Http\Response
    {
        $request_data = \json_decode($request->getContent());
        $ip_id = $request_data->id;
        $pt_id = $request_data->ptId;
        $treatments = $request_data->treatments;

        $refNo = IPTreatment::where('ip_id', $ip_id)->max('ref_no') + 1;
        IPTreatment::create([
            'pt_id' => $pt_id,
            'ip_id' => $ip_id,
            'ref_no' => $refNo,
            'user_id' => session('user_id')
        ]);

        $treatmentID = IPTreatment::max('id');

        $insertval = [];
        foreach ($treatments as $i => $treatment) {
            $insertval[] = [
                'treatment_id' => $treatmentID,
                'ip_id' => $ip_id,
                'pt_id' => $pt_id,
                's_no' => ($i + 1),
                'fees_id' => $treatment->feesId,
                'department' => $treatment->dept,
                'category' => $treatment->category,
                'fees_type' => $treatment->feesType,
                'test_type' => $treatment->testType,
                'qty' => floatval($treatment->qty),
                'cost' => floatval($treatment->cost),
                'total' => floatval($treatment->qty) * floatval($treatment->cost)
            ];
        }
        IPTreatmentDetails::insert($insertval);
        return response('Treatments Saved')->header('Content-Type', 'text/plain');
    }

    public function getOldIpNos(string $year): \Illuminate\Support\Collection
    {
        return IPAdmission::where('year', '=', $year)
                        ->has('treatments')
                        ->get(['id', 'ip_no as ipNo'])
                        ->sortByDesc('id')
                        ->values();
    }

    public function getRefNos(int $ip_id): \Illuminate\Support\Collection
    {
        return IPTreatment::where('ip_id', '=', $ip_id)
                        ->get(['id as treatmentId', 'ref_no as refNo'])
                        ->where('refNo', '>', 0)
                        ->values();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(int $id): array
    {
        $data = IPTreatment::find($id, ['ip_id'])->admission;

        $treatments = IPTreatmentDetails::where('treatment_id', $id)->get();

        return [
            'data' => PatientResource::make($data),
            'treatments' => TreatmentResourceCollection::make($treatments)
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id): \Illuminate\Http\Response
    {
        $request_values = json_decode($request->getContent());

        (new IPTreatment())->touch();

        IPTreatmentDetails::where('treatment_id', $id)->delete();

        $insertval = [];
        foreach ($request_values->treatments as $i => $treatment) {
            $insertval[] = [
                'treatment_id' => $id,
                'ip_id'=>$request_values->ipId,
                'pt_id' => $request_values->ptId,
                's_no' => ($i + 1),
                'fees_id' => $treatment->feesId,
                'department' => $treatment->dept,
                'category' => $treatment->category,
                'fees_type' => $treatment->feesType,
                'test_type' => $treatment->testType,
                'qty' => floatval($treatment->qty),
                'cost' => floatval($treatment->cost),
                'total' => floatval($treatment->qty) * floatval($treatment->cost)
            ];
        }
        IPTreatmentDetails::insert($insertval);

        return \response('Treatments Updated')->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        IPTreatment::where('id', '=', $id)->delete();
        IPLabResult::where('treatment_id', '=', $id)->delete();

        return \response('Treatment Deleted')->header('Content-Type', 'text/plain');
    }
}
