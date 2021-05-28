<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CallCenterResource extends JsonResource
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
            'name_customer'  => @$this->customer->full_name,
            'phone'          => @$this->dest_number,
            'name_employee'  => @$this->user->full_name,
            'caller_number'  => @$this->caller_number,
            'start_time'     => @$this->start_time,
            'recording_url'  => @$this->recording_url,
//            'colors'         => $this->colors,
//            'trademark_id'   => $this->trademark_id,
//            'guarantee'      => $this->guarantee,
//            'order_status'   => $this->order_status,
//            'quality'        => $this->quality,
//            'category'       => @$this->category->name,
//            'category_en'    => @$this->category->name_en,
        ];
        return $result;
    }
}
