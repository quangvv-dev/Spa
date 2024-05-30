<?php

namespace App\Http\Controllers\BE;

use App\Constants\DepartmentConstant;
use App\Constants\OrderConstant;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\AgeAndJob;
use App\Models\Branch;
use App\Models\CallCenter;
use App\Models\Category;
use App\Models\City;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\GroupComment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Schedule;
use App\Models\Services;
use App\Services\TaskService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Source;

class SalesController extends Controller
{

    /**
     * TaskController constructor.
     *
     * @param TaskService $taskService
     */
    public function __construct()
    {
        $this->middleware('permission:report.groupSale', ['only' => ['indexGroupCategory']]);
        $this->middleware('permission:report.saleAdmin', ['only' => ['adminIndex']]);
        $this->middleware('permission:report.sale', ['only' => ['index']]);
        $location = Branch::$location;
        $branchs = Branch::pluck('name', 'id');
        view()->share([
            'location' => $location,
            'branchs' => $branchs,
        ]);

    }

    /**
     * Bảng xếp hạng sales
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        if (count($request->all()) == 2) {
            $request->merge(['branch_id' => 1]);
        }
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $users = User::select('id', 'full_name', 'caller_number')->where('department_id', DepartmentConstant::TELESALES)->get()->map(function ($item) use ($request) {

            $data_new = Customer::select('id')->where('telesales_id', $item->id)
                ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                    $q->whereIn('branch_id', $request->group_branch);
                })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                    $q->where('branch_id', $request->branch_id);
                });

            $orders = Order::select('id', 'member_id', 'all_total', 'gross_revenue')->whereIn('role_type', [StatusCode::COMBOS, StatusCode::SERVICE])
                ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                    $q->whereIn('branch_id', $request->group_branch);
                })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                    $q->where('branch_id', $request->branch_id);
                })->with('orderDetails')->whereHas('customer', function ($qr) use ($item) {
                    $qr->where('telesales_id', $item->id);
                });

            $input = $request->all();
//            $input['caller_number'] = $item->caller_number;
//            $input['call_status'] = 'ANSWERED';
//            if (!empty($item->caller_number)) {
//                $call_center = CallCenter::search($input, 'id,answer_time');
//                $item->history = $call_center->sum('answer_time');
//                $item->call_center = $call_center->where('call_status', 'ANSWERED')->count();
//            } else {
//                $item->call_center = 0;
//            }

            $schedules = Schedule::select('id')->where('creator_id', $item->id)->whereBetween('date', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                    $q->whereIn('branch_id', $request->group_branch);
                })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                    $q->where('branch_id', $request->branch_id);
                });
            $schedules2 = clone $schedules;
            //Lịch hẹn
            $item->all_schedules = $schedules->count();
            $item->schedules_den = $schedules->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])->count();
//            $item->schedules_huy = $schedules2->where('status', ScheduleConstant::HUY)->count();
            //End Lịch hẹn

            $item->customer_new = $data_new->count();
            $item->tiep_can = $data_new->whereNotIn('status_id', [2, 20])->count();
            $item->orders = $orders->count(); // HV chốt

            return $item;
        })->filter(function ($f) {
            if ($f->customer_new > 0) {
                return $f;
            }
        })->sortByDesc('all_payment');

        if ($request->ajax()) {
            return view('report_products.ajax_sale', compact('users'));
        }
        return view('report_products.sale', compact('users'));
    }

    /**
     * Xếp hạng telesale
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ranking(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }

        $params = $request->except('doanh_so_doanh_thu');
        $sale = User::where('department_id', DepartmentConstant::TELESALES)->get()->map(function ($item) use ($params, $request) {
            $params['telesales'] = $item->id;

            if (!isset($request->doanh_so_doanh_thu) || $request->doanh_so_doanh_thu == 0) {
                $item->gross_revenue = Order::select('id', 'member_id', 'all_total', 'gross_revenue')->whereIn('role_type', [StatusCode::COMBOS, StatusCode::SERVICE])
                    ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                    ->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                        $q->whereIn('branch_id', $request->group_branch);
                    })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                        $q->where('branch_id', $request->branch_id);
                    })->with('orderDetails')->where('telesale_id', $item->id)->sum('all_total');
            } else {
                $item->gross_revenue = PaymentHistory::search($params, 'price')->sum('price');
            }
            return $item;
        })->sortByDesc('gross_revenue')->toArray();

        $my_key = array_keys(array_column((array)$sale, 'id'), Auth::user()->id);

        if ($request->ajax()) {
            return view('sale.ranking.ajax', compact('sale', 'my_key'));
        }
        return view('sale.ranking.index', compact('sale', 'my_key'));
    }

    /**
     * Thống kê nhóm sản phẩm dịch vụ
     *
     * @param Request $request
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexGroupCategory(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        if (!isset($request->branch_id)) {
            $request->merge(['branch_id' => 1]);
        } elseif ($request->branch_id == (-1)) {
            $request->merge(['branch_id' => null]);
        }
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }

        $type = isset($request->type) ? $request->type : StatusCode::SERVICE;

        $branchs = Branch::search()->pluck('name', 'id');

        $location = Branch::$location;

        $telesales = User::whereIn('role', [UserConstant::TP_SALE, UserConstant::TELESALES, UserConstant::WAITER])->pluck('full_name', 'id')->toArray();
        $users = Category::where('type', $type)->get()->map(function ($item) use ($request, $type) {
            $booking = Services::select('id')->where('type', $type)->where('category_id', $item->id)->pluck('id')->toArray();
            $arr_customer = CustomerGroup::select('customer_id')->where('category_id', $item->id)->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                $q->whereIn('branch_id', $request->group_branch);
            })->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);
            $arr_customer = self::searchBranch($arr_customer, $request);
            $data_new = $arr_customer->pluck('customer_id')->toArray();
            $schedules = Schedule::select('id')->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                    $q->where('branch_id', $request->branch_id);
                })->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                    $q->whereIn('branch_id', $request->group_branch);
                });
            $schedules_new = $schedules->whereIn('user_id', $data_new);
            $item->schedules_new = $schedules_new->count();//lich hen
            $item->become = $schedules->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])->count();//lich hen

            $detail = OrderDetail::select('order_id', \DB::raw('SUM(total_price) AS all_total'), \DB::raw('COUNT(order_id) AS COUNTS'))->whereIn('booking_id', $booking)
                ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                    $q->where('branch_id', $request->branch_id);
                })->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                    $q->whereIn('branch_id', $request->group_branch);
                });
            $detail_new = clone $detail;
            $detail_new = $detail_new->whereHas('order', function ($qr) {
                $qr->where('is_upsale', OrderConstant::NON_UPSALE);
            })->groupBy('order_id');

            $comment = GroupComment::select('id')->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->whereIn('customer_id', $data_new)->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                    $q->whereIn('branch_id', $request->group_branch);
                });

            $item->comment_new = self::searchBranch($comment, $request)->get()->count();// trao doi moi

            $item->customer_new = count($data_new);
            $item->order_new = $detail_new->get()->count();
            $item->order_old = $detail->get()->sum('COUNTS') - $detail_new->get()->sum('COUNTS');
            $item->revenue_new = $detail_new->get()->sum('all_total');
            $item->revenue_old = $detail->groupBy('order_id')->get()->sum('all_total') - $item->revenue_new;
            $item->revenue_total = $detail->groupBy('order_id')->get()->sum('all_total');
            return $item;
        })->sortByDesc('revenue_total')->filter(function ($item) {
            if ($item->revenue_total > 0) {
                return $item;
            }
        });

        \View::share([
            'allTotal' => $users->sum('revenue_total'),
        ]);
        if ($request->ajax()) {
            return view('report_products.ajax_group', compact('users', 'telesales', 'type', 'location'));
        }
        return view('report_products.group_sale', compact('branchs', 'users', 'telesales', 'type', 'location'));
    }

    public function searchBranch($query, $input)
    {
        return $query->when(isset($input->branch_id) && $input->branch_id, function ($q) use ($input) {
            $q->where('branch_id', $input->branch_id);
        });
    }

    public function customReport(Request $request)
    {

//        $order = Order::whereNull('city_id')->get()->map(function ($i){
//            Order::find($i->id)->update(['city_id'=>0]);
////            return $i;
//        });
//        dd($order);

        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }

        $branchs = Branch::pluck('name', 'id')->toArray();
        $marketing = [];
        $type_search = $request->type_search ? $request->type_search : 1;

        $search = $request->all();
        $data = [];
        if ($type_search == 1) { //doanh thu theo tỉnh

            $data = City::select('name', 'id')->get()->map(function ($item) use ($search) {
                $search['city_id'] = $item->id;
                $order = Order::searchAll($search);
                $order1 = clone $order;
                $order2 = clone $order;

                $array_order = $order2->pluck('id')->toArray();

                $item->so_don = $order->count();
                $item->doanh_so = $order1->sum('all_total');

                $payment = PaymentHistory::search($search)->whereIn('order_id', $array_order);
                $payment1 = clone $payment;
                $item->doanh_thu = $payment->sum('price');
                $item->so_don_doanh_thu = $payment->count();

                $item->doanh_thu_no = $payment1->where('is_debt', 1)->sum('price');
                $item->so_don_no = $payment1->where('is_debt', 1)->count();

                return $item;
            })->sortByDesc('doanh_so');
            if ($request->ajax()) {
                return view('statistics.report_custom.report_city', compact('data'));
            }

        }
        if ($type_search == 2) { //doanh thu theo tuổi
            $age = AgeAndJob::where('type', 0)->get();
            $source = \App\Models\Source::search($search)->get()->map(function ($s) use ($search) {
                $s->age = AgeAndJob::where('type', 0)->get()->map(function ($item) use ($search, $s) {
                    $orderArray = Order::searchAll($search)->select('all_total', 'member_id')->whereHas('customer', function ($qr) use ($item, $s) {
                        $qr->where('age_from', $item->id)->where('source_fb', $s->id);
                    });
                    $item->price = $orderArray->sum('all_total');
                    return $item;
                });
                return $s;
            });
//            dd($source);
            return view('statistics.report_custom.report_age', compact('age', 'source'));
        }
        if ($type_search == 3) { //doanh thu theo nghề nghiệp
            $job = AgeAndJob::where('type', 1)->get();
            $source = \App\Models\Source::search($search)->get()->map(function ($s) use ($search) {
                $s->job = AgeAndJob::where('type', 1)->get()->map(function ($item) use ($search, $s) {
                    $orderArray = Order::searchAll($search)->select('all_total', 'member_id')->whereHas('customer', function ($qr) use ($item, $s) {
                        $qr->where('customer_job', $item->id)->where('source_fb', $s->id);
                    });
                    $item->price = $orderArray->sum('all_total');
                    return $item;
                });
                return $s;
            });
            return view('statistics.report_custom.report_job', compact('job', 'source'));
        }
        return view('statistics.report_custom.thong_ke', compact('branchs', 'marketing', 'data'));
    }


    /**
     * Báo cáo doanh thu admin
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminIndex(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        if (count($request->all()) == 2) {
            $request->merge(['branch_id' => 1]);
        }
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }

        $users = User::select('id', 'full_name')->where('department_id', DepartmentConstant::TELESALES)->get()->map(function ($item) use ($request) {

            $orders = Order::select('id', 'member_id', 'all_total', 'gross_revenue')
                ->when(isset($request->role_type), function ($q) use ($request) {
                    $q->where('role_type', $request->role_type);
                })
                ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                    $q->whereIn('branch_id', $request->group_branch);
                })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                    $q->where('branch_id', $request->branch_id);
                })->with('orderDetails')->where('telesale_id', $item->id);
            $params = $request->all();
            $params['telesales'] = $item->id;
            $payment = PaymentHistory::search($params, 'price');
            $payment2 = clone $payment;

            $item->all_total = $orders->sum('all_total');
            $item->gross_revenue = $payment->sum('price');
            $item->upsales = $payment2->whereHas('order', function ($query) {
                $query->where('is_upsale', OrderConstant::IS_UPSALE);
            })->sum('price');
            $item->the_rest = $payment->where('is_debt', OrderConstant::TRUE_DEBT)->sum('price');
            $item->orders = $orders->count(); // HV chốt
            return $item;
        })->filter(function ($f) {
            if ($f->gross_revenue > 0) return $f;
        })->sortByDesc('gross_revenue');

        if ($request->ajax()) {
            return view('sale.admin.ajax', compact('users'));
        }
        return view('sale.admin.index', compact('users'));
    }
}
