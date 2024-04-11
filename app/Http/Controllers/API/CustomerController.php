<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Http\Resources\AppCustomers\CustomerResource;
use App\Http\Resources\ChartResource;
use App\Http\Resources\OrderResource;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\PaymentWallet;
use App\Models\Status;
use App\Services\CustomerService;
use App\Http\Controllers\API\AppCustomers\AuthController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CustomerController extends BaseApiController
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Danh sách album
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->merge(['type' => 'full_data']);
        $input = $request->all();
        if (!empty($input['search'])) {
            $input['page'] = 1;
        }
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        if (!empty($input['search'])) {
            unset($input['branch_id']);
        }
        $customers = Customer::searchApi($input);

        $customers = $customers->take(StatusCode::PAGINATE_1000)->orderByDesc('id')->get();
        if (isset($input['limit'])) {
            $customers = Functions::customPaginate($customers, $input['page'], $input['limit']);
        } else {
            $customers = Functions::customPaginate($customers, $input['page']);
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', CustomerResource::collection($customers));
    }

    /**
     * list người tạo và người duyệt
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validate = [
            'phone'        => "required",
            'full_name'    => "required",
            'gender'       => "required",
            'telesales_id' => "required",
            'status_id'    => "required",
            'source_id'    => "required",
            'group_id'     => "required",
            'branch_id'    => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $customer = $request->jwtUser;
        $request->merge([
            'fb_name'   => $request->full_name,
            'full_name' => str_replace("'", "", $request->full_name),
            'type'      => 'full_data',
        ]);

        $input = $request->except(['group_id']);
        $input['mkt_id'] = empty($input['mkt_id']) ? $customer->id : $input['mkt_id'];
        $input['wallet'] = 0;
        $input['wallet_ctv'] = 0;
        $input['post_id'] = 0;
        $input['carepage_id'] = $customer->id;
        $input['status_id'] = empty($input['status_id']) ? Functions::getStatusWithCode('moi') : $input['status_id'];
        $customer = Customer::create($input);
        $category = Category::whereIn('id', $request->group_id)->get();
        AuthController::createCustomerGroup($category, $customer->id, $input['branch_id']);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', new CustomerResource($customer));
    }

    /**
     * cập nhật thu chi
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'full_name' => str_replace("'", "", $request->full_name),
            'type'      => 'full_data',
        ]);
        $input = $request->except('group_id');
        if (isset($input['phone']) && str_contains($input['phone'], 'xxx')) {
            unset($input['phone']);
        }
        $customer = $this->customerService->update($input, $id);
        CustomerGroup::where('customer_id', $customer->id)->delete();
        $category = Category::whereIn('id', $request->group_id)->get();
        AuthController::createCustomerGroup($category, $customer->id, $input['branch_id']);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', new CustomerResource($customer));
    }

    public function statusCustomer()
    {
        $status = Status::where('type', StatusCode::RELATIONSHIP)->select('id', 'name')->get();//mối quan hệ
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $status);
    }

    public function sourceCustomer()
    {
        $status = Status::where('type', StatusCode::SOURCE_CUSTOMER)->select('id', 'name')->get();//mối quan hệ
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $status);
    }

    public function groupCustomer()
    {
        $group = Category::select('id', 'name')->where('type', StatusCode::SERVICE)->get();//nhóm KH
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $group);
    }

    /**
     * Thống kê nhân viên
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function revenueSourceCustomer(Request $request)
    {

        $input = $request->all();
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        $request->merge(['type_api' => '7.1']);
        if (isset($input['type']) && $input['type'] == 1) {
            $customers = Customer::orderByDesc('id');
            $data = Customer::applySearchConditions($customers, $input)->select('id', 'source_id',
                \DB::raw('COUNT(ID) AS total'))->groupBy('source_id')->whereHas('source_customer')->get()
                ->sortByDesc('total');
        } else {
            if (isset($input['type']) && $input['type'] == 2) {
                $data = Status::where('type', StatusCode::SOURCE_CUSTOMER)->select('id', 'name')->get()->map(function (
                    $item
                ) use ($input) {
                    $payment_wallet = PaymentWallet::search($input, 'price')->whereHas('order_wallet',
                        function ($it) use ($item) {
                            $it->where('source_id', $item->id);
                        })->sum('price');
                    $payment_All = PaymentHistory::search($input, 'price')->whereHas('order',
                        function ($it) use ($item) {
                            $it->where('source_id', $item->id);
                        });
                    $price = $payment_All->sum('price');
                    $score = $payment_All->where('payment_type', 3)->sum('price');

                    $item->total = $price + $payment_wallet - $score;
                    return $item;
                })->filter(function ($fl) {
                    if ($fl->total > 0) {
                        return $fl;
                    }
                })->sortByDesc('total');
            } else {
                $data = Status::where('type', StatusCode::SOURCE_CUSTOMER)->select('id', 'name')->get()->map(function (
                    $item
                ) use ($input) {
                    $orders = Order::returnRawData($input)->select('id')->whereHas('customer',
                        function ($it) use ($item) {
                            $it->where('source_id', $item->id);
                        })->count();
                    $item->total = $orders;
                    return $item;
                })->filter(function ($fl) {
                    if ($fl->total > 0) {
                        return $fl;
                    }
                })->sortByDesc('total');
            }
        }
        $response = ChartResource::collection($data);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $response);
    }

    public function orders(Request $request, Customer $customer)
    {
        $orders = $customer->orders(isset($request->sort) ? $request->sort : 'created_at')->paginate(StatusCode::PAGINATE_10);
        $data = [
            'currentPage' => $orders->currentPage(),
            'lastPage'    => $orders->lastPage(),
            'record'      => OrderResource::collection($orders),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

}
