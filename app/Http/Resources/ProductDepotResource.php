<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDepotResource extends JsonResource
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
//            'branch'    => @$this->branch->name,
            'branch'    => @$this->product->name,
            'product'   => @$this->product->name,
            'quantity'  => @(int)$this->quantity,
            'sell'      => @(int)$this->xuat_ban,
            'failed'    => @(int)$this->tieu_hao,
        ];
    }
}
