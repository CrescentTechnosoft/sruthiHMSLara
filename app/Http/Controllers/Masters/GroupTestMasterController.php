<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Masters\GroupTestMasterService;

class GroupTestMasterController extends Controller
{

    /**
     *
     * @var GroupTestMasterService
     */
    private GroupTestMasterService $service;

    public function __construct()
    {
        $this->service = new GroupTestMasterService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            'categories' => $this->service->GetCategories(),
            'fields' => $this->service->GetFields()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_datas= \json_decode($request->getContent());

        return $this->service->saveTest($request_datas->data, $request_datas->fields);
    }

    public function getTests()
    {
        return $this->service->getTests();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return $this->service->getTestDetails($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request_datas= \json_decode($request->getContent());

        return $this->service->UpdateTest($id, $request_datas->data, $request_datas->fields);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->service->DeleteTest($id);
        return response('Test Deleted')->header('Content-Type', 'text/plain');
    }
}
