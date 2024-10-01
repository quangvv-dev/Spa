<?php

namespace App\Http\Controllers\BE;

use App\Constants\DepartmentConstant;
use App\Constants\OrderConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Commission;
use App\Models\CommissionEmployee;
use App\Models\Customer;
use App\Models\HistoryUpdateOrder;
use App\Models\HistoryWalletCtv;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\SupportOrder;
use App\Services\CommissionService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommissionController extends Controller
{
    private $commissionService;

    /**
     * CommissionController constructor.
     * @param CommissionService $commissionService
     */
    public function __construct(CommissionService $commissionService)
    {
        $this->middleware('permission:report.commission', ['only' => ['statistical']]);
        $this->middleware('permission:report.waiters', ['only' => ['statisticalWaiters']]);
        $this->middleware('permission:report.hoa-hong', ['only' => ['statisticalRose']]);
        $this->commissionService = $commissionService;
        $branchs = Branch::search()->pluck('name', 'id');
        $location = Branch::getLocation();
        view()->share([
            'branchs' => $branchs,
            'location' => $location,
        ]);
    }

    public function index($id)
    {
        $title = 'Hoa hồng upsale';
        $customers = User::where('department_id', '<>', DepartmentConstant::MARKETING)->pluck('full_name', 'id');
        $doc = Commission::where('order_id', $id)->first();
        $commissions = Commission::where('order_id', $id)->get();
        $order = Order::where('id', $id)->first();
        if (isset($doc) && $doc) {
            return view('commisstion.index', compact('title', 'customers', 'doc', 'commissions', 'order'));
        } else {
            return view('commisstion.index', compact('title', 'customers', 'order'));
        }
    }

    public function store(Request $request, $id)
    {
        $input = $request->except('_token', 'all_total');

        $this->commissionService->create($input, $id);

        return redirect(url('order/' . $id . '/show'));
    }

    public function update(Request $request)
    {
        $commission = $this->commissionService->find($request->id);
        $input = $request->except('_token', 'order_id', 'user_id1', 'percent1', 'all_total');
        $input['order_id'] = $commission->order_id;

        $this->commissionService->create($input, $input['order_id']);

        return redirect('order/' . $commission->order_id . '/show');
    }

    public function destroy(Request $request, $id)
    {
        $this->commissionService->delete($id);
        $request->session()->flash('error', 'Xóa thành công!');
    }

    /**
     * Thong ke hoa hong nhan vien
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function statistical(Request $request)
    {
        $docs = [];
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $users = Auth::user();
        if ($users->department_id == DepartmentConstant::WAITER) {
            $request->merge(['branch_id' => $users->branch_id]);
        }
        $input = $request->all();
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        $data = User::select('id', 'full_name', 'avatar', 'branch_id')->whereIn('role', [UserConstant::TECHNICIANS])
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
                    ->where('user_id', $item->id)->orWhere('support_id', $item->id)->select('id', 'user_id', 'support_id', 'support2_id', 'tip_id', 'service_id')
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
                    'id' => $item->id,
                    'avatar' => $item->avatar,
                    'branch_name' => isset($item->branch) ? @$item->branch->name : '',
                    'full_name' => $item->full_name,
                    'orders' => $order->count(),
                    'all_total' => $order->sum('all_total'),
                    'gross_revenue' => $order->sum('gross_revenue'),
                    'days' => $cong_chinh,
                    'days_phu' => $cong_phu,
                    'earn' => Commission::search($input, 'earn')->sum('earn'),
                    'price' => array_sum($price) ? array_sum($price) : 0,
                ];
                if ($doc['days'] > 0 || $doc['price'] > 0 || $doc['days_phu'] > 0) {
                    $docs[] = $doc;
                }
            }
        }
        $data = collect($docs)->sortByDesc('gross_revenue')->toArray();
        if ($request->ajax()) {
            return view('report_products.ajax_commision', compact('data'));
        }
        return view('report_products.index_commision', compact('data'));
    }

    public function getCommissionWithUser(Request $request)
    {

        $data = Commission::where('user_id', $request->user_id)->whereBetween('created_at', getTime($request->data_time))
            ->has('orders')->with('orders')->paginate(StatusCode::PAGINATE_10);
        return response()->json($data);
    }

    public function statisticalWaiters(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $users = Auth::user();
        if ($users->department_id == DepartmentConstant::WAITER) {
            $request->merge(['branch_id' => $users->branch_id]);
        }

        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $users = User::select('id', 'full_name')->where('department_id', DepartmentConstant::WAITER)->get()->map(function ($item) use ($request) {
            $data_new = Customer::select('id')->where('telesales_id', $item->id)
                ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                    $q->whereIn('branch_id', $request->group_branch);
                })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                    $q->where('branch_id', $request->branch_id);
                });

            $orders = Order::select('member_id', 'all_total', 'gross_revenue')->whereIn('role_type', [StatusCode::COMBOS, StatusCode::SERVICE])
                ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
                    $q->whereIn('branch_id', $request->group_branch);
                })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                    $q->where('branch_id', $request->branch_id);
                })->with('orderDetails')->whereHas('customer', function ($qr) use ($item) {
                    $qr->where('telesales_id', $item->id);
                });
            $orders2 = clone $orders;
            $order_new = $orders->where('is_upsale', OrderConstant::NON_UPSALE);
            $order_old = $orders2->where('is_upsale', OrderConstant::IS_UPSALE);

//            $schedules = Schedule::select('id')->where('creator_id', $item->id)->whereBetween('date', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
////                ->when(isset($request->group_branch) && count($request->group_branch), function ($q) use ($request) {
////                    $q->whereIn('branch_id', $request->group_branch);
////                })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
////                    $q->where('branch_id', $request->branch_id);
////                });
////            $schedules_den = clone $schedules;
////            $schedules_new = clone $schedules;
////
////            $item->schedules_den = $schedules_den->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])
////                ->whereHas('customer', function ($qr) {
////                    $qr->where('old_customer', 0);
////                })->count();
////            $item->schedules_new = $schedules_new->whereHas('customer', function ($qr) {
////                $qr->where('old_customer', 0);
////            })->count();
            //lich hen

            $request->merge(['telesales' => $item->id]);
            $detail = PaymentHistory::search($request->all(), 'price');//đã thu trong kỳ
            $detail_new = clone $detail;

            $item->detail_new = $detail_new->whereHas('order', function ($qr) {
                $qr->where('is_upsale', OrderConstant::NON_UPSALE);
            })->sum('price');
            $item->customer_new = $data_new->count();
            $item->order_new = $order_new->count();
            $item->order_old = $order_old->count();
            $item->revenue_new = $order_new->sum('all_total');
            $item->revenue_old = $order_old->sum('all_total');
            $item->payment_revenue = $orders->sum('gross_revenue');
            $item->payment_new = $order_new->sum('gross_revenue');//da thu trong ky
            $item->payment_old = $order_old->sum('gross_revenue'); //da thu trong ky
            $item->revenue_total = $order_new->sum('all_total') + $order_old->sum('all_total');;
            $item->all_payment = $detail->sum('price');
            return $item;
        })->sortByDesc('all_payment')
            ->filter(function ($it) {
                if ($it->all_payment > 0 || $it->customer_new) {
                    return $it;
                }
            });

        if ($request->ajax()) {
            return view('waiters.ajax', compact('users'));
        }
        return view('waiters.index', compact('users'));
    }

    public function statisticalCTV(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }

        $request['start_date'] = "21-06-2021";

        $ctv = Customer::select('id', 'full_name', 'is_gioithieu')->where('type_ctv', 1)->get()->map(function ($item) use ($request) {
            $orders = Order::where('member_id', $item->id)
                ->when(isset($request['start_date']) && isset($request['end_date']), function ($q) use ($request) {
                    $q->whereBetween('created_at', [
                        Functions::yearMonthDay($request['start_date']) . " 00:00:00",
                        Functions::yearMonthDay($request['end_date']) . " 23:59:59",
                    ]);
                });
            $orders1 = clone $orders;
            $orders1 = $orders1->pluck('id')->toArray();
            $item->doanh_so = $orders->sum('all_total');

            $item->doanh_thu = PaymentHistory::whereIn('order_id', $orders1)->sum('price');

            $item->doanh_thu_ctv = HistoryWalletCtv::where('customer_id', $item->id)->sum('price');

            $item->total_khach_gt = Customer::whereBetween('created_at', [
                Functions::yearMonthDay($request['start_date']) . " 00:00:00",
                Functions::yearMonthDay($request['end_date']) . " 23:59:59",
            ])->where('is_gioithieu', $item->id)->count();

            return $item;
        });
        return view('statistics.hoa_hong_ctv', compact('ctv'));
    }


    public function statisticalRose(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $paginate = 20;
        $current_user = Auth::user();

        if ($current_user->department_id == DepartmentConstant::ADMIN) {
            $check_admin = 1;
            $users = User::whereIn('department_id', [DepartmentConstant::DOCTOR, DepartmentConstant::TU_VAN_VIEN, UserConstant::WAITER, DepartmentConstant::TECHNICIANS])
                ->when(isset($request->searchUser) && $request->searchUser, function ($q) use ($request) {
                    $q->where('department_id', $request->searchUser);
                })->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                    $q->where('branch_id', $request->branch_id);
                })->paginate($paginate);
        } else {
            $check_admin = 0;
            $users = User::select('id', 'avatar', 'full_name', 'percent_rose')->where('department_id', $request->searchUser)->paginate($paginate);
        }

        $users = $users->setCollection($users->getCollection()->map(function ($item) use ($request) {
            $price = 0;
            $count = 0;
            $commisson = CommissionEmployee::whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->with('supportOrder')->whereHas('supportOrder', function ($qr) use ($item) {
                    $qr->where('doctor_id', $item->id)->orWhere('yta1_id', $item->id)->orWhere('yta2_id', $item->id)->orWhere('support1_id', $item->id)->orWhere('support2_id', $item->id);
                })->get();
            foreach ($commisson as $i) {
                if ($item->id == $i->supportOrder->doctor_id) {
                    $price += $i->doctor;
                    $count++;
                } elseif ($item->id == $i->supportOrder->yta1_id) {
                    $price += $i->yta1;
                    $count++;
                } elseif ($item->id == $i->supportOrder->yta2_id) {
                    $price += $i->yta2;
                    $count++;
                } elseif ($item->id == $i->supportOrder->support1_id) {
                    $price += $i->support1;
                    $count++;
                } elseif ($item->id == $i->supportOrder->support2_id) {
                    $price += $i->support1;
                    $count++;
                }
            }
            $item->price_rose = $price;
            $item->count = $count;
            return $item;
        }));

        $branchs = Branch::pluck('name', 'id')->toArray();
        if ($request->ajax()) {
            return view('statistics.hoa_hong_ajax', compact('users'));
        }
        return view('statistics.hoa_hong', compact('users', 'check_admin', 'branchs'));
    }

    public function detailHoaHong($user_id)
    {
        $support_order = SupportOrder::where('doctor_id', $user_id)->orWhere('yta1_id', $user_id)->orWhere('yta2_id', $user_id)->orWhere('support1_id', $user_id)->orWhere('support2_id', $user_id)->with('order.customer')->get()->map(function ($m) use ($user_id) {
            if ($user_id == $m->doctor_id) {
                $m->price = CommissionEmployee::where('order_id', $m->order_id)->select('*', \DB::raw('SUM(doctor) AS all_doctor'))->groupBy('order_id')->first()->all_doctor;
            } elseif ($user_id == $m->yta1_id) {
                $m->price = CommissionEmployee::where('order_id', $m->order_id)->select('*', \DB::raw('SUM(yta1) AS all_yta1'))->groupBy('order_id')->first()->all_yta1;
            } elseif ($user_id == $m->yta2_id) {
                $m->price = CommissionEmployee::where('order_id', $m->order_id)->select('*', \DB::raw('SUM(yta2) AS all_yta2'))->groupBy('order_id')->first()->all_yta2;
            } elseif ($user_id == $m->support1_id) {
                $m->price = CommissionEmployee::where('order_id', $m->order_id)->select('*', \DB::raw('SUM(support1) AS all_support1'))->groupBy('order_id')->first()->all_support1;
            } elseif ($user_id == $m->support2_id) {
                $m->price = CommissionEmployee::where('order_id', $m->order_id)->select('*', \DB::raw('SUM(support2) AS all_support2'))->groupBy('order_id')->first()->all_support2;
            }
            return $m;
        });
        return $support_order;
    }
}
