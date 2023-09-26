<?php

namespace App\Http\Controllers\BE\Cskh;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Services\CskhService;
use Illuminate\Http\Request;

class CskhController extends Controller
{

    public function __construct(CskhService $cskhService)
    {
        $location = Branch::getLocation();
        $this->cskh = $cskhService;
        view()->share([
            'location' => $location,
        ]);
    }

    public function ranking(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = count($group_branch) ? $group_branch : [0];
        }

        $tasks = $this->cskh->getDataTask($input);
        $orders = $this->cskh->getDataOrders($input);
        $data = $this->cskh->getDataNew($input);
        $payments = $this->cskh->getDataPayment($input);
        $call = $this->cskh->getDataCall($input);

        $users = $this->cskh->transformData($tasks, $orders, $data, $payments, $call)->sortByDesc('all_payment');
        if ($request->ajax()) {
            return view('cskh.ajax', compact('users'));
        }
        return view('cskh.index', compact('users'));
    }
}
