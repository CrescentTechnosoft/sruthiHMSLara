<?php

namespace App\Services\Printouts;

use App\Models\OPBill;
use App\Models\OpLabResultDetails;
use App\Models\GroupTest;
use App\Models\Doctor;

class OPLabResultPrintService
{
    public function getResultDatas(int $id, bool $sel,array $selected_tests)
    {
        $data = OPBill::findOrFail($id);
        $data->consultant = $data->doctor_id === 0 ? 'SELF' : Doctor::find($data->doctor_id)->name;

        $results = OpLabResultDetails::where('bill_id', $id)->when($sel, function ($query)use($selected_tests) {
                    $query->whereIn('field_id', $selected_tests);
                })
                ->with('test')
                ->orderBy('alignment')
                ->get();

        $groups = [];

        foreach ($results as $result) {
            if ($result->is_group === false) {
                $result->FieldCategory = '';
                continue;
            }
            if (!isset($groups[$result->test_id])) {
                $groups[$result->test_id] = $this->getTestNameForResults($result->test_id);
            }
            $temp = $groups[$result->test_id];
            $result->category = $temp->category;
            $result->name = $temp->name;

            $fields = $temp->test_fields;
            $field = array_values(array_filter($fields, fn(array $val): bool => $val[0] === $result->field_id));

            $result->FieldCategory = isset($field[0]) ? $field[0][1] : '';
        }

        $catData = $this->GetUniqueDatas($results);

        return compact('data', 'results', 'catData');
    }

    private function getTestNameForResults(int $testID): object
    {
        return GroupTest::select([
                    'category',
                    'name',
                    'test_fields'
                ])->find($testID);
    }

    private function getUniqueDatas(object $data): array
    {
        $values = [];
        $data->each(function (object $dat) use (&$values) {
            $isNotExists = empty(array_filter($values, fn(array $val): bool => ($val['testName'] === $dat->name ?? $dat->test->name)));
            if ($isNotExists) {
                $values[] = [
                    'category' => $dat->category ?? $dat->test->category,
                    'testName' => $dat->name ?? $dat->test->name
                ];
            }
        });
        return $values;
    }
}
