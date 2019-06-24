<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Category;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Excel;

class CustomerController extends Controller
{
    /**
     * @var Filesystem
     */
    private $fileUpload;

    /**
     * UserController constructor.
     *
     * @param Filesystem $fileUpload
     */
    public function __construct(Filesystem $fileUpload)
    {
        $this->fileUpload = $fileUpload;
        $status = Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id')->toArray();//mối quan hệ
        $group = Category::pluck('name', 'id')->toArray();//nhóm KH
        $source = Status::where('type', StatusCode::SOURCE_CUSTOMER)->pluck('name', 'id')->toArray();// nguồn KH
        $branch = Status::where('type', StatusCode::BRANCH)->pluck('name', 'id')->toArray();// chi nhánh
        $marketingUsers = User::where('role', UserConstant::MARKETING)->pluck('full_name', 'id')->toArray();
        $telesales = User::where('role', UserConstant::TELESALES)->pluck('full_name', 'id')->toArray();
        view()->share([
            'status'         => $status,
            'group'          => $group,
            'source'         => $source,
            'branch'         => $branch,
            'telesales'      => $telesales,
            'marketingUsers' => $marketingUsers,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $users = User::with('status', 'marketing', 'category');
        $statuses = Status::where('type', StatusCode::RELATIONSHIP)->get();
        $title = 'Danh sách khách hàng';
        $search = $request->search;
        $searchStatus = $request->status;
        $searchGroup = $request->group;
        $searchTelesales = $request->telesales;

        if (Auth::user()->role == UserConstant::MARKETING || Auth::user()->role == UserConstant::TELESALES) {
            $users = $users->where('role', UserConstant::CUSTOMER)->where('mkt_id', Auth::user()->id);
            $title = "Tạo khách hàng mới";
        }
        if ($search) {
            $users = $users->where(function ($query) use ($search) {
                $query->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($searchStatus) {
            $users->whereHas('status', function ($query) use ($searchStatus) {
                $query->where('status.name', $searchStatus);
            });
        }

        if ($searchGroup) {
            $users->where('group_id', $searchGroup);
        }

        if ($searchTelesales) {
            $users->where('telesales_id', $searchTelesales);
        }

        $users = $users->where('role', UserConstant::CUSTOMER)
            ->paginate(10);

        if ($request->ajax()) {
            return Response::json(view('customers.ajax', compact('users', 'statuses', 'title'))->render());
        }

        return view('customers.index', compact('users', 'statuses', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm mới khách hàng';
        return view('customers._form', compact('title'));
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
        @$date = Functions::yearMonthDay($request->birthday);
        $input = $request->except('image');
        $marketingUser = Auth::user()->id;
        $input['active'] = UserConstant::ACTIVE;
        $input['birthday'] = isset($date) && $date ? $date : '';
        $input['password'] = bcrypt($request->password);
        $input['role'] = UserConstant::CUSTOMER;
        $input['telesales_id'] = $request->telesales_id;

        if ($request->image) {
            $input['avatar'] = $this->fileUpload->uploadUserImage($request->image);
        }

        $dataUser = User::create($input);
        if ($request->mkt_id == null) {
            $dataUser->update([
                'mkt_id' => $marketingUser,
            ]);
        }

        return redirect('customers')->with('status', 'Tạo người dùng thành công');
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
    public function edit(User $customer)
    {
        $user['birthday'] = Functions::dayMonthYear($customer->birthday);
        $title = 'Sửa khách hàng';
        return view('customers._form', compact('customer', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $customer)
    {
        $input = $request->except('image');
        @$date = Functions::yearMonthDay($request->birthday);
        $input['birthday'] = isset($date) && $date ? $date : '';
        $input['password'] = bcrypt($request->password);
        $input['telesales_id'] = $request->telesales_id;
//        dd($input['telesales_id']);

        if ($request->image) {
            $input['avatar'] = $this->fileUpload->uploadUserImage($request->image);
        }
        $customer->update($input);

        return redirect(route('customers.index'))->with('status', 'Cập nhật khách hàng thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $customer)
    {
        $customer->delete();
        $request->session()->flash('error', 'Xóa người dùng thành công!');
    }

    public function exportUser()
    {
        $rq = $request->all();
        $data = User::orderBy('id', 'desc');
        if ($rq['search']) {
            $data = $data->where('name', 'like', '%' . $rq['search'] . '%')
                ->orWhere('email', 'like', '%' . $rq['search'] . '%')
                ->orWhere('phone', 'like', '%' . $rq['search'] . '%');
        }

        $data = $data->get();
        Excel::create('Danh sách User', function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->cell('A1:J1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->row(1, [
                    'ID',
                    'Name',
                    'Email',
                    'SĐT',
                    'Type',
                    'Address',
                    'Birth Day',
                    'Giới tính',
                    'Company',
                    'MST',
                ]);
                $i = 1;
                if ($data) {
                    foreach ($data as $k => $ex) {
                        $i++;
                        $sheet->row($i, [
                            @$ex->id,
                            @$ex->name,
                            @$ex->email,
                            @$ex->phone,
                            (@$ex->type == 0) ? 'Tài khoản thường' : 'Tài khoản VIP',
                            @$ex->address,
                            @$ex->birth_day,
                            (@$ex->gender == 0) ? 'Nam' : 'Nữ',
                            @$ex->company,
                            @$ex->tax_code,
                        ]);
                    }
                }
            });
        })->export('xlsx');
    }
}
