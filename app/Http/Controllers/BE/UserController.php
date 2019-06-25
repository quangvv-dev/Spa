<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Requests\UserRequest;
use App\Models\Category;
use App\Models\Status;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    private $userService;

    /**
     * UserController constructor.
     *
     * @param Filesystem $fileUpload
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
        $users = User::search($request);
        $title = 'Quản lý người dùng';

        if ($request->ajax()) {
            return Response::json(view('users.ajax', compact('users', 'title'))->render());
        }

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
        $input['image'] = $request->image;

        $this->userService->create($input);
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
    public function update(UserRequest $request, $id)
    {
        $input = $request->except('image');
        $input['image'] = $request->image;

        $this->userService->update($input, $id);

        return redirect(route('users.index'))->with('status', 'Cập nhật người dùng thành công');
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
        $phone = $request->phone;
        $email = $request->email;
        $result = User::when($phone, function ($query, $phone) {
            $query->where('phone', $phone);
        })->when($email, function ($query, $email) {
            $query->where('email', $email);
        })->first();

        if ($result) {
            return $result->id == $request->id ? 'true' : 'false';
        }
        return 'true';
    }
}
