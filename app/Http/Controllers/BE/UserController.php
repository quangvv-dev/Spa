<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Http\Requests\UserRequest;
use App\Models\Category;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == UserConstant::MARKETING || Auth::user()->role == UserConstant::TELESALES) {
            $users = User::with('status', 'marketing')->where('role', UserConstant::CUSTOMER)
                ->where('status_id', StatusCode::NEW);
        } elseif (Auth::user()->role == UserConstant::WAITER) {
            $users = User::with('status', 'marketing')->where('role', UserConstant::CUSTOMER);

        } else {
            $users = User::with('status', 'marketing')->where('role', '<>', UserConstant::ADMIN);
        }
        $users = $users->orderBy('id', 'desc')->paginate(10);
        $title = 'Quản lý người dùng';
        return view('users.index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm người dùng';
        return view('users._form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User                     $user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->except('image');
        $marketingUser = Auth::user()->id;
        $input['active'] = UserConstant::ACTIVE;
        $input['password'] = bcrypt($request->password);

        if ($request->image) {
            $input['avatar'] = $this->fileUpload->uploadUserImage($request->image);
        }

        if ($request->role == null) {
            $input['role'] = UserConstant::CUSTOMER;
        }
        $dataUser = User::create($input);
        if ($request->mkt_id == null) {
            $dataUser->update([
                'mkt_id' => $marketingUser,
            ]);
        }

        return redirect('users')->with('status', 'Tạo người dùng thành công');
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
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $title = 'Sửa người dùng';
        return view('users._form', compact('user', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User                     $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $input = $request->except('image');
        $input['password'] = bcrypt($request->password);

        if ($request->image) {
            $input['avatar'] = $this->fileUpload->uploadUserImage($request->image);
        }

        $user->update($input);

        return redirect(route('users.index'))->with('status', 'Sửa người dùng thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return void
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();
        $request->session()->flash('error', 'Xóa người dùng thành công!');
    }

    public function checkUnique(Request $request)
    {
        $result = User::where('phone', $request->phone)->orWhere('email', $request->email)->first();
        if ($result) {
            return $result->id == $request->id ? 'true' : 'false';
        }
        return 'true';
    }

    public function getEditProfile($id)
    {
        $title = 'Cập nhật thông tin';
        $user = User::findOrFail($id);
        return view('profiles._form', compact('user', 'title'));
    }

    public function postEditProfile($id, UserRequest $request)
    {
        $user = User::findOrFail($id);
        $input = $request->except('image');
        $input['password'] = bcrypt($request->password);

        if ($request->image) {
            $input['avatar'] = $this->fileUpload->uploadUserImage($request->image);
        }

        $user->update($input);

        return redirect('/')->with('status', 'Cập nhật thông tin thành công');
    }
}
