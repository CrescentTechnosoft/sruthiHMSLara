<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fee;
use App\Models\Department;
use App\Http\Resources\Masters\FeesResourceCollection;

class FeesMasterController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::select(['name'])
                ->pluck('name')
                ->sort()
                ->values();

        $fees = new FeesResourceCollection(Fee::all()->sortBy('department'));

        return compact('departments', 'fees');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        $data = \json_decode($request->getContent());
        Fee::insert([
            'department' => $data->department,
            'category' => $data->category,
            'name' => $data->feesName,
            'op_cost' => $data->opFees,
            'ip_cost' => $data->ipFees
        ]);
        return \response(Fee::max('id'))->header('Content-Type', 'text/plain');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): \Illuminate\Http\Response
    {
        $data = \json_decode($request->getContent());
        Fee::where('id', $id)
                ->update([
                    'department' => $data->department,
                    'category' => $data->category,
                    'name' => $data->feesName,
                    'op_cost' => $data->opFees,
                    'ip_cost' => $data->ipFees
        ]);

        return response('Fees Details Updated')->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id):\Illuminate\Http\Response
    {
        Fee::where('id', $id)
                ->delete();

        return response('Fees Deleted!!!')->header('Content-Type', 'text/plain');
    }
}
