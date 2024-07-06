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
        $images = @json_decode($this->images);
        $user = User::find($request->jwtUser->id);
        if (!in_array(@$user->department_id, [DepartmentConstant::ADMIN, DepartmentConstant::KE_TOAN])){
            $images = null;
        }
        return [
            'customer_id'   => @$this->customer->id,
            'customer_name' => @$this->customer->full_name,
            'phone'         => @$this->customer->phone,
            'title'         => @$this->title,
            'branch_id'     => @$this->branch_id,
            'service_text'  => @$this->service_text,
            'branch'        => @$this->branch->name,
            'images'        => $images
        ];
    }
}
