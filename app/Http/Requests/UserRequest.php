<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = (is_numeric(Request::segment(2))) ? Request::segment(2) : '';
        return [
            'full_name' => 'required',
            'phone' => 'required|unique:users,phone,'. $id,
            'confirm_password' => 'same:password',
        ];
    }
}
