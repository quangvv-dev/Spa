<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchedulesResource extends JsonResource
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
            'id'               => @$this->id,
            'full_name'        => @$this->full_name,
            'all_schedules'    => @$this->all_schedules,
            'schedules_buy'    => @$this->schedules_buy,
            'schedules_notbuy' => @$this->schedules_notbuy,
            'schedules_cancel' => @$this->schedules_cancel,
        ];
    }
}
