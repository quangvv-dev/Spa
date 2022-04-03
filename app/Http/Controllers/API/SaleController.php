<?php

namespace App\Http\Controllers\API;

use App\Constants\OrderConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Resources\SaleResource;
use App\Models\Branch;
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
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();

        $users = User::select('id', 'full_name', 'avatar', 'caller_number')->whereIn('role', [UserConstant::TP_SALE, UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request, $input) {
            $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])
                ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                });
            $orders = Order::select('id','member_id', 'all_total', 'gross_revenue')->whereIn('role_type', [StatusCode::COMBOS, StatusCode::SERVICE])
                ->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])
                ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                })->with('orderDetails')->whereHas('customer', function ($qr) use ($item) {
                    $qr->where('telesales_id', $item->id);
                });
            $orders2 = clone $orders;
            $order_new = $orders->where('is_upsale', OrderConstant::NON_UPSALE);
            $order_old = $orders2->where('is_upsale', OrderConstant::IS_UPSALE);

            $input['telesales'] = $item->id;
            $detail = PaymentHistory::search($input, 'price');
            $detail_total = clone $detail;
            $detail2 = clone $detail;
            $total_old = $detail_total->whereIn('order_id', $order_old->pluck('id')->toArray())->sum('price');
            $total_new = $detail2->whereIn('order_id', $order_new->pluck('id')->toArray())->sum('price');

            $item->phoneNew = $data_new->get()->count();
            $item->orderNew = $order_new->count();
            $input['creator_id'] = $item->id;
            $schedules = Schedule::getBooks2($input, 'id');
            $schedulesDen = clone $schedules;
//            $schedulesHuy = clone $schedules;

            $item->schedulesNew = $schedules->whereHas('customer', function ($qr) {
                $qr->where('old_customer', 0);
            })->count();

            $item->schedules = $schedulesDen->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])
                ->whereHas('customer', function ($qr) {
                    $qr->where('old_customer', 0);
                })->count();
//            $item->schedulesHuy = $schedulesHuy->where('status', ScheduleConstant::HUY)->count();
//            $item->schedulesHuy = 0;

            $input['caller_number'] = $item->caller_number;
            $input['call_status'] = 'ANSWERED';

            $item->call = $input['caller_number'] ? CallCenter::search($input, 'id')->count() : 0;
//            $item->thu_no = 0;

            $item->totalNew = $total_new;
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
            $detail = PaymentHistory::search($input, 'price');
            $detail_total = clone $detail;
            $detail2 = clone $detail;
            $total_old = $detail_total->whereIn('order_id', $order_old->pluck('id')->toArray())->sum('price');
            $total_new = $detail2->whereIn('order_id', $order_new->pluck('id')->toArray())->sum('price');


            $item->phoneNew = $data_new->get()->count();
            $item->orderNew = $order_new->count();
            $input['creator_id'] = $item->id;
            $item->schedules = Schedule::getBooks($input, 'id');

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
