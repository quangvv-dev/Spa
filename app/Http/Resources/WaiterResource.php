<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WaiterResource extends JsonResource
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
            'full_name' => @$this->full_name,
            'avatar'            => @$this->avatar,
            'payment_new' => @$this->payment_new,
            'contact' => @$this->contact,
            'order_new' => $this->order_new,
            'order_old' => @(int)$this->order_old,
            'total_new' => @(int)$this->total_new,
            'total_old' => @$this->total_old,
            'all_total' => @$this->all_total,
            'all_payment' => @$this->all_payment,
        ];
        return $result;
    }
}
