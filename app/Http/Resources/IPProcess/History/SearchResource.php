<?php

namespace App\Http\Resources\IPProcess\History;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
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
            'year' => $this->year,
            'ipNo' => $this->ip_no,
            'id' => $this->id,
            'name' => $this->patient->name,
            'contactNo' => $this->patient->contact_no
        ];
    }
}
