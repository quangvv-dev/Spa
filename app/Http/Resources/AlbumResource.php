<?php

namespace App\Http\Resources;

use App\Constants\DepartmentConstant;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
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
        $user = User::find($request->jwtUser->id);

        return [
            'customer_id'   => @$this->customer->id,
            'customer_name' => @$this->customer->full_name,
            'phone'         => @$this->customer->phone,
            'title'         => @$this->title,
            'branch_id'     => @$this->branch_id,
            'service_text'  => @$this->service_text,
            'branch'        => @$this->branch->name,
            'images'        => in_array($user->department_id, [DepartmentConstant::ADMIN, DepartmentConstant::KE_TOAN]) ? @json_decode($this->images) : [],
        ];
    }
}
