<?php

namespace App\Http\Resources\CashCounter\IpAdvances;

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
            'ptId'=>$this->pt_id.' // '.$this->patient->uhid ,
            'name'=>$this->patient->salutation.'.'.$this->patient->name,
            'age'=>$this->patient->age,
            'gender'=>$this->patient->gender
        ];
    }
}
