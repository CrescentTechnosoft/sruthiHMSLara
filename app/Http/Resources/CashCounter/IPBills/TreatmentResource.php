<?php

namespace App\Http\Resources\CashCounter\IPBills;

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
            'dept'=>$this->department,
            'category'=>$this->category,
            'feesId'=>$this->fees_id,
            'service'=>$this->fees_type,
            'cost'=>(float)$this->cost,
            'qty'=>(int)$this->qty,
            'total'=>(float)$this->total,
            'discount'=>0
        ];
    }
}
