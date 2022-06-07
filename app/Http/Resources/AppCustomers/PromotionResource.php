<?php

namespace App\Http\Resources\AppCustomers;

use App\Constants\PromotionConstant;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
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

        if ($this->type == PromotionConstant::MONEY) {
            return [
                'id'               => @$this->id,
                'title'            => @$this->title,
                'promotion'        => @$this->money_promotion,
                'type'             => @$this->type,
                'min_price'        => @$this->min_price,
                'current_quantity' => @$this->current_quantity,
                'service_name'     => !empty($this->service_id) ? @$this->service->name : "Tất cả dịch vụ",
            ];
        } else {
            return [
                'id'               => @$this->id,
                'title'            => @$this->title,
                'promotion'        => @$this->percent_promotion,
                'type'             => @$this->type,
                'min_price'        => @$this->min_price,
                'max_discount'     => @$this->max_discount,
                'current_quantity' => @$this->current_quantity,
                'service_name'     => !empty($this->service_id) ? @$this->service->name : "Tất cả dịch vụ",
            ];
        }
    }
}
