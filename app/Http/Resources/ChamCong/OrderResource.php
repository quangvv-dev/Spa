<?php

namespace App\Http\Resources\ChamCong;

use App\Constants\ChamCongConstant;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'          => $this->id,
            'full_name'   => @$this->user->full_name,
            'status_text' => @$this->status == 1 ? "Đã duyệt" : ($this->status == 0 ? "Chờ duyệt" : 'Không duyệt'),
            'status'      => $this->status,
            'title'       => $this->type == 0 ? "Đơn nghỉ" : 'Đơn check-in/check-out',
            'description' => @$this->description,
            'date'        => @$this->date,
            'date_end'    => @$this->date_end,
            'time_to'     => !empty($this->time_to) ? array_search($this->time_to, ChamCongConstant::HOURS) : '',
            'time_end'    => !empty($this->time_end) ? array_search($this->time_end, ChamCongConstant::HOURS) : '',
        ];
    }
}
