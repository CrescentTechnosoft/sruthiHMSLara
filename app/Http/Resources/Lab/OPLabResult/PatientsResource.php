<?php

namespace App\Http\Resources\Lab\OPLabResult;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientsResource extends JsonResource
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
            'year' => $this->year,
            'billNo' => $this->bill_no,
            'name' => $this->registration->salutation . '.' . $this->registration->name,
            'contact' => $this->registration->contact_no
        ];
    }

}
