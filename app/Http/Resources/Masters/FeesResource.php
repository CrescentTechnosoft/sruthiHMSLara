<?php

namespace App\Http\Resources\Masters;

use Illuminate\Http\Resources\Json\JsonResource;

class FeesResource extends JsonResource
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
            'department'=>$this->department,
            'category'=>$this->category,
            'feesName'=>$this->name,
            'opFees'=>(float)$this->op_cost,
            'ipFees'=>(float)$this->ip_cost,
        ];
    }
}
