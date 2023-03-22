<?php

namespace App\Http\Controllers\BE\ChamCong;

use App\Constants\ChamCongConstant;
use App\Constants\DepartmentConstant;
use App\Constants\OrderConstant;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\ChamCong;
use App\Models\DonTu;
use App\Models\Order;
use App\Models\Reason;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public $time = [];

    public function __construct()
    {
        $this->time = ChamCongConstant::HOURS;

        $this->middleware('permission:don_tu.list', ['only' => ['index']]);
        $this->middleware('permission:don_tu.edit', ['only' => ['editOrder']]);
        $this->middleware('permission:don_tu.add', ['only' => ['createOrder']]);
        $this->middleware('permission:don_tu.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
//        if (!$request->start_date) {
//            Functions::addSearchDateFormat($request, 'd-m-Y');
//        }
        $param = $request->all();
        if ($user->department_id == DepartmentConstant::ADMIN) {
            $docs = DonTu::when(isset($param['start_date']) && isset($param['end_date']), function ($q) use ($param) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($param['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($param['end_date']) . " 23:59:59",
                ]);
            })->when(isset($param['searchName']) && $param['searchName'], function ($q) use ($param) {
                $q->whereHas('user', function ($qr) use ($param) {

                    $qr->where('full_name', 'like', '%' . $param['searchName'] . '%');
                });
            })->when(isset($param['department_id']) && $param['department_id'], function ($q) use ($param) {
                $q->whereHas('user', function ($qr) use ($param) {
                    $qr->where('department_id', $param['department_id']);
                });
            })->when(isset($param['status']), function ($q) use ($param) {
                $q->where('status', $param['status']);
            })->where(function ($q) use ($user, $param) {
                $q->where('user_id', $user->id)->orWhere('accept_id', $user->id);
            })->orderBy('status')->orderByDesc('id');
            $count = $docs->count();
            $docs = $docs->paginate(StatusCode::PAGINATE_20);
        } else {
            $docs = DonTu::where('user_id', $user->id);
            $count = $docs->count();
            $docs = $docs->paginate(StatusCode::PAGINATE_20);

        }
        if ($request->ajax()) {
            return view('cham_cong.order.ajax', compact('docs','count'));
        }
        return view('cham_cong.order.index', compact('docs','count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());

        $data = $request->all();
        $date = date_create($request->date);
        $data['date'] = date_format($date, "Y-m-d");

        if ($request->date_end) {
            $date2 = date_create($request->date_end);
            $data['date_end'] = date_format($date2, "Y-m-d");
        }

        $data['user_id'] = Auth::id();
        DonTu::create($data);
        return redirect(route('approval.order.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('cham_cong.order.detail.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = $request->all();
        $data['date'] = Carbon::createFromFormat('d/m/Y',$request->date)->format('Y-m-d');
        if ($request->date_end) {
            $data['date_end'] = Carbon::createFromFormat('d/m/Y',$request->date_end)->format('Y-m-d');
        }
        DonTu::find($id)->update($data);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DonTu::find($id)->delete();
        return 1;
    }

    public function createOrder($type)
    {
        $time = $this->time;
        $type = isset($type) && $type ? $type : 1;
        $user_accept = User::where('department_id', DepartmentConstant::ADMIN)->select('full_name', 'id')->get();

        if ($type == 1) { //đơn nghỉ
            $reasons = Reason::where('type', 0)->get();
            return view('cham_cong.order.order_type.don_nghi', compact('time', 'user_accept', 'reasons'));
        } else if ($type == 2) { //đơn checkin
            $reasons = Reason::where('type', 1)->get();
            return view('cham_cong.order.order_type.don_check_in_out', compact('time', 'user_accept', 'reasons'));

        }
    }

    public function showDetail($id, $type)
    {
        $order = DonTu::find($id);
        if(!$order){
            return redirect(route('approval.order.index'));
        }
        if ($type == OrderConstant::TYPE_DON_NGHI) {
            return view('cham_cong.order.detail.detail_don_nghi', compact('order'));
        }
        if ($type == OrderConstant::TYPE_DON_CHECKIN_CHECKOUT) {
            return view('cham_cong.order.detail.detail_checkin', compact('order'));
        }
    }

    public function accept(Request $request)
    {

    }

    public function acceptArrayOrder(Request $request)
    {
        if ($request->type == 2) { //không duyệt
            DonTu::whereIn('id', $request->array_id)->update(['status' => 2]);
            return 1;
        } else { //duyệt
            foreach ($request->array_id as $item) {
                $don_tu = DonTu::find($item);
                if($don_tu->status === 0){ //đơn chưa duyệt
                    if ($don_tu->type == OrderConstant::TYPE_DON_CHECKIN_CHECKOUT) {
                        $user = User::find($don_tu->user_id);
                        $branch = Branch::find($user->branch_id);
                        $approval_code = $user->approval_code;
                        $key = array_search($don_tu->time_to, ChamCongConstant::HOURS);

                        $time = $don_tu->date . ' ' . $key;
                        ChamCong::create([
                            'name_machine' => $branch->name_machine,
                            'machine_number' => 1,
                            'date_time_record' => $time,
                            'ind_red_id' => $approval_code,
                            'type' => 1
                        ]);
                    }
                    $don_tu->update(['status' => OrderConstant::DUYET]);
                }
            }
            return 1;
        }
    }

    public function editOrder($order_id)
    {
        $order = DonTu::find($order_id);
        $time = $this->time;
        $user_accept = User::where('department_id', DepartmentConstant::ADMIN)->select('full_name', 'id')->get();
        if ($order->type == OrderConstant::TYPE_DON_NGHI) { //đơn nghỉ
            $reasons = Reason::where('type', 0)->get();
            return view('cham_cong.order.order_type.don_nghi', compact('time', 'user_accept', 'reasons','order'));
        } else if ($order->type == OrderConstant::TYPE_DON_CHECKIN_CHECKOUT) { //đơn checkin
            $reasons = Reason::where('type', 1)->get();
            return view('cham_cong.order.order_type.don_check_in_out', compact('time', 'user_accept', 'reasons','order'));
        }
    }
}
