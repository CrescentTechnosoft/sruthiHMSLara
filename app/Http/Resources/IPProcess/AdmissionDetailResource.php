<?php
namespace App\Http\Resources\IPProcess;

use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionDetailResource extends JsonResource
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
            'txtID' => $this->pt_id,
            'name' => $this->patient->name,
            'age' => $this->patient->age,
            'gender' => $this->patient->gender,
            'address' => $this->patient->address,
            'contact' => $this->patient->contact_no,
            'fees' => $this->fees,
            'admType' => $this->type,
            'diagnosis' => $this->diagnosis,
            'ref' => $this->referrer,
            'department' => $this->department,
            'cons' => $this->consultant,
            'rName' => $this->rel_name,
            'rContact' => $this->rel_contact_no,
            'rType' => $this->rel_type,
            'relAddress' => $this->rel_address,
            'insCat' => $this->ins_cat,
            'insID' => $this->ins_id,
            'insName' => $this->ins_name
        ];
    }
}
