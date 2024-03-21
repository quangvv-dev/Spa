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
use Illuminate\Support\Facades\Auth;

class CustomerCampaignController extends Controller
{
    public function __construct()
    {
        view()->share([
            'branchs' => Branch::pluck('name', 'id')->toArray(),
            'status'  => Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id')->toArray(),
        ]);
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
        $input = $request->all();
        if (Auth::user()->department_id != DepartmentConstant::ADMIN) {
            $campaigns = CustomerCampaign::select('c.id', 'c.name')->join('campaigns as c', 'c.id', '=', 'customer_campaign.campaign_id')
                ->where('customer_campaign.sale_id', Auth::user()->id)->groupBy('campaign_id')->orderByDesc('c.id')->get();
            $input['sale_id'] = Auth::user()->id;
        } else {
            $campaigns = Campaign::select('id', 'name','sale_id')->orderByDesc('id')->get();
        }

//        if (empty($input['campaign_id'])) {
//            $input['campaign_id'] = count($campaigns) ? $campaigns[0]->id : 0;
//        }
        $customers = CustomerCampaign::search($input)->take(500)->paginate(StatusCode::PAGINATE_20);
        if ($request->ajax()) {
            return view('customer_campaign.ajax', compact('campaigns', 'customers'));
        }
        return view('customer_campaign.index', compact('campaigns', 'customers'));
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
            $index_cskh = 0;
            foreach ($customers as $c) {
                $sale = $request->sale_id[$index_sale];

                $list_campaign[] = [
                    'customer_id' => $c,
                    'campaign_id' => $campaign->id,
                    'sale_id'     => $sale,
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
        $campaign->delete();
        return back()->with('error', 'Xóa chiến dịch thành công');
    }

    public function updateStatus(Request $request, CustomerCampaign $customer)
    {   $input = $request->only('status','message');
        $customer->update($input);
        return $customer;
    }
}
