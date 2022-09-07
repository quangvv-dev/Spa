<?php

namespace App\Http\Resources\AppCustomers;

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
        if ($request->type =='full_data'){
            return [
                'id'           => @$this->id,
                'full_name'    => @$this->full_name,
                'phone'        => @$this->phone,
                'telesales_id' => @$this->telesales_id,
                'mkt_id'       => @$this->mkt_id,
                'gender'       => @$this->gender,
                'status_id'    => @$this->status_id,
                'source_id'    => @$this->source_id,
                'description'  => @$this->description,
                'branch_id'    => @$this->branch_id,
                'branch_name'  => @$this->branch->name,
                'status_name'  => @$this->status->name,
            ];
        }else{
            return [
                'id'           => @$this->id,
                'full_name'    => @$this->full_name,
                'phone'        => @$this->phone,
                'membership'   => @$this->membership,
                'wallet'       => @$this->wallet,
                'wallet_ctv'   => @$this->wallet_ctv,
                'avatar'       => @$this->avatar,
                'birthday'     => @$this->birthday,
                'gender'       => @$this->gender,
                //            'gender'    => @$this->gender==0?"Nữ":'Nam',
                'branch_id'    => @$this->branch_id,
                'branch'       => @$this->branch->name,
                'status'       => @$this->status->name,
                'status_id'    => @$this->status_id,
                'is_gioithieu' => @$this->is_gioithieu,
            ];
        }
    }
}
