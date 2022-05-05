<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AppCustomers\CustomerResource;
use App\Http\Resources\AppCustomers\ServiceResource;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomePageController extends BaseApiController
{

    public function __construct()
    {
        //coding
    }

    /**
     * Danh sách dịch vụ
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServices(Request $request)
    {
        $request->merge(['type' => StatusCode::SERVICE]);
        $docs = Services::where('type', StatusCode::SERVICE)->where('enable', StatusCode::ON)->paginate(StatusCode::PAGINATE_10);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', ServiceResource::collection($docs));
    }

    /**
     * Danh sách sản phẩm
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts()
    {
        $docs = Services::where('type', StatusCode::PRODUCT)->where('enable', StatusCode::ON)->paginate(StatusCode::PAGINATE_10);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', ServiceResource::collection($docs));
    }
}
