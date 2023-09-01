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
            'id'                => @$this->id,
            'full_name'         => @$this->full_name,
            'avatar'            => @$this->avatar,
            'contact'           => @$this->contact,
            'schedules'         => @$this->schedules,
//            'schedules_den'     => @$this->schedules_den,
            'orders'            => $this->orders,
            'all_total'         => @(int)$this->all_total,
            'gross_revenue'     => @(int)$this->gross_revenue,
            'payment'           => @$this->payment,
            'avg'               => @$this->avg,
            'the_rest'          => 0,
            'percent_order'     => @$this->percent_order,
            'percent_schedules' => @$this->percent_schedules,
        ];
        return $result;
    }
}
