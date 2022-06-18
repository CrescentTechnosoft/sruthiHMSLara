<?php
namespace App\Http\Resources\Reception;

use Illuminate\Http\Resources\Json\JsonResource;

class UpdateResource extends JsonResource
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
            'salutation' => $this->salutation,
            'name' => $this->name,
            'age' => $this->age,
            'gender' => $this->gender,
            'contact' => $this->contact_no,
            'email' => $this->email_address,
            'dob' => $this->dob,
            'address' => $this->address,
            'cons' => $this->doctor_id
        ];
    }
}
