<?php

namespace App\Http\Controllers\API;

use App\Constants\DepartmentConstant;
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
use App\Models\GroupComment;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Schedule;
use App\Services\SaleService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class SaleController extends BaseApiController
{

    public function __construct(SaleService $sale)
    {
        $this->sale = $sale;
    }

    public function salePerfomance(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();
        $data_new = $this->sale->getDataNew($input);
        $order_new = $this->sale->getDataOrders($input);
        $schedules = $this->sale->getDataSchedules($input);
        $payments = $this->sale->getDataPayment($input);
        $call = $this->sale->getDataCall($input);
        $users = $this->sale->transformData($data_new, $order_new, $schedules, $payments, $call);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $users);
    }

    /**
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
        $users = User::select('id', 'full_name', 'avatar', 'caller_number')->where('department_id', DepartmentConstant::TELESALES)
            ->where('active', StatusCode::ON)->get()->map(function ($item) use ($request, $input) {
            $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])
                ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                });
            $orders = Order::select('id', 'member_id', 'all_total', 'gross_revenue')->whereIn('role_type', [StatusCode::COMBOS, StatusCode::SERVICE])
                ->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])
                ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                })->with('orderDetails')->whereHas('customer', function ($qr) use ($item) {
                    $qr->where('telesales_id', $item->id);
                });
            $order_new = $orders->where('is_upsale', OrderConstant::NON_UPSALE);

            $input['telesales'] = $item->id;
            $detail = PaymentHistory::search($input, 'price')->whereHas('order', function ($qr) {
                    $qr->where('is_upsale', OrderConstant::NON_UPSALE);
                });
            $item->phoneNew = $data_new->get()->count();
            $item->orderNew = $order_new->count();
            $input['creator_id'] = $item->id;
            $schedules = Schedule::getBooks2($input, 'id')->whereHas('customer', function ($qr) {
                    $qr->where('old_customer', 0);
                });
            $schedules_den = clone $schedules;
            $item->schedulesNew = $schedules->count();
//
            $item->schedules_mua = $schedules_den->where('status', ScheduleConstant::DEN_MUA)->count();
            $item->schedules_failed = $schedules->where('status', ScheduleConstant::CHUA_MUA)->count();
            $input['caller_number'] = $item->caller_number;
            $input['call_status'] = 'ANSWERED';

            $item->call = $input['caller_number'] ? CallCenter::search($input, 'id')->count() : 0;

            $item->totalNew = $detail->sum('price');
            $item->gross_revenue = $order_new->sum('gross_revenue');
            $item->the_rest = $detail->where('is_debt', StatusCode::ON)->sum('price');
//            $item->the_rest = $item->totalNew - $order_new->sum('gross_revenue');
            $item->avg = !empty($item->orderNew) ? round($item->totalNew / $item->orderNew) : 0;
            $item->percentOrder = !empty($item->orderNew) && !empty($item->phoneNew) ? round($item->orderNew / $item->phoneNew * 100,2) : 0;
            return $item;
        })->sortByDesc('totalAll');

        $users = SaleResource::collection($users);
        return $this->responseApi(ResponseStatusCode::OK, "SUCCESS", $users);
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
        $users = User::select('id', 'full_name', 'avatar')->where('department_id', DepartmentConstant::TELESALES)
            ->where('active', StatusCode::ON)->get()->map(function ($item) use ($request, $input) {
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

    public function statistic(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $response = [];
        $input = $request->all();
        $sale = User::select('id')->where('department_id', DepartmentConstant::TELESALES)->where('active', StatusCode::ON)
            ->when(isset($input['sale_id']) && $input['sale_id'], function ($query) use ($input) {
                $query->where('id', $input['sale_id']);
            })->pluck('id')->toArray();

        $data_new = Customer::select('id')->whereIn('telesales_id', $sale)
            ->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])
            ->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            });

        $orders = Order::select('id', 'member_id', 'all_total', 'gross_revenue')->whereIn('role_type', [StatusCode::COMBOS, StatusCode::SERVICE])
            ->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])
            ->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->with('orderDetails')->whereHas('customer', function ($qr) use ($sale) {
                $qr->whereIn('telesales_id', $sale);
            });
        $orders2 = clone $orders;
        $order_new = $orders->where('is_upsale', OrderConstant::NON_UPSALE);
        $order_old = $orders2->where('is_upsale', OrderConstant::IS_UPSALE);

        $group_comment = GroupComment::select('id')->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])
            ->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            });
        $comment_new = clone $group_comment;

        $response['comment_new'] = $comment_new->whereIn('customer_id', $order_new->pluck('member_id')->toArray())->count();// trao doi moi;
        $schedules = Schedule::select('id')->whereIn('creator_id', $sale)->whereBetween('date', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
            ->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            });
        $schedules_den = clone $schedules;
        $schedules_new = clone $schedules;

        $response['schedules_den'] = $schedules_den->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])
            ->whereHas('customer', function ($qr) {
                $qr->where('old_customer', 0);
            })->count();
        $response['schedules_new'] = $schedules_new->whereHas('customer', function ($qr) {
            $qr->where('old_customer', 0);
        })->count();
        //lich hen

//        $request->merge(['telesales' => $item->id]);
        $params = $request->all();
        $detail = PaymentHistory::search($params, 'price')->whereHas('order', function ($item) use ($sale) {
            $item->whereHas('customer', function ($q) use ($sale) {
                $q->whereIn('telesales_id', $sale);
            });
        });//đã thu trong kỳ
        $detail_new = clone $detail;

        $response['payment_new'] = (int)$detail_new->whereHas('order', function ($qr) {
            $qr->where('is_upsale', OrderConstant::NON_UPSALE);
        })->sum('price');

        $response['contact'] = $data_new->count();
        $response['order_new'] = $order_new->count();
        $response['order_old'] = $order_old->count();
        $response['total_new'] = (int)$order_new->sum('all_total');
        $response['total_old'] = (int)$order_old->sum('all_total');

        $response['gross_new'] = (int)$order_new->sum('gross_revenue');
        $response['gross_old'] = (int)$order_old->sum('gross_revenue');
        $response['all_payment'] = (int)$detail->sum('price');
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $response);
    }
}
