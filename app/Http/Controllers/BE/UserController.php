<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\UserConstant;
use App\Http\Requests\UserRequest;
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Quản lý người dùng';
        $users = User::with('status', 'marketing')->paginate(10);
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
        $status = Status::pluck('name', 'id');
        $marketingUsers = User::where('role', UserConstant::MARKETING)->pluck('full_name', 'id');
        return view('users._form', compact('title', 'status', 'marketingUsers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User                      $user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, User $user)
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

        $dataUser = $user->create($input);

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
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $title = 'Sửa người dùng';
        $status = Status::pluck('name', 'id');
        $marketingUsers = User::where('role', UserConstant::MARKETING)->pluck('full_name', 'id');
        return view('users._form', compact('user', 'title', 'status', 'marketingUsers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User                      $user
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
