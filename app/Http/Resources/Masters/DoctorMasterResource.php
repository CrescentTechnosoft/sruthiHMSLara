<?php
namespace App\Http\Resources\Masters;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorMasterResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'gender' => $this->gender,
            'contact' => $this->contact_no,
            'email' => $this->email_address,
            'address' => $this->address,
            'specs' => $this->specialization,
            'qualification' => $this->qualification,
            'status' => $this->status
        ];
    }
}
