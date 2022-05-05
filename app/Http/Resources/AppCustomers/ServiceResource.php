<?php

namespace App\Http\Resources\AppCustomers;

use App\Constants\StatusCode;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        if ($request->type == StatusCode::SERVICE){
            return [
                'id'            => @$this->id,
                'category_name' => @$this->category->name,
                'price_sell'    => @$this->price_sell,
                'images'        => @$this->images,
                'description'   => @$this->description,
            ];
        } else {
            return [
                'id'            => @$this->id,
                'category_name' => @$this->category->name,
                'price_sell'    => @$this->price_sell,
                'images'        => @$this->images,
                'trademark'     => @$this->trademarks->name,
                'description'   => @$this->description,
            ];
        }
    }
}
