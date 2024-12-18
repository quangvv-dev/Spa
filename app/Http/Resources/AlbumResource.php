<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $phone = $request->jwtUser->permission('phone.open') ? @$this->customer->phone : str_limit($this->customer->phone, 7, 'xxx');
        return [
//            'id'               => @$this->id,
            'customer_id'      => @$this->customer->id,
            'customer_name'    => @$this->customer->full_name,
            'phone'            => $phone,
            'account_code'     => @$this->customer->account_code,
            'title'            => @$this->title,
            'branch_id'        => @$this->branch_id,
            'service_text'     => @$this->service_text,
            'branch'           => @$this->branch->name,
            'images'           => @json_decode($this->images),
        ];
    }
}
