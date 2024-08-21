<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TherapyResource;
use App\Models\Branch;
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();
        $orders = Order::searchAll($input);
        $data['sumTotal'] = $orders->sum('all_total');
        $data['sumRevenue'] = $orders->sum('gross_revenue');
        $data['sumRest'] = $orders->sum('the_rest');
        $orders = $orders->select('id', 'member_id', 'all_total', 'gross_revenue',
            'the_rest')->paginate(StatusCode::PAGINATE_20);
        $data['lastPage'] = $orders->lastPage();
        $data['records'] = OrderResource::collection($orders);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    /**
     * Chi tiết đơn hàng
     *
     * @param Order $id
     *
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function commission(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();
        $docs = [];
        $data = User::select('id', 'full_name', 'avatar')->whereIn('role', [UserConstant::TECHNICIANS])
            ->when(isset($input['branch_id']), function ($query) use ($input) {
                $query->where('branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })->with('branch')->get();

        if (count($data)) {
            foreach ($data as $item) {
                $price = [];
                $input['support_id'] = $item->id;
                $input['user_id'] = $item->id;
                $input['type'] = 0;
                $order = Order::getAll($input);
                unset($input['support_id'], $input['user_id']);
                $history_orders = HistoryUpdateOrder::search($input)
                    ->where('user_id', $item->id)->orWhere('support_id', $item->id)->select('id', 'user_id',
                        'support_id', 'support2_id', 'tip_id', 'service_id')
                    ->orWhere('support2_id', $item->id)->with('service', 'tip');
                $history = $history_orders->get();
                $cong_chinh = 0;
                $cong_phu = 0;
                if (count($history)) {
                    foreach ($history as $item2) {
                        if (isset($item2->tip)) {
                            $price [] = (int)$item2->tip->price ?: 0;
                        }
                        if ($item->id == $item2->user_id) {
                            $cong_chinh += 1;
                        } elseif ($item->id == @$item2->support_id || $item->id == @$item2->support2_id) {
                            $cong_phu += 1;
                        }
                    }
                }
                $input['user_id'] = $item->id;
                $doc = [
                    'id'            => $item->id,
                    'avatar'        => $item->avatar,
                    'full_name'     => $item->full_name,
                    //                    'orders' => $order->count(),
                    //                    'all_total' => $order->sum('all_total'),
                    'gross_revenue' => $order->sum('gross_revenue'),
                    'days'          => (int) $cong_chinh + (int) $cong_phu,
                    'rose_money'    => Commission::search($input, 'earn')->sum('earn'),
                    'price'         => array_sum($price) ?? 0,
                ];
                $docs[] = $doc;
            }
        }

        $data = collect($docs)->sortBy('gross_revenue')->reverse()->toArray();

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', array_values($data));
    }

    public function tuvanvien(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();
        $docs = [];
        $data = User::select('id', 'full_name', 'avatar')->where('department_id', UserConstant::PHONG_TVV)
            ->where('active', StatusCode::ON)
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->get();
        if (count($data)) {

            foreach ($data as $item) {
                $input['support_id'] = $item->id;
                $input['user_id'] = $item->id;
                $input['type'] = 0;
                $order = Order::getAll($input);
                $doc = [
                    'id'            => $item->id,
                    'avatar'        => $item->avatar,
                    'full_name'     => $item->full_name,
                    'orders'        => $order->count(),
                    'gross_revenue' => $order->sum('gross_revenue'),
                    'rose_money'    => Commission::search($input)->sum('earn'),
                ];
                $docs[] = $doc;
            }
        }
        $data = collect($docs)->sortBy('gross_revenue')->reverse()->toArray();

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', array_values($data));
    }

    public function therapy(Request $request, Order $order)
    {
        $therapy = $order->historyUpdateOrders(isset($request->sort) ? $request->sort : 'all_total')->paginate(StatusCode::PAGINATE_10);
        $data = [
            'currentPage' => $therapy->currentPage(),
            'lastPage'    => $therapy->lastPage(),
            'sub'         => count($therapy),
            'the_rest'    => $order->count_day,
            'record'      => TherapyResource::collection($therapy),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }
}
