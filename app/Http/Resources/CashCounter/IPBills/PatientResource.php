<?php

namespace App\Http\Resources\CashCounter\IPBills;

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
            'ptId'=>$this->patient->id,
            'name'=>$this->patient->salutation.'.'.$this->patient->name,
            'age'=>$this->patient->age,
            'gender'=>$this->patient->gender,
            'consultant'=>$this->doctor->name,
            'advance'=>(float)$this->getAdvances()
        ];
    }
}
