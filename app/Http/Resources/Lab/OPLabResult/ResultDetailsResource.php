<?php

namespace App\Http\Resources\Lab\OPLabResult;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultDetailsResource extends JsonResource
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
            'testId' => $this->id,
            'category' => $this->category,
            'test' => $this->name,
            'field' => $this->field_name,
            'result' => $this->result,
            'method' => $this->method,
            'sample' => $this->sample,
            'type' => $this->type,
            'checked' => (bool) $this->is_selected,
        ];
    }
}
