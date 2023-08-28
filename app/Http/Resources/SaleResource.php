<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'id'           => $this->id,
            'full_name'    => $this->full_name,
            'avatar'       => $this->avatar,
            'phoneNew'     => $this->phoneNew,
            'orderNew'     => $this->orderNew,
            'schedulesNew' => $this->schedulesNew,
            'schedules'    => $this->schedules,
            'call'         => $this->call,
            'percentOrder' => $this->percentOrder,
            'totalNew'     => $this->totalNew,
            'avg'          => $this->avg,
        ];
    }
}
