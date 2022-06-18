<?php

namespace App\Http\Resources\CashCounter\IPBills;

use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
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
            'tIP'=>$this->ip_id,
            'ptId'=>$this->patient->id,
            'name'=>$this->patient->salutation.'.'.$this->patient->name,
            'age'=>$this->patient->age,
            'gender'=>$this->patient->gender,
            'consultant'=>$this->admission->doctor->name,
            'total'=>(float)$this->total,
            'advance'=>(float)$this->advance_paid,
            'discount'=>(float)$this->discount,
            'subTotal'=>(float)$this->sub_total,
            'paying'=>(float)$this->paid,
            'due'=>(float)$this->due,
            'refund'=>(float)$this->refund,
            'payType'=>$this->payment_method,
            'otherType'=>$this->other_payment,
            'cardNo'=>$this->card_no,
            'cardType'=>$this->card_type,
            'cardExpiry'=>$this->card_expiry
        ];
    }
}
