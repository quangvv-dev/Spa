<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Http\Requests\UserRequest;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Location;
use App\Models\Role;
use App\Models\TeamMember;
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
        $this->middleware('permission:users.list', ['only' => ['index']]);
        $this->middleware('permission:users.edit', ['only' => ['edit']]);
        $this->middleware('permission:users.add', ['only' => ['create']]);
        $this->middleware('permission:users.delete', ['only' => ['destroy']]);

        $this->userService = $userService;
        $branchs = Branch::search()->pluck('name', 'id');
        $location = Location::select('id', 'name')->pluck('name', 'id')->toArray();

        \View::share([
            'branchs' => $branchs,
            'location' => $location
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $department = Department::select('id', 'name')->pluck('name', 'id')->toArray();
        $input = $request->all();
        $branch_id = Auth::user()->branch_id;
        if (!empty($branch_id)) {
            $input['branch_id'] = $branch_id;
        }
        $users = User::search($input);
        $users2 = clone $users;
        $statistics = [
            'all' => $users->count(),
            'active' => $users2->where('active', UserConstant::ACTIVE)->count(),
        ];
        $users = $users->paginate(StatusCode::PAGINATE_10);
        if ($request->ajax()) {
            return Response::json(view('users.ajax', compact('department', 'users', 'statistics'))->render());
        }
        return view('users.index', compact('department', 'users', 'statistics'));
    }

    public function resetLogin(Request $request, User $user)
    {
        if ($request->type == 2) {
            $pc_name = 0;
        } else {
            $pc_name = NULL;
        }
        $user->update(['pc_name' => $pc_name]);
        return 1;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm người dùng';
        $departments = Department::pluck('name', 'id');
        return view('users._form', compact('title', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
        $departments = Department::pluck('name', 'id');
        $role = Role::where('department_id', $user->department_id)->get();

        return view('users._form', compact('user', 'title', 'departments', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UserRequest $request, $id)
    {
        $input = $request->except('image', 'confirm_password');
        $input['image'] = $request->image;
        $input['password'] = $request->password;

        $this->userService->update($input, $id);

        return redirect(route('users.index'))->with('status', 'Cập nhật người dùng thành công');
    }

    /**
     * Delete
     *
     * @param Request $request
     * @param User $user
     * @throws \Exception
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();
        $request->session()->flash('error', 'Xóa người dùng thành công!');
    }

    /**
     * Check trùng data
     *
     * @param Request $request
     * @return string
     */
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

    /**
     * get list user role sale
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUserDepartmentNotTeam(Request $request)
    {
        $team_member = TeamMember::all()->pluck('user_id')->toArray();
        $user = User::where('department_id', $request->department)->whereNotIn('id', $team_member)->where('active', StatusCode::ON)->get();
        return response()->json([
            'user' => $user
        ]);
    }


    /**
     * get danh sách user trong team chọn và user chưa có trong team nào.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUserDepartmentTeam(Request $request)
    {
        $user_team_member_id = TeamMember::where('team_id', $request->team_id)->pluck('user_id')->toArray();
        $user_team = User::whereIn('id', $user_team_member_id)->where('active', StatusCode::ON)->get();
        $team_member = TeamMember::all()->pluck('user_id')->toArray();
        $user = User::where('department_id', $request->department)->whereNotIn('id', $team_member)->where('active', StatusCode::ON)->get();
        $user = $user->merge($user_team);
        return response()->json([
            'user' => $user
        ]);
    }

    public function activeUser(Request $request, $id)
    {
        User::find($id)->update($request->only('active'));
        return response()->json([
            'code' => 200
        ]);
    }
}
