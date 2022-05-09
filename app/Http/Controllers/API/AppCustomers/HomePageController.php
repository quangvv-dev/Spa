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
        $paginate = isset($request->records) && $request->records ? $request->records : StatusCode::PAGINATE_10;
        $request->merge(['type' => StatusCode::SERVICE]);
        $docs = Services::where('type', StatusCode::SERVICE)->where('enable', StatusCode::ON)->paginate($paginate);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', ServiceResource::collection($docs));
    }

    /**
     * Danh sách sản phẩm
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request)
    {
        $paginate = isset($request->records) && $request->records ? $request->records : StatusCode::PAGINATE_10;
        $docs = Services::where('type', StatusCode::PRODUCT)->where('enable', StatusCode::ON)->paginate($paginate);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', ServiceResource::collection($docs));
    }

    /**
     * khoảng cách chi nhánh
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBranchWithDistance(Request $request)
    {
        $validate = [
            'lat' => "required",
            'long' => "required",
            'location_id' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $input = $request->all();
        $branch = Branch::select('id', 'name', 'address', 'location_id', 'lat', 'long')->where('location_id', $input['location_id'])->get()->map(function ($item) use ($input) {
            $item->distance = "";
            if ($item->lat && $item->long) {
                $adctual = distance($input['lat'], $input['long'], $item->lat, $item->long, "K");
                $item->distance = round($adctual, 1, PHP_ROUND_HALF_UP);
            }
            unset($item->lat, $item->long);
            return $item;
        })->sortBy("distance");
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $branch);
    }

}
