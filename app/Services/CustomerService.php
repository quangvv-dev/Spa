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

    public function find($id)
    {
        $customer = $this->customer->where('id', $id)->first();

        return $customer;
    }

    public function create($input)
    {
        $userLogin = Auth::user()->id;

        if ($input['mkt_id'] === null) {
            $input['mkt_id'] = $userLogin;
        }
        $data = $this->data($input);

        $customer = $this->customer->fill($data);
        $customer->save();

        return $customer;
    }

    public function data($input)
    {
        @$date = Functions::yearMonthDay($input['birthday']);
        $input['birthday'] = isset($date) && $date ? $date : '';

        return $input;

    }

    public function update($input, $id)
    {
        $data = $this->data($input);

        $customer = $this->find($id);

        $customer->update([$data]);

        return $customer;

    }
}
