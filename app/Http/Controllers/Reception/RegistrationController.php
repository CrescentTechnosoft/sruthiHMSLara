<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Registration;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Doctor::where('status', '=', 'Active')
            ->get(['id', 'name'])
            ->sortBy('name')
            ->values();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent());
        $count = Registration::where([
            'name' => $data->name,
            'contact_no' => $data->contactNo
        ])->count();

        if ($count > 0) {
            return [
                'status' => false,
                'message' => 'Patient Details already Exists'
            ];
        }

        $registration = Registration::create([
            'salutation' => $data->salutation,
            'name' => $data->name,
            'age' => $data->age,
            'gender' => $data->gender,
            'dob' => $data->dob,
            'contact_no' => $data->contactNo,
            'email_address' => $data->email,
            'address' => $data->address,
            'doctor_id' => $data->consultant,
            'user_id' => $request->session()->get('user_id')
        ]);

        return [
            'status' => true,
            'id' => $registration->id
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
