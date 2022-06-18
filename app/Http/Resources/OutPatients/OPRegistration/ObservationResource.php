<?php

namespace App\Http\Resources\OutPatients\OPRegistration;

use Illuminate\Http\Resources\Json\JsonResource;

class ObservationResource extends JsonResource
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
            'id' => $this->id,
            'ptid' => $this->pt_id,
            'name' => $this->name,
            'age' => $this->age,
            'gender' => $this->gender,
            'contact' => $this->contact_no,
            'consultant' => $this->doctor_id,
            'reason' => $this->visit_reason,
            'height' => $this->height,
            'weight' => $this->weight,
            'bsa' => $this->bsa,
            'bp' => $this->bp,
            'pulse' => $this->pulse,
            'status' => $this->status,
        ];
    }
}
