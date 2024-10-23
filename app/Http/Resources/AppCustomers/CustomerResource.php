<?php

namespace App\Http\Resources\AppCustomers;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
        $phone = $this->phone;
        if (!empty($request->jwtUser)) {
            $user = User::find($request->jwtUser->id);
            $phone = @$user->permission('phone.open') ? $phone : str_limit($phone, 7, 'xxx');
        }
        if ($request->type == 'full_data') {
            return [
                'id'               => @$this->id,
                'full_name'        => @$this->full_name,
                'phone'            => $phone,
                'phone_click2call' => $this->phone,
                'telesales_id'     => @$this->telesales_id,
                'mkt_id'           => @$this->mkt_id,
                'gender'           => @$this->gender,
                'status_id'        => @$this->status_id,
                'source_id'        => @$this->source_id,
                'description'      => @$this->description,
                'branch_id'        => @$this->branch_id,
                'branch_name'      => @$this->branch->name,
                'status_name'      => @$this->status->name,
                'group_array'      => @$this->group_array,
            ];
        } else {
            return [
                'id'               => @$this->id,
                'full_name'        => @$this->full_name,
                'phone'            => $phone,
                'phone_click2call' => $this->phone,
                'membership'       => @$this->membership,
                'wallet'           => @$this->wallet,
                'wallet_ctv'       => @$this->wallet_ctv,
                'avatar'           => @$this->avatar,
                'birthday'         => @$this->birthday,
                'gender'           => @$this->gender,
                //            'gender'    => @$this->gender==0?"Nữ":'Nam',
                'branch_id'        => @$this->branch_id,
                'branch'           => @$this->branch->name,
                'status'           => @$this->status->name,
                'status_id'        => @$this->status_id,
                'is_gioithieu'     => @$this->is_gioithieu,
            ];
        }
    }
}
