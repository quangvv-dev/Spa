<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;

use App\Components\Filesystem\Filesystem;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Customer;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class CustomerService
{
    public $customer;
    private $fileUpload;

    public function __construct(Filesystem $fileUpload, Customer $customer)
    {
        $this->customer = $customer;
        $this->fileUpload = $fileUpload;
    }

    public function find($id)
    {
        $customer = $this->customer->where('id', $id)->first();

        return $customer;
    }

    public function findWith($id)
    {
        $customer = $this->customer->where('id', $id)->with('category')->first();

        return $customer;
    }

    public function createApi($input)
    {
        if ($input['mkt_id'] === null) {
            $userLogin = Auth::user()->id;
            $input['mkt_id'] = $userLogin;
        }
        if (empty($input['telesales_id'])) {
            $input['telesales_id'] = 0;
        }
        if (empty($input['carepage_id'])) {
            $input['carepage_id'] = 0;
        } else {
            $input['carepage_id'] = Auth::user()->id;
        }
        $customer = Customer::create($input);
        return $customer;
    }

    public function create($input)
    {
        if ($input['mkt_id'] === null) {
            $userLogin = Auth::user()->id;
            $input['mkt_id'] = $userLogin;
        }
        if (empty($input['carepage_id'])) {
            $input['carepage_id'] = 0;
        } else {
            $input['carepage_id'] = Auth::user()->id;
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
        if (!empty($input['image'])) {
            $input['avatar'] = $this->fileUpload->uploadUserImage($input['image']);
        }

        return $input;

    }

    public function update($input, $id)
    {
        $data = $this->data($input);
        $customer = $this->find($id);
        $customer->update($data);
        return $customer;

    }

    public function updateStatus($data)
    {
        $id = [];

        foreach ($data as $item) {
            if ($item->orders->sum('all_total') >= Customer::VIP_STATUS) {
                $id[] = $item->id;
            }
        }

        $vip = Status::where('type', StatusCode::RELATIONSHIP)->where('code', 'vip')->first();

        $customers = $this->customer->whereIn('id', $id)->update(['status_id' => $vip->id]);

        return $customers;
    }

    public function update_code($customer)
    {
        $customer_id = $customer->id < 10 ? '0' . $customer->id : $customer->id;
        $code = 'KH' . $customer_id;
        $customer->update(['account_code' => $code]);
        return $customer;
    }
}
