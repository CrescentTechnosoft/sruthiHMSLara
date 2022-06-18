<?php

namespace App\Http\Resources\IPProcess\Discharge;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->pt_id,
            'name' => $this->patient->name,
            'age' => $this->patient->age,
            'gender' => $this->patient->gender,
            'consultant' => $this->doctor->name,
        ];
    }

}
