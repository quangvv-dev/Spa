<?php

namespace App\Http\Resources;

use App\Models\HistoryUpdateOrder;
use Illuminate\Http\Resources\Json\JsonResource;

class TherapyResource extends JsonResource
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
            'id'=> $this->id,
            'primary'=> $this->user->full_name,
            'support'=> $this->support->full_name.' | '.$this->support2->full_name,
            'service_name'=> $this->service->name,
            'type'=> @HistoryUpdateOrder::TYPE[$this->type],
            'created_at'=> date('d-m-Y H:i', strtotime($this->created_at)),
        ];
    }
}
