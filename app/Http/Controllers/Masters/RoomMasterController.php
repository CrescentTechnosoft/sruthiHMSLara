<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ward;

class RoomMasterController extends Controller
{

    public function __construct()
    {
        $this->middleware('compress')->only('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Support\Collection
    {
        return Ward::all(['id', 'floor', 'ward', 'room', 'bed as bedNo', 'rent', 'status as occupied'])
            ->sortBy('floor')
            ->values();
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
        Ward::create([
            'floor' => $data->floor,
            'ward' => $data->ward,
            'room' => $data->room,
            'bed' => $data->bedNo,
            'rent' => $data->rent,
            'ip_id' => null,
            'pt_id' => null,
            'name' => '',
            'status' => 0
        ]);

        return [
            'status' => true,
            'message' => 'Room Details Saved',
            'id' => Ward::max('id')
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
        //
    }

    public function update(Request $request, int $id): \Illuminate\Http\Response
    {
        $data = \json_decode($request->getContent());
        Ward::where('id', $id)
            ->update([
                'floor' => $data->floor,
                'ward' => $data->ward,
                'room' => $data->room,
                'bed' => $data->bedNo,
                'rent' => $data->rent
            ]);

        return \response('Room Details Updated!!!')->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        Ward::where('id', $id)
            ->where('status', 0)
            ->delete();

        return response('Room Details Deleted')->header('Content-Type', 'text/plain');
    }
}
