<?php

namespace App\Http\Controllers\API\Marketing;

use App\Constants\DepartmentConstant;
use App\Constants\OrderConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\CarepageResource;
use App\Http\Resources\MarketingResource;
use App\Http\Resources\WaiterResource;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\PaymentWallet;
use App\Models\PriceMarketing;
use App\Models\Schedule;
use App\Models\Source;
use App\Models\ThuChi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function JmesPath\search;

class MarketingController extends BaseApiController
{

    public function __construct()
    {
        $branchs = Branch::search()->pluck('name', 'id');
        $location = Branch::getLocation();
        view()->share([
            'branchs' => $branchs,
            'location' => $location,
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        $data = User::where('department_id', DepartmentConstant::MARKETING)->where('active',StatusCode::ON)
            ->select('id', 'full_name', 'avatar')->get()->map(function ($item) use ($input) {
            $input['marketing'] = $item->id;
            $customer = Customer::searchApi($input)->select('id');
            $item->contact = $customer->count();
            $input['is_upsale'] = OrderConstant::NON_UPSALE;
            $orders = Order::searchAll($input)->select('id', 'gross_revenue', 'all_total');
            $item->orders = $orders->count();
            $item->gross_revenue = $orders->sum('gross_revenue');
            $input['marketing'] = $item->id;
            $input['date_customers'] = OrderConstant::NON_UPSALE;
            $item->schedules = Schedule::search($input)->count();
            return $item;
        })->sortByDesc('gross_revenue');

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', MarketingResource::collection($data));

    }

    /**
     * Thống kê carepage
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function carepage(Request $request)
    {
        $input = $request->all();
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        $marketing = User::where('department_id', DepartmentConstant::CARE_PAGE)->where('active',StatusCode::ON)
            ->select('id', 'full_name', 'avatar')->get()->map(function ($item) use ($input) {
            $input['carepage_id'] = $item->id;
            $customer = Customer::searchApi($input)->select('id');
            $item->contact = $customer->count();
            $group_user = $customer->pluck('id')->toArray();
            $input['group_user'] = $group_user;

            if (count($group_user)) {
                $schedules = Schedule::search($input)->select('id');
                $item->schedules = $schedules->count();
//                $item->schedules_den = $schedules->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])->count();
            } else {
                $item->schedules = 0;
//                $item->schedules_den = 0;
            }
            $orders = Order::searchAll($input)->select('id', 'order_id', 'gross_revenue', 'all_total');
            $item->orders = $orders->count();
            $item->percent_order = !empty($item->contact) ? round($item->orders / $item->contact, 2) * 100 : 0;
            $item->percent_schedules = !empty($item->contact) ? round($item->schedules / $item->contact, 2) * 100 : 0;
            $item->all_total = (int)$orders->sum('all_total');
            $payment = PaymentHistory::search($input, 'price,order_id')->whereHas('order', function ($item) {
                $item->where('is_upsale', OrderConstant::NON_UPSALE);
            });
//            $item->gross_revenue = (int)$orders->sum('gross_revenue');
            $item->payment = $payment->sum('price');
            $item->avg = !empty($item->orders) ? round($item->payment / $item->orders, 2) : 0;

            return $item;
        })->sortByDesc('payment');
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', CarepageResource::collection($marketing));

    }

    public function waiters(Request $request)
    {
        $input = $request->all();
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        $users = User::select('id', 'full_name', 'avatar')->where('department_id', DepartmentConstant::WAITER)
            ->where('active',StatusCode::ON)->get()->map(function ($item) use ($request) {
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
            //lich hen

            $request->merge(['telesales' => $item->id]);
            $detail = PaymentHistory::search($request->all(), 'price');//đã thu trong kỳ
            $detail_new = clone $detail;

            $item->payment_new = (int)$detail_new->whereHas('order', function ($qr) {
                $qr->where('is_upsale', OrderConstant::NON_UPSALE);
            })->sum('price');
            $item->contact = $data_new->count();
            $item->order_new = $order_new->count();
            $item->order_old = $order_old->count();
            $item->total_new = (int)$order_new->sum('all_total');
            $item->total_old = (int)$order_old->sum('all_total');
            $item->all_total = (int)$order_new->sum('all_total') + $order_old->sum('all_total');;
            $item->all_payment = (int)$detail->sum('price');
            return $item;
        })->sortByDesc('all_payment')
            ->filter(function ($it) {
                if ($it->all_payment > 0 || $it->customer_new) {
                    return $it;
                }
            });
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', WaiterResource::collection($users));

    }


    /**
     * ds MKT
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMarketingUser()
    {
        $marketing = User::select('id', 'full_name')->where('department_id', DepartmentConstant::MARKETING)
            ->where('active',StatusCode::ON)->get();
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $marketing);
    }

    /**
     * Đánh giá chi tiết MKT
     *
     * @return \Illuminate\Http\Response
     */
    public function statistic(Request $request)
    {
        $input = $request->all();
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        $data = [];
        $marketing = User::select('id')->where('department_id', DepartmentConstant::MARKETING)
            ->where('active',StatusCode::ON)
            ->when(isset($input['mkt_id']) && $input['mkt_id'], function ($query) use ($input) {
                $query->where('id', $input['mkt_id']);
            })->get();
        if (count($marketing)) {
            $input['arr_marketing'] = $marketing->pluck('id')->toArray();
            $input['arr_thuc_hien'] = $marketing->pluck('id')->toArray();
            $params = $input;
            $thu_chi = ThuChi::search($params, 'so_tien')->where('status', 1);
            $customer = Customer::searchApi($input)->select('id');
            unset($params['marketing'], $params['branch_id'], $params['location_id']);
            $data['contact'] = $customer->count();
            $group_user = $customer->pluck('id')->toArray();
            $input['group_user'] = $group_user;
//            if (isset($input['group_branch']) || empty($input['branch_id'])) {
//                unset($input['group_user']);
//            }
            if (count($group_user)) {
//                $schedules = Schedule::search($input)->select('id');
                $schedules = Schedule::getBooks2($input)->select('id');
                $data['schedules'] = $schedules->count();
                $data['schedules_den'] = $schedules->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])
                    ->whereHas('customer', function ($qr) {
                        $qr->where('old_customer', 0);
                    })->count();
            } else {
                $data['schedules'] = 0;
                $data['schedules_den'] = 0;
            }
            if (count($input['arr_marketing']) != 1) {
                unset($input['arr_marketing']);
            }
//            $orders = Order::searchAll($input)->select('id', 'gross_revenue', 'all_total');
            $orders = Order::returnRawData($input)->select('id', 'gross_revenue', 'all_total');
            $order_new = clone $orders;
            $payment = PaymentHistory::search($input, 'price,order_id');
            $paymentNew = clone $payment;
            $paymentNew = $paymentNew->whereHas('order', function ($item) {
                $item->where('is_upsale', 0);
            });
            unset($input['marketing']);
            $price = PriceMarketing::search($input)
                ->when(isset($input['arr_marketing']), function ($query) use ($input) {
                    $query->whereIn('user_id', $input['arr_marketing']);
                })->select('budget', 'comment', 'message', \DB::raw('sum(budget) as total_budget'),
                    \DB::raw('sum(comment) as total_comment'), \DB::raw('sum(message) as total_message'))->first();
            $data['budget'] = (int)$price->total_budget; //ngân sách
            $data['comment'] = (int)$price->total_comment; //comment
            $data['message'] = (int)$price->total_message; //tin nhắn
            $data['all_orders'] = (int)$orders->count();
            $data['orders'] = (int)$order_new->where('is_upsale', 0)->count();
            $data['all_total'] = (int)$orders->sum('all_total');
            $data['gross_revenue'] = (int)$orders->sum('gross_revenue');
            $data['payment'] = (int)$paymentNew->sum('price');
            $data['paymentAll'] = (int)$payment->sum('price');
            $data['nap'] = (int)$thu_chi->sum('so_tien');
            $payment_wallet = PaymentWallet::search($input, 'price')->sum('price');
            $payment_used = $payment->where('payment_type', 3)->sum('price');
            $data['paymentAll'] = $data['paymentAll'] + $payment_wallet - $payment_used;

        }

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $input['searchAccept'] = UserConstant::ACTIVE;
        $source = Source::search($input)->with('user')->get()->map(function ($item) use ($input) {
            $input['source_fb'] = $item->id;
            $customer = Customer::search($input)->select('id');
            $input['group_user'] = $customer->pluck('id')->toArray();
            if (count($input['group_user'])) {
                $schedules = Schedule::search($input)->select('id');
                $item->schedules = $schedules->count();
                $item->schedules_den = $schedules->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])->count();
            } else {
                $item->schedules = 0;
                $item->schedules_den = 0;
            }
            $input['source_id'] = $item->id;

            $orders = Order::searchAll($input)->where('is_upsale', OrderConstant::NON_UPSALE)
                ->select('id', 'gross_revenue', 'all_total');
            unset($input['marketing']);
            $input['user_id'] = $item->id;
            $price = PriceMarketing::search($input)->select('budget', \DB::raw('sum(budget) as total_budget'))->first();
            $item->budget = $price->total_budget; //ngân sách
            $item->customers = $customer->count();
            $item->orders = $orders->count();
            $item->all_total = $orders->sum('all_total');
            $item->gross_revenue = $orders->sum('gross_revenue');
            return $item;
        })->sortByDesc('payment');
        if ($request->ajax()) {
            return view('marketing.dashbroad.ajax', compact('source'));
        }

        return view('marketing.dashbroad.index', compact('source'));
    }


    public function searchPriceMarketing(Request $request)
    {
        $input = $request->all();
        $price = PriceMarketing::search($input)->with('user')->get();
        return $price;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        PriceMarketing::find($id)->delete();
        $request->session()->flash('error', 'Xóa thành công bản ghi ngân sách!');
    }

    /**
     * Bảng xếp hạng MKT
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ranking(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }

        $input = $request->all();
        $marketing = User::where('department_id', DepartmentConstant::MARKETING)->where('active',StatusCode::ON)
            ->select('id', 'full_name', 'avatar')->get()->map(function ($item) use ($input) {
            $input['marketing'] = $item->id;
            $data = Order::searchAll($input)->select('gross_revenue');
            $item->gross_revenue = $data->sum('gross_revenue');
            return $item;
        })->sortByDesc('gross_revenue')->toArray();

        $my_key = array_keys(array_column((array)$marketing, 'id'), Auth::user()->id);

        if ($request->ajax()) {
            return view('marketing.ranking.ajax', compact('marketing', 'my_key'));
        }
        return view('marketing.ranking.index', compact('marketing', 'my_key'));
    }
}
