<?php

namespace App\Http\Resources\OutPatients\Prescription;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'pt_id' => $this->pt_id,
            'name' => $this->name,
            'age' => $this->age,
            'gender' => $this->gender,
            'consultant' => $this->doctor->name,
            'height' => $this->height,
            'weight' => $this->weight,
            'bsa' => $this->bsa,
            'bp' => $this->bp,
            'pulse' => $this->pulse,
            'status' => $this->status,
            'diagnosis' => $this->prescription->diagnosis,
            'opinion' => $this->prescription->opinion,
            'patient_info' => $this->prescription->patient_info,
        ];
    }
}
