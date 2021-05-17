<?php

namespace App\Http\Controllers\BE;

use App\Constants\UserConstant;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public $list;
    public $type = 'roles';
    public $view = 'BE';
    protected $module = [
        'roles',
        'customers',
        'users',
        'department',
        'rules',
        'landipages',
        'posts',
        'promotions',

        'category',
        'category-product',
        'products',
        'services',
        'trademark',
        'genitives',
        'combos',
        'schedules',
        'status',
    ];
    protected $report = [
        'statistics.index',
        'report.groupSale',
        'sms.history',
        'report.tasks',
        'report.commission',
        'report.sale',
        'statistics.taskSchedules',
        'call-center'
    ];

    protected $other = [
        'leaderSale',
        'leaderMKT',
        'post.customer',
        'order.index_payment',
        'tasks.employee',
        'sms',
        'settings',
        'fanpage',
    ];
    protected $permissions = ['list', 'edit', 'add', 'delete'];

    public function generateParams()
    {
        view()->share([
            'permissions' => $this->permissions,
            'module' => $this->module,
            'report' => $this->report,
            'other' => $this->other,
        ]);
    }

    public function __construct()
    {
        $this->middleware('permission:roles.list', ['only' => ['index']]);
        $this->middleware('permission:roles.edit', ['only' => ['edit']]);
        $this->middleware('permission:roles.add', ['only' => ['create']]);
        $this->middleware('permission:roles.delete', ['only' => ['destroy']]);
        $department = Department::pluck('name', 'id')->toArray();

        view()->share([
            'type' => $this->type,
            'department' => $department,
            'report' => $this->report,
            'other' => $this->other,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "Danh sách quyền trong hệ thống";
        $dataSearch['searchName'] = $request->searchName;
        $dataSearch['department_id'] = $request->department_id;
        $docs = Role::search($dataSearch);

        if ($request->ajax()) {
            return view('role.ajax', compact('title', 'docs', 'dataSearch'));
        }
        return view('role.index', compact('title', 'docs', 'dataSearch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = route('roles.store');
        $module = $this->module;
        $permissions = $this->permissions;
        return view('role.create', compact('action', 'module', 'permissions'));
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
        Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'department_id' => $request->department_id,
            'permissions' => json_encode($request->permissions),
        ]);

        return redirect(route('roles.index'))->with('success', 'Thêm mới quền thành công!');
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
    public function edit(Role $role)
    {
        $doc = $role;
        $action = route('roles.update', $doc->id);
        $this->generateParams();
        return view('role.create', compact('doc'));
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
        $role = Role::findOrFail($id);
        if ($role) {
            $role->update([
                'name' => $request->name,
                'description' => $request->description,
                'department_id' => $request->department_id,
                'permissions' => json_encode($request->permissions),
            ]);

            return back();
            return redirect(route('roles.index'))->with('success', 'Chỉnh sửa thành công !');
        }

        return redirect(route('roles.index'))->with('danger', 'Chỉnh sửa không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $count = $role->users->count();
        if (!$count) {
            if ($role->id != UserConstant::ADMIN) {
                $role->delete();
                return 1;
            }
        }
        return redirect()->route('roles.index')
            ->with('danger', 'Có nhân viên thuôc quyền nên không thể xóa !');
    }
}
