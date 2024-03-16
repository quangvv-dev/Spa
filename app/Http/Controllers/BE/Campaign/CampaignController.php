<?php

namespace App\Http\Controllers\BE\Campaign;

use App\Constants\DepartmentConstant;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Campaign;
use App\Models\CustomerCampaign;
use App\Models\Order;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CampaignController extends Controller
{
    public function __construct()
    {
        view()->share([
            'branchs' => Branch::pluck('name', 'id')->toArray(),
            'sale'    => User::whereIn('department_id', [DepartmentConstant::TELESALES, DepartmentConstant::CSKH])
                ->pluck('full_name', 'id')->toArray(),
            'status'  => Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function checkCampaign(Request $request)
    {
        return $this->loadCustomer($request)->count();
    }

    public function loadCustomer($request)
    {
        return Order::select('c.id')->join('customers as c', 'c.id', '=', 'orders.member_id')
            ->whereBetween('orders.created_at', [$request->from_order . " 00:00:00", $request->to_order . " 23:59:59"])
            ->whereIn('c.status_id', $request->customer_status)->whereIn('orders.branch_id',
                $request->branch_id)->groupBy('orders.member_id')->get();
    }

    /**
     *  Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $campaigns = Campaign::search($request->all())->paginate(StatusCode::PAGINATE_20);
        if ($request->ajax()) {
            return view('campaigns.ajax', compact('campaigns'));
        }
        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaigns._form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['sale_id'] = json_encode($input['sale_id']);
        $input['customer_status'] = json_encode($input['customer_status']);
        $input['branch_id'] = json_encode($input['branch_id']);
        $campaign = Campaign::create($input);
        $customers = $this->loadCustomer($request)->pluck('id')->toArray();
        $list_campaign = [];
        if (count($customers)) {
            $index_sale = 0;
            foreach ($customers as $c) {
                $sale = $request->sale_id[$index_sale];
                $list_campaign[] = [
                    'customer_id' => $c,
                    'campaign_id' => $campaign->id,
                    'sale_id'     => $sale,
                    'status'      => CustomerCampaign::NEW,
                ];

                $index_sale++;

                // Kiểm tra nếu đã duyệt hết mảng sale_id và cskh_id,
                // thì reset lại index để bắt đầu lại từ đầu
                if ($index_sale >= count($request->sale_id)) {
                    $index_sale = 0;
                }
            }
        }
        $campaign->customer_campaign()->insert($list_campaign);
        return redirect(route('campaigns.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        return view('campaigns._form', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $input = $request->all();
        $input['sale_id'] = json_encode($input['sale_id']);
        $input['customer_status'] = json_encode($input['customer_status']);
        $input['branch_id'] = json_encode($input['branch_id']);
        $campaign->update($input);
        $campaign->customer_campaign()->delete();
        $customers = $this->loadCustomer($request)->pluck('id')->toArray();
        $list_campaign = [];
        if (count($customers)) {
            $index_sale = 0;
            foreach ($customers as $c) {
                $sale = $request->sale_id[$index_sale];
                $list_campaign[] = [
                    'customer_id' => $c,
                    'campaign_id' => $campaign->id,
                    'sale_id'     => $sale,
                    'status'      => CustomerCampaign::NEW,
                ];

                $index_sale++;

                // Kiểm tra nếu đã duyệt hết mảng sale_id và cskh_id,
                // thì reset lại index để bắt đầu lại từ đầu
                if ($index_sale >= count($request->sale_id)) {
                    $index_sale = 0;
                }
            }
        }
        $campaign->customer_campaign()->insert($list_campaign);
        return back()->with('status', 'Cập nhật chiến dịch thành công');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Campaign $campaign
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->customer_campaign()->delete();
        $campaign->delete();
        return back()->with('error', 'Xóa chiến dịch thành công');
    }
}