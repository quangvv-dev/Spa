<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;

use App\Helpers\Functions;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerService
{
    public $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function create($input)
    {
        $data = $this->data($input);

        $customer = $this->customer->fill($data);
        $customer->save();

        return $customer;
    }

    public function data($input)
    {
        @$date = Functions::yearMonthDay($input['birthday']);
        $userLogin = Auth::user()->id;
        $input['birthday'] = isset($date) && $date ? $date : '';

        if ($input['mkt_id'] === null) {
            $input['mkt_id'] = $userLogin;
        }

        return $input;

    }
}