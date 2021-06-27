<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Resources\SaleResource;
use App\Models\CallCenter;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Schedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class SaleController extends BaseApiController
{
    /**
     * Login APP
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sale(Request $request)
    {
        $input = $request->all();
        $users = User::select('id', 'full_name','avatar')->whereIn('role', [UserConstant::TP_SALE, UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request, $input) {

            $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
            $order_new = Order::whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])->with('orderDetails');
            $data_old = Customer::select('id')->where('telesales_id', $item->id)->where('old_customer', 1);
            $order_old = Order::whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');


            $input['telesales'] = $item->id;
            $detail = PaymentHistory::search($input,'price');
            $detail_total = clone $detail;
            $detail2 = clone $detail;
            $total_old = $detail_total->whereIn('order_id',$order_old->pluck('id')->toArray())->sum('price');
            $total_new = $detail2->whereIn('order_id',$order_new->pluck('id')->toArray())->sum('price');


            $item->phoneNew = $data_new->get()->count();
            $item->orderNew = $order_new->count();
            $input['creator_id'] = $item->id;
            $item->schedules = Schedule::getBooks($input,'id');
            $input['caller_number'] = $item->caller_number;
            $input['call_status'] = 'ANSWERED';

            $item->call = !empty($input['caller_number']) ? CallCenter::search($input,'id')->count() : 0;
            $item->thu_no = $detail->sum('price') - $total_new - $total_old;

            $item->totalNew =$total_new;
            $item->totalOld = $total_old;

            $item->totalAll = $detail->sum('price');//da thu trong ky
            return $item;
        })->sortByDesc('totalAll');

        $users = SaleResource::collection($users);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $users);
    }

    /**
     * Sale version toi uu
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleToiUu(Request $request)
    {
        $input = $request->all();
        $users = User::select('id', 'full_name', 'avatar')->whereIn('role', [UserConstant::TP_SALE, UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request, $input) {

            $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
            $orders = Order::select('id')->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])
                ->whereHas('customer', function ($qr) use ($item) {
                    $qr->where('telesales_id', $item->id);
                });
            $orders2 = clone $orders;
            $order_new = $orders->whereHas('customer', function ($qr) use ($item) {
                $qr->where('old_customer', 0);
            });
            $order_old = $orders2->whereHas('customer', function ($qr) use ($item) {
                $qr->where('old_customer', 1);
            });


            $input['telesales'] = $item->id;
            $detail = PaymentHistory::search($input,'price');
            $detail_total = clone $detail;
            $detail2 = clone $detail;
            $total_old = $detail_total->whereIn('order_id', $order_old->pluck('id')->toArray())->sum('price');
            $total_new = $detail2->whereIn('order_id', $order_new->pluck('id')->toArray())->sum('price');


            $item->phoneNew = $data_new->get()->count();
            $item->orderNew = $order_new->count();
            $input['creator_id'] = $item->id;
            $item->schedules = Schedule::getBooks($input,'id');
            $input['caller_number'] = $item->caller_number;
            $input['call_status'] = 'ANSWERED';

            $item->call = !empty($input['caller_number']) ? CallCenter::search($input)->count() : 0;
            $item->thu_no = $detail->sum('price') - $total_new - $total_old;

            $item->totalNew = $total_new;
            $item->totalOld = $total_old;

            $item->totalAll = $detail->sum('price');//da thu trong ky
            return $item;
        })->sortByDesc('totalAll');
        $users = SaleResource::collection($users);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $users);
    }
}
