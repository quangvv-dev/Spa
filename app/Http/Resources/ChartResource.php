<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChartResource extends JsonResource
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
        if ($request->type_api == 2) {
            $result = [
                'name'      => @$this->name,
                'all_total' => @$this->all_total,
            ];
        }elseif ($request->type_api == 3){
            $result = [
                'name'      => @$this->service->name,
                'all_total' => @$this->total,
            ];
        }elseif ($request->type_api == 7){
            $result = [
                'name'      => @$this->source_customer->name,
                'total'     => @$this->total,
            ];
        }

        return $result;
    }
}
