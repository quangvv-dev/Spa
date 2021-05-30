<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
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
            'id'         => @$this->id,
            'full_name'  => @$this->full_name,
            'all_task'   => @$this->all_task,
            'all_done'   => @$this->all_done,
            'all_failed' => @$this->all_failed,
        ];
    }
}
