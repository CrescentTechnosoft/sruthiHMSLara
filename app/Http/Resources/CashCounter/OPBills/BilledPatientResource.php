<?php

namespace App\Http\Resources\CashCounter\OPBills;

use Illuminate\Http\Resources\Json\JsonResource;

class BilledPatientResource extends JsonResource
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
            'pt_id' => $this->pt_id .'/ '.$this->patient->uhid,
            'name' => $this->patient->salutation . '.' . $this->patient->name,
            'age' => $this->patient->age,
            'gender' => $this->patient->gender,
            'contact' => $this->patient->contact_no,
            'consultant' => $this->doctor_id,
            'total' => (float) $this->total,
            'discount' => (float) $this->discount,
            'sub_total' => (float) $this->sub_total,
            'paying' => (float) $this->paid,
            'due' => (float) $this->due,
            'refund' => (float) $this->refund,
            'pay_type' => $this->payment_method,
            'other_type' => $this->other_payment,
            'card_no' => $this->card_no,
            'card_type' => $this->card_type,
            'card_expiry' => $this->card_expiry,
        ];
    }
}
