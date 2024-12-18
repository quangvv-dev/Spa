<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'id'               => $this->id,
            'full_name'        => $this->full_name,
            'avatar'           => @$this->avatar,
            'phoneNew'         => @$this->phoneNew,
            'orderNew'         => @$this->orderNew,
            'schedulesNew'     => @$this->schedulesNew,
            'schedules_mua'    => @$this->schedules_mua,
            'schedules_failed' => @$this->schedules_failed,
            'call'             => @$this->call,
            'percentOrder'     => @$this->percentOrder,
            'gross_revenue'    => @$this->gross_revenue,
            'totalNew'         => @$this->totalNew,
            'the_rest'         => @$this->the_rest,
            'avg'              => @$this->avg,
        ];
    }
}
