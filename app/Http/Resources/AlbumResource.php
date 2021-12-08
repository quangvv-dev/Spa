<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id'               => @$this->id,
            'customer_name'    => @$this->customer->full_name,
            'phone'            => @$this->customer->phone,
//            'branch'           => @$this->branch->name,
            'images'           => @json_decode($this->images),
        ];
    }
}
