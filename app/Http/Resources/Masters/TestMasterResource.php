<?php
namespace App\Http\Resources\Masters;

use Illuminate\Http\Resources\Json\JsonResource;

class TestMasterResource extends JsonResource
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
            'category' => $this->category,
            'test' => $this->name,
            'method' => $this->method,
            'sample' => $this->sample,
            'units' => $this->units,
            'parameters' => $this->parameters,
            'comment' => $this->comments,
            'normal' => $this->reference_range,
            'fees' => $this->fees
        ];
    }
}
