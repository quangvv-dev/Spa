<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryRevenueResource extends JsonResource
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
            'id'       => @$this->id,
            'name'     => @$this->name,
            'orders'   => @$this->orders,
            'revuenue' => @$this->revuenue,
            'total'    => @$this->total,
        ];
    }
}
