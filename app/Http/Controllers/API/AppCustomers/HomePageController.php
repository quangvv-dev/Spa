<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\AppCustomers\CustomerResource;
use App\Http\Resources\AppCustomers\KhacResource;
use App\Http\Resources\AppCustomers\ServiceResource;
use App\Models\Album;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\HistoryUpdateOrder;
use App\Models\Landipage;
use App\Models\Order;
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServices(Request $request)
    {
        $input = $request->all();
        $paginate = isset($request->records) && $request->records ? $request->records : 2;
        $request->merge(['type' => StatusCode::SERVICE]);
        $docs = Services::where('type', StatusCode::SERVICE)->where('enable', StatusCode::ON)
            ->when(isset($input['category_id']) && $input['category_id'], function ($q) use ($input) {
                $q->where('category_id', $input['category_id']);
            })->when(isset($input['name']) && $input['name'], function ($q) use ($input) {
                $q->where('name', 'like', '%' . $input['name'] . '%');
            })->whereNotNull('images')->orderByDesc('id')->paginate($paginate);
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
        $paginate = isset($request->records) && $request->records ? $request->records : 4;
        $docs = Services::where('type', StatusCode::PRODUCT)->where('enable', StatusCode::ON)
            ->when(isset($input['category_id']) && $input['category_id'], function ($q) use ($input) {
                $q->where('category_id', $input['category_id']);
            })->orderByDesc('images')->orderByDesc('id')->paginate($paginate);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', ServiceResource::collection($docs));
    }


    /**
     * Get NEWS
     *
     * @param Request $request
     *
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBranchWithDistance(Request $request)
    {
//        $validate = [
//            'lat'  => "required",
//            'long' => "required",
//            //            'location_id' => "required",
//        ];
//        $this->validator($request, $validate);
//        if (!empty($this->error)) {
//            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
//        }
        $input = $request->all();
        $branch = Branch::select('id', 'name', 'address', 'location_id', 'lat', 'long', 'phone')
            ->when(isset($input['location_id']) && $input['location_id'], function ($q) use ($input) {
                $q->where('location_id', $input['location_id']);
            })->whereNotNull('lat')->get()->map(function ($item) use ($input) {
                $item->distance = "";
                if (isset($input['lat']) & isset($input['long'])) {
                    if ($item->lat && $item->long) {
                        $adctual = distance($input['lat'], $input['long'], $item->lat, $item->long, "K");
                        $item->distance = round($adctual, 1, PHP_ROUND_HALF_UP);
                    }
                }
                unset($item->lat, $item->long);
                return $item;
            })->sortBy("distance");
        $request->merge(['type_resource' => 'branchs']);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', KhacResource::collection($branch));
    }

    /**
     * Ảnh liệu trình của bản thân
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function album(Request $request)
    {
        $customer = $request->jwtUser;
        $album = Album::where('customer_id', $customer->id)->first();
        $data = new AlbumResource($album);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    /**
     * Danh mục sản phẩm || dịch vụ
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function category(Request $request)
    {
        $validate = [
            'type' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $category = Category::select('id', 'name', 'image')->where('type',
            $request->type)->orderByDesc('image')->get();

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $category);

    }

    /**
     * Lịch sử trừ liệu trình
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function process(Request $request)
    {
        $customer = $request->jwtUser;
        $order = Order::select('id')->where('member_id', $customer->id)->pluck('id')->toArray();
        $process = [];
        if (count($order)) {
            $process = HistoryUpdateOrder::whereIn('order_id', $order)->where('type',
                0)->orderByDesc('created_at')->get()
                ->transform(function ($i) {
                    $support = isset($i->support) ? $i->support->full_name : '';
                    $support2 = isset($i->support2) ? '| ' . $i->support2->full_name : '';

                    return [
                        'id' => $i->id,
                        'support' => $support . $support2,
                        'employee' => isset($i->user) ? $i->user->full_name : '',
                        'date' => @\date('d-m-Y', strtotime($i->created_at)),
                        'time' => @\date('H:i', strtotime($i->created_at)),
                        'branch_name' => isset($i->branch) ? $i->branch->address : '',
                        'phone' => isset($i->branch) ? $i->branch->phone : '',
                        'service' => isset($i->service) ? $i->service->name : '',
                        'image' => isset($i->service) && !empty($i->service->images) ? $i->service->images : '',
                        'rate' =>@$i->rate,
                        'comment_rate' =>@$i->comment_rate,
                    ];
                });
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $process);
    }
}
