<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ContactRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id'     => 'required',
            'code'            => 'required',
            'full_name'       => 'required',
            'phone'           => 'required',
            'service'         => 'string',
            'address'         => 'string',
            'cccd'            => 'integer',
            'warranty_number' => 'required|integer',
            'date'            => 'required',
            'before'          => 'required',
            'after'           => 'required',
            'price'           => 'required',
            'result'          => 'string',
            'warranty_time'   => 'string',
        ];
    }
}
