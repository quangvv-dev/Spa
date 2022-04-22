<?php

namespace App\Http\Controllers\BE\ThuChi;

use App\Constants\DepartmentConstant;
use App\Constants\NotificationConstant;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\DanhMucThuChi;
use App\Models\LyDoThuChi;
use App\Models\Notification;
use App\Models\ThuChi;
use Excel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ThuChiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:thu-chi.list', ['only' => ['index']]);
        $this->middleware('permission:thu-chi.edit', ['only' => ['edit']]);
        $this->middleware('permission:thu-chi.add', ['only' => ['create']]);
        $this->middleware('permission:thu-chi.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $search = $request->all();
        $user = Auth::user();
        $admin = $user->department_id == DepartmentConstant::ADMIN && $user->role == 1 ? true : false;
        $quan_ly = $user->department_id == DepartmentConstant::ADMIN && $user->role != 1 ? true : false;
        $ke_toan = $user->department_id == DepartmentConstant::KE_TOAN ? true : false;
        $branches = [];
        $users = User::pluck('full_name', 'id')->toArray();
        if (!$admin) {
            if ($quan_ly) {
                $search['duyet_id'] = $user->id;
            } elseif ($ke_toan) {
                $branches = Branch::pluck('name', 'id');
            } else {
                $search['thuc_hien_id'] = $user->id;
            }
        } else {
            $branches = Branch::pluck('name', 'id');
        }

        $docs = ThuChi::search($search)->orderByDesc('id');
        View::share([
            'allPrice' => $docs->sum('so_tien'),
        ]);

        $docs = $docs->paginate(StatusCode::PAGINATE_20);
        $categories = DanhMucThuChi::pluck('name', 'id');
        if ($request->ajax()) {
            return view('thu_chi.danh_sach_thu_chi.ajax', compact('docs'));
        }
        return view('thu_chi.danh_sach_thu_chi.index', compact('docs', 'categories', 'branches', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::pluck('name', 'id');
        $li_do = LyDoThuChi::pluck('name', 'id')->toArray();
        $user_duyet = User::whereIn('department_id', [DepartmentConstant::ADMIN, DepartmentConstant::KE_TOAN])->pluck('full_name', 'id');

        $type = collect(['0' => 'Tiền mặt', '1' => 'Chuyển khoản']);

        $categories = DanhMucThuChi::pluck('name', 'id');

        return view('thu_chi.danh_sach_thu_chi._form', compact('categories', 'user_duyet', 'type', 'li_do', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $data['so_tien'] = replaceNumberFormat($request->so_tien);
        $data['thuc_hien_id'] = $user->id;
        $data['branch_id'] = $data['branch_id'] ?: $user->branch_id;
        $data['danh_muc_thu_chi_id'] = LyDoThuChi::find($request->ly_do_id)->category_id;
        $data['created_at'] = Functions::yearMonthDay($request->created_at);
        $thu_chi = ThuChi::create($data);
        $centor = User::select()->where('id', $request->duyet_id)->first();
        if (isset($centor) && $centor) {
            $data_noti = json_encode((array)['pay_id' => $thu_chi->id]);
            $title = '💸💸💸 Bạn có yêu cầu duyệt chi';
            $type = NotificationConstant::THU_CHI;
            if (!empty($centor->devices_token)) {
                $devices_token = [$centor->devices_token];
                fcmSendCloudMessage($devices_token, $title, 'Chạm để xem', 'notification', ['pay_id' => $thu_chi->id]);
            }

            Notification::insert(
                [
                    'user_id' => $request->duyet_id,
                    'title' => $title,
                    'data' => $data_noti,
                    'type' => $type,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                ]);
        }

        return redirect('thu-chi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branches = Branch::pluck('name', 'id');
        $doc = ThuChi::find($id);
//        $li_do = LyDoThuChi::where('category_id', $doc->danh_muc_thu_chi_id)->pluck('name', 'id')->toArray();
        $li_do = LyDoThuChi::pluck('name', 'id')->toArray();
        $user_duyet = User::whereIn('department_id', [DepartmentConstant::ADMIN, DepartmentConstant::KE_TOAN])->pluck('full_name', 'id');
        $type = collect(['0' => 'Tiền Mặt', '1' => 'Chuyển Khoản']);
        $categories = DanhMucThuChi::pluck('name', 'id');
        return view('thu_chi.danh_sach_thu_chi._form', compact('doc', 'categories', 'user_duyet', 'type', 'li_do', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['created_at'] = Functions::yearMonthDay($request->created_at);
        $data['so_tien'] = replaceNumberFormat($request->so_tien);
        $thu_chi = ThuChi::find($id);
        if ($thu_chi->status == 1) {
            return redirect('thu-chi')->with('warning', 'Đã duyệt không được sửa');
        }
        $thu_chi->update($data);
        return redirect('thu-chi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $thu_chi = ThuChi::find($id);
        if ($thu_chi->status == 0) {
            $thu_chi->delete();
        }
        return redirect()->back();

    }

    public function changeStatus(Request $request)
    {
        $user = Auth::user();
        $thu_chi = ThuChi::find($request->id);

        $admin = $user->department_id == DepartmentConstant::ADMIN && $user->role == DepartmentConstant::ADMIN ? true : false;
        $quan_ly = $user->id == $thu_chi->duyet_id ? true : false;
        $ke_toan = $user->department_id == DepartmentConstant::KE_TOAN ? true : false;

        $status = $request->status == 'true' ? 1 : 0;

        if ($admin || $quan_ly || $ke_toan) {
            $thu_chi->update(['status' => $status]);
            return 1;
        } else {
            return 0;
        }
    }

    public function category($category_id)
    {
        $data = LyDoThuChi::where('category_id', $category_id)->get();
        return $data;
    }

    /**
     * Xuất excel đơn chi
     *
     * @param Request $request
     */
    public function exportExcel(Request $request)
    {
        $request->merge([
            'start_date' => Functions::yearMonthDayTimeFormat($request->start_date),
            'end_date' => Functions::yearMonthDayTimeFormat($request->end_date)
        ]);
        $search = $request->all();

        $user = Auth::user();
        $admin = $user->department_id == DepartmentConstant::ADMIN && $user->role == 1 ? true : false;
        $quan_ly = $user->department_id == DepartmentConstant::ADMIN && $user->role != 1 ? true : false;
        $ke_toan = $user->department_id == DepartmentConstant::KE_TOAN ? true : false;
        if (!$admin) {
            if ($quan_ly) {
                $search['duyet_id'] = $user->id;
            } elseif (!$ke_toan) {
                $search['thuc_hien_id'] = $user->id;
            }
        }

        $docs = ThuChi::search($search)->orderByDesc('id')->get();
        Excel::create('Thu chi download (' . date("d/m/Y") . ')', function ($excel) use ($docs) {
            $excel->sheet('Sheet 1', function ($sheet) use ($docs) {
                $sheet->cell('A1:H1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->freezeFirstRow();
                $sheet->row(1, [
                    'STT',
                    'Ngày đề xuất',
                    'Người duyệt',
                    'Lý do',
                    'Số tiền',
                    'Loại thanh toán',
                    'Trạng thái',
                    'Chi nhánh',
                ]);
                $i = 1;
                if ($docs) {
                    foreach ($docs as $k => $ex) {
                        $i++;
                        $sheet->row($i, [
                            @$k + 1,
                            isset($ex->created_at) ? date("d/m/Y", strtotime($ex->created_at)) : '',
                            @$ex->thucHien->full_name,
                            @$ex->lyDoThuChi->name,
                            number_format($ex->so_tien),
                            $ex->type == 0 ? 'Tiền mặt' : 'Chuyển khoản',
                            $ex->status == 1 ? 'Đã duyệt' : 'Chưa duyệt',
                            @$ex->branch->name,
                        ]);
                    }
                }
            });
        })->export('xlsx');
    }
}
