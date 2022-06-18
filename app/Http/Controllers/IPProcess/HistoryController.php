<?php

namespace App\Http\Controllers\IPProcess;

use App\Http\Controllers\Controller;
use App\Models\IPAdmission;
use App\Models\IPTreatment;
use App\Http\Resources\IPProcess\History\PatientResource;
use App\Http\Resources\IPProcess\History\SearchResourceCollection;
use App\Models\Registration;

class HistoryController extends Controller
{

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): array
    {
        $years = IPAdmission::select('year')->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $ipNos = $years->isEmpty() ? [] : $this->getIpNos($years->first());

        return compact('years', 'ipNos');
    }

    public function getIpNos(string $year): \Illuminate\Support\Collection
    {
        return IPAdmission::where('year', $year)
            ->get(['id', 'ip_no as ipNo'])
            ->sortByDesc('id')
            ->values();
    }

    public function searchPatients(string $search): SearchResourceCollection
    {
        $patients = IPAdmission::whereHas('patient', function ($query) use ($search) {
            $query->where('name', 'like', $search . '%')
                ->orWhere('contact_no', $search . '%');
        })
            ->with('patient:id,name,contact_no')
            ->get(['id', 'pt_id', 'year', 'ip_no']);

        SearchResourceCollection::wrap('patients');
        return SearchResourceCollection::make($patients);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(int $id): array
    {
        $data = IPTreatment::where('ip_id', '=', $id)
            ->with(['treatments:treatment_id,department,category,fees_type,qty,cost'])
            ->get(['id', 'pt_id', 'ip_id', 'ref_no', 'created_at'])
            ->sortBy('ref_no');

        $treatments = collect();

        $data->each(function ($val) use (&$treatments) {
            $val->treatments->each(function ($treat) use ($val, &$treatments) {
                $treatments->push([
                    'dept' => $treat->department,
                    'category' => $treat->category,
                    'service' => $treat->fees_type,
                    'qty' => (float) $treat->qty,
                    'cost' => (float) $treat->cost,
                    'total' => (float) $treat->qty * (float) $treat->cost,
                    'refNo' => $val->ref_no,
                    'date' => $val->created_at->format('Y-m-d H:i:s')
                ]);
            });
        });

        return [
            'data' => PatientResource::make($data->first()),
            'treatments' => $treatments
        ];
    }
}
