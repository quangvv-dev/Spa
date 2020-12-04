<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Models\Commission;
use App\Models\Customer;
use App\Models\HistoryUpdateOrder;
use App\Models\Order;
use App\Services\CommissionService;
use App\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $this->commissionService = $commissionService;
    }

    public function index($id)
    {
        $title = 'Hoa hồng upsale';
        $customers = User::where('role', '<>', UserConstant::MARKETING)->pluck('full_name', 'id');
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

        $commission = $this->commissionService->create($input, $id);

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
        if (empty($request->data_time)) {
            $request->merge(['data_time' => 'THIS_MONTH']);
        }
        $input = $request->all();
        $data = User::select('id', 'full_name','avatar')->where('role', UserConstant::TECHNICIANS)->get()->map(function ($item) use ($input) {
            $input['support_id'] = $item->id;
            $input['user_id'] = $item->id;
            $order = Order::getAll($input);
            $item->orders = $order->count();
            $item->all_total = $order->sum('all_total');
            $item->gross_revenue = $order->sum('gross_revenue');
            $item->days = HistoryUpdateOrder::search($input)->count();
            $item->earn = Commission::search($input)->sum('earn');
            return $item;
        })->sortByDesc('gross_revenue');

//        $data = Commission::select('user_id', 'order_id', DB::raw('SUM(earn) AS total'))->groupBy('user_id')
//            ->with('users')->whereBetween('created_at', getTime($request->data_time))->get()->map(function ($item) use ($request) {
//                $orders = Order::select('all_total', 'gross_revenue')->where('id', $item->order_id)->whereBetween('created_at', getTime($request->data_time));
//                $item->all_total = $orders->sum('all_total');
//                $item->gross_revenue = $orders->sum('gross_revenue');
//                return $item;
//            })->sortByDesc('total');

        if ($request->ajax()) {
            return Response::json(view('report_products.ajax_commision', compact('data'))->render());
        }
        return view('report_products.index_commision', compact('data'));
    }

    public function getCommissionWithUser(Request $request)
    {
        $data = Commission::where('user_id', $request->user_id)->whereBetween('created_at', getTime($request->data_time))
            ->has('orders')->with('orders')->paginate(StatusCode::PAGINATE_10);
        return response()->json($data);
    }
}
