<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">ID</th>
            <th class="text-white text-center">Họ tên</th>
            <th class="text-white text-center">Số điện thoại</th>
            <th class="text-white text-center">Cụm</th>
            <th class="text-white text-center">Phòng ban</th>
            <th class="text-white text-center">Quyền</th>
            <th class="text-white text-center">Chi nhánh</th>
            <th class="text-white text-center">Chi nhánh</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if (count($users))
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td class="text-center">{{ $user->full_name }}</td>
                    <td class="text-center">{{ $user->phone }}</td>
                    <td class="text-center">{{ @$user->location->name }}</td>
                    <td class="text-center">{{ @$user->department->name}}</td>
                    <td class="text-center">{{ $user->role_text }}</td>
                    <td class="text-center">{{ isset($user->branch)?$user->branch->name:'Tất cả chi nhánh'}}</td>
                    <td class="text-center">
                        <a title="sửa tài khoản" class="btn" href="{{ route('users.edit', $user->id) }}"><i
                                class="fas fa-edit"></i></a>
                        @if (Auth::user()->department_id == \App\Constants\DepartmentConstant::ADMIN)
                            <a title="Xóa tài khoản" class="btn delete" href="javascript:void(0)"
                               data-url="{{ route('users.destroy', $user->id) }}"><i class="fas fa-trash-alt"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $users->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $users->appends(['search' => @$input['search'],'branch_id' => @$input['branch_id'],'department_id' => @$input['department_id'] ])->links() }}
    </div>
</div>
<!-- table-responsive -->
