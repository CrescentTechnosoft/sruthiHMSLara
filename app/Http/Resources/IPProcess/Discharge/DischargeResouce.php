<?php

namespace App\Http\Resources\IPProcess\Discharge;

use Illuminate\Http\Resources\Json\JsonResource;

class DischargeResouce extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $cons = explode('|', $this->consultants);
        $death_date=explode('|',$this->death_date);
        return [
            'id' => $this->patient->id,
            'name' => $this->patient->name,
            'age' => $this->patient->age,
            'gender' => $this->patient->gender,
            'consultant' => $this->admission->doctor->name,
            'history' => $this->history,
            'pReaction' => $this->pt_reaction,
            'pulse' => $this->pulse,
            'bp' => $this->bp,
            'hb' => $this->hb,
            'tc' => $this->tc,
            'wbc' => $this->wbc,
            'poly' => $this->poly,
            'lymp' => $this->lymp,
            'eos' => $this->eos,
            'm' => $this->m,
            'b' => $this->b,
            'sugar' => $this->blood_sugar,
            'urea' => $this->urea,
            'scr' => $this->scr,
            'crit' => $this->crit,
            'plat' => $this->plat,
            'diagnosis' => $this->diagnosis,
            'investigation' => $this->investigations,
            'surgery' => $this->surgery,
            'treatment' => $this->treatment,
            'advice' => $this->advice,
            'condition' => $this->condition,
            'disease' => $this->disease,
            'cons1' => $cons[0],
            'cons2' => $cons[1],
            'cons3' => $cons[2],
            'cons4' => $cons[3],
            'cons5' => $cons[4],
            'dDate' => $death_date[0],
            'dTime' => $death_date[1],
            'dCause' => $this->death_details,
            'hCourse' => $this->hosp_course,
            'report' => $this->report
        ];
    }

}
