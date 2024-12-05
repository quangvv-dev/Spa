<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'full_name' => $this->full_name,
            'phone' => $this->phone ? $this->phone : '',
            'email' => $this->email,
            'role' => $this->role_id,
            'role_name' => @$this->roles->name,
            'gender' => $this->gender ?: 1,
            'avatar' => $this->avatar ?: '',
            'department_id' => $this->department_id,
            'department_name' => @$this->departments->name
        ];
    }
}
