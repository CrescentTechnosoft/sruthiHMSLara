<?php

namespace App\Http\Resources\CashCounter\OPBills;

use Illuminate\Http\Resources\Json\JsonResource;

class BillDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'dept' => $this->department,
            'category' => $this->category,
            'fees_id' => $this->fees_id,
            'fees_type' => $this->fees_type,
            'test_type' => $this->test_type,
            'cost' => (float) $this->fees,
            'discount' => (float) $this->discount,
        ];
    }
}
