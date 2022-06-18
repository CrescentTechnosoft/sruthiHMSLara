<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Http\Resources\Masters\DoctorMasterResourceCollection;

class DoctorMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('compress')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index():array
    {
        $doctors = new DoctorMasterResourceCollection(Doctor::all()->sortBy('name'));
        $specs = \App\Models\Specialization::select('name')->pluck('name');

        return compact('doctors', 'specs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function store(Request $request): array
    {
        $data = \json_decode($request->getContent());
        if (Doctor::where('name', $data->name)->count() > 0) {
            return [
                'status' => false,
                'message' => 'Doctor Name already Exists!!!'
            ];
        } else {
            Doctor::insert([
                'name' => $data->name,
                'age' => $data->age,
                'gender' => $data->gender,
                'contact_no' => $data->contact,
                'email_address' => $data->email,
                'address' => $data->address,
                'specialization' => $data->specs,
                'qualification' => $data->qualification,
                'status' => $data->status
            ]);

            return [
                'status' => true,
                'message' => 'Doctor Details Added',
                'id' => Doctor::max('id')
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return array
     */
    public function update(Request $request, $id): array
    {
        $data = \json_decode($request->getContent());

        $is_exists = Doctor::where('id', '!=', $id)
                        ->where('name', $data->name)
                        ->count() > 0;

        if ($is_exists) {
            return [
                'status' => false,
                'message' => 'Doctor Name already Exists!!!'
            ];
        } else {
            Doctor::where('id', $id)
                    ->update([
                        'name' => $data->name,
                        'age' => $data->age,
                        'gender' => $data->gender,
                        'contact_no' => $data->contact,
                        'email_address' => $data->email,
                        'address' => $data->address,
                        'specialization' => $data->specs,
                        'qualification' => $data->qualification,
                        'status' => $data->status
            ]);
            return [
                'status' => true,
                'message' => 'Doctor Details Updated'
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Doctor::where('id', $id)
                ->delete();

        return response('Doctor Details Deleted!!!')->header('Content-Type', 'text/plain');
    }
}
