<?php

namespace App\Http\Resources\Lab;

use Illuminate\Http\Resources\Json\JsonResource;

class Fields extends JsonResource
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
            'category' => $this->category ?? $this->test->category,
            'testID' => $this->test_id,
            'test' => $this->name ?? $this->test->name,
            'id' => $this->field_id,
            'field' => $this->test->name,
            'result' => $this->result,
            'parameters' => $this->test->parameters === '' ? [] : explode(',', $this->test->parameters),
            'normal' => $this->test->reference_range,
            'method' => $this->test->method,
            'norm' => $this->result_type,
            'selected' => $this->is_selected,
            'isGroup' => $this->is_group
        ];
    }

}
