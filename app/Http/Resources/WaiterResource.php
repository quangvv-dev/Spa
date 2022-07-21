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
            'id'            => @$this->id,
            'full_name'     => @$this->full_name,
            'detail_new'    => @$this->detail_new,
            'customer_new'  => @$this->customer_new,
            'order_new'     => $this->order_new,
            'order_old'     => @(int)$this->order_old,
            'revenue_new'   => @(int)$this->revenue_new,
            'revenue_old'   => @$this->revenue_old,
            'payment_revenue' => @$this->payment_revenue,
            'payment_new'   => @$this->payment_new,
            'payment_old'   => @$this->payment_old,
            'revenue_total' => @$this->revenue_total,
            'all_payment'   => @$this->all_payment,
        ];
        return $result;
    }
}
