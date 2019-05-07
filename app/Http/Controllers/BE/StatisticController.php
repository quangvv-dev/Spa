<?php

namespace App\Http\Controllers\BE;

use App\Constants\UserConstant;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Thống kê';
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        if (Auth::user()->role == UserConstant::MARKETING) {
            $statisticUsers = User::with('marketing')->select('mkt_id', \DB::raw('count(id) as count'))
                ->whereNotNull('mkt_id')
                ->where('mkt_id', Auth::user()->id)
                ->groupBy('mkt_id');
        } else {
            $statisticUsers = User::with('marketing')->select('mkt_id', \DB::raw('count(id) as count'))
                ->whereNotNull('mkt_id')
                ->groupBy('mkt_id');
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
        $user = User::findOrFail($id);

        return view('statistics.detail', compact('user', 'title'));
    }
}
