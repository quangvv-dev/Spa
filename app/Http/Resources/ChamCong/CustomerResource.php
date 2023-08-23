<?php

namespace App\Http\Resources\ChamCong;

use App\Constants\ChamCongConstant;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'id'         => $this->id,
            'full_name'  => @$this->full_name,
            'phone'      => $this->phone,
            'group_text' => $this->group_text,
            'wallet'     => $this->wallet,
            'telesale'   => isset($this->telesale) ? [
                'id'        => $this->telesale->id,
                'full_name' => $this->telesale->full_name,
                'avatar'    => $this->telesale->avatar,
            ] : null,
            'amount_orders'=> $this->orders->sum('gross_revenue'),
            'branch_id'  => $this->branch_id,
        ];
    }
}
