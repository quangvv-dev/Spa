<div class="table-responsive">
    <div class="card-header">
        <div class="col-md-3 bold">
            Nhân sự trên hệ thống : <span class="text-info">{{$statistics['all']}}</span>
        </div>
        <div class="col-md-3 bold">
            Nhân sự đang hoạt động: <span class="text-success">{{$statistics['active']}}</span>
        </div>
        <div class="col-md-3 bold">
            Nhân sự nghỉ việc (Khóa TK) : <span class="text-danger">{{$statistics['all'] - $statistics['active']}}</span>
        </div>
        <div class="col-md-3 bold">
            Nhân sự tạm nghỉ : <span class="text-warning">0</span>
        </div>
    </div>
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">Mã NV</th>
            <th class="text-white text-center">Mã chấm công</th>
            <th class="text-white text-center">Họ tên</th>
{{--            <th class="text-white text-center">Tên export</th>--}}
            <th class="text-white text-center">Số điện thoại</th>
            <th class="text-white text-center">Cụm</th>
            <th class="text-white text-center">Phòng ban</th>
            <th class="text-white text-center">Quyền</th>
            <th class="text-white text-center">Chi nhánh</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if (count($users))
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->code }}</th>
                    <td class="text-center">{{ $user->approval_code }}</td>
                    <td class="text-center"><a href="{{route('users.edit',$user->id)}}">{{ $user->full_name }}</a></td>
{{--                    <td class="text-center">{{ $user->name_display }}</td>--}}
                    <td class="text-center">{{ $user->phone }}</td>
                    <td class="text-center">{{ @$user->location->name }}</td>
                    <td class="text-center">{{ @$user->department->name}}</td>
                    <td class="text-center">{{ $user->role_text }}</td>
                    <td class="text-center">{{ isset($user->branch)?$user->branch->name:'Tất cả chi nhánh'}}</td>
                    <td class="text-center">
                        <label class="switch">
                            <input data-id="{{$user->id}}" name="checkbox" class="check" type="checkbox" {{$user->active==\App\Constants\StatusCode::ON?'checked':''}}>
                            <span class="slider round"></span>
                        </label>
                        <a title="sửa tài khoản" class="btn" href="{{ route('users.edit', $user->id) }}"><i class="fas fa-edit"></i></a>
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
        {{ $users->links() }}
    </div>
</div>
<!-- table-responsive -->
