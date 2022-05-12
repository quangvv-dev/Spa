<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AppCustomers\CustomerResource;
use App\Http\Resources\AppCustomers\ServiceResource;
use App\Models\Album;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Landipage;
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
        $input = $request->all();
        $paginate = isset($request->records) && $request->records ? $request->records : StatusCode::PAGINATE_10;
        $request->merge(['type' => StatusCode::SERVICE]);
        $docs = Services::where('type', StatusCode::SERVICE)->where('enable', StatusCode::ON)
            ->when(isset($input['category_id']) && $input['category_id'], function ($q) use ($input) {
                $q->where('category_id', $input['category_id']);
            })->paginate($paginate);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', ServiceResource::collection($docs));
    }

    /**
     * Danh sách sản phẩm
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request)
    {
        $input = $request->all();
        $paginate = isset($request->records) && $request->records ? $request->records : StatusCode::PAGINATE_10;
        $docs = Services::where('type', StatusCode::PRODUCT)->where('enable', StatusCode::ON)
            ->when(isset($input['category_id']) && $input['category_id'], function ($q) use ($input) {
                $q->where('category_id', $input['category_id']);
            })->paginate($paginate);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', ServiceResource::collection($docs));
    }


    /**
     * Get NEWS
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function news(Request $request)
    {
        $paginate = isset($request->records) && $request->records ? $request->records : StatusCode::PAGINATE_10;
        $docs = Landipage::where('active', StatusCode::ON)->orderByDesc('position', 'created_at')->paginate($paginate);
        $docs = $docs->transform(function ($i) {
            $short = new \Html2Text\Html2Text($i->content);
            return [
                'id' => $i->id,
                'title' => $i->title,
                'short_description' => str_limit($short->getText(), 35),
                'content' => $i->content,
                'thumbnail' => $i->thumbnail,
                'created_at' => \date('d/m/Y', strtotime($i->created_at)),
            ];
        });
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $docs);
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

    /**
     * Ảnh liệu trình của bản thân
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function album(Request $request)
    {
        $customer = $request->jwtUser;
        $album = Album::where('customer_id', $customer->id)->get()->transform(function ($i) {
            return [
                'images' => @json_decode($i->images),
            ];
        });
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $album);

    }

    public function category(Request $request)
    {
        $validate = [
            'type' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $category = Category::select('id', 'name', 'image')->where('type', $request->type)->paginate(StatusCode::PAGINATE_10);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $category);

    }

}
