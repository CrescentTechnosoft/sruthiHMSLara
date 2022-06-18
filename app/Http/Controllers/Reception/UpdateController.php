<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Doctor;
use App\Http\Resources\Reception\UpdateResource;

class UpdateController extends Controller
{
    public function show($id): array
    {
        $cons = Doctor::where('status', '=', 'Active')
            ->get(['id', 'name'])
            ->sortBy('name')
            ->values();

        $details = UpdateResource::make(Registration::where('uuid', '=', $id)->first());

        return compact('cons', 'details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $uuid)
    {
        $data = json_decode($request->getContent());

        Registration::where('uuid', '=', $uuid)
            ->first()
            ->update([
                'salutation' => $data->salutation,
                'name' => $data->name,
                'age' => $data->age,
                'gender' => $data->gender,
                'dob' => $data->dob,
                'contact_no' => $data->contactNo,
                'email_address' => $data->email,
                'address' => $data->address,
                'doctor_id' => $data->consultant
            ]);

        return response('Patient Details Updated')->header('Content-Type', 'text/plain');
    }
}
