<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'title'     => @$this->title,
            'data'      => @$this->data,
            'type'      => @$this->type,
            'status'    => @$this->status,
        ];
    }
}
