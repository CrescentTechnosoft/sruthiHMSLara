<?php

namespace App\Services\Lab;

use App\Models\Test;
use App\Models\GroupTest;
use App\Models\Profile;

class LabService
{

    public function getTestDetails(int $id, int $testID = null, string $testName = null, string $category = null): array
    {
        $row = Test::find($id);
        if (is_null($row)) {
            return null;
        }
        $values = [
            'category' => $row->category,
            'testID' => $row->id,
            'test' => $row->name,
            'id' => $row->id,
            'field' => $row->name,
            'result' => '',
            'selected' => false,
            'method' => $row->method,
            'normal' => $row->reference_range,
            'parameters' => $row->parameters === '' ? [] : explode(',', $row->parameters),
            'norm' => 'N',
            'isGroup' => false
        ];

        if (!is_null($testID)) {
            $values['testID'] = $testID;
            $values['category'] = $category;
            $values['test'] = $testName;
            $values['isGroup'] = true;
        }

        return $values;
    }

    public function getTestsFromGroup(int $id): GroupTest
    {
        return GroupTest::find($id);
    }

    public function getTestsFromProfile(int $id): array
    {
        return Profile::find($id)->tests;
    }

    public function getTestDetailsForResults(int $testID): GroupTest
    {
        return GroupTest::select([
                    'category',
                    'name'
                ])->find($testID);
    }

}
