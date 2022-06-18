<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Doctor;
use App\Models\DoctorTiming;
use App\Models\Appointment;
use App\Http\Resources\Reception\AppointmentsResourceCollection;
use Carbon\Carbon;

class AppointmentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ids = Registration::select('id')->limit(250)->orderBy('id', 'desc')->pluck('id');
        $consultants = Doctor::has('timings')->get(['id', 'name'])->sortBy('name')->values();
        return compact('ids', 'consultants');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = \json_decode($request->getContent());

        Appointment::create([
            'pt_id' => $data->type === 'Old' ? $data->id : '0',
            'name' => $data->name,
            'contact_no' => $data->contact,
            'doctor_id' => $data->consultant,
            'appointment_at' => Carbon::createFromFormat('Y-m-d g:i A', $data->date . ' ' . $data->time)
                ->format('Y-m-d H:i:s')
        ]);

        return [
            'id' => Appointment::max('id'),
            'message' => 'Appointment Added'
        ];
    }

    public function searchPatients(Request $request)
    {
        $search = $request->input('search');
        return Registration::select(['id', 'name', 'contact_no as contact'])
            ->where('id', $search)
            ->orWhere('name', 'like', $search . '%')
            ->orWhere('contact_no', 'like', $search . '%')
            ->get();
    }

    public function getPatientDetails(int $id): array
    {
        $patient = Registration::find($id, ['salutation', 'name', 'contact_no']);

        return [
            'name' => $patient->salutation . '.' . $patient->name,
            'contact' => $patient->contact_no
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $timings = DoctorTiming::select(['day', 'start', 'end'])->where('doctor_id', $id)->get()
            ->map(function ($map) {
                $map->start = Carbon::createFromFormat('H:i:s', $map->start)->format('g:i A');
                $map->end = Carbon::createFromFormat('H:i:s', $map->end)->format('g:i A');
                return $map;
            });
        $appointments = new AppointmentsResourceCollection(Appointment::where('doctor_id', $id)
            ->where('appointment_at', '>=', Carbon::now())
            ->get());

        return compact('timings', 'appointments');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): \Illuminate\Http\Response
    {
        Appointment::where('id', $id)->delete();
        return response('Appointment Cancelled!!!')->header('Content-Type', 'text/plain');
    }
}
