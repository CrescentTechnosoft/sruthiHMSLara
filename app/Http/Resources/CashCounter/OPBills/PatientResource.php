<?php

namespace App\Http\Resources\CashCounter\OPBills;

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
            'id' => $this->id,
            'name' => $this->salutation . '.' . $this->name,
            'contact' => $this->contact_no
        ];
    }
}
