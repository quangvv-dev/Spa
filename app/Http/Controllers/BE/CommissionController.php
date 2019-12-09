<?php

namespace App\Http\Controllers\BE;

use App\Constants\UserConstant;
use App\Models\Commission;
use App\Models\Order;
use App\Services\CommissionService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function update(Request $request, Commission $commission)
    {
        $commission1 = Commission::where('id', $request->id)->first();
        $input = $request->except('_token', 'order_id', 'user_id1', 'percent1', 'all_total');
        $input['order_id'] = $commission1->order_id;
        $commission = $this->commissionService->create($input, $input['order_id']);

        return redirect('order/' . $commission1->order_id . '/show');
    }
}
