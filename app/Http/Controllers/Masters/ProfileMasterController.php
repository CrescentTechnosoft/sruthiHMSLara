<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Masters\ProfileMasterService;

class ProfileMasterController extends Controller
{

    /**
     *
     * @var ProfileMasterService
     */
    private ProfileMasterService $service;

    public function __construct(ProfileMasterService $service)
    {
        $this->middleware('compress', [
            'only' => 'index'
        ]);
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): array
    {
        return [
            'test' => $this->service->GetTests(),
            'groupTest' => $this->service->GetGroupTests()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): array
    {
        $request_data = \json_decode($request->getContent());

        return $this->service->saveProfile($request_data->data, $request_data->tests);
    }

    public function getProfiles(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->service->getProfiles();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): array
    {
        return $this->service->getProfileDetails($id);
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
        $request_data = \json_decode($request->getContent());

        return $this->service->updateProfile($id, $request_data->data, $request_data->tests);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->service->DeleteProfile($id);
        return \response('Profile Deleted')->header('Content-Type', 'text/plain');
    }
}
