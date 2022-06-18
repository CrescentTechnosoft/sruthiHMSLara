<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\OPBill;
use App\Models\OPBillDetail;
use App\Models\OpLabResult;
use App\Models\OpLabResultDetails;
use App\Http\Resources\Lab\OPLabResult\PatientsResourceCollection;
use App\Http\Resources\Lab\FieldsCollection;
use App\Services\Lab\LabService;
use Illuminate\Http\Request;

class OPLabController extends Controller
{
    public function index(): array
    {
        $years = OPBill::distinct()->orderByDesc('year')->pluck('year');
        $bill_nos = $years->isEmpty() ? [] : $this->getBillNos($years->first());

        return compact('years', 'bill_nos');
    }

    public function searchPatient(Request $request)
    {
        $search = $request->input('search');

        $results = OPBill::whereHas('billDetails', function ($query) {
            $query->where('department', '=', 'Lab')->select('bill_id');
        })->whereHas('registration', function ($query) use ($search) {
            $query->where('name', 'like', $search . '%')
                ->orWhere('contact_no', 'like', $search . '%')->select('id');
        })
            ->with('registration:id,salutation,name,contact_no')
            ->orderByDesc('id')
            ->get(['id', 'pt_id', 'year', 'bill_no']);

        return PatientsResourceCollection::make($results);
    }

    public function getBillNos(string $year = null): \Illuminate\Support\Collection
    {
        if (\is_null($year)) {
            $year = $year = request('year');
        }

        return OPBill::where('year', '=', $year)
            ->whereHas('billDetails', function ($query) {
                $query->where('department', '=', 'Lab');
            })->with('registration:id,salutation,name')
            ->orderByDesc('id')
            ->get(['id', 'pt_id', 'bill_no'])
            ->map(function ($map) {
                return [
                    'id' => $map->id,
                    'billNo' => $map->bill_no,
                    'name' => $map->registration->salutation . '.' . $map->registration->name
                ];
            });
    }

    public function store(Request $request)
    {
        $request_values = json_decode($request->getContent());

        OpLabResult::updateOrCreate([
            'bill_id' => $request_values->id
        ], [
            'bill_id' => $request_values->id,
            'user_id' => session('user_id')
        ]);

        OpLabResultDetails::where('bill_id', '=', $request_values->id)->delete();

        $insertVal = [];
        foreach ($request_values->fields as $i => $val) {
            $insertVal[] = [
                'bill_id' => $request_values->id,
                'test_id' => $val->testID,
                'field_id' => $val->id,
                'result' => $val->result,
                'result_type' => $val->norm,
                'is_selected' => $val->selected,
                'alignment' => $i,
                'is_group' => $val->isGroup
            ];
        }

        OpLabResultDetails::insert($insertVal);

        return ['message' => 'Lab Result Saved'];
    }

    public function show(int $id): array
    {
        $bill_data = OPBill::find($id, ['pt_id', 'doctor_id']);
        $patient_details = [
            'ptId' => $bill_data->pt_id,
            'name' => $bill_data->registration->salutation . '.' . $bill_data->registration->name,
            'age' => $bill_data->registration->age,
            'gender' => $bill_data->registration->gender,
            'consultant' => $bill_data->doctor->name,
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
        return OpLabResult::where('bill_id', $id)
            ->count('bill_id') > 0;
    }

    private function getBillData(int $id): array
    {
        $test_fields = [];
        $service = new LabService();

        $billed_tests = OPBillDetail::where('bill_id', '=', $id)
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
        $service = new LabService();
        $results = OpLabResultDetails::where('bill_id', '=', $id)
            ->with('test:id,category,name,parameters,reference_range,method')
            ->get();

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

    public function destroy(int $id): \Illuminate\Http\Response
    {
        OpLabResult::where('bill_id', $id)->delete();
        return response('Lab Result Deleted')->header('Content-Type', 'text/plain');
    }
}
