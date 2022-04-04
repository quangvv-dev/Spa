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
        } elseif ($request->type_api == 3) {
            $result = [
                'name'      => @$this->name,
                'all_total' => @$this->all_total,
            ];
        } elseif ($request->type_api == 7) {
            $result = [
                'name'  => @$this->status->name,
                'total' => @$this->total,
            ];
        } elseif ($request->type_api == 'all_branch') {
            $result = [
                'branch_id'    => @$this->branch_id,
                'total'   => @$this->total,
                'revenue' => @$this->revenue,
                'payment' => @$this->payment,
                'name'    => @$this->name,
            ];
        }

        return $result;
    }
}
