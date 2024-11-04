<?php

namespace App\Http\Controllers\BE;

use App\Constants\DepartmentConstant;
use App\Constants\OrderConstant;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\CallCenter;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\GroupComment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Schedule;
use App\Models\Services;
use App\Models\Team;
use App\Models\TeamMember;
use App\Services\TaskService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('permission:report.sale', ['only' => ['index']]);
        $location = Branch::getLocation();
        $branchs = Branch::pluck('name', 'id');
        view()->share([
            'location' => $location,
            'branchs' => $branchs,
        ]);

    }

    /**
     * Bảng xếp hạng sales
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $teams = Team::select('id','name')->where('department_id', DepartmentConstant::TELESALES)->pluck('name','id')->toArray();
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
        $members = Functions::members($request->all());

        $users = User::select('id', 'full_name', 'caller_number')->where('department_id', DepartmentConstant::TELESALES)
            ->where('active', StatusCode::ON)
            ->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                $q->where('branch_id', $request->branch_id);
            })
            ->when(!empty($members), function ($q) use ($members) {
                $q->whereIn('id', $members);
            })->get()->map(function ($item) use ($request) {
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
                $order_new = $orders->where('is_upsale', OrderConstant::NON_UPSALE);
                $order_hot = clone $order_new;

                $order_hot = $order_hot->whereHas('customer', function ($qr) use ($request) {
                    $qr->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);
                });

                if ($item->caller_number) {
                    $paramsCenter = [
                        'caller_number' => $item->caller_number,
                        'call_status' => 'ANSWERED',
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                    ];

                    $callCenter = CallCenter::search($paramsCenter, 'id');
                    $item->call_center = $callCenter->count();
                    $item->answer_time = $callCenter->sum('answer_time')/60;
                    $item->call2minute = $callCenter->where('answer_time', '>=', 120)->count();
                } else {
                    $item->call_center = 0;
                    $item->answer_time = 0;
                    $item->call2minute = 0;
                }

                $schedulesAll = Schedule::select('id')->where('creator_id', $item->id)
                    ->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                        $q->whereIn('branch_id', $request->group_branch);
                    })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                        $q->where('branch_id', $request->branch_id);
                    });
                $schedules = clone $schedulesAll;
                $schedules = $schedules->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);

                $schedules_den = $schedulesAll->whereBetween('date', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);
                $schedules_hot = clone $schedules;

                $item->schedules_new = $schedules_hot->count();// lịch được tạo trong time lọc
                $schedules_new_hot = $schedules_hot->whereHas('customer', function ($qr) use ($request) {
                    $qr->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);
                });
                $item->schedules_hot = $schedules_new_hot->count();
                $item->schedules_hot_den = $schedules_new_hot->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])->count();
                $item->schedules_hot_mua = $schedules_new_hot->whereIn('status', [ScheduleConstant::DEN_MUA])->count();

                $item->schedules_den = $schedules_den->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])
                    ->whereHas('customer', function ($qr) {
                        $qr->where('old_customer', 0);
                    })->count();
                $item->become_buy = $schedules_den->where('status', ScheduleConstant::DEN_MUA)->count();
                $item->not_buy = $item->schedules_den - $item->become_buy;

                //lich hen

                $request->merge(['telesales' => $item->id]);
                $params = $request->all();
                $detail = PaymentHistory::search($params, 'price');//đã thu trong kỳ
                $item->detail_new = $detail->whereHas('order', function ($qr) {
                    $qr->where('is_upsale', OrderConstant::NON_UPSALE);
                })->sum('price');
                $item->is_debt = $detail->where('is_debt', StatusCode::ON)->sum('price');
                $item->customer_new = $data_new->count();
                $item->order_new = $order_new->count();
                $item->order_hot = $order_hot->count();
                $item->revenue_new = $order_new->sum('all_total');
                $item->payment_new = $item->detail_new - $item->is_debt;
                return $item;
            })->sortByDesc('detail_new');
        \View::share([
            'allTotal' => $users->sum('revenue_new'),
            'grossRevenue' => $users->sum('payment_new'),
        ]);

        if ($request->ajax()) {
            return view('report_products.ajax_sale', compact('users'));
        }
        return view('report_products.sale', compact('users','teams'));
    }

    /**
     * Xếp hạng telesale
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ranking(Request $request)
    {
        $teams = Team::select('id','name')->where('department_id', DepartmentConstant::TELESALES)->pluck('name','id')->toArray();
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $members = Functions::members($request->all());

        $params = $request->all();

        $sale = $this->getSale($members, $params);
        $orders = $this->getSaleOrders($members, $params);
        $sale = Functions::transformRanking($sale, $orders);

        if ($request->ajax()) {
            return view('sale.ranking.ajax', compact('sale'));
        }
        return view('sale.ranking.index', compact('sale','teams'));
    }

    public function getSale($members, $input)
    {
        return User::leftJoin('branchs as b', 'users.branch_id', '=', 'b.id')
            ->join('orders as o', 'o.telesale_id', '=', 'users.id')
            ->join('payment_histories as ph', 'o.id', '=', 'ph.order_id')
            ->where('users.department_id', DepartmentConstant::TELESALES)->where('users.active', StatusCode::ON)
            ->when(!empty($members), function ($q) use ($members) {
                $q->whereIn('users.id', $members);
            })
            ->where('o.is_upsale', OrderConstant::NON_UPSALE)
            ->whereBetween('ph.payment_date', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
            ->select('users.id', 'users.full_name', 'users.avatar', 'b.name as branch_name',
                \DB::raw('sum(ph.price) as gross_revenue'))
            ->groupBy('users.id')
            ->orderBy('gross_revenue', 'desc')->get();
    }

    public function getSaleOrders($members, $input)
    {
        return User::join('orders as o', 'o.telesale_id', '=', 'users.id')
            ->where('users.department_id', DepartmentConstant::TELESALES)->where('users.active', StatusCode::ON)
            ->when(!empty($members), function ($q) use ($members) {
                $q->whereIn('users.id', $members);
            })
            ->where('o.is_upsale', OrderConstant::NON_UPSALE)
            ->whereBetween('o.created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
            ->select('users.id', \DB::raw('count(o.id) as orders'))
            ->groupBy('users.id')->get();
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
        $user = Auth::user();
        if (!in_array($user->department_id, [
                DepartmentConstant::KE_TOAN,
                DepartmentConstant::MARKETING,
                DepartmentConstant::TELESALES,
            ]) && ($user->department_id != DepartmentConstant::BAN_GIAM_DOC || ($user->department_id == DepartmentConstant::BAN_GIAM_DOC && $user->branch_id != null))) {
            $request->merge(['branch_id' => $user->branch_id]);
        }
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }

        $type = isset($request->type) ? $request->type : StatusCode::SERVICE;

        $branchs = Branch::search()->pluck('name', 'id');

        $location = Branch::getLocation();

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

            $item->customer_new = count($data_new);
            $item->order_new = $detail_new->get()->count();
            $item->revenue_new = $detail_new->get()->sum('all_total');
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


}
