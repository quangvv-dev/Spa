<?php

namespace App\Http\Controllers\API\ChamCong;

use App\Constants\ChamCongConstant;
use App\Constants\DepartmentConstant;
use App\Constants\OrderConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\ChamCong\OrderResource;
use App\Models\ChamCong;
use App\Models\DonTu;
use App\Models\Reason;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseApiController
{

    public $time = [];

    public function __construct()
    {
        $this->time = ChamCongConstant::HOURS;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->jwtUser;
        $param = $request->all();
        if ($user->department_id == DepartmentConstant::ADMIN) {
            $docs = DonTu::search($param)->where(function ($q) use ($user, $param) {
                $q->where('user_id', $user->id)->orWhere('accept_id', $user->id);
            })->orderBy('status')->orderByDesc('id');
        } else {
            $docs = DonTu::search($param)->where('user_id', $user->id)->orderByDesc('id');
        }
        $clone = clone $docs;
        $clone = $clone->groupBy('status')->select(DB::raw('COUNT(id) as count'), 'status')->get()->map(function ($item
        ) {
            $item->name = $item->status == 1 ? "Đã duyệt" : ($item->status == 0 ? "Chờ duyệt" : 'Không duyệt');
            return $item;
        });
        $docs = $docs->orderByDesc('date')->paginate(StatusCode::PAGINATE_20);
        $data = [
            'status' => $clone,
            'records' => OrderResource::collection($docs),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function getListReason(Request $request)
    {
        $validate = ['type' => "required"];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        if ($request->type == OrderConstant::TYPE_DON_NGHI) {
            $reasons = Reason::select('id', 'name', 'phat_tien')->where('type', OrderConstant::TYPE_DON_NGHI)->get();
        } else {
            $reasons = Reason::select('id', 'name', 'phat_tien')->where('type',
                OrderConstant::TYPE_DON_CHECKIN_CHECKOUT)->get();
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $reasons);
    }

    public function getListAccept(Request $request)
    {
        $users = User::select('id', 'full_name')->where('department_id', DepartmentConstant::ADMIN)->get();
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getListHours(Request $request)
    {
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $this->time);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->type == OrderConstant::TYPE_DON_NGHI) {
            $validate = [
                'date' => "required",
                'date_end' => "required",
                'time_to' => "required",
                'time_end' => "required",
                'reason_id' => "required",
                'accept_id' => "required",
            ];
        } else {
            $validate = [
                'date' => "required",
                'time_to' => "required",
                'reason_id' => "required",
                'accept_id' => "required",
            ];
        }
        $user = $request->jwtUser;
        $request->merge(['user_id' => $user->id, 'status' => OrderConstant::CHO_DUYET]);

        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $data = $request->all();
        $approval_order = DonTu::create($data);
        return $this->responseApi(ResponseStatusCode::OK, 'Tạo mới đơn thành công', new OrderResource($approval_order));
    }

    public function checkInOrder(Request $request)
    {
        $validate = [
            'date' => "required",
            'time_to' => "required",
            'reason_id' => "required",
            'accept_id' => "required",
        ];
        $user = $request->jwtUser;
        $request->merge(['user_id' => $user->id, 'status' => OrderConstant::CHO_DUYET, 'type' => OrderConstant::TYPE_DON_CHECKIN_CHECKOUT]);
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $data = $request->all();
        $approval_order = DonTu::create($data);
        return $this->responseApi(ResponseStatusCode::OK, 'Tạo mới đơn check in - out thành công', new OrderResource($approval_order));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $approval_order = DonTu::find($id);
        if (empty($approval_order) || $approval_order->status != OrderConstant::CHO_DUYET) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Đơn đã được duyệt không thể chỉnh sửa !!');
        }
        $data = $request->all();
        $approval_order->update($data);
        return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Cập nhật đơn thành công !!',
            new OrderResource($approval_order));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DonTu::find($id)->delete();
        return 1;
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
                if ($don_tu->status === 0) { //đơn chưa duyệt
                    if ($don_tu->type == OrderConstant::TYPE_DON_CHECKIN_CHECKOUT) {
                        $user = User::find($don_tu->user_id);
                        $cham_cong = ChamCong::where('approval_code', $user->approval_code)->first();
                        $key = array_search($don_tu->time_to, ChamCongConstant::HOURS);
                        $time = $don_tu->date . ' ' . $key;
                        ChamCong::insert([
                            'name_machine' => $cham_cong->name_machine ?: 'HN',
                            'machine_number' => 1,
                            'approval_code' => $user->approval_code,
                            'date_time_record' => $time,
                            'ind_red_id' => explode('.', $user->approval_code),
                            'type' => 1,
                            'created_at' => $time,
                            'updated_at' => $time,

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
            return view('cham_cong.order.order_type.don_nghi', compact('time', 'user_accept', 'reasons', 'order'));
        } elseif ($order->type == OrderConstant::TYPE_DON_CHECKIN_CHECKOUT) { //đơn checkin
            $reasons = Reason::where('type', 1)->get();
            return view('cham_cong.order.order_type.don_check_in_out',
                compact('time', 'user_accept', 'reasons', 'order'));
        }
    }
}
