<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppleResource extends JsonResource
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
        $result = [
            'id'                => @$this->id,
            'name'              => @$this->name,
            'description'     => @$this->user->full_name,
            'images'     => @$this->images[0],
            'price'        => @$this->price_sell,
//            'trademark'     => @$this->trademark->name,
            'category'     => @$this->category->name,
        ];
        return $result;
    }
}
