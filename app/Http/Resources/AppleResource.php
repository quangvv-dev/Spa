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
            'id' => @$this->id,
            'name' => @$this->name,
            'description' => @$this->user->full_name,
            'images' => @$this->images[0],
            'price' => @$this->price_sell,
            'category' => @$this->category->name,
        ];
        if ($request->api_type == 2) {
            $result = [
                'id' => @$this->id,
                'services' => @$this->service_text,
                'all_total' => @$this->all_total,
                'images' => @$this->orderDetails[0]->services->images[0],
            ];
            return $result;
        }
        return $result;
    }
}
