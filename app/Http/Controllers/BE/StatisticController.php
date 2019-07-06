<?php

namespace App\Http\Controllers\BE;

use App\Constants\UserConstant;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    private $customer;

    /**
     * StatisticController constructor.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index(Request $request)
    {
        $title = 'Thống kê';
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        if (Auth::user()->role == UserConstant::MARKETING) {
            $statisticUsers = $this->customer->getStatisticsUsers()
                ->where('mkt_id', Auth::user()->id);
        } else {
            $statisticUsers = $this->customer->getStatisticsUsers();
        }
        if ($fromDate && $toDate == null) {
            $statisticUsers = $statisticUsers->whereDate('created_at', $fromDate);
        }

        if ($fromDate && $toDate) {
            $statisticUsers = $statisticUsers->whereRaw("created_at >= ? AND created_at <= ?",
                [$fromDate . " 00:00:00", $toDate . " 23:59:59"]);
        }

        $statisticUsers = $statisticUsers->paginate(10);

        if ($request->ajax()) {
            return Response::json(view('statistics.ajax', compact('statisticUsers', 'title'))->render());
        }

        return view('statistics.index', compact('statisticUsers', 'title'));
    }

    public function show($id)
    {
        $title = 'Chi tiết thống kê';
        $total = $this->customer->getStatisticsUsers()->get()->sum('count');
        $detail = $this->customer->getStatisticsUsers()->where('mkt_id', $id)->first();

        return view('statistics.detail', compact('detail', 'title', 'total'));
    }
}
