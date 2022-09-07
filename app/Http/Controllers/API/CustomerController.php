<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Http\Resources\AppCustomers\CustomerResource;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
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
        if (isset($input['search']) && $input['search'] && is_numeric($input['search'])) {
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
            'phone'         => "required",
            'full_name'     => "required",
            'gender'        => "required",
            'telesales_id'  => "required",
            'status_id'     => "required",
            'source_id'     => "required",
            'group_id'      => "required",
            'branch_id'     => "required",
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
        $input['mkt_id']        = empty($input['mkt_id']) ? $customer->id : $input['mkt_id'];
        $input['telesales_id']  = empty($input['telesales_id']) ? $customer->id : $input['mkt_id'];
        $input['wallet']        = 0;
        $input['wallet_ctv']    = 0;
        $input['post_id']       = 0;
        $input['status_id']     = empty($input['status_id']) ? Functions::getStatusWithCode('moi') : $input['status_id'];
        $customer = $this->customerService->createApi($input);
        $category = Category::whereIn('id', $request->group_id)->get();
        AuthController::createCustomerGroup($category, $customer->id, $input['branch_id']);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', new CustomerResource($customer));
    }

    /**
     * cập nhật thu chi
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id)
    {
        $request->merge([
            'full_name' => str_replace("'", "", $request->full_name),
            'type'      => 'full_data',
        ]);
        $input = $request->except('group_id');
        $customer = $this->customerService->update($input, $id);
        CustomerGroup::where('customer_id', $customer->id)->delete();
        $category = Category::whereIn('id', $request->group_id)->get();
        AuthController::createCustomerGroup($category, $customer->id, $input['branch_id']);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', new CustomerResource($customer));
    }

    public function statusCustomer()
    {
        $status = Status::where('type', StatusCode::RELATIONSHIP)->select('id','name')->get();//mối quan hệ
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $status);
    }

    public function sourceCustomer()
    {
        $status = Status::where('type', StatusCode::SOURCE_CUSTOMER)->select('id','name')->get();//mối quan hệ
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $status);
    }

    public function groupCustomer()
    {
        $group = Category::select('id','name')->where('type',StatusCode::SERVICE)->get();//nhóm KH
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $group);
    }

}
