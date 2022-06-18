<?php

namespace App\Http\Controllers\IPProcess;

use App\Http\Controllers\Controller;
use App\Services\IPProcess\AdmissionService;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    /**
     * @var AdmissionService
     */
    private AdmissionService $service;

    public function __construct(AdmissionService $service)
    {
        $this->service = $service;
        $this->middleware('compress')->only(['index', 'getWards']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \response()->json($this->service->getAll());
    }

    public function getPatientDetails(Request $request)
    {
        return $this->service->getPatientDetails($request->id);
    }

    public function getWards()
    {
        return $this->service->getWards();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): array
    {
        $data = json_decode($request->data);
        if ($this->service->checkRoomStatus($data->room)) {
            return [
                'status' => false,
                'message' => 'Sorry this room is already Occupied\nSelect Other room',
            ];
        } else {
            $year = $this->service->generateYear();
            $ip_no = $this->service->generateIPNo($year);
            $ip_id = $this->service->saveIPAdmission($data, $year, $ip_no);

            return [
                'ip_no' => $ip_no,
                'ip_id' => $ip_id,
                'status' => true,
            ];
        }
    }

    public function getYears(): array
    {
        $years = $this->service->getAdmissionYear();
        $ipNos = $years->isEmpty() ? [] : $this->service->getIPNo($years->first());

        return compact('years', 'ipNos');
    }

    public function getIpNos(string $year): \Illuminate\Support\Collection
    {
        return $this->service->getIPNo($year);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->service->getIPDetails($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent());
        $this->service->updateIPAdmission($data, $id);

        return response('Admission Details Updated!!!')->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $this->service->deleteIPAdmission($id);

        return response('Admission Details Deleted')->header('Content-Type', 'text/plain');
    }

    public function getRevert(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
                    'id' => $this->service->getPID(),
                    'rooms' => $this->service->getWards(),
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        return $this->service->searchPatients($search);
    }
}
