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
use Illuminate\Support\Facades\DB;

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
        $input['mkt_id'] = 0;
        $input['carepage_id'] = 0;
        $input['telesales_id'] = 0;
        $customer = Customer::create($input);

        return $customer;
    }

    public function create($input)
    {

        if ($input['mkt_id'] === null) {
            $userLogin = Auth::user()->id;
            $input['mkt_id'] = $userLogin;
        }
        if (isset($input['genitive_id']) && count($input['genitive_id'])) {
            $input['genitive_id'] = json_encode($input['genitive_id']);
        }
        $customer = $this->customer->where('phone', $input['phone'])->first();
        $input['is_duplicate'] = !empty($customer) ? Customer::DUPLICATE : Customer::NON_DUPLICATE;
        $input['carepage_id'] = Auth::user()->id;
        $data = $this->data($input);
        $customer = $this->customer->fill($data);
        $customer->save();

        return $customer;
    }

    public function data($input)
    {
        if (empty($input['birthday'])) {
            unset($input['birthday']);
        } else {
            $input['birthday'] = @Functions::yearMonthDay($input['birthday']);
        }
        if (!empty($input['category_tips'])) {
            $input['category_tips'] = json_encode($input['category_tips']);
        }
        if (!empty($input['image'])) {
            $input['avatar'] = $this->fileUpload->uploadUserImage($input['image']);
        }

        return $input;

    }

    public function update($input, $id)
    {
        if (isset($input['genitive_id']) && count($input['genitive_id'])) {
            $input['genitive_id'] = json_encode($input['genitive_id']);
        }
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

    public function countWithStatus($input)
    {
        return Customer::when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('customers.created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
        })->when(isset($input['branch_id']), function ($query) use ($input) {
            $query->where('customers.branch_id', $input['branch_id']);
        })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('customers.branch_id', $input['group_branch']);
        })->join('status as s', 's.id', 'customers.status_id')->select(
            DB::raw('COUNT(customers.id) AS total'), 's.name as name')
            ->groupBy('customers.status_id')->orderByDesc('total')->get();
    }
}
