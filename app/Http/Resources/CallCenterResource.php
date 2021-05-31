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
            'name_customer'     => @$this->customer->full_name,
            'phone'             => @$this->dest_number,
            'name_employee'     => @$this->user->full_name,
            'caller_number'     => @$this->caller_number,
            'start_time'        => @$this->start_time,
            'recording_url'     => @$this->recording_url,
            'recording_stream'  => @url('call-content').'?link='.$this->recording_url,
        ];
        return $result;
    }
}
