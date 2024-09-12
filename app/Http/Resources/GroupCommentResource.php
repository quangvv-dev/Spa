<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupCommentResource extends JsonResource
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
            'id'          => @$this->id,
            'customer_id' => @$this->customer_id,
            'user_name'   => @$this->user->full_name,
            'avatar'      => @$this->user->avatar,
            'messages'    => @$this->messages,
            'created_at'  => @$this->created_at,
            'images'      => $this->image,
        ];
    }
}
