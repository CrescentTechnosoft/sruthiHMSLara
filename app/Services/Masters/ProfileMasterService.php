<?php

namespace App\Services\Masters;

use App\Models\Test;
use App\Models\GroupTest;
use App\Models\Profile;

class ProfileMasterService
{

    public function getTests(): object
    {
        return Test::select([
                    'id',
                    'name as test'
                ])->where('name', 'NOT LIKE', '%culture%')->get();
    }

    public function getGroupTests(): object
    {
        return GroupTest::select([
                    'id',
                    'name as test'
                ])->get();
    }

    private function isProfileExists(string $profile, int $id = null): bool
    {
        return Profile::where('name', $profile)->when(!is_null($id), function ($query) use ($id) {
                            $query->where('ID', '!=', $id);
                        })
                        ->count('ID') > 0;
    }

    public function saveProfile(object $data, array $tests): array
    {
        if ($this->isProfileExists($data->profile)) {
            return [
                'status' => false,
                'message' => 'Profile already Exists'
            ];
        } else {
            $altTests = json_encode(array_map(fn(object $val): array => [
                        $val->id,
                        $val->type
                            ], $tests));

            Profile::create([
                'name' => $data->profile,
                'fees' => $data->fees,
                'tests' => $altTests
            ]);

            return [
                'status' => true,
                'message' => 'Profile Saved'
            ];
        }
    }

    public function getProfiles(): \Illuminate\Database\Eloquent\Collection
    {
        return Profile::select([
                    'id',
                    'name as profile'
                ])->get();
    }

    private function getTestNames(array $val): array
    {
        if ($val[1] === 'Test') {
            $test = Test::find($val[0])->name;
            return [
                'id' => $val[0],
                'test' => $test,
                'type' => 'Test'
            ];
        } else {
            $test = GroupTest::find($val[0])->name;
            return [
                'id' => $val[0],
                'test' => $test,
                'type' => 'Group'
            ];
        }
    }

    public function getProfileDetails(int $id): array
    {
        $data = [];
        $row = Profile::find($id);
        $data['data'] = [
            'profile' => $row->name,
            'fees' => $row->fees
        ];
        $data['tests'] = array_map([
            $this,
            'GetTestNames'
                ], $row->tests);

        return $data;
    }

    public function updateProfile(int $id, object $data, array $tests): array
    {
        if ($this->IsProfileExists($data->profile, $id)) {
            return [
                'status' => false,
                'message' => 'Profile Name already Exists'
            ];
        } else {
            $altTests = json_encode(array_map(fn(object $val): array => [$val->id, $val->type], $tests));

            Profile::where('id', $id)->update([
                'name' => $data->profile,
                'fees' => $data->fees,
                'tests' => $altTests
            ]);

            return [
                'status' => true,
                'message' => 'Profile Updated'
            ];
        }
    }

    public function deleteProfile(int $id): void
    {
        Profile::find($id)->delete();
    }

}
