<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'             => @$this->id,
            'name'           => @$this->customer->full_name,
            'phone'          => @$this->customer->phone,
            'total'          => @$this->all_total,
            'gross_revenue'  => !empty($this->gross_revenue)?$this->gross_revenue:"0",
            'the_rest'       => !empty($this->the_rest)?$this->the_rest:"0",
        ];
    }
}
