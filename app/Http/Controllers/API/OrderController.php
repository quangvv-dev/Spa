<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Models\Category;
use App\Models\Commission;
use App\Models\HistoryUpdateOrder;
use App\Models\Order;

use App\Models\OrderDetail;
use App\User;
use Illuminate\Http\Request;

class OrderController extends BaseApiController
{
    /**
     * Danh sách đơn hàng
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $orders = Order::searchAll($input)->paginate(StatusCode::PAGINATE_20);
        $data['lastPage'] = $orders->lastPage();
        $data['records'] = OrderResource::collection($orders);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    /**
     * Chi tiết đơn hàng
     *
     * @param Order $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $id)
    {
        $order = $id;
        $data['name_customer'] = @$order->customer->full_name;
        $data['phone'] = @$order->customer->phone;
        $order_detail = OrderDetail::where('order_id', $order->id)->get();
        $data['records'] = OrderDetailResource::collection($order_detail);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    /**
     * Kỹ thuật viên
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function commission(Request $request)
    {
        $category_price = Category::pluck('price', 'id')->toArray();
        $input = $request->all();
        $docs = [];
        $data = User::select('id', 'full_name', 'avatar')->whereIn('role', [UserConstant::TECHNICIANS])->get();
        if (count($data)) {

            foreach ($data as $item) {
                $price = [];
                $input['support_id'] = $item->id;
                $input['user_id'] = $item->id;
                $input['type'] = 0;
                $order = Order::getAll($input);
                $history_orders = HistoryUpdateOrder::search($input)->with('service');
                $history = $history_orders->get();

                if (count($history)) {
                    foreach ($history as $item2) {
                        $category_id = $item2->service->category_id ?: 0;
                        if (!empty($category_price[$category_id])) {
                            $price[] = (int)$category_price[$category_id];
                        }
                    }
                }

                $doc = [
                    'id' => $item->id,
                    'avatar' => $item->avatar,
                    'full_name' => $item->full_name,
//                    'orders' => $order->count(),
//                    'all_total' => $order->sum('all_total'),
                    'gross_revenue' => $order->sum('gross_revenue'),
                    'days' => $history_orders->count(),
                    'rose_money' => Commission::search($input)->sum('earn'),
                    'price' => array_sum($price) ? array_sum($price) : 0,
                ];
                $docs[] = $doc;
            }
        }
        $data = collect($docs)->sortBy('gross_revenue')->reverse()->toArray();

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', array_values($data));
    }

    public function tuvanvien(Request $request)
    {
        $input = $request->all();
        $docs = [];
        $data = User::select('id', 'full_name', 'avatar')->where('department_id', UserConstant::PHONG_TVV)->get();
        if (count($data)) {

            foreach ($data as $item) {
                $input['support_id'] = $item->id;
                $input['user_id'] = $item->id;
                $input['type'] = 0;
                $order = Order::getAll($input);
                $doc = [
                    'id' => $item->id,
                    'avatar' => $item->avatar,
                    'full_name' => $item->full_name,
                    'orders' => $order->count(),
                    'gross_revenue' => $order->sum('gross_revenue'),
                    'rose_money' => Commission::search($input)->sum('earn'),
                ];
                $docs[] = $doc;
            }
        }
        $data = collect($docs)->sortBy('gross_revenue')->reverse()->toArray();

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', array_values($data));
    }
}
