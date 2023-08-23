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
                'name'           => @$this->service_text,
                'all_total'      => @$this->all_total,
                'gross_revenue'  => (int)$this->gross_revenue,
                'the_rest'       => (int)$this->the_rest,
                'role_type'      => @$this->role_type,
                'rate'           => @$this->rate,
                'comment_rate'   => @$this->comment_rate,
                'quantity'       => isset($this->orderDetails) ? count($this->orderDetails) : 1,
                'created_at'     => date('d-m-Y H:i', strtotime($this->created_at)),
                'branch_address' => isset($this->branch) ? $this->branch->address : 'Tất cả chi nhánh',
            ];
        } else {
            return [
                'id'            => @$this->id,
                'name'          => @$this->customer->full_name,
                'phone'         => @$this->customer->phone,
                'service_text'  => @str_replace('<br>', ' ,', $this->service_text),
                'total'         => @$this->all_total,
                'gross_revenue' => !empty($this->gross_revenue) ? $this->gross_revenue : 0,
                'is_therapy'    => $this->count_day > 0,
                'created_at'    => date('d-m-Y H:i', strtotime($this->created_at)),
                'the_rest'      => !empty($this->the_rest) ? $this->the_rest : 0,
            ];
        }
    }
}
