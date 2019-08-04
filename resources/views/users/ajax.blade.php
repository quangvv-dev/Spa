<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">ID</th>
            <th class="text-white text-center">Họ tên</th>
            <th class="text-white text-center">Số điện thoại</th>
            <th class="text-white text-center">Email</th>
            <th class="text-white text-center">Quyền</th>
            <th class="text-white text-center">Phòng ban</th>
            <th class="text-white text-center">Trạng thái đăng nhập</th>
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
                    <td class="text-center">{{ $user->email }}</td>
                    <td class="text-center">{{ $user->role_text }}</td>
                    <td class="text-center">{{ @$user->department->name  }}</td>
                    <td class="text-center">{{ $user->active_text}}</td>
                    <td class="text-center">
                        <a title="sửa tài khoản" class="btn" href="{{ route('users.edit', $user->id) }}"><i class="fas fa-edit"></i></a>
                    @if (Auth::user()->role == \App\Constants\UserConstant::ADMIN)
                            <a title="Xóa tài khoản" class="btn delete" href="javascript:void(0)" data-url="{{ route('users.destroy', $user->id) }}"><i class="fas fa-trash-alt"></i></a>
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
        {{ $users->appends(['search' => request()->search ])->links() }}
    </div>
</div>
<!-- table-responsive -->
