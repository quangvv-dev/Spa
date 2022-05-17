<?php

namespace App\Http\Resources\AppCustomers;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'id'        => @$this->id,
            'full_name' => @$this->full_name,
            'phone'     => @$this->phone,
            'membership'=> @$this->membership,
            'wallet'    => @$this->wallet,
            'avatar'    => @$this->avatar,
            'birthday'  => @$this->birthday,
            'gender'    => @$this->gender,
//            'gender'    => @$this->gender==0?"Nữ":'Nam',
            'branch_id' => @$this->branch_id,
            'branch'    => @$this->branch->name,
            'status'    => @$this->status->name,
        ];
    }
}
