<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\DoctorTiming;
use Carbon\Carbon;

class DoctorTimingController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        $data = \json_decode($request->getContent());
        DoctorTiming::where('doctor_id', $data->id)
                ->delete();

        $timings = [];
        foreach ($data->timings as $timing) {
            $timings[] = [
                'doctor_id' => $data->id,
                'day' => $timing->day,
                'start' => Carbon::createFromFormat('g:i A', $timing->start),
                'end' => Carbon::createFromFormat('g:i A', $timing->end)
            ];
        }
        DoctorTiming::insert($timings);

        return response('Doctor Timings Added')->header('Content-Type', 'text/plain');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return DoctorTiming::select(['day', 'start', 'end'])
                        ->where('doctor_id', $id)
                        ->get()
                        ->map(function ($map) {
                            $map->start = Carbon::createFromFormat('H:i:s', $map->start)->format('g:i A');
                            $map->end = Carbon::createFromFormat('H:i:s', $map->end)->format('g:i A');
                            return $map;
                        });
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
    public function destroy($id)
    {
        //
    }

}
