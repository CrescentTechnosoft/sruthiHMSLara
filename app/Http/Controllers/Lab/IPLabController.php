<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IPAdmission;
use App\Models\IPTreatmentDetails;
use App\Models\IPLabResult;
use App\Models\IPLabResultDetail;
use App\Services\Lab\LabService;
use App\Http\Resources\Lab\FieldsCollection;

class IPLabController extends Controller
{

    public function index()
    {
        $years = IPAdmission::distinct()->orderBy('year', 'desc')->pluck('year');
        $ip_nos = $years->isEmpty() ? [] : $this->getIPNos($years->first());

        return [
            'years' => $years,
            'ipNos' => $ip_nos
        ];
    }

    public function getIPNos(string $year)
    {
        return IPTreatmentDetails::select(['ip_id', 'treatment_id'])
            ->where('department', '=', 'Lab')
            ->orderBy('ip_id', 'desc')
            ->with('admission:id,ip_no', 'treatment:id,ref_no')
            ->whereHas('admission', function ($query) use ($year) {
                $query->where('year', '=', $year);
            })
            ->get()
            ->map(function ($map) {
                return [
                    'treatmentId' => $map->treatment_id,
                    'ipNo' => $map->admission->ip_no,
                    'refNo' => $map->treatment->ref_no
                ];
            })
            ->unique('treatmentId')
            ->values();
    }

    public function searchPatient(string $key)
    {
        return IPTreatmentDetails::where('department', '=', 'Lab')
        ->distinct()
        ->whereHas('patient', function ($patient) use ($key) {
            $patient->where('name', 'like', $key.'%')
            ->orWhere('contact_no', 'like', $key.'%');
        })
        ->with(['admission:id,year,ip_no', 'patient:id,name,contact_no','treatment:id,ref_no'])
        ->get(['ip_id','pt_id','treatment_id'])
        ->map(function (IPTreatmentDetails $treatment) {
            return [
                'year'=>$treatment->admission->year,
                'ipNo'=>$treatment->admission->ip_no,
                'ipId'=>$treatment->ip_id,
                'name'=>$treatment->patient->name,
                'contact'=>$treatment->patient->contact_no,
                'treatmentId'=>$treatment->treatment_id,
                'refNo'=>$treatment->treatment->ref_no
            ];
        });
    }

    public function store(Request $request)
    {
        $request_values = \json_decode($request->getContent());

        $treatment = IPTreatmentDetails::where('treatment_id', '=', $request_values->treatmentId)->first(['ip_id', 'pt_id']);

        IPLabResult::updateOrCreate([
            'treatment_id' => $request_values->treatmentId
        ], [
            'treatment_id' => $request_values->treatmentId,
            'ip_id' => $treatment->ip_id,
            'pt_id' => $treatment->pt_id,
            'user_id' => session('user_id')
        ]);

        IPLabResultDetail::where('treatment_id', $request_values->treatmentId)->delete();

        $insertVal = [];
        foreach ($request_values->fields as $i => $val) {
            $insertVal[] = [
                'treatment_id' => $request_values->treatmentId,
                'test_id' => $val->testID,
                'field_id' => $val->id,
                'result' => $val->result,
                'result_type' => $val->norm,
                'is_selected' => $val->selected,
                'alignment' => $i,
                'is_group' => $val->isGroup
            ];
        }

        IPLabResultDetail::insert($insertVal);

        return ['message' => 'Lab Result Saved'];
    }

    public function show(int $id): array
    {
        $treatment_data = IPTreatmentDetails::where('treatment_id', '=', $id)->first();
        $patient_details = [
            'ptId' => $treatment_data->admission->pt_id,
            'name' => $treatment_data->admission->patient->salutation . '.' . $treatment_data->admission->patient->name,
            'age' => $treatment_data->admission->patient->age,
            'gender' => $treatment_data->admission->patient->gender,
            'consultant' => $treatment_data->admission->doctor->name,
            'saved' => false,
        ];

        if ($this->isResultExists($id) === false) {
            return ['data' => $patient_details, 'fields' => $this->getBillData($id)];
        } else {
            $patient_details['saved'] = true;

            return ['data' => $patient_details, 'fields' => $this->getLabResult($id)];
        }
    }

    private function isResultExists(int $id): bool
    {
        return IPLabResult::where('treatment_id', $id)->count('treatment_id') > 0;
    }

    private function getBillData(int $id): array
    {
        $test_fields = [];
        $service = new LabService;

        $billed_tests = IPTreatmentDetails::where('treatment_id', '=', $id)
            ->where('department', '=', 'Lab')
            ->get(['fees_id', 'test_type']);

        foreach ($billed_tests as $val) {
            switch ($val->test_type) {
                case 'Test':
                    $test = $service->getTestDetails($val->fees_id);
                    if (is_null($test) === false) {
                        $test_fields[] = $test;
                    }
                    break;
                case 'GroupTest':
                    $group = $service->getTestsFromGroup($val->fees_id);
                    $tests = $group->test_fields;
                    foreach ($tests as $test) {
                        $fields = $service->getTestDetails($test[0], $val->fees_id, $group->name, $group->category);
                        if (!is_null($fields)) {
                            $test_fields[] = $fields;
                        }
                    }
                    break;
                case 'Profile':
                    $all = $service->getTestsFromProfile($val->fees_id);
                    foreach ($all as $prof) {
                        if ($prof[1] === 'Test') {
                            $test_fields[] = $service->getTestDetails($prof[0]);
                            continue;
                        }
                        $group = $service->getTestsFromGroup($prof[0]);
                        $tests = $group->test_fields;
                        foreach ($tests as $test) {
                            $fields = $service->getTestDetails($test[0], $group->id, $group->name, $group->category);
                            if (!is_null($fields)) {
                                $test_fields[] = $fields;
                            }
                        }
                    }
                    break;
            }
        }
        return $test_fields;
    }

    private function getLabResult(int $id): FieldsCollection
    {
        $service = new LabService;
        $results = IPLabResultDetail::where('treatment_id', $id)->with('test:id,category,name,parameters,reference_range,method')->get();
        $groups = [];

        foreach ($results as $result) {
            if ($result->is_group === false) {
                continue;
            }
            if (!isset($groups[$result->test_id])) {
                $groups[$result->test_id] = $service->getTestDetailsForResults($result->test_id);
            }

            $temp = $groups[$result->test_id];
            $result->category = $temp->category;
            $result->name = $temp->name;
        }
        return FieldsCollection::make($results);
    }

    public function destroy(int $id): array
    {
        IPLabResult::where('treatment_id', '=', $id)->delete();
        IPLabResultDetail::where('treatment_id', '=', $id)->delete();
        return ['message' => 'Lab Result Deleted'];
    }
}
