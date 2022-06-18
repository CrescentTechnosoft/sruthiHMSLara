<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\TestCategory;
use App\Http\Resources\Masters\TestMasterResource;

class TestMasterController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('compress', [
            'only' => 'getTests'
        ]);
        session()->put('HosID', 1);
    }

    public function index(): object
    {
        return TestCategory::select('Category')->distinct()
                        ->orderBy('Category')
                        ->pluck('Category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = \json_decode($request->getContent());
        return $this->saveTest($data);
    }

    public function getTests()
    {
        return Test::select([
                    'id',
                    'name as test'
                ])->orderBy('name')->get();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $test_details = Test::find($id);
        return TestMasterResource::make($test_details);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): array
    {
        $data = \json_decode($request->getContent());
        return $this->updateTest($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        Test::find($id)->delete();

        return response('Test Deleted')->header('Content-Type', 'text/plain');
    }

    public function addCategory(Request $request): \Illuminate\Http\Response
    {
        TestCategory::insert([
            'Category' => $request->category,
            'HosID' => $this->hosID
        ]);
        return \response('Category Added', 200, [
            'Content-Type' => 'text/plain'
        ]);
    }

    public function removeCategory(Request $request): \Illuminate\Http\Response
    {
        TestCategory::where('Category', $request->category)->delete();

        return \response('Category Removed!!!')->header('Content-Type', 'text/plain');
    }

    private function isTestExists(string $test, int $testID = null): bool
    {
        return Test::where('name', $test)->when(!is_null($testID), function ($query) use ($testID) {
            return $query->where('ID', '!=', $testID);
        })
                        ->first() !== null;
    }

    private function saveTest(object $data): array
    {
        if ($this->isTestExists($data->test)) {
            return [
                'status' => false,
                'message' => 'Test is already Exists!!!'
            ];
        } else {
            Test::create([
                'category' => $data->category,
                'name' => $data->test,
                'fees' => $data->fees,
                'method' => $data->method,
                'sample' => $data->sample,
                'units' => $data->units,
                'reference_range' => $data->normal,
                'comments' => $data->comment,
                'parameters' => $data->parameters
            ]);
            return [
                'status' => true,
                'message' => 'Test Saved'
            ];
        }
    }

    private function updateTest(int $id, object $data): array
    {
        if ($this->isTestExists($data->test, $id)) {
            return [
                'status' => false,
                'message' => 'Test already Exists!!!'
            ];
        } else {
            Test::where('id', $id)->update([
                'category' => $data->category,
                'name' => $data->test,
                'method' => $data->method,
                'sample' => $data->sample,
                'units' => $data->units,
                'reference_range' => $data->normal,
                'comments' => $data->comment,
                'parameters' => $data->parameters,
                'fees' => $data->fees
            ]);
            return [
                'status' => true,
                'message' => 'Test Updated!!!'
            ];
        }
    }
}
