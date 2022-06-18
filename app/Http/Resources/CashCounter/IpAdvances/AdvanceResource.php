<?php

namespace App\Http\Resources\CashCounter\IpAdvances;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvanceResource extends JsonResource
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
            'advNo' => $this->advance_no,
            'amount' => $this->amount,
            'date' => $this->created_at->format('Y-m-d H:i:s'),
            'payType'=>$this->pay_type,
            'otherPayType'=>$this->other_pay_type,
            'cardNo'=>$this->card_no,
            'cardType'=>$this->card_type,
            'cardExpiry'=>$this->card_expiry,
        ];
    }

}
