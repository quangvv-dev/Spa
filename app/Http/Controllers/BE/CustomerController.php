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
        $users = User::with('status', 'marketing');
        $statuses = Status::where('type', StatusCode::RELATIONSHIP)->get();
        $title = 'Quản lý khách hàng';
        $search = $request->search;
        $searchStatus = $request->status;

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

        $users = $users->where('role', UserConstant::CUSTOMER)
            ->paginate(10);

        if ($request->ajax()) {
            return Response::json(view('customers.ajax', compact('users', 'statuses','title'))->render());
        }

        return view('customers.index', compact('users','statuses', 'title'));
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
     * @param  \Illuminate\Http\Request  $request
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

        if ($request->image) {
            $input['avatar'] = $this->fileUpload->uploadUserImage($request->image);
        }

        $dataUser = User::create($input);
        if ($request->mkt_id == null && Auth::user()->role == UserConstant::MARKETING) {
            $dataUser->update([
                'mkt_id' => $marketingUser,
            ]);
        }

        return redirect('customers')->with('status', 'Tạo người dùng thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $customer)
    {
        $input = $request->except('image');
        @$date = Functions::yearMonthDay($request->birthday);
        $input['birthday'] = isset($date) && $date ? $date : '';
        $input['password'] = bcrypt($request->password);

        if ($request->image) {
            $input['avatar'] = $this->fileUpload->uploadUserImage($request->image);
        }

        $customer->update($input);

        return redirect(route('customers.index'))->with('status', 'Cập nhật khách hàng thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $customer)
    {
        $customer->delete();
        $request->session()->flash('error', 'Xóa người dùng thành công!');
    }
}
