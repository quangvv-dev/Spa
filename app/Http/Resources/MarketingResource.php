<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarketingResource extends JsonResource
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
            'id'               => @$this->id,
            'full_name'        => @$this->full_name,
            'avatar'           => @$this->avatar,
            'contact'          => @$this->contact,
            'orders'           => @(int)$this->orders,
            'schedules'        => @(int)$this->schedules,
            'percent_schedule' => !empty($this->contact) ? round($this->schedules / $this->contact *100, 2) : 0,
            'percent_order'    => !empty($this->contact) ? round($this->orders / $this->contact * 100, 2) : 0,
            'avg'              => !empty($this->orders) ? round($this->gross_revenue / $this->orders, 2) : 0,
            'gross_revenue'    => @$this->gross_revenue,
        ];
        return $result;
    }
}
