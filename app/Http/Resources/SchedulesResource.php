<?php

namespace App\Http\Resources;

use App\User;
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
        if ($request->type == "detail_schedules"){
            return [
                'id'             => @$this->id,
                'note'           => @$this->note,
                'date'           => @date('d/m/Y', strtotime($this->date)),
                'time_from'      => @$this->time_from,
                'time_to'        => @$this->time_to,
                'branch_id'      => @$this->branch_id,
                'branch_name'    => @$this->branch->name,
                'branch_phone'   => @$this->branch->phone,
                'branch_address' => @$this->branch->address,
            ];
        }elseif ($request->type == "list_schedules"){
            $user = User::find($request->jwtUser->id);
            $phone = @$user->permission('phone.open') ? $this->customer->phone : str_limit($this->customer->phone, 7, 'xxx');
            return [
                'id'           => @$this->id,
                'note'         => @$this->note,
                'date'         => @$this->date,
                'time_from'    => @$this->time_from,
                'time_to'      => @$this->time_to,
                'status'       => @$this->status,
                'branch_id'    => @$this->branch_id,
                'user_id'      => @$this->user_id,
                'user_name'    => @$this->customer->full_name,
                'user_phone'   => @$phone,
                'creator_id'   => @$this->creator_id,
                'creator_name' => @$this->creator->full_name,
            ];
        } else{
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
}
