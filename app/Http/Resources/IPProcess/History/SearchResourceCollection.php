<?php

namespace App\Http\Resources\IPProcess\History;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
