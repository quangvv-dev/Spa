<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Category;
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
        $this->middleware('permission:report.commission', ['only' => ['statistical']]);
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

        $docs = [];
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $data = User::select('id', 'full_name', 'avatar')->whereIn('role', [UserConstant::TECHNICIANS])
            ->when(isset($input['branch_id']), function ($query) use ($input) {
                $query->where('branch_id', $input['branch_id']);
            })->get();
        if (count($data)) {

            foreach ($data as $item) {
                $price = [];
                $input['support_id'] = $item->id;
                $input['user_id'] = $item->id;
                $input['type'] = 0;
                $order = Order::getAll($input);
                unset($input['support_id'], $input['user_id']);
                $history_orders = HistoryUpdateOrder::search($input, 'id')
                    ->where('user_id', $item->id)->orWhere('support_id', $item->id)->with('service');
                $history = $history_orders->get();
                $cong_chinh = 0;
                $cong_phu = 0;
                if (count($history)) {
                    foreach ($history as $item2) {
                        if (isset($item2->service)) {
                            $price [] = (int)$item2->service->price_buy ?: 0;
                        }
                        if ($item->id == $item2->user_id) {
                            $cong_chinh += $cong_chinh + 1;
                        } elseif ($item->id == $item2->support_id) {
                            $cong_phu += $cong_phu + 1;
                        }
                    }
                }

                $doc = [
                    'id' => $item->id,
                    'avatar' => $item->avatar,
                    'full_name' => $item->full_name,
                    'orders' => $order->count(),
                    'all_total' => $order->sum('all_total'),
                    'gross_revenue' => $order->sum('gross_revenue'),
                    'days' => $cong_chinh,
                    'days_phu' => $cong_phu,
                    'earn' => Commission::search($input, 'earn')->sum('earn'),
                    'price' => array_sum($price) ? array_sum($price) : 0,
                ];
//                if ($doc['days'] > 0 || $doc['price'] > 0) {
                    $docs[] = $doc;
//                }
            }
        }
        $data = collect($docs)->sortBy('gross_revenue')->reverse()->toArray();
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
}
