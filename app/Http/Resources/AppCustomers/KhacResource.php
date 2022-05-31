<?php

namespace App\Http\Resources\AppCustomers;

use App\Constants\StatusCode;
use Illuminate\Http\Resources\Json\JsonResource;

class KhacResource extends JsonResource
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

        if ($request->type_resource == 'branchs') {
            return [
                'id'          => $this->id,
                'name'        => $this->name,
                'address'     => $this->address,
                'location_id' => $this->location_id,
                'distance'    => $this->distance,
                'phone'       => $this->phone,
            ];
        }
    }
}
