<?php

namespace App\Http\Resources\IPProcess\Treatments;

use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentResource extends JsonResource
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
            'feesId' => $this->fees_id,
            'dept' => $this->department,
            'category' => $this->category,
            'feesType' => $this->fees_type,
            'testType' => $this->test_type,
            'qty' => $this->qty,
            'cost' => $this->cost
        ];
    }

}
