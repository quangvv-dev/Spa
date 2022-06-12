<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
        if ($request->type == 'app-customer') {
            return [
                'id'             => @$this->id,
                'service_text'   => @$this->service_text,
                'all_total'      => @$this->all_total,
                'gross_revenue'  => (int)$this->gross_revenue,
                'the_rest'       => (int)$this->the_rest,
                'role_type'      => @$this->role_type,
                'quantity'       => isset($this->orderDetails) ? count($this->orderDetails) : 1,
                'created_at'     => date('d-m-Y H:i', strtotime($this->created_at)),
                'branch_address' => isset($this->branch) ? $this->branch->address : 'Tất cả chi nhánh',
            ];
        } else {
            return [
                'id'            => @$this->id,
                'name'          => @$this->customer->full_name,
                'phone'         => @$this->customer->phone,
                'total'         => @$this->all_total,
                'gross_revenue' => !empty($this->gross_revenue) ? $this->gross_revenue : 0,
                'the_rest'      => !empty($this->the_rest) ? $this->the_rest : 0,
            ];
        }
    }
}
