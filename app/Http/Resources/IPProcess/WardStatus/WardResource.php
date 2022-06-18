<?php

namespace App\Http\Resources\IPProcess\WardStatus;

use Illuminate\Http\Resources\Json\JsonResource;

class WardResource extends JsonResource
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
            'year' => $this->admission === null ? '' : $this->admission->year,
            'ipNo' => $this->admission === null ? '' : $this->admission->ip_no,
            'name' => $this->patient === null ? '' : $this->patient->name,
            'age' => $this->patient === null ? '' : $this->patient->age,
            'gender' => $this->patient === null ? '' : $this->patient->gender,
            'contact' => $this->patient === null ? '' : $this->patient->contact_no,
            'consultant' => $this->admission === null ? '' : $this->admission->doctor->name,
            'floor' => $this->floor,
            'ward' => $this->ward,
            'room' => $this->room,
            'bedNo' => $this->bed,
            'rent' => $this->rent,
            'status'=>$this->status
        ];
    }

}

/**
  name: string,
  age: string,
  gender: string,
  admitted: string,
  contact: string,
  consultant: string,
  floor: string,
  ward: string,
  room: string,
  bedNo: string,
  rent: number
 */