<?php

namespace App\Http\Resources\ChamCong;

use App\Constants\ChamCongConstant;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'              => $this->id,
            'full_name'       => @$this->user->full_name,
            'code_user'       => @$this->user->code,
            'department_name' => @$this->user->department->name,
            'role_name'       => @$this->user->roles->name,
            'status_text'     => @$this->status == 1 ? "Đã duyệt" : ($this->status == 0 ? "Chờ duyệt" : 'Không duyệt'),
            'status'          => $this->status,
            'title'           => $this->type == 0 ? "Đơn nghỉ" : 'Đơn check-in/check-out',
            'description'     => @$this->description,
            'date'            => @$this->date,
            'date_end'        => @$this->date_end,
            'created_at'      => @$this->created_at->format('H:i d/m/Y'),
            'reason_id'       => @$this->reason_id,
            'reason_text'     => @$this->reason->name,
            'accept_id'       => @$this->accept_id,
            'accept_name'     => @$this->accept ? $this->accept->full_name : '',
            'time_to'         => !empty($this->time_to) ? array_search($this->time_to, ChamCongConstant::HOURS) : '',
            'time_end'        => !empty($this->time_end) ? array_search($this->time_end, ChamCongConstant::HOURS) : '',
        ];
    }
}
