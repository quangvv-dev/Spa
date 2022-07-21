<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarepageResource extends JsonResource
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
            'id'            => @$this->id,
            'full_name'     => @$this->full_name,
            'avatar'        => @$this->avatar,
            'contact'       => @$this->contact,
            'budget'        => $this->budget ?: 0,
            'orders'        => @(int)$this->orders,
            'gross_revenue' => @$this->gross_revenue,
        ];
        return $result;
    }
}
