<?php

namespace App\Http\Resources;

use App\Models\PaymentHistory;
use Illuminate\Http\Resources\Json\JsonResource;

class AppleResource extends JsonResource
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

        if ($request->api_type == 2) {
            $payment = PaymentHistory::where('order_id', @$this->id)->first();
            $result = [
                'id'        => @$this->id,
                'services'  => @$this->service_text,
                'all_total' => @$this->all_total,
                'images'    => @$this->orderDetails[0]->services->images[0],
                'status'    => isset($payment) && $payment ? 1 : 0,
            ];
        } else {
            $result = [
                'id'          => @$this->id,
                'name'        => @$this->name,
                'description' => @$this->description,
                'images'      => !empty(@$this->images[0]) ? '/uploads/services/' . @$this->images[0] : '',
                'price'       => @$this->price_sell,
                'category'    => @$this->category->name,
            ];
        }
        return $result;
    }
}
