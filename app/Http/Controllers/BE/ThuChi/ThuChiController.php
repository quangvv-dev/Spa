<?php

namespace App\Http\Controllers\BE\ThuChi;

use App\Constants\NotificationConstant;
use App\Constants\StatusCode;
use App\Models\Branch;
use App\Models\DanhMucThuChi;
use App\Models\LyDoThuChi;
use App\Models\Notification;
use App\Models\Role;
use App\Models\ThuChi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $search = $request->all();
        $user = Auth::user();
        $admin = $user->department_id == 1 && $user->role == 1 ? true : false;
        $quan_ly = $user->department_id == 1 && $user->role != 1 ? true : false;
        $branches = [];
        $users = User::pluck('full_name', 'id')->toArray();
        if ($admin) {
            $branches = Branch::pluck('name', 'id');
        } else {
            if ($quan_ly) {
                $search['duyet_id'] = $user->id;
            } else {
                $search['thuc_hien_id'] = $user->id;
            }
        }
        $docs = ThuChi::search($search)->orderByDesc('id')->paginate(StatusCode::PAGINATE_20);

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
        $roles = Role::where('department_id', 1)->pluck('id')->toArray();
        $user = Auth::user();
        $user_duyet = User::whereIn('role', $roles)->where(function ($b) use ($user) {
            $b->where('branch_id', $user->branch_id)->orWhereNull('branch_id');
        })->pluck('full_name', 'id');

        $type = collect(['0' => 'Tiền mặt', '1' => 'Chuyển khoản']);

        $categories = DanhMucThuChi::pluck('name', 'id');

        return view('thu_chi.danh_sach_thu_chi._form', compact('categories', 'user_duyet', 'type'));
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
        $data['branch_id'] = $user->branch_id ? $user->branch_id : 0;

        $thu_chi = ThuChi::create($data);
        $centor = User::select()->where('id', $request->duyet_id)->first();
        if (isset($centor) && $centor) {
            $data_noti = json_encode((array)['pay_id' => $thu_chi->id]);
            $title = '💸💸💸 Bạn có yêu cầu duyệt chi';
            $type = NotificationConstant::THU_CHI;
            if (!empty($centor->devices_token)){
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
        $doc = ThuChi::find($id);
        $li_do = LyDoThuChi::where('category_id', $doc->danh_muc_thu_chi_id)->pluck('name', 'id')->toArray();
        $roles = Role::where('department_id', 1)->pluck('id')->toArray();
        $user = Auth::user();

        $user_duyet = User::whereIn('role', $roles)->where(function ($b) use ($user) {
            $b->where('branch_id', $user->branch_id)->orWhereNull('branch_id');
        })->pluck('full_name', 'id');
        $type = collect(['0' => 'Tiền Mặt', '1' => 'Chuyển Khoản']);
        $categories = DanhMucThuChi::pluck('name', 'id');
        return view('thu_chi.danh_sach_thu_chi._form', compact('doc', 'categories', 'user_duyet', 'type', 'li_do'));
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

        $admin = $user->department_id == 1 && $user->role == 1 ? true : false;
        $quan_ly = $user->id == $thu_chi->duyet_id ? true : false;

        $status = $request->status == 'true' ? 1 : 0;

        if ($admin || $quan_ly) {
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
}
