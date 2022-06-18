<?php

namespace App\Http\Resources\Reception;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentsResource extends JsonResource
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
            'id'=>$this->id,
            'ptID'=>$this->pt_id,
            'name'=>$this->name,
            'contact'=>$this->contact_no,
            'date'=>$this->appointment_at
        ];
    }
}
