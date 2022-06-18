<?php

namespace App\Services\Masters;

use App\Models\TestCategory;
use App\Models\Test;
use App\Models\GroupTest;

class GroupTestMasterService
{
    public function getCategories(): object
    {
        return TestCategory::select('Category')->distinct()
                        ->orderBy('Category')
                        ->pluck('Category');
    }

    public function getFields(): object
    {
        return Test::select([
                            'id',
                            'name as field'
                        ])->distinct()
                        ->where('name', 'NOT LIKE', '%culture%')
                        ->orderBy('name')
                        ->get();
    }

    public function isTestExists(string $test, int $id = null): bool
    {
        return GroupTest::select('ID')->where('name', $test)
                        ->when(!is_null($id), function ($query) use ($id) {
                            $query->where('ID', '!=', $id);
                        })
                        ->get()
                        ->isNotEmpty();
    }

    public function saveTest(object $data, array $fields): array
    {
        if ($this->isTestExists($data->test)) {
            return ['status' => false, 'message' => 'Test already Exists'];
        } else {
            $altField = array_map(fn (object $val): array => [$val->id,$val->category], $fields);

            GroupTest::create([
                'category' => $data->category,
                'name' => $data->test,
                'fees' => $data->fees,
                'test_fields' => $altField
            ]);

            return [
                'status' => true,
                'message' => 'Test Saved'
            ];
        }
    }

    public function getTests(): object
    {
        return GroupTest::select([
                    'id',
                    'name as test'
                ])->orderBy('name')->get();
    }

    // Don't Delete .Being Used in Next Method
    private function getFieldName(array $val)
    {
        $field = Test::find($val[0], [
                    'name'
                ])->name;

        return [
            'id' => $val[0],
            'category' => $val[1],
            'field' => $field
        ];
    }

    public function getTestDetails(int $id): array
    {
        $row = GroupTest::find($id, [
                    'category',
                    'name',
                    'fees',
                    'test_fields'
        ]);

        $data['data'] = [
            'category' => $row->category,
            'test' => $row->name,
            'fees' => $row->fees
        ];
        $data['fields'] = array_map([$this, 'GetFieldName'], $row->test_fields);

        return $data;
    }

    public function updateTest(int $id, object $data, array $fields): array
    {
        if ($this->isTestExists($data->test, $id)) {
            return [
                'status' => false,
                'message' => 'Test already Exists'
            ];
        } else {
            $altField = array_map(fn (object $val): array => [$val->id,$val->category], $fields);

            GroupTest::find($id)->update([
                'category' => $data->category,
                'name' => $data->test,
                'fees' => $data->fees,
                'test_fields' => $altField
            ]);
            return [
                'status' => true,
                'message' => 'Test Updated'
            ];
        }
    }

    public function deleteTest(int $id): string
    {
        GroupTest::find($id)->delete();

        return 'Test Deleted';
    }
}
